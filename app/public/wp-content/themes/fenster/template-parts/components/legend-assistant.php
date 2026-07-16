<?php
/**
 * Legend AI assistant preview.
 *
 * The browser-only placeholder response in main.js is intentionally isolated so
 * it can be replaced with the production live-chat transport later.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$legend_sprite = get_theme_file_uri('/assets/images/assistant/legend-spritesheet.webp');
$legend_sleep_sprite = get_theme_file_uri('/assets/images/assistant/legend-sleep-strip.webp');
$legend_connected = function_exists('fenster_legend_is_configured') && fenster_legend_is_configured();
?>
<aside
    class="legend-assistant"
    data-legend-assistant
    data-legend-endpoint="<?php echo esc_url(rest_url('fenster/v1/legend/chat')); ?>"
    data-legend-nonce="<?php echo esc_attr(wp_create_nonce('fenster_legend_chat')); ?>"
    data-legend-connected="<?php echo $legend_connected ? 'true' : 'false'; ?>"
    style="--legend-cookie-offset: 0px;"
>
    <section
        class="legend-assistant__panel"
        id="legend-assistant-panel"
        data-legend-panel
        role="dialog"
        aria-labelledby="legend-assistant-title"
        aria-describedby="legend-assistant-description"
        data-lenis-prevent
        hidden
    >
        <header class="legend-assistant__header">
            <div class="legend-assistant__identity">
                <p class="legend-assistant__eyebrow">Fenster AI assistant</p>
                <h2 id="legend-assistant-title">Legend the cat</h2>
                <p class="legend-assistant__status"><span aria-hidden="true"></span> <?php echo esc_html($legend_connected ? 'AI online' : 'Awaiting connection'); ?></p>
                <a class="legend-assistant__about" href="<?php echo esc_url(home_url('/meet-the-team/#legend')); ?>">Who is Legend?</a>
            </div>
            <div class="legend-assistant__stage" aria-hidden="true">
                <span class="legend-assistant__roamer" data-legend-roamer>
                    <span class="legend-sprite" data-legend-roamer-sprite>
                        <img src="<?php echo esc_url($legend_sprite); ?>" alt="" width="1536" height="2288">
                    </span>
                    <span class="legend-sleep-sprite" data-legend-sleep-sprite>
                        <img src="<?php echo esc_url($legend_sleep_sprite); ?>" alt="" width="1536" height="208">
                    </span>
                </span>
            </div>
            <button class="legend-assistant__close" type="button" data-legend-close aria-label="Close chat with Legend">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6.5 6.5 11 11m0-11-11 11" /></svg>
            </button>
        </header>

        <div class="legend-assistant__messages" data-legend-messages role="log" aria-live="polite" aria-relevant="additions">
            <div class="legend-message legend-message--assistant">
                <span class="legend-message__author">Legend</span>
                <p id="legend-assistant-description">Hello. I’m Legend, Fenster’s real office cat and Chief Meow Officer. Ask me about this page and I’ll help point you in the right direction.</p>
            </div>
        </div>

        <section class="legend-assistant__consent" data-legend-consent aria-label="Live chat terms">
            <p class="legend-assistant__consent-summary">By using this live chat, you agree to Fenster processing your messages to provide an AI reply. Please do not share sensitive personal information.</p>
            <details class="legend-assistant__consent-details">
                <summary>Read chat terms</summary>
                <div>
                    <p>Legend uses AI. Your message and relevant content from the page you are viewing are processed to create a reply.</p>
                    <p>Recent messages are saved in this browser for up to 24 hours so your chat can continue across Fenster pages and tabs. Fenster also stores the transcript for up to 30 days in its restricted quality-assurance tracker so the team can improve Legend. If you accept optional cookies it is linked to your anonymous website journey; otherwise it remains chat-only. This does not change your optional cookie choice.</p>
                    <p>Replies may be inaccurate and are general guidance only. They do not form a quotation, contract, warranty, professional advice or legally binding commitment. Read our <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>.</p>
                </div>
            </details>
        </section>

        <div class="legend-assistant__composer" data-legend-composer>
            <label class="screen-reader-text" for="legend-assistant-message">Message Legend</label>
            <textarea
                id="legend-assistant-message"
                data-legend-input
                rows="1"
                maxlength="500"
                placeholder="Write a message…"
                autocomplete="off"
            ></textarea>
            <button type="button" data-legend-send disabled>
                <span>Send</span>
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m4 4 16 8-16 8 2.2-8L4 4Zm2.2 8H20" /></svg>
            </button>
        </div>
        <div class="legend-assistant__notice" data-legend-notice>
            <p>
                <?php if ($legend_connected) : ?>
                    AI replies may be inaccurate and are not legally binding. Chats may be reviewed for quality assurance for up to 30 days. Do not share sensitive personal information. <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>.
                <?php else : ?>
                    AI connection coming soon. Messages are not sent to the Fenster team. <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>.
                <?php endif; ?>
            </p>
            <button type="button" data-legend-clear>Clear chat</button>
        </div>
    </section>

    <div class="legend-assistant__launcher-wrap" data-legend-launcher-wrap>
        <div class="legend-assistant__prompt" data-legend-prompt>
            <button class="legend-assistant__prompt-action" type="button" data-legend-prompt-action aria-controls="legend-assistant-panel">
                <strong>Need a hand?</strong>
                <small>I’m Fenster’s AI assistant</small>
            </button>
            <button class="legend-assistant__prompt-close" type="button" data-legend-prompt-close aria-label="Hide Legend prompt">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m7 7 10 10m0-10L7 17" /></svg>
            </button>
        </div>
        <button
            class="legend-assistant__launcher"
            type="button"
            data-legend-launcher
            aria-controls="legend-assistant-panel"
            aria-expanded="false"
            aria-label="Chat with Legend, Fenster’s AI assistant"
        >
            <span class="legend-assistant__character" data-legend-character aria-hidden="true">
                <span class="legend-sprite" data-legend-sprite>
                    <img src="<?php echo esc_url($legend_sprite); ?>" alt="" width="1536" height="2288">
                </span>
                <span class="legend-sleep-sprite" data-legend-sleep-sprite>
                    <img src="<?php echo esc_url($legend_sleep_sprite); ?>" alt="" width="1536" height="208">
                </span>
            </span>
        </button>
    </div>
</aside>
