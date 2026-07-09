<?php
/**
 * Cookie consent and third-party tracking controls.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

const FENSTER_GTM_ID = 'GTM-K89BCS9';
const FENSTER_CLARITY_ID = 'xi7rk1pic8';
const FENSTER_META_PIXEL_ID = '4315058575189194';

add_filter('option_ihaf_insert_header', 'fenster_empty_public_tracking_option', PHP_INT_MAX);
add_filter('option_ihaf_insert_body', 'fenster_empty_public_tracking_option', PHP_INT_MAX);
add_filter('option_ihaf_insert_footer', 'fenster_empty_public_tracking_option', PHP_INT_MAX);
add_filter('option_clarity_project_id', 'fenster_empty_public_tracking_option', PHP_INT_MAX);
add_filter('option_clarity_wordpress_site_id', 'fenster_empty_public_tracking_option', PHP_INT_MAX);

function fenster_empty_public_tracking_option($value)
{
    if (is_admin() || wp_doing_ajax() || wp_is_json_request()) {
        return $value;
    }

    return '';
}

add_action('template_redirect', 'fenster_start_tracking_output_buffer', 0);
function fenster_start_tracking_output_buffer(): void
{
    if (is_admin() || wp_doing_ajax() || wp_is_json_request()) {
        return;
    }

    ob_start('fenster_strip_ungated_tracking_output');
}

function fenster_strip_ungated_tracking_output(string $html): string
{
    $patterns = [
        '/<!-- Google Tag Manager -->.*?<!-- End Google Tag Manager -->\\s*/is',
        '/<!-- Google Tag Manager \\(noscript\\) -->.*?<!-- End Google Tag Manager \\(noscript\\) -->\\s*/is',
        '/<!-- Meta Pixel Code -->.*?<!-- End Meta Pixel Code -->\\s*/is',
        '/<!-- Meta Pixel Event Code -->.*?<!-- End Meta Pixel Event Code -->\\s*/is',
        '/<div id=[\'"]fb-pxl-ajax-code[\'"]><\\/div>/i',
        '/<script\\b[^>]*>\\s*\\(function\\(c,\\s*l,\\s*a,\\s*r,\\s*i,\\s*t,\\s*y\\).*?clarity\\.ms\\/tag\\/.*?<\\/script>\\s*/is',
        '/<script\\b[^>]*>\\s*var url = window\\.location\\.origin \\+ [\'"]\\?ob=open-bridge[\'"];.*?fbq\\([\'"]init[\'"].*?<\\/script>\\s*/is',
        '/<script\\b[^>]*>\\s*fbq\\([\'"]track[\'"],\\s*[\'"]PageView[\'"].*?<\\/script>\\s*/is',
    ];

    return (string) preg_replace($patterns, '', $html);
}

add_action('wp_footer', 'fenster_render_cookie_consent', 45);
function fenster_render_cookie_consent(): void
{
    if (is_admin()) {
        return;
    }
    ?>
    <div class="fg-cookie-consent" data-fg-cookie-consent hidden>
        <div class="fg-cookie-consent__copy">
            <strong><?php esc_html_e('Cookie choices', 'fenster'); ?></strong>
            <p><?php esc_html_e('We use optional analytics and marketing cookies to understand site use and improve enquiries. They only load if you accept.', 'fenster'); ?></p>
        </div>
        <div class="fg-cookie-consent__actions">
            <button type="button" class="button button--light" data-fg-cookie-decline><?php esc_html_e('Reject', 'fenster'); ?></button>
            <button type="button" class="button" data-fg-cookie-accept><?php esc_html_e('Accept', 'fenster'); ?></button>
        </div>
        <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>"><?php esc_html_e('Cookie policy', 'fenster'); ?></a>
    </div>
    <button type="button" class="fg-cookie-settings" data-fg-cookie-settings hidden><?php esc_html_e('Cookies', 'fenster'); ?></button>
    <script>
    (function () {
        var consentKey = 'fenster_cookie_consent';
        var banner = document.querySelector('[data-fg-cookie-consent]');
        var settings = document.querySelector('[data-fg-cookie-settings]');
        var accepted = false;

        function getChoice() {
            try {
                return window.localStorage.getItem(consentKey);
            } catch (error) {
                return null;
            }
        }

        function setChoice(value) {
            try {
                window.localStorage.setItem(consentKey, value);
            } catch (error) {}
        }

        function loadScript(src) {
            var script = document.createElement('script');
            script.async = true;
            script.src = src;
            document.head.appendChild(script);
        }

        function afterVisualReady(callback) {
            var run = function () {
                window.setTimeout(function () {
                    window.requestAnimationFrame(function () {
                        window.requestAnimationFrame(callback);
                    });
                }, 750);
            };

            if (document.readyState === 'complete') {
                run();
            } else {
                window.addEventListener('load', run, { once: true });
            }
        }

        function setClarityConsent(adStorage, analyticsStorage) {
            if (typeof window.clarity !== 'function') {
                return;
            }

            window.clarity('consentv2', {
                ad_Storage: adStorage,
                analytics_Storage: analyticsStorage
            });
        }

        function revokeTrackingConsent() {
            if (typeof window.clarity === 'function') {
                setClarityConsent('denied', 'denied');
                window.clarity('consent', false);
            }
        }

        function loadTracking() {
            if (accepted) {
                setClarityConsent('granted', 'granted');
                return;
            }

            accepted = true;
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
            loadScript('https://www.googletagmanager.com/gtm.js?id=<?php echo esc_js(FENSTER_GTM_ID); ?>');

            afterVisualReady(function () {
                window.clarity = window.clarity || function () {
                    (window.clarity.q = window.clarity.q || []).push(arguments);
                };
                setClarityConsent('granted', 'granted');
                loadScript('https://www.clarity.ms/tag/<?php echo esc_js(FENSTER_CLARITY_ID); ?>');
            });

            if (! window.fbq) {
                window.fbq = function () {
                    window.fbq.callMethod ? window.fbq.callMethod.apply(window.fbq, arguments) : window.fbq.queue.push(arguments);
                };
                if (! window._fbq) {
                    window._fbq = window.fbq;
                }
                window.fbq.push = window.fbq;
                window.fbq.loaded = true;
                window.fbq.version = '2.0';
                window.fbq.queue = [];
                loadScript('https://connect.facebook.net/en_US/fbevents.js');
            }
            window.fbq('init', '<?php echo esc_js(FENSTER_META_PIXEL_ID); ?>');
            window.fbq('track', 'PageView');
        }

        function showSettingsButton() {
            if (settings) {
                settings.hidden = false;
            }
        }

        function showBanner() {
            if (banner) {
                banner.hidden = false;
            }
        }

        function hideBanner() {
            if (banner) {
                banner.hidden = true;
            }
        }

        var choice = getChoice();
        if (choice === 'accepted') {
            loadTracking();
            showSettingsButton();
        } else if (choice === 'rejected') {
            showSettingsButton();
        } else {
            showBanner();
        }

        document.addEventListener('click', function (event) {
            if (event.target.closest('[data-fg-cookie-accept]')) {
                setChoice('accepted');
                hideBanner();
                showSettingsButton();
                loadTracking();
            }

            if (event.target.closest('[data-fg-cookie-decline]')) {
                setChoice('rejected');
                hideBanner();
                showSettingsButton();
                revokeTrackingConsent();
            }

            if (event.target.closest('[data-fg-cookie-settings]')) {
                showBanner();
            }
        });
    }());
    </script>
    <?php
}
