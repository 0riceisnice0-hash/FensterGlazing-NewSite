<?php
/**
 * Consent-free ad attribution.
 *
 * THE POINT OF THIS FILE. Under consent-first, nothing is written to a
 * visitor's device until they press a button, so the `FGV`/`FG2` journey that
 * used to carry ad attribution does not exist for most traffic. That would have
 * made paid search unmeasurable — which is not acceptable when it is where the
 * budget goes.
 *
 * It does not have to be. A Google Ads click arrives with its campaign in the
 * landing URL. Reading the address of a page somebody just asked us for stores
 * nothing on their device, so it needs no consent, and it is enough to answer
 * the question that decides spend: which campaign produced which lead, and at
 * what cost.
 *
 * WHAT IS STORED WHERE, because the boundaries matter:
 *   - The raw `gclid`/`gbraid`/`wbraid` stays in WordPress. It already did, for
 *     the offline conversion feed. It is never sent to the dashboard, per the
 *     standing rule in `AI.md`.
 *   - The dashboard gets a SALTED HASH of the click id, used only so reloading
 *     a landing page is not counted as a second click.
 *   - The visitor's device gets nothing at all.
 *
 * KNOWN LIMIT, stated rather than discovered later: the reference is derived
 * from the click id in the URL, so it survives for as long as that URL is the
 * page being viewed. A visitor who lands from an ad and converts ON THAT PAGE
 * is joined — which is the normal path, because every ad points at a product
 * page carrying both the quote embed and the enquiry form. A visitor who
 * navigates away first and converts two pages later is not, and their lead
 * reports as unattributed while their CLICK is still counted. Cost per lead is
 * therefore slightly conservative for paid, never inflated. Closing that gap
 * needs either device storage (which needs consent) or link decoration (which
 * puts a query string on internal URLs); neither was worth it at current volume
 * and both are reversible decisions.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_ad_click_parameters(): array
{
    return ['gclid', 'gbraid', 'wbraid'];
}

/**
 * The ad click identifier in a set of query parameters.
 *
 * @return array{type: string, id: string}|array{}
 */
function fenster_ad_click_from_params(array $params): array
{
    foreach (fenster_ad_click_parameters() as $parameter) {
        $value = isset($params[$parameter]) ? sanitize_text_field((string) $params[$parameter]) : '';
        if ($value !== '' && preg_match('/^[A-Za-z0-9_.-]{10,200}$/', $value)) {
            return ['type' => $parameter, 'id' => $value];
        }
    }

    return [];
}

/**
 * The ad click identifier on the current request, if there is one.
 *
 * Still used by the cache-header guard in `inc/generated-pages.php`, which runs
 * on requests that DO reach PHP.
 *
 * @return array{type: string, id: string}|array{}
 */
function fenster_ad_click_from_request(): array
{
    static $click = null;

    if ($click === null) {
        $click = fenster_ad_click_from_params(wp_unslash($_GET));
    }

    return $click;
}

/**
 * The opaque same-visit reference for this ad click.
 *
 * Derived from the click id rather than randomised, so a reload or a back
 * button produces the same reference instead of a second one. It is a one-way
 * HMAC, so the click id cannot be recovered from it by anyone holding the
 * reference — which is what lets it travel to WindowCAD and into the dashboard
 * without breaching the never-share-a-click-id rule.
 */
function fenster_ad_attribution_reference_for(string $click_id): string
{
    if ($click_id === '') {
        return '';
    }

    return 'FGA-' . strtoupper(substr(hash_hmac('sha256', $click_id, wp_salt('auth')), 0, 18));
}

/**
 * The dedupe key sent to the dashboard in place of the click id.
 *
 * A different salt from the reference above, so holding one never yields the
 * other.
 */
function fenster_ad_click_hash(string $click_id): string
{
    return substr(hash_hmac('sha256', $click_id, wp_salt('secure_auth')), 0, 32);
}

/**
 * Campaign context from the landing URL's ValueTrack/UTM suffix.
 */
function fenster_ad_context_from_params(array $params): array
{
    $get = static function (string $key) use ($params): string {
        return isset($params[$key]) ? sanitize_text_field((string) $params[$key]) : '';
    };

    return [
        'source' => $get('utm_source'),
        'medium' => $get('utm_medium'),
        'campaign' => $get('utm_campaign'),
        'content' => $get('utm_content'),
        'term' => $get('utm_term'),
        // The readable ad-group tracker the Google Ads suffix copies in as
        // `ads={adgroupid}`, and which WindowCAD carries in its own `ads` field.
        'ad_group' => $get('ads'),
    ];
}

function fenster_ad_context_key(string $reference): string
{
    return 'fenster_adctx_' . substr(hash_hmac('sha256', strtoupper($reference), wp_salt('auth')), 0, 40);
}

/**
 * The stored context for a reference that arrived with a form or a quote.
 */
function fenster_ad_context_for_reference(string $reference): array
{
    if (! preg_match('/^FGA-[A-Z0-9-]{8,80}$/i', $reference)) {
        return [];
    }

    $record = get_transient(fenster_ad_context_key($reference));

    return is_array($record) ? $record : [];
}

function fenster_ad_device_class(): string
{
    if (! function_exists('wp_is_mobile')) {
        return 'desktop';
    }

    $agent = strtolower((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''));
    if (str_contains($agent, 'ipad') || str_contains($agent, 'tablet')) {
        return 'tablet';
    }

    return wp_is_mobile() ? 'mobile' : 'desktop';
}

/**
 * Record an ad click. REST, because the landing page itself is cached.
 *
 * THIS WAS A `template_redirect` HOOK AND IT RECORDED NOTHING ON LIVE.
 *
 * SiteGround's proxy caches the generated pages by PATH, ignoring the query
 * string. Proven on production: a `?gclid=` value never used before still came
 * back `X-Proxy-Cache: HIT`, and an extra unknown parameter did not change it.
 * So on the one request that matters — a paid visitor arriving on a popular
 * landing page — PHP is never executed at all, the hook never fires, and
 * `nocache_headers()` cannot help because nothing is running to send it.
 *
 * The test site could not have caught this: it is Basic Auth protected, which
 * disables the proxy cache, so every page there is a cache miss.
 *
 * A REST route is not proxy-cached, and the browser runs on a cached page, so
 * the click is reported from the visitor rather than inferred from their
 * request. Everything that must stay server-side still is: the hashing, the
 * salts, the stored context and the relay. The browser only forwards the query
 * string it was already given.
 */
add_action('rest_api_init', 'fenster_register_ad_click_route');
function fenster_register_ad_click_route(): void
{
    register_rest_route('fenster/v1', '/ad-click', [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'fenster_record_ad_click',
        'permission_callback' => 'fenster_ad_attribution_request_allowed',
    ]);
}

function fenster_record_ad_click(WP_REST_Request $request): WP_REST_Response
{
    // The user agent on this request is the visitor's own, so the crawler gate
    // still applies exactly as it would on a page view.
    if (! fenster_request_may_be_tracked()) {
        return new WP_REST_Response(['reference' => ''], 200);
    }

    $params = [];
    parse_str(ltrim((string) $request->get_param('search'), '?'), $params);

    $click = fenster_ad_click_from_params($params);
    if ($click === []) {
        return new WP_REST_Response(['reference' => ''], 200);
    }

    $landing_path = (string) wp_parse_url((string) $request->get_param('path'), PHP_URL_PATH);
    if ($landing_path === '' || $landing_path[0] !== '/') {
        $landing_path = '/';
    }

    $reference = fenster_ad_attribution_reference_for($click['id']);
    $context = fenster_ad_context_from_params($params);

    /*
     * The context is kept server-side against the reference so a lead arriving
     * later in the visit can be attributed without the browser having had to
     * remember anything. 90 days matches the Google Ads conversion window
     * already used for the click id itself.
     *
     * `set_transient` is idempotent for a repeated click, and the dashboard
     * dedupes on the hash, so a reload costs a rewrite and never a second row.
     */
    set_transient(
        fenster_ad_context_key($reference),
        $context + [
            'click_type' => $click['type'],
            'click_hash' => fenster_ad_click_hash($click['id']),
            'landing_path' => $landing_path,
            'recorded_at' => gmdate('c'),
        ],
        90 * DAY_IN_SECONDS
    );

    fenster_relay_ad_click($click, $context, $reference, $landing_path);

    // The reference goes back so the browser can stamp forms and the WindowCAD
    // URL with it. It is one-way and carries no click id.
    return new WP_REST_Response(['reference' => $reference], 200);
}

function fenster_website_dashboard_ad_click_url(): string
{
    return (string) preg_replace('#/event/?$#', '/ad-click', fenster_website_dashboard_url());
}

/**
 * Send the click to the dashboard. Never blocking.
 *
 * This runs on the landing request of a paid visitor, so it must not be allowed
 * to hold up the page. Losing an attribution row costs a row; a slow first
 * paint on a £3.20 click costs the visit. Same reasoning as the Meta relay.
 */
function fenster_relay_ad_click(array $click, array $context, string $reference, string $landing_path): void
{
    $endpoint = fenster_website_dashboard_ad_click_url();
    if ($endpoint === '' || fenster_website_dashboard_secret() === '') {
        return;
    }

    wp_remote_post($endpoint, [
        'timeout' => 2,
        'blocking' => false,
        'headers' => [
            'Content-Type' => 'application/json',
            'X-Fenster-Website-Secret' => fenster_website_dashboard_secret(),
        ],
        'body' => wp_json_encode([
            // The hash, never the click id itself.
            'click_hash' => fenster_ad_click_hash($click['id']),
            'click_type' => $click['type'],
            'occurred_at' => gmdate('c'),
            'landing_path' => $landing_path,
            'source' => $context['source'] !== '' ? $context['source'] : 'google',
            'medium' => $context['medium'] !== '' ? $context['medium'] : 'cpc',
            'campaign' => $context['campaign'],
            'content' => $context['content'],
            'term' => $context['term'],
            'ad_group' => $context['ad_group'],
            'device_type' => fenster_ad_device_class(),
            'traffic_class' => fenster_request_traffic_class(),
            'attribution_ref' => $reference,
            'origin' => home_url('/'),
            'environment' => fenster_website_tracking_environment(),
        ]),
    ]);
}

/**
 * Attach the result to the click that produced it.
 *
 * Called when a lead is saved. Blocking is fine here: it runs after the
 * customer has their response, not before it.
 */
function fenster_relay_ad_click_outcome(string $reference, string $outcome, float $value = 0): void
{
    $context = fenster_ad_context_for_reference($reference);
    $click_hash = (string) ($context['click_hash'] ?? '');

    if ($click_hash === ''
        || ! in_array($outcome, ['form_submitted', 'quote_completed'], true)
        || fenster_website_dashboard_secret() === ''
    ) {
        return;
    }

    $response = wp_remote_post(fenster_website_dashboard_ad_click_url(), [
        'timeout' => 8,
        'blocking' => true,
        'headers' => [
            'Content-Type' => 'application/json',
            'X-Fenster-Website-Secret' => fenster_website_dashboard_secret(),
        ],
        'body' => wp_json_encode([
            'click_hash' => $click_hash,
            'outcome' => $outcome,
            'outcome_value' => max(0, $value),
            'origin' => home_url('/'),
            'environment' => fenster_website_tracking_environment(),
        ]),
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        error_log('Fenster ad click outcome relay failed for reference: ' . $reference);
    }
}
