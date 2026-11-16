<?php
/**
 * `/stop-window-draughts/` — the winter guide.
 *
 * THE PAGE IDEA (STYLE.md asks for it in writing before any layout):
 *
 * 1. The reader's task: make a cold room warmer tonight, then work out what is
 *    worth paying for. Most arrive with single glazing, a sash window, a
 *    landlord or a conservation officer in the way.
 * 2. The object that commands the first screen: one sash window, drawn once,
 *    that can be seen the way a thermal camera sees it. The same window is the
 *    leak finder further down and the cross-section after that, so the page is
 *    one window being fixed a layer at a time, not a stack of tips.
 * 3. What earns a place: the free fixes, the leak finder, every fix side by
 *    side, the heat and noise comparison, the four shortcuts to skip, renting,
 *    protected buildings, then one clear route onward. Nothing else.
 * 4. The supporting image: the listed Winslow house, where the windows had to
 *    stay and we glazed them a second time. It proves the conservation section.
 * 5. Reassurance is the sources. Every figure names where it came from, beside
 *    the figure and again at the foot.
 *
 * ARTICLES ON THIS SITE HAVE NOT CONVERTED (646 organic landings, 2 leads, to
 * November 2026), so this is not written as one. The route onward is a tool
 * that reads the visitor's own answers, and for a tenant that route is a letter
 * to the landlord, not an enquiry form they cannot use.
 *
 * Each section is its own part in `template-parts/warm/`, and every word and
 * figure comes from `inc/warm-guide-data.php`. Progressive enhancement
 * throughout: with JavaScript off every panel is open and the page reads top to
 * bottom.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once FENSTER_THEME_DIR . '/inc/warm-guide-graphics.php';

$warm = fenster_warm_guide_data();

if ($warm === []) {
    return;
}

/**
 * A small "Source: ..." line, linked, for the figure beside it.
 */
if (! function_exists('fenster_warm_source_line')) {
    function fenster_warm_source_line(array $warm, string ...$keys): string
    {
        $links = [];
        foreach ($keys as $key) {
            $source = $warm['sources'][$key] ?? null;
            if (! is_array($source)) {
                continue;
            }
            $links[] = sprintf('<a href="%s" rel="noopener" target="_blank">%s</a>', esc_url((string) $source['url']), esc_html((string) $source['short']));
        }

        return $links === [] ? '' : '<p class="fg-warm-source">' . esc_html__('Source:', 'fenster') . ' ' . implode(', ', $links) . '</p>';
    }
}

$warm_parts = ['hero', 'tonight', 'find', 'fixes', 'compare', 'avoid', 'renting', 'heritage', 'picker', 'faq', 'close'];
?>

<div class="fg-warm" data-fg-warm>
    <article>
        <?php
        foreach ($warm_parts as $warm_part) {
            get_template_part('template-parts/warm/' . $warm_part, null, ['warm' => $warm]);
        }
        ?>
    </article>
</div>
