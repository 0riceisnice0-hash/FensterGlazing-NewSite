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

/*
 * The Google Ads destination. `inc/website-tracking.php` publishes this same id
 * to the browser alongside the conversion labels, and reads it from here so
 * there is one copy of it rather than two that can drift.
 */
const FENSTER_GOOGLE_ADS_ID = 'AW-808336148';

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

    $clarity_stylesheet = FENSTER_THEME_URI . '/assets/css/main.css';
    $clarity_stylesheet_path = FENSTER_THEME_DIR . '/assets/css/main.css';

    if (file_exists($clarity_stylesheet_path)) {
        $clarity_stylesheet = add_query_arg(
            'ver',
            filemtime($clarity_stylesheet_path) . '-' . filesize($clarity_stylesheet_path),
            $clarity_stylesheet
        );
    }
    ?>
    <dialog
        class="fg-cookie-consent"
        data-fg-cookie-consent
        aria-labelledby="fg-cookie-title"
        aria-describedby="fg-cookie-summary"
    >
        <div class="fg-cookie-consent__panel">
            <button
                type="button"
                class="fg-cookie-consent__close"
                data-fg-cookie-close
                aria-label="<?php esc_attr_e('Close cookie settings', 'fenster'); ?>"
                hidden
            >&times;</button>

            <div data-fg-cookie-overview>
                <p class="fg-cookie-consent__eyebrow"><?php esc_html_e('Your privacy', 'fenster'); ?></p>
                <h2 id="fg-cookie-title"><?php esc_html_e('Choose how this website uses cookies', 'fenster'); ?></h2>
                <p id="fg-cookie-summary">
                    <?php esc_html_e('Strictly necessary storage keeps the website working and remembers your choice. We also use analytics to improve the site and marketing tools to measure advertising.', 'fenster'); ?>
                </p>
                <p class="fg-cookie-consent__note">
                    <?php esc_html_e('Analytics and marketing cookies are already on. You can turn them off in Customise, and change your choice at any time.', 'fenster'); ?>
                </p>
                <div class="fg-cookie-consent__actions fg-cookie-consent__actions--two">
                    <button type="button" class="button button--light" data-fg-cookie-customise><?php esc_html_e('Customise', 'fenster'); ?></button>
                    <button type="button" class="button" data-fg-cookie-accept-all><?php esc_html_e('Accept all', 'fenster'); ?></button>
                </div>
            </div>

            <div data-fg-cookie-custom hidden>
                <p class="fg-cookie-consent__eyebrow"><?php esc_html_e('Cookie settings', 'fenster'); ?></p>
                <h2 id="fg-cookie-custom-title"><?php esc_html_e('Choose optional cookies', 'fenster'); ?></h2>
                <p id="fg-cookie-custom-summary"><?php esc_html_e('Necessary storage is always on. The two optional categories below are on unless you switch them off.', 'fenster'); ?></p>

                <div class="fg-cookie-consent__choices">
                    <div class="fg-cookie-consent__choice">
                        <div>
                            <strong><?php esc_html_e('Strictly necessary', 'fenster'); ?></strong>
                            <p><?php esc_html_e('Required for security, forms, requested features and remembering this choice.', 'fenster'); ?></p>
                        </div>
                        <span class="fg-cookie-consent__always"><?php esc_html_e('Always on', 'fenster'); ?></span>
                    </div>
                    <label class="fg-cookie-consent__choice">
                        <span>
                            <strong><?php esc_html_e('Analytics', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Microsoft Clarity and Fenster website measurement help us understand page use and individual journeys.', 'fenster'); ?></span>
                        </span>
                        <span class="fg-cookie-consent__switch">
                            <input type="checkbox" role="switch" data-fg-cookie-analytics>
                            <span class="fg-cookie-consent__switch-track" aria-hidden="true"></span>
                        </span>
                    </label>
                    <label class="fg-cookie-consent__choice">
                        <span>
                            <strong><?php esc_html_e('Marketing', 'fenster'); ?></strong>
                            <span><?php esc_html_e('Google and Meta tools help us measure advertising and enquiries from ads.', 'fenster'); ?></span>
                        </span>
                        <span class="fg-cookie-consent__switch">
                            <input type="checkbox" role="switch" data-fg-cookie-marketing>
                            <span class="fg-cookie-consent__switch-track" aria-hidden="true"></span>
                        </span>
                    </label>
                </div>

                <div class="fg-cookie-consent__actions fg-cookie-consent__actions--three">
                    <button type="button" class="button button--steel" data-fg-cookie-necessary><?php esc_html_e('Use necessary only', 'fenster'); ?></button>
                    <button type="button" class="button button--light" data-fg-cookie-save><?php esc_html_e('Save choices', 'fenster'); ?></button>
                    <button type="button" class="button" data-fg-cookie-accept-all><?php esc_html_e('Accept all', 'fenster'); ?></button>
                </div>
            </div>

            <p class="fg-cookie-consent__policy">
                <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>"><?php esc_html_e('Read the cookie policy', 'fenster'); ?></a>
            </p>
        </div>
    </dialog>
    <script>
    (function () {
        var consentKey = 'fenster_cookie_consent';
        var consentVersion = 2;
        var consentLifetime = 180 * 24 * 60 * 60 * 1000;
        var dialog = document.querySelector('[data-fg-cookie-consent]');
        var settings = document.querySelector('[data-fg-cookie-settings]');
        var overview = dialog && dialog.querySelector('[data-fg-cookie-overview]');
        var custom = dialog && dialog.querySelector('[data-fg-cookie-custom]');
        var closeButton = dialog && dialog.querySelector('[data-fg-cookie-close]');
        var analyticsInput = dialog && dialog.querySelector('[data-fg-cookie-analytics]');
        var marketingInput = dialog && dialog.querySelector('[data-fg-cookie-marketing]');
        var mandatoryChoice = false;
        var gtmLoaded = false;
        var clarityLoaded = false;
        var metaLoaded = false;
        var googleAdsLoaded = false;
        var bannerShownRecorded = false;

        /*
         * Decided server-side in `inc/traffic-classification.php`, because only
         * the server sees the real user agent. False for crawlers and for
         * logged-in staff. Blanking the dashboard endpoints already stops our
         * own measurement; this is what stops Clarity, GTM and Meta being fed
         * as well, so crawler sessions no longer appear in replay or in Google
         * and Meta reporting.
         */
        var trackingAllowed = <?php echo fenster_request_may_be_tracked() ? 'true' : 'false'; ?>;

        function recordConsentMetric(choice) {
            var endpoint = window.fensterWebsiteTracking && window.fensterWebsiteTracking.consentEndpoint;
            if (! endpoint) {
                return;
            }

            window.fetch(endpoint, {
                method: 'POST',
                mode: 'cors',
                keepalive: true,
                // Keep this a CORS "simple request". Some mobile/privacy
                // browsers abandon a JSON preflight while the visitor closes
                // the banner. This contains aggregate consent only.
                headers: { 'Content-Type': 'text/plain;charset=UTF-8' },
                body: JSON.stringify({ choice: choice })
            }).catch(function () {});
        }

        /*
         * `chosen` is RECORDED but deliberately NOT REQUIRED here.
         *
         * It is written only by `setPreferences`, where every caller is a
         * button, so a stored record carrying it is one the visitor actually
         * chose. That distinction is worth keeping — it is the only way to tell
         * a real answer from an assumed one.
         *
         * It is not required for validity because optional cookies are granted
         * by default: requiring it would invalidate every existing record and
         * re-prompt the whole audience for no gain, since they are being
         * tracked either way. If the default is ever flipped back to off, add
         * `record.chosen === true` here and in `src/js/main.js` together.
         */
        function validPreferences(record) {
            return Boolean(
                record &&
                record.version === consentVersion &&
                typeof record.analytics === 'boolean' &&
                typeof record.marketing === 'boolean' &&
                Number(record.expires_at) > Date.now()
            );
        }

        /*
         * The choice is published on `window` as well as stored, because storage
         * is not always writable. A browser set to block all site data throws on
         * setItem, the write below is swallowed, and the visitor who has just
         * pressed "Accept all" reads back as having made no choice at all: the
         * banner returns, no journey id is issued, and the quote embed stays
         * blocked waiting for a decision that was already taken. The published
         * copy cannot outlive the page, which is the honest limit of a browser
         * that refuses to remember, but it makes the page they are on behave.
         */
        function publishPreferences(preferences) {
            window.fensterCookieConsent = preferences;
            return preferences;
        }

        /*
         * Optional cookies are GRANTED by default and stay on until refused
         * (owner instruction, 2026-08-09, restored 2026-08-12). It is never
         * written to storage, because a default is not a choice and the banner
         * has to keep appearing until they make one.
         *
         * The known cost of this model is that identifiers are issued before
         * the banner is answered, so somebody who then refuses has already been
         * recorded. That is what the withdrawal call in `saveChoice` exists to
         * clean up — under this default it is doing more work, not less.
         *
         * This is weaker than the ICO's position that consent must precede
         * non-essential storage. It was raised and it is the owner's decision.
         */
        function defaultPreferences() {
            return {
                version: consentVersion,
                analytics: true,
                marketing: true,
                chosen: false,
                expires_at: Date.now() + consentLifetime
            };
        }

        function getPreferences() {
            try {
                var raw = window.localStorage.getItem(consentKey);
                var stored = raw ? JSON.parse(raw) : null;

                if (validPreferences(stored)) {
                    return publishPreferences(stored);
                }

                if (raw) {
                    window.localStorage.removeItem(consentKey);
                }
            } catch (error) {
                try {
                    window.localStorage.removeItem(consentKey);
                } catch (storageError) {}
            }

            return validPreferences(window.fensterCookieConsent) ? window.fensterCookieConsent : null;
        }

        function setPreferences(analytics, marketing) {
            var preferences = {
                version: consentVersion,
                analytics: Boolean(analytics),
                marketing: Boolean(marketing),
                // Written here and ONLY here, because reaching this function is
                // the definition of a real choice: every caller is a button.
                // Its absence was the bug that made assumed consent and given
                // consent indistinguishable.
                chosen: true,
                updated_at: new Date().toISOString(),
                expires_at: Date.now() + consentLifetime
            };

            publishPreferences(preferences);

            try {
                window.localStorage.setItem(consentKey, JSON.stringify(preferences));
            } catch (error) {}

            return preferences;
        }

        function loadScript(src) {
            var script = document.createElement('script');
            script.async = true;
            script.src = src;
            document.head.appendChild(script);
        }

        function inlineStylesheetForClarity(callback) {
            var existing = document.getElementById('fenster-clarity-replay-css');

            if (existing) {
                callback();
                return;
            }

            window.fetch('<?php echo esc_js(esc_url_raw($clarity_stylesheet)); ?>', {
                credentials: 'same-origin',
                cache: 'force-cache'
            })
                .then(function (response) {
                    if (! response.ok) {
                        throw new Error('Stylesheet request failed');
                    }

                    return response.text();
                })
                .then(function (css) {
                    var style = document.createElement('style');
                    style.id = 'fenster-clarity-replay-css';
                    style.setAttribute('data-clarity-unmask', 'true');
                    style.textContent = css;
                    document.head.appendChild(style);
                })
                .catch(function () {})
                .then(callback);
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

        function configureGoogleConsent(preferences, command) {
            window.dataLayer = window.dataLayer || [];
            window.gtag = window.gtag || function () {
                window.dataLayer.push(arguments);
            };
            window.gtag('consent', command || 'update', {
                ad_storage: preferences.marketing ? 'granted' : 'denied',
                ad_user_data: preferences.marketing ? 'granted' : 'denied',
                ad_personalization: preferences.marketing ? 'granted' : 'denied',
                analytics_storage: preferences.analytics ? 'granted' : 'denied',
                functionality_storage: 'granted',
                security_storage: 'granted'
            });
        }

        function clearOptionalCookies(category) {
            var optionalCookieName = category === 'analytics'
                ? /^(?:_ga(?:_.+)?|_gid|_gat(?:_.+)?|_clck|_clsk)$/
                : /^(?:_fbp|_fbc|_gcl_.+|_gac_.+|_gads|_gpi)$/;
            var domain = window.location.hostname.replace(/^www\./, '');

            document.cookie.split(';').forEach(function (cookie) {
                var name = cookie.split('=')[0].trim();
                if (! optionalCookieName.test(name)) {
                    return;
                }

                ['', domain, '.' + domain].forEach(function (cookieDomain) {
                    var domainPart = cookieDomain ? '; domain=' + cookieDomain : '';
                    document.cookie = name + '=; Max-Age=0; path=/' + domainPart + '; SameSite=Lax';
                });
            });
        }

        /*
         * Ask the dashboard to erase what it already holds for this browser.
         *
         * Until now a refusal cleared local storage and reloaded, and that was
         * the whole of it: the visitor row, the journey and every page view
         * already relayed stayed in the dashboard with nothing to remove them.
         * Under the granted-by-default model those rows were created before the
         * banner had even rendered, so somebody who pressed "Use necessary only"
         * remained on record as a consented visitor. Consent-first makes that
         * rare, but it does not make it impossible — anyone who accepts and
         * later changes their mind from footer Cookie settings is exactly this
         * case, and they are the ones most entitled to be forgotten.
         *
         * Must run BEFORE `clearAnalyticsStorage`, which is what removes the two
         * identifiers this needs to name.
         */
        function withdrawTrackedData() {
            var endpoint = window.fensterWebsiteTracking && window.fensterWebsiteTracking.withdrawEndpoint;
            if (! endpoint || ! window.fetch) {
                return;
            }

            var stored = function (key) {
                try {
                    var record = JSON.parse(window.localStorage.getItem(key) || 'null');
                    return record && typeof record.value === 'string' ? record.value : '';
                } catch (error) {
                    return '';
                }
            };

            var journeyId = stored('fenster_quote_journey_ref');
            var visitorId = stored('fenster_website_visitor_id');
            if (! journeyId && ! visitorId) {
                return;
            }

            // `keepalive`, because the page reloads immediately afterwards and
            // an ordinary fetch would be cancelled in flight — which would look
            // exactly like a working withdrawal and delete nothing.
            window.fetch(endpoint, {
                method: 'POST',
                mode: 'cors',
                keepalive: true,
                headers: { 'Content-Type': 'text/plain;charset=UTF-8' },
                body: JSON.stringify({ journey_id: journeyId, visitor_id: visitorId })
            }).catch(function () {});
        }

        function clearAnalyticsStorage() {
            [
                'fenster_quote_journey_ref',
                'fenster_website_visitor_id',
                'fenster_website_first_touch',
                'fenster_website_event_queue'
            ].forEach(function (key) {
                try {
                    window.localStorage.removeItem(key);
                } catch (error) {}
            });
        }

        function clearMarketingStorage() {
            [
                'fenster_ad_click_id',
                'fenster_ads_tracker',
                'fenster_marketing_attribution_ref'
            ].forEach(function (key) {
                try {
                    window.localStorage.removeItem(key);
                } catch (error) {}
            });
        }

        function revokeTrackingConsent(preferences) {
            configureGoogleConsent(preferences, 'update');

            if (typeof window.clarity === 'function') {
                setClarityConsent(
                    preferences.marketing ? 'granted' : 'denied',
                    preferences.analytics ? 'granted' : 'denied'
                );
                if (! preferences.analytics) {
                    window.clarity('consent', false);
                }
            }

            if (! preferences.analytics) {
                clearAnalyticsStorage();
                clearOptionalCookies('analytics');
            }
            if (! preferences.marketing) {
                clearMarketingStorage();
                clearOptionalCookies('marketing');
            }
        }

        function loadGtm(preferences) {
            configureGoogleConsent(preferences, 'update');
            if (gtmLoaded || (! preferences.analytics && ! preferences.marketing)) {
                return;
            }

            gtmLoaded = true;
            window.dataLayer = window.dataLayer || [];
            window.dataLayer.push({'gtm.start': new Date().getTime(), event: 'gtm.js'});
            loadScript('https://www.googletagmanager.com/gtm.js?id=<?php echo esc_js(FENSTER_GTM_ID); ?>');
        }

        /*
         * The Google Ads tag, gated exactly as `loadMeta` is and for the same
         * reason: a conversion is marketing, not analytics. That also matches
         * the gate `sendGoogleAdsConversion()` already applies in
         * `src/js/main.js`, so the tag exists on precisely the visits that are
         * allowed to send one, and `GOOGLE-ADS-SETUP.md` 6c, which requires the
         * Google tag and Conversion Linker to load only after marketing
         * consent. Deliberately NOT loaded alongside GTM, which loads on
         * analytics OR marketing.
         *
         * WHY THIS WAS MISSING FOR MONTHS AND NOTHING REPORTED IT.
         * `configureGoogleConsent()` defines `window.gtag` as a dataLayer shim
         * on every page so the consent signal can be queued before any tag
         * exists. That shim satisfies the `typeof window.gtag !== 'function'`
         * guard in `sendGoogleAdsConversion()`, so every enquiry, consultation,
         * phone click and quote open called `gtag('event', 'conversion', ...)`,
         * pushed it into the dataLayer, and returned as though it had worked.
         * Nothing was listening. The real tag was never loaded anywhere in the
         * theme, and `GOOGLE-ADS-SETUP.md` 6c had meanwhile told the operator
         * not to build the equivalent tags in GTM because the site "calls the
         * known Google Ads destinations directly" — so the document pointed at
         * the code, the code pointed at a shim, and the one thing that would
         * have caught it was deliberately never created.
         *
         * The shim is not a workaround to be replaced here. It IS the standard
         * gtag queue function, byte for byte what Google's own snippet
         * declares, so the consent default and update already queued through it
         * are read in order the moment the tag arrives. Consent before tag is
         * the required order for Consent Mode, and this file already had it.
         * Do not add a second `window.gtag` definition; it would shadow the
         * queue that carries the consent state.
         */
        function loadGoogleAds(preferences) {
            if (! preferences.marketing || googleAdsLoaded) {
                return;
            }

            googleAdsLoaded = true;
            window.dataLayer = window.dataLayer || [];
            loadScript('https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js(FENSTER_GOOGLE_ADS_ID); ?>');
            window.gtag('js', new Date());
            window.gtag('config', '<?php echo esc_js(FENSTER_GOOGLE_ADS_ID); ?>');
        }

        function loadClarity(preferences) {
            if (! preferences.analytics) {
                setClarityConsent(preferences.marketing ? 'granted' : 'denied', 'denied');
                return;
            }
            if (clarityLoaded) {
                setClarityConsent(preferences.marketing ? 'granted' : 'denied', 'granted');
                return;
            }

            clarityLoaded = true;
            afterVisualReady(function () {
                inlineStylesheetForClarity(function () {
                    window.clarity = window.clarity || function () {
                        (window.clarity.q = window.clarity.q || []).push(arguments);
                    };
                    setClarityConsent(preferences.marketing ? 'granted' : 'denied', 'granted');
                    loadScript('https://www.clarity.ms/tag/<?php echo esc_js(FENSTER_CLARITY_ID); ?>');
                });
            });
        }

        function loadMeta(preferences) {
            if (! preferences.marketing || metaLoaded) {
                return;
            }

            metaLoaded = true;
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

        function applyPreferences(preferences) {
            // The consent signal is still sent when tracking is not allowed, so
            // anything that loads later cannot inherit a granted default. Only
            // the tag loading below is skipped.
            configureGoogleConsent(preferences, 'update');

            if (! trackingAllowed) {
                return;
            }

            loadGtm(preferences);
            loadGoogleAds(preferences);
            loadClarity(preferences);
            loadMeta(preferences);
        }

        function showSettingsButton() {
            if (settings) {
                settings.hidden = false;
            }
        }

        function showOverview() {
            if (dialog) {
                dialog.setAttribute('aria-labelledby', 'fg-cookie-title');
                dialog.setAttribute('aria-describedby', 'fg-cookie-summary');
            }
            if (overview) {
                overview.hidden = false;
            }
            if (custom) {
                custom.hidden = true;
            }
        }

        function syncSwitchAppearance(input) {
            var track = input && input.nextElementSibling;
            var activeColour = 'var(--color-accent)';

            if (! track || ! track.classList.contains('fg-cookie-consent__switch-track')) {
                return;
            }

            track.style.setProperty('background-color', input.checked ? activeColour : '#ffffff', 'important');
            track.style.setProperty('border-color', input.checked ? activeColour : '#6c7b80', 'important');
        }

        function syncSwitchAppearances() {
            syncSwitchAppearance(analyticsInput);
            syncSwitchAppearance(marketingInput);
        }

        function showCustom() {
            // Reflects the effective state, so the switches show what is
            // actually running. Under granted-by-default they start ON, and
            // saving without touching them keeps them on rather than silently
            // refusing tools the visitor can see are already loaded.
            var preferences = getPreferences() || defaultPreferences();
            if (dialog) {
                dialog.setAttribute('aria-labelledby', 'fg-cookie-custom-title');
                dialog.setAttribute('aria-describedby', 'fg-cookie-custom-summary');
            }
            if (analyticsInput) {
                analyticsInput.checked = Boolean(preferences && preferences.analytics);
            }
            if (marketingInput) {
                marketingInput.checked = Boolean(preferences && preferences.marketing);
            }
            syncSwitchAppearances();
            if (overview) {
                overview.hidden = true;
            }
            if (custom) {
                custom.hidden = false;
                custom.querySelector('input, button')?.focus();
            }
        }

        /*
         * `recordImpression` is separate from `isMandatory` now. The banner is
         * no longer blocking, but the first-visit impression is still the health
         * check the dashboard's `banner_shown` depends on: a live figure of zero
         * means the modal or the consent endpoint has broken. The footer
         * re-opener must still not record one, or the figure stops meaning
         * "first visits" at all.
         */
        function openDialog(isMandatory, recordImpression) {
            if (! dialog) {
                return;
            }

            mandatoryChoice = Boolean(isMandatory);
            if (recordImpression && ! bannerShownRecorded) {
                bannerShownRecorded = true;
                recordConsentMetric('shown');
            }
            closeButton.hidden = mandatoryChoice;
            showOverview();
            document.documentElement.classList.add('fg-cookie-consent-open');
            if (typeof dialog.showModal === 'function') {
                if (! dialog.open) {
                    dialog.showModal();
                }
            } else {
                dialog.setAttribute('open', '');
            }
        }

        function closeDialog() {
            if (! dialog) {
                return;
            }
            if (typeof dialog.close === 'function' && dialog.open) {
                dialog.close();
            } else {
                dialog.removeAttribute('open');
            }
            document.documentElement.classList.remove('fg-cookie-consent-open');
        }

        function saveChoice(analytics, marketing) {
            /*
             * Measured against the *effective* previous state, not the stored
             * one. Optional cookies are granted by default, so a first-time
             * visitor pressing "Use necessary only" HAS withdrawn something:
             * their identifiers were issued on the first paint and their page
             * view is already recorded. Comparing against the stored record
             * would read that as "nothing withdrawn" and leave both in place,
             * which is precisely the fault this catches.
             */
            var previous = getPreferences() || defaultPreferences();
            var preferences = setPreferences(analytics, marketing);
            var consentWithdrawn = Boolean(
                (previous.analytics && ! preferences.analytics) ||
                (previous.marketing && ! preferences.marketing)
            );

            var consentChoice = preferences.analytics && preferences.marketing
                ? 'all'
                : preferences.analytics
                    ? 'analytics_only'
                    : preferences.marketing
                        ? 'marketing_only'
                        : 'necessary_only';
            recordConsentMetric(consentChoice);
            closeDialog();
            showSettingsButton();

            /*
             * Order matters here and is the whole point. The erase request has
             * to name the identifiers, and `revokeTrackingConsent` is what
             * deletes them from storage — so asking afterwards would send two
             * empty strings and quietly erase nothing.
             */
            if (consentWithdrawn && ! preferences.analytics) {
                withdrawTrackedData();
            }

            revokeTrackingConsent(preferences);

            if (consentWithdrawn) {
                window.location.reload();
                return;
            }

            applyPreferences(preferences);
            window.dispatchEvent(new CustomEvent('fenster:cookie-preferences-updated', {
                detail: preferences
            }));
            if (preferences.analytics && (! previous || ! previous.analytics)) {
                window.dispatchEvent(new CustomEvent('fenster:tracking-consent-accepted'));
            }
        }

        /*
         * Owner instruction, 2026-08-09: optional cookies are granted by
         * default and the tools load on the first page view. The banner still
         * appears on a first visit and still offers Customise and Accept all,
         * but it no longer blocks and no longer holds the tracking back — a
         * visitor who dismisses it stays on the defaults. Only an explicit
         * refusal turns anything off, and `saveChoice` treats that refusal as a
         * withdrawal so the identifiers are cleared and the page reloads
         * without the tools.
         *
         * This is deliberately weaker than the ICO's position that consent must
         * be given before non-essential storage and that default-on is not
         * valid consent. It was raised and it is the owner's decision. Do not
         * describe it in customer-facing copy as consent having been obtained.
         */
        var storedPreferences = getPreferences();
        var preferences = storedPreferences || publishPreferences(defaultPreferences());

        configureGoogleConsent(preferences, 'default');
        applyPreferences(preferences);
        showSettingsButton();

        /*
         * Not shown to a crawler. It recorded a `banner_shown` impression every
         * time, which is most of why that figure ran at 1,120 against 152 real
         * choices and could never be used as a denominator. Keeping the modal
         * out of a rendered crawl also removes any question of an intrusive
         * interstitial. The footer Cookie settings control is unaffected.
         */
        if (! storedPreferences && trackingAllowed) {
            openDialog(false, true);
        }

        if (dialog) {
            dialog.addEventListener('cancel', function (event) {
                if (mandatoryChoice) {
                    event.preventDefault();
                    return;
                }
                closeDialog();
            });
        }

        if (settings) {
            settings.addEventListener('click', function () {
                openDialog(false, false);
            });
        }

        if (analyticsInput) {
            analyticsInput.addEventListener('change', function () {
                syncSwitchAppearance(analyticsInput);
            });
        }

        if (marketingInput) {
            marketingInput.addEventListener('change', function () {
                syncSwitchAppearance(marketingInput);
            });
        }

        document.addEventListener('click', function (event) {
            if (event.target.closest('[data-fg-cookie-accept-all]')) {
                saveChoice(true, true);
            }

            if (event.target.closest('[data-fg-cookie-necessary]')) {
                saveChoice(false, false);
            }

            if (event.target.closest('[data-fg-cookie-customise]')) {
                showCustom();
            }

            if (event.target.closest('[data-fg-cookie-save]')) {
                saveChoice(
                    Boolean(analyticsInput && analyticsInput.checked),
                    Boolean(marketingInput && marketingInput.checked)
                );
            }

            if (event.target.closest('[data-fg-cookie-close]')) {
                closeDialog();
            }
        });
    }());
    </script>
    <?php
}
