<?php
/**
 * IndexNow for Bing (and Yandex, Seznam, Naver). SEO plan 10/11/2026, 0.4.
 *
 * Bing sent 6 leads from 41 visits in October, the best rate of any channel,
 * and Bing recrawls on its own timetable unless told a page changed. IndexNow
 * is that telling: a public key file on the site proves ownership, then a list
 * of changed URLs is posted to api.indexnow.org.
 *
 * The key is not a secret. The protocol publishes it at /<key>.txt, and anyone
 * can read it; all it allows is asking search engines to recrawl this site.
 *
 * Submitting, after a deploy to LIVE (it refuses to run anywhere else, because
 * the URLs must be on the host the key file is served from):
 *
 *     wp fenster indexnow --since=2026-11-10
 *         every sitemap URL whose <lastmod> is on or after that day
 *     wp fenster indexnow https://fensterglazing.com/online-quote/ ...
 *         exactly the URLs given
 *     add --dry-run to print the list without sending it.
 *
 * The lastmod dates come from data/sitemap-lastmod.json, so run
 * scripts/build-sitemap-lastmod.py and commit its output before deploying.
 */

const FENSTER_INDEXNOW_KEY = '50df79f222f6ba0bbba3e413ec26fc67';

/** Serves /<key>.txt before WordPress looks for a page there. */
add_action('init', 'fenster_serve_indexnow_key', 0);
function fenster_serve_indexnow_key(): void
{
    $path = (string) wp_parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH);
    if ($path !== '/' . FENSTER_INDEXNOW_KEY . '.txt') {
        return;
    }

    status_header(200);
    header('Content-Type: text/plain; charset=utf-8');
    header('Cache-Control: public, max-age=86400');
    echo FENSTER_INDEXNOW_KEY;
    exit;
}

function fenster_indexnow_production_host(): string
{
    return 'fensterglazing.com';
}

/** Sitemap URLs whose lastmod is on or after $since (Y-m-d). */
function fenster_indexnow_urls_since(string $since): array
{
    $urls = [];
    foreach (fenster_generated_sitemap_entries() as $entry) {
        $lastmod = substr((string) ($entry['lastmod'] ?? ''), 0, 10);
        if ($lastmod !== '' && strcmp($lastmod, $since) >= 0 && ! empty($entry['loc'])) {
            $urls[] = (string) $entry['loc'];
        }
    }

    return array_values(array_unique($urls));
}

/** Posts up to 10,000 URLs in one request; the HTTP status, or an error string. */
function fenster_indexnow_submit(array $urls)
{
    $host = fenster_indexnow_production_host();
    $response = wp_remote_post('https://api.indexnow.org/indexnow', [
        'timeout' => 20,
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'body' => (string) wp_json_encode([
            'host' => $host,
            'key' => FENSTER_INDEXNOW_KEY,
            'keyLocation' => 'https://' . $host . '/' . FENSTER_INDEXNOW_KEY . '.txt',
            'urlList' => array_slice(array_values($urls), 0, 10000),
        ]),
    ]);
    if (is_wp_error($response)) {
        return $response->get_error_message();
    }

    return (int) wp_remote_retrieve_response_code($response);
}

if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command('fenster indexnow', static function (array $args, array $assoc_args): void {
        $host = strtolower((string) wp_parse_url(home_url('/'), PHP_URL_HOST));
        $since = (string) ($assoc_args['since'] ?? '');
        $urls = $args;
        if ($since !== '') {
            if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $since)) {
                WP_CLI::error('--since takes a date as YYYY-MM-DD.');
            }
            $urls = array_merge($urls, fenster_indexnow_urls_since($since));
        }
        $production = fenster_indexnow_production_host();
        $urls = array_values(array_unique(array_filter($urls, static fn (string $url): bool => strtolower((string) wp_parse_url($url, PHP_URL_HOST)) === $production)));

        if ($urls === []) {
            WP_CLI::success('Nothing to submit.');
            return;
        }
        WP_CLI::log(implode("\n", $urls));
        WP_CLI::log(count($urls) . ' URLs.');
        if (isset($assoc_args['dry-run'])) {
            return;
        }
        if ($host !== $production) {
            WP_CLI::error('Refusing to submit from ' . $host . ': IndexNow URLs must be on ' . $production . ', where the key file is served. Use --dry-run here.');
        }

        $result = fenster_indexnow_submit($urls);
        if ($result === 200 || $result === 202) {
            WP_CLI::success('IndexNow accepted the list (HTTP ' . $result . ').');
        } else {
            WP_CLI::error('IndexNow refused the list: ' . (is_int($result) ? 'HTTP ' . $result : $result));
        }
    });
}
