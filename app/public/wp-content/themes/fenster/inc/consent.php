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
                    <?php esc_html_e('Nothing optional runs until you choose. You can change your mind at any time from Cookie settings in the footer.', 'fenster'); ?>
                </p>
                <div class="fg-cookie-consent__actions fg-cookie-consent__actions--two">
                    <button type="button" class="button button--light" data-fg-cookie-customise><?php esc_html_e('Customise', 'fenster'); ?></button>
                    <button type="button" class="button" data-fg-cookie-accept-all><?php esc_html_e('Accept all', 'fenster'); ?></button>
                </div>
            </div>

            <div data-fg-cookie-custom hidden>
                <p class="fg-cookie-consent__eyebrow"><?php esc_html_e('Cookie settings', 'fenster'); ?></p>
                <h2 id="fg-cookie-custom-title"><?php esc_html_e('Choose optional cookies', 'fenster'); ?></h2>
                <p id="fg-cookie-custom-summary"><?php esc_html_e('Necessary storage is always on. The two optional categories below are off until you switch them on.', 'fenster'); ?></p>

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
         * `chosen` is REQUIRED, and that is what makes this consent-first.
         *
         * The field existed before and was never written: `defaultPreferences`
         * set it false, `setPreferences` did not set it at all, and nothing
         * anywhere read it. So no record could distinguish "this visitor agreed"
         * from "this visitor was assumed to agree", which is why the dashboard
         * could never answer how many people actually consented.
         *
         * Records written under the granted-by-default model carry no `chosen`
         * and are therefore invalid here, so those visitors are asked once more.
         * That is deliberate: we cannot tell which of them ever pressed a
         * button, and re-collecting is the only honest way to find out. Same
         * reasoning that deliberately invalidated the old accepted/rejected
         * strings.
         */
        function validPreferences(record) {
            return Boolean(
                record &&
                record.version === consentVersion &&
                record.chosen === true &&
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
         * The state a visitor is in before they say anything: NOTHING OPTIONAL
         * IS ON. No analytics, no marketing, no identifiers, no third-party
         * tags. It is never written to storage, because a default is not a
         * choice and the banner has to keep appearing until they make one.
         *
         * This reverses the 2026-08-09 granted-by-default model. That model
         * assumed consent it had not been given, and because nothing ever
         * retracted an identifier that had already been issued, a visitor who
         * pressed "Use necessary only" was still recorded as a consented
         * visitor for the page they were on. See the withdrawal call in
         * `saveChoice`, which now cleans that up as well.
         */
        function defaultPreferences() {
            return {
                version: consentVersion,
                analytics: false,
                marketing: false,
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
            // actually running. Under consent-first they start OFF for a new
            // visitor, and pressing Save without touching them is a valid
            // refusal rather than an accident — which is the honest reading,
            // because nothing is running for them to leave on.
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
             * one. Under consent-first a first-time visitor pressing "Use
             * necessary only" withdraws nothing, because nothing was ever
             * granted — so no erase request is sent and the page does not
             * reload, which is correct and is also the common case. What this
             * comparison still catches is the visitor who accepted earlier and
             * has come back through footer Cookie settings to turn it off; they
             * have real data to erase and they get a reload without the tools.
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
