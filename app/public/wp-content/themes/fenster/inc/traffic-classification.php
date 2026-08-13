<?php
/**
 * Server-side traffic classification.
 *
 * Every number in the Marketing Dashboard was inflated by automated traffic
 * because nothing anywhere classified the request. There was no user-agent
 * check in the theme and none at the dashboard ingest either, so any crawler
 * that executes JavaScript became a real visitor with a real journey and a real
 * page view. The fingerprint was already in the data and had been read as
 * noise: 1,120 banner impressions against 152 choices in the launch audit, and
 * 466 impressions on 3 August 2026 against 35 choices.
 *
 * This has to be SERVER-SIDE. A check inside the page can only see what the
 * page is told, and the point of the exercise is to decide whether to hand the
 * page a tracking endpoint at all.
 *
 * WHAT THIS DOES NOT CATCH, stated plainly so nobody reads a filtered figure as
 * a guaranteed one: a scraper that sends a real browser's user agent is
 * indistinguishable here and will still be counted. Catching those needs
 * reverse-DNS verification or behavioural scoring, neither of which is worth
 * its cost at this site's volume. The bulk of the inflation is honest crawlers
 * that identify themselves, and this removes them.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

/**
 * User agents that identify themselves as automated.
 *
 * Matched as plain lowercase substrings, so order and word boundaries do not
 * matter here. The generic rule below is the one that needs care.
 */
function fenster_known_bot_agents(): array
{
    return [
        // Search engines.
        'googlebot', 'google-inspectiontool', 'storebot-google', 'google favicon',
        'bingbot', 'bingpreview', 'adidxbot', 'msnbot',
        'slurp', 'duckduckbot', 'duckassistbot', 'baiduspider', 'yandex',
        'sogou', 'exabot', 'seznambot', 'petalbot', 'applebot', 'qwantbot',
        'naver', 'coccocbot', 'mojeekbot', 'gigabot', 'marginalia',

        // SEO and marketing crawlers.
        'ahrefsbot', 'ahrefssiteaudit', 'semrushbot', 'mj12bot', 'dotbot',
        'rogerbot', 'blexbot', 'screaming frog', 'sitebulb', 'serpstatbot',
        'dataforseobot', 'barkrowler', 'zoominfobot', 'linkdexbot', 'sistrix',
        'seokicks', 'searchmetricsbot', 'majestic', 'cognitiveseo', 'awariobot',
        'brandwatch', 'similartech', 'builtwith', 'wappalyzer', 'netcraft',

        // AI and dataset crawlers.
        'gptbot', 'chatgpt-user', 'oai-searchbot', 'ccbot', 'claudebot',
        'claude-web', 'claude-searchbot', 'anthropic-ai', 'perplexitybot',
        'perplexity-user', 'google-extended', 'bytespider', 'amazonbot',
        'meta-externalagent', 'meta-externalfetcher', 'facebookbot', 'diffbot',
        'imagesiftbot', 'omgili', 'omgilibot', 'youbot', 'timpibot', 'webzio',
        'cohere-ai', 'cohere-training-data-crawler', 'ai2bot', 'firecrawl',
        'scrapy', 'nettle', 'velenpublicwebcrawler', 'iaskspider',

        // Link previewers and social unfurlers. These fire on every share and
        // on some messaging apps for every link in a conversation.
        'facebookexternalhit', 'twitterbot', 'linkedinbot', 'slackbot',
        'slack-imgproxy', 'whatsapp', 'telegrambot', 'discordbot', 'discourse',
        'pinterest', 'redditbot', 'embedly', 'quora link preview',
        'skypeuripreview', 'vkshare', 'tumblr', 'nuzzel', 'bitlybot',
        'outbrain', 'flipboard', 'google-pagerenderer', 'yahoo link preview',

        // Uptime, performance and security monitors.
        'uptimerobot', 'pingdom', 'statuscake', 'site24x7', 'newrelicpinger',
        'datadog', 'hetrixtool', 'betteruptime', 'uptime-kuma', 'freshping',
        'chrome-lighthouse', 'pagespeed', 'gtmetrix', 'webpagetest', 'pingbot',
        'observatory', 'ssllabs', 'qualys', 'detectify', 'sucuri', 'wpscan',

        // Headless browsers and automation. A real visitor never sends these.
        'headlesschrome', 'phantomjs', 'puppeteer', 'playwright', 'selenium',
        'webdriver', 'cypress', 'electron/', 'jsdom', 'splash', 'zombie.js',

        // Libraries and command-line clients.
        'curl/', 'wget', 'python-requests', 'python-urllib', 'aiohttp',
        'go-http-client', 'okhttp', 'axios/', 'node-fetch', 'got/', 'undici',
        'java/', 'apache-httpclient', 'httpclient', 'guzzlehttp', 'libwww-perl',
        'lwp::simple', 'mechanize', 'httpie', 'postmanruntime', 'insomnia',
        'restsharp', 'rest-client', 'faraday', 'typhoeus', 'urlgrabber',

        // Feed readers and archivers.
        'feedfetcher', 'feedburner', 'feedly', 'inoreader', 'newsblur',
        'ia_archiver', 'archive.org_bot', 'wayback', 'heritrix', 'commoncrawl',
    ];
}

/**
 * User agents that contain a generic bot token but are real people.
 *
 * `CUBOT` is an Android handset brand and its phones send a user agent reading
 * `Mozilla/5.0 (Linux; Android 10; CUBOT_X30...)`. A bare `bot` substring test
 * therefore classifies every Cubot owner as a crawler and quietly deletes them
 * from the data. There is no way to notice that from a dashboard, which is why
 * the exclusion is here rather than discovered later.
 */
function fenster_bot_token_exceptions(): array
{
    return ['cubot', 'aboutus', 'robotics', 'botswana', 'abbot', 'talkbot'];
}

/**
 * Whether the current request looks automated.
 *
 * IMPORTANT: this describes the CURRENT HTTP request, so it is only meaningful
 * on a front-end page render. Do not call it from a server-to-server context.
 * The WindowCAD completion callback arrives with a non-browser user agent and
 * would classify as a bot, which would silently drop completed quotes from the
 * dashboard — the exact class of failure this file exists to prevent.
 */
function fenster_request_is_bot(): bool
{
    static $is_bot = null;

    if ($is_bot !== null) {
        return $is_bot;
    }

    $agent = strtolower(trim((string) ($_SERVER['HTTP_USER_AGENT'] ?? '')));

    // A real browser always sends a user agent. An empty one is either a
    // scripted client or something deliberately hiding, and neither is a
    // visitor worth counting.
    if ($agent === '') {
        $is_bot = true;

        return (bool) apply_filters('fenster_request_is_bot', $is_bot, $agent);
    }

    foreach (fenster_known_bot_agents() as $needle) {
        if (str_contains($agent, $needle)) {
            $is_bot = true;

            return (bool) apply_filters('fenster_request_is_bot', $is_bot, $agent);
        }
    }

    $is_bot = fenster_agent_has_generic_bot_token($agent);

    return (bool) apply_filters('fenster_request_is_bot', $is_bot, $agent);
}

/**
 * Catch self-identifying agents the named list has not met yet.
 *
 * New crawlers appear constantly and a list alone goes stale, so anything
 * carrying `bot`, `crawler`, `spider` or `scraper` as a recognisable token is
 * treated as automated. The exceptions above are removed first, because the
 * token test cannot tell `Googlebot` from `CUBOT_X30` on shape alone.
 */
function fenster_agent_has_generic_bot_token(string $agent): bool
{
    foreach (fenster_bot_token_exceptions() as $exception) {
        $agent = str_replace($exception, '', $agent);
    }

    return (bool) preg_match('/(?:bot|crawl(?:er)?|spider|scrape[rd]?)(?:[^a-z0-9]|$)/', $agent);
}

/**
 * The traffic class recorded against anything this request produces.
 *
 * `human` is deliberately the label for "not identifiably automated" rather
 * than a claim that a person was present. See the file header.
 */
function fenster_request_traffic_class(): string
{
    return fenster_request_is_bot() ? 'bot' : 'human';
}

/**
 * Whether this request may be given browser tracking at all.
 *
 * One gate, used by both the tracking config and the consent layer, so the two
 * cannot drift apart and start disagreeing about who is being measured.
 */
function fenster_request_may_be_tracked(): bool
{
    if (fenster_request_is_bot()) {
        return false;
    }

    // Logged-in staff browsing the live site are not customers and should not
    // appear in acquisition reporting. Previously they did.
    if (is_user_logged_in()) {
        return false;
    }

    return (bool) apply_filters('fenster_request_may_be_tracked', true);
}
