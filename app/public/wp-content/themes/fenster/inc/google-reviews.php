<?php
/**
 * Live Google review integration.
 *
 * Reads the real rating, review count and latest reviews from the Google
 * Places API so the review showcase is never stale. The API key is server-side
 * only; it is never rendered into the page and never committed. When no key is
 * configured, or the API fails, the curated reviews in `inc/site-data.php`
 * remain the fallback so the section always renders.
 *
 * Google's terms require visible attribution for review content, so each card
 * shows the reviewer's own name/photo and links to the review on Google.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

const FENSTER_GOOGLE_REVIEWS_TRANSIENT = 'fenster_google_reviews_v1';
const FENSTER_GOOGLE_PLACE_ID_OPTION = 'fenster_google_place_id';

/**
 * Server-side configuration lookup: constant, then environment, then option.
 */
function fenster_google_config_value(string $key, string $option = ''): string
{
    if (defined($key)) {
        return trim((string) constant($key));
    }

    $value = getenv($key);
    if (is_string($value) && trim($value) !== '') {
        return trim($value);
    }

    if (isset($_ENV[$key]) && trim((string) $_ENV[$key]) !== '') {
        return trim((string) $_ENV[$key]);
    }

    if ($option !== '') {
        $stored = get_option($option, '');
        if (is_string($stored) && trim($stored) !== '') {
            return trim($stored);
        }
    }

    return '';
}

function fenster_google_places_api_key(): string
{
    return fenster_google_config_value('FENSTER_GOOGLE_PLACES_API_KEY', 'fenster_google_places_api_key');
}

/**
 * The Google Place ID for the showroom.
 *
 * Configure it directly to avoid a lookup, or let it resolve once from the
 * business name and address and persist to an option.
 */
function fenster_google_place_id(): string
{
    $configured = fenster_google_config_value('FENSTER_GOOGLE_PLACE_ID', FENSTER_GOOGLE_PLACE_ID_OPTION);
    if ($configured !== '') {
        return $configured;
    }

    $key = fenster_google_places_api_key();
    if ($key === '') {
        return '';
    }

    $response = wp_remote_post('https://places.googleapis.com/v1/places:searchText', [
        'timeout' => 8,
        'headers' => [
            'Content-Type' => 'application/json',
            'X-Goog-Api-Key' => $key,
            'X-Goog-FieldMask' => 'places.id,places.displayName,places.formattedAddress',
        ],
        'body' => wp_json_encode([
            'textQuery' => 'Fenster Glazing, 98 Alston Drive, Bradwell Abbey, Milton Keynes MK13 9HF',
            'maxResultCount' => 1,
        ]),
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        return '';
    }

    $body = json_decode((string) wp_remote_retrieve_body($response), true);
    $place_id = (string) ($body['places'][0]['id'] ?? '');
    if ($place_id !== '') {
        update_option(FENSTER_GOOGLE_PLACE_ID_OPTION, $place_id, false);
    }

    return $place_id;
}

/**
 * Cached Google Place details: rating, total review count and latest reviews.
 *
 * Cached for six hours. Failures are cached briefly too, so a broken key or an
 * API outage cannot add a blocking request to every page load.
 */
function fenster_google_place_details(): array
{
    $cached = get_transient(FENSTER_GOOGLE_REVIEWS_TRANSIENT);
    if (is_array($cached)) {
        return $cached;
    }

    $empty = ['rating' => 0.0, 'count' => 0, 'reviews' => [], 'maps_url' => ''];

    $key = fenster_google_places_api_key();
    $place_id = $key !== '' ? fenster_google_place_id() : '';
    if ($key === '' || $place_id === '') {
        set_transient(FENSTER_GOOGLE_REVIEWS_TRANSIENT, $empty, 15 * MINUTE_IN_SECONDS);
        return $empty;
    }

    $response = wp_remote_get('https://places.googleapis.com/v1/places/' . rawurlencode($place_id), [
        'timeout' => 8,
        'headers' => [
            'X-Goog-Api-Key' => $key,
            'X-Goog-FieldMask' => 'rating,userRatingCount,googleMapsUri,reviews',
        ],
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) >= 300) {
        error_log('Fenster Google reviews: place details request failed.');
        set_transient(FENSTER_GOOGLE_REVIEWS_TRANSIENT, $empty, 15 * MINUTE_IN_SECONDS);
        return $empty;
    }

    $body = json_decode((string) wp_remote_retrieve_body($response), true);
    if (! is_array($body)) {
        set_transient(FENSTER_GOOGLE_REVIEWS_TRANSIENT, $empty, 15 * MINUTE_IN_SECONDS);
        return $empty;
    }

    $details = [
        'rating' => round((float) ($body['rating'] ?? 0), 1),
        'count' => (int) ($body['userRatingCount'] ?? 0),
        'maps_url' => esc_url_raw((string) ($body['googleMapsUri'] ?? '')),
        'reviews' => fenster_google_normalise_reviews($body['reviews'] ?? []),
    ];

    set_transient(FENSTER_GOOGLE_REVIEWS_TRANSIENT, $details, 6 * HOUR_IN_SECONDS);

    return $details;
}

/**
 * Reduce the Places API review payload to the shape the showcase renders.
 *
 * Only the reviewer's own attribution, rating, text and link are kept.
 */
function fenster_google_normalise_reviews($reviews): array
{
    if (! is_array($reviews)) {
        return [];
    }

    $clean = [];

    foreach ($reviews as $review) {
        if (! is_array($review)) {
            continue;
        }

        $text = (string) ($review['originalText']['text'] ?? $review['text']['text'] ?? '');
        $text = trim(wp_strip_all_tags($text));
        $author = trim((string) ($review['authorAttribution']['displayName'] ?? ''));

        if ($text === '' || $author === '') {
            continue;
        }

        $published = (string) ($review['publishTime'] ?? '');
        $timestamp = $published !== '' ? strtotime($published) : false;

        $clean[] = [
            'source' => 'Google',
            'rating' => max(1, min(5, (int) ($review['rating'] ?? 5))),
            'author' => sanitize_text_field($author),
            'author_photo' => esc_url_raw((string) ($review['authorAttribution']['photoUri'] ?? '')),
            'date' => $timestamp ? gmdate('Y-m-d', $timestamp) : '',
            'relative_date' => sanitize_text_field((string) ($review['relativePublishTimeDescription'] ?? '')),
            'quote' => $text,
            'url' => esc_url_raw((string) ($review['googleMapsUri'] ?? $review['authorAttribution']['uri'] ?? '')),
            'context' => '',
            'live' => true,
        ];
    }

    return $clean;
}

/**
 * The rating summary shown above the carousel.
 *
 * Live figures when the API is configured; otherwise the owner-verified
 * fallback in `inc/site-data.php`, which must be kept accurate by hand.
 */
function fenster_review_summary(): array
{
    $details = fenster_google_place_details();

    if ($details['count'] > 0 && $details['rating'] > 0) {
        return [
            'rating' => $details['rating'],
            'count' => $details['count'],
            'live' => true,
        ];
    }

    return [
        'rating' => (float) fenster_data('brand.google_rating', 4.9),
        'count' => (int) fenster_data('brand.google_review_count', 0),
        'live' => false,
    ];
}

/**
 * Canonical Google review URLs, built from the resolved place ID.
 *
 * These are the real review panel and review form, not a Google search query.
 */
function fenster_google_reviews_url(): string
{
    $place_id = fenster_google_config_value('FENSTER_GOOGLE_PLACE_ID', FENSTER_GOOGLE_PLACE_ID_OPTION);
    if ($place_id !== '') {
        return 'https://search.google.com/local/reviews?placeid=' . rawurlencode($place_id);
    }

    $configured = (string) fenster_data('brand.google_reviews_url', '');

    return $configured !== '' ? $configured : 'https://www.google.com/maps/place/?q=place_id:';
}

function fenster_google_write_review_url(): string
{
    $place_id = fenster_google_config_value('FENSTER_GOOGLE_PLACE_ID', FENSTER_GOOGLE_PLACE_ID_OPTION);

    return $place_id !== ''
        ? 'https://search.google.com/local/writereview?placeid=' . rawurlencode($place_id)
        : fenster_google_reviews_url();
}

/**
 * The review set the showcase renders.
 *
 * Live Google reviews lead because they are current and verifiable; the
 * curated set backfills so the carousel keeps its card count. When a context
 * is supplied (a product name or a town), matching reviews are promoted so a
 * Milton Keynes page shows Milton Keynes proof.
 */
function fenster_review_cards(int $limit = 7, string $context = ''): array
{
    $live = fenster_google_place_details()['reviews'];
    $curated = fenster_data('customer_reviews', []);
    $curated = is_array($curated) ? array_values($curated) : [];

    // Drop curated entries that duplicate a live review by author.
    $live_authors = array_map(
        static fn (array $review): string => strtolower((string) $review['author']),
        $live
    );
    $curated = array_values(array_filter(
        $curated,
        static fn ($review): bool => is_array($review)
            && ! in_array(strtolower((string) ($review['author'] ?? '')), $live_authors, true)
    ));

    $cards = array_merge($live, $curated);

    $context = strtolower(trim($context));
    if ($context !== '') {
        $terms = array_values(array_filter(array_map('trim', explode(' ', $context))));
        usort($cards, static function (array $left, array $right) use ($context, $terms): int {
            $score = static function (array $review) use ($context, $terms): int {
                $haystack = strtolower(
                    (string) ($review['context'] ?? '') . ' ' . (string) ($review['quote'] ?? '')
                );
                if ($context !== '' && str_contains($haystack, $context)) {
                    return 2;
                }
                foreach ($terms as $term) {
                    if (strlen($term) > 3 && str_contains($haystack, $term)) {
                        return 1;
                    }
                }
                return 0;
            };

            return $score($right) <=> $score($left);
        });
    }

    return array_slice($cards, 0, max(1, $limit));
}

/**
 * Clear the cache when the key or place changes so a fix takes effect at once.
 */
add_action('update_option_fenster_google_places_api_key', 'fenster_google_reviews_flush_cache');
add_action('update_option_' . FENSTER_GOOGLE_PLACE_ID_OPTION, 'fenster_google_reviews_flush_cache');
function fenster_google_reviews_flush_cache(): void
{
    delete_transient(FENSTER_GOOGLE_REVIEWS_TRANSIENT);
}
