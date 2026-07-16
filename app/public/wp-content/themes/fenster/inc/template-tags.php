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
            echo '<div class="site-nav__mega-columns">';
            foreach ($item['columns'] as $column) {
                echo '<section class="site-nav__mega-column">';
                printf(
                    '<a class="site-nav__mega-heading" href="%s" data-mobile-menu-column>%s</a>',
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
                    printf(
                        '<a class="site-nav__mega-cta" href="%s">%s<strong>%s</strong><span>%s</span></a>',
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

        printf(
            '<a class="%s" href="%s"><span>%s</span></a>',
            esc_attr(implode(' ', $link_classes)),
            esc_url($url),
            esc_html($label)
        );
    }

    echo '</div>';
}
