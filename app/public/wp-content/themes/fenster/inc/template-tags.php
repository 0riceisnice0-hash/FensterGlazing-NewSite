<?php
/**
 * Template helpers.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_data(string $key, mixed $default = null): mixed
{
    $data = fenster_site_data();
    $segments = explode('.', $key);

    foreach ($segments as $segment) {
        if (! is_array($data) || ! array_key_exists($segment, $data)) {
            return $default;
        }

        $data = $data[$segment];
    }

    return $data;
}

/**
 * Attribute string for trust/accreditation logo links.
 *
 * Review-site logos (Google, Trustpilot) point off-site and should open in a new
 * tab so the visitor does not lose the page. Internal accreditation pages stay
 * in the same tab. Returns a leading-space attribute string ready to echo.
 */
function fenster_trust_link_attrs(array $item): string
{
    if (empty($item['external'])) {
        return '';
    }

    return ' target="_blank" rel="noopener"';
}

function fenster_render_nav_fallback(): void
{
    $items = fenster_data('primary_nav_fallback', []);

    echo '<ul class="site-nav__list">';
    foreach ($items as $item) {
        $is_mega = ! empty($item['mega']) && ! empty($item['columns']) && is_array($item['columns']);
        $has_children = $is_mega || (! empty($item['children']) && is_array($item['children']));
        $item_classes = ['site-nav__item'];

        if ($has_children) {
            $item_classes[] = 'has-children';
        }

        if ($is_mega) {
            $item_classes[] = 'has-mega-menu';
        }

        foreach (($item['classes'] ?? []) as $class) {
            $item_classes[] = sanitize_html_class((string) $class);
        }

        printf(
            '<li class="%s"><a href="%s">%s</a>',
            esc_attr(implode(' ', array_filter($item_classes))),
            esc_url($item['url']),
            esc_html($item['label'])
        );

        if ($is_mega) {
            echo '<div class="site-nav__mega" hidden>';
            echo '<div class="site-nav__mobile-panel-head">';
            printf(
                '<button class="site-nav__mobile-back" type="button" data-mobile-menu-back>%s</button>',
                esc_html__('Menu', 'fenster')
            );
            printf(
                '<strong>%s</strong>',
                esc_html($item['label'])
            );
            echo '</div>';
            echo '<div class="site-nav__mega-grid">';
            /* The grid was hardcoded to three tracks, so a two-column menu left an
               empty third and read as a missing column. Driven by the real count now. */
            printf('<div class="site-nav__mega-columns" style="--fg-mega-columns: %d;">', count($item['columns']));
            /* EACH COLUMN IS NAMED BY ITS OWN HEADING, and that is load-bearing
               rather than tidiness. The menu labels were shortened on 2026-08-12
               so a row no longer repeats the column it sits in, and the owner
               then set BOTH heritage rows to read "Aluminium Heritage" — the
               window under Windows and the door under Doors. Two links with
               identical text pointing at different routes are only unambiguous
               if something tells you which section you are in, and a bare
               <section> tells a screen reader nothing. Naming it from the
               heading is what makes the short labels safe.

               A counter rather than the label, because two menus could
               reasonably use the same column name and duplicate ids are worse
               than ugly ones. */
            static $mega_column_id = 0;
            foreach ($item['columns'] as $column) {
                $mega_column_id++;
                $column_heading_id = 'fg-mega-column-' . $mega_column_id;
                printf('<section class="site-nav__mega-column" aria-labelledby="%s">', esc_attr($column_heading_id));
                printf(
                    '<a class="site-nav__mega-heading" id="%s" href="%s" data-mobile-menu-column>%s</a>',
                    esc_attr($column_heading_id),
                    esc_url($column['url'] ?? $item['url']),
                    esc_html($column['label'] ?? '')
                );

                if (! empty($column['items']) && is_array($column['items'])) {
                    echo '<ul>';
                    printf(
                        '<li class="site-nav__mobile-view-all"><a href="%s">%s</a></li>',
                        esc_url($column['url'] ?? $item['url']),
                        esc_html(sprintf('View all %s', $column['label'] ?? 'products'))
                    );
                    foreach ($column['items'] as $child) {
                        printf(
                            '<li><a href="%s">%s</a></li>',
                            esc_url($child['url']),
                            esc_html($child['label'])
                        );
                    }
                    echo '</ul>';
                }
                echo '</section>';
            }
            echo '</div>';

            if (! empty($item['ctas']) && is_array($item['ctas'])) {
                echo '<div class="site-nav__mega-ctas">';
                foreach ($item['ctas'] as $cta) {
                    $cta_badge = (string) ($cta['badge'] ?? '');
                    /* Green used to be whichever CTA came second. That made the colour a
                       side effect of the order, so reordering a menu silently recoloured
                       it. It is declared per CTA now. */
                    $cta_class = 'site-nav__mega-cta';
                    if (($cta['variant'] ?? '') === 'accent') {
                        $cta_class .= ' site-nav__mega-cta--accent';
                    }
                    printf(
                        '<a class="' . esc_attr($cta_class) . '" href="%s">%s<strong>%s</strong><span>%s</span></a>',
                        esc_url($cta['url'] ?? '#'),
                        $cta_badge !== '' ? '<span class="site-nav__mega-cta-badge">' . esc_html($cta_badge) . '</span>' : '',
                        esc_html($cta['label'] ?? ''),
                        esc_html($cta['copy'] ?? '')
                    );
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
        } elseif ($has_children) {
            echo '<ul class="site-nav__sublist" hidden>';
            foreach ($item['children'] as $child) {
                printf(
                    '<li><a href="%s">%s</a></li>',
                    esc_url($child['url']),
                    esc_html($child['label'])
                );
            }
            echo '</ul>';
        }

        echo '</li>';
    }
    echo '</ul>';

    fenster_render_mobile_nav_fallback($items);
}

function fenster_render_mobile_nav_fallback(array $items): void
{
    echo '<div class="site-mobile-nav" data-mobile-accordion-nav data-lenis-prevent hidden>';

    foreach ($items as $item) {
        $label = (string) ($item['label'] ?? '');
        $url = (string) ($item['url'] ?? '#');
        $is_mega = ! empty($item['mega']) && ! empty($item['columns']) && is_array($item['columns']);
        $has_children = ! empty($item['children']) && is_array($item['children']);

        if ($is_mega) {
            echo '<section class="site-mobile-nav__item" data-mobile-accordion-item>';
            printf(
                '<button class="site-mobile-nav__row" type="button" data-mobile-accordion-toggle aria-expanded="false"><span>%s</span><span aria-hidden="true"></span></button>',
                esc_html($label)
            );
            echo '<div class="site-mobile-nav__panel" hidden>';
            foreach ($item['columns'] as $column) {
                echo '<section class="site-mobile-nav__item site-mobile-nav__item--child" data-mobile-accordion-item>';
                printf(
                    '<button class="site-mobile-nav__row" type="button" data-mobile-accordion-toggle aria-expanded="false"><span>%s</span><span aria-hidden="true"></span></button>',
                    esc_html($column['label'] ?? '')
                );
                echo '<div class="site-mobile-nav__panel site-mobile-nav__panel--links" hidden>';
                printf(
                    '<a href="%s">%s</a>',
                    esc_url($column['url'] ?? $url),
                    esc_html(sprintf('All %s', $column['label'] ?? 'products'))
                );
                foreach (($column['items'] ?? []) as $child) {
                    printf(
                        '<a href="%s">%s</a>',
                        esc_url($child['url'] ?? '#'),
                        esc_html($child['label'] ?? '')
                    );
                }
                echo '</div>';
                echo '</section>';
            }
            echo '</div>';
            echo '</section>';
            continue;
        }

        if ($has_children) {
            echo '<section class="site-mobile-nav__item" data-mobile-accordion-item>';
            printf(
                '<button class="site-mobile-nav__row" type="button" data-mobile-accordion-toggle aria-expanded="false"><span>%s</span><span aria-hidden="true"></span></button>',
                esc_html($label)
            );
            echo '<div class="site-mobile-nav__panel site-mobile-nav__panel--links" hidden>';
            foreach ($item['children'] as $child) {
                printf(
                    '<a href="%s">%s</a>',
                    esc_url($child['url'] ?? '#'),
                    esc_html($child['label'] ?? '')
                );
            }
            echo '</div>';
            echo '</section>';
            continue;
        }

        $link_classes = ['site-mobile-nav__row', 'site-mobile-nav__row--link'];
        if (in_array('site-nav__quote', $item['classes'] ?? [], true)) {
            $link_classes[] = 'site-mobile-nav__row--quote';
        }
        /* The consultation CTA had no mobile modifier, so it dropped to a plain
           row while the quote button stayed green. The two are a pair in the
           header and should read as one on a phone too. */
        if (in_array('site-nav__consultation', $item['classes'] ?? [], true)) {
            $link_classes[] = 'site-mobile-nav__row--consultation';
        }

        printf(
            '<a class="%s" href="%s"><span>%s</span></a>',
            esc_attr(implode(' ', $link_classes)),
            esc_url($url),
            esc_html($label)
        );
    }

    echo '</div>';
}
