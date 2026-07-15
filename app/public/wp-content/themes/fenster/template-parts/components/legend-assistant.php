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
?>
<aside class="legend-assistant" data-legend-assistant style="--legend-cookie-offset: 0px;">
    <section
        class="legend-assistant__panel"
        id="legend-assistant-panel"
        data-legend-panel
        role="dialog"
        aria-labelledby="legend-assistant-title"
        aria-describedby="legend-assistant-description"
        hidden
    >
        <header class="legend-assistant__header">
            <div class="legend-assistant__identity">
                <p class="legend-assistant__eyebrow">Fenster AI assistant</p>
                <h2 id="legend-assistant-title">Legend the cat</h2>
                <p class="legend-assistant__status"><span aria-hidden="true"></span> Preview mode</p>
                <a class="legend-assistant__about" href="<?php echo esc_url(home_url('/meet-the-team/#legend')); ?>">Who is Legend?</a>
            </div>
            <div class="legend-assistant__stage" aria-hidden="true">
                <span class="legend-assistant__roamer">
                    <span class="legend-sprite" data-legend-sprite>
                        <img src="<?php echo esc_url($legend_sprite); ?>" alt="" width="1536" height="2288">
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
                <p id="legend-assistant-description">Hello. I’m Legend, Fenster’s real office cat and Chief Meow Officer. I’m also the face of this AI assistant while live chat is in preview.</p>
            </div>
        </div>

        <div class="legend-assistant__composer">
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
        <p class="legend-assistant__notice">Preview only. Messages aren’t sent to the Fenster team yet.</p>
    </section>

    <button
        class="legend-assistant__launcher"
        type="button"
        data-legend-launcher
        aria-controls="legend-assistant-panel"
        aria-expanded="false"
        aria-label="Chat with Legend, Fenster’s AI assistant"
    >
        <span class="legend-assistant__prompt" aria-hidden="true">
            <strong>Ask Legend</strong>
            <small>AI assistant</small>
        </span>
        <span class="legend-assistant__character" aria-hidden="true">
            <span class="legend-sprite" data-legend-sprite>
                <img src="<?php echo esc_url($legend_sprite); ?>" alt="" width="1536" height="2288">
            </span>
            <span class="legend-assistant__available"></span>
        </span>
    </button>
</aside>
