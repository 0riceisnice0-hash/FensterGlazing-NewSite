<?php
/**
 * 404 template, and the 410 page for the routes in `fenster_gone_slugs()`.
 *
 * Rebuilt 2026-09-23. `inc/not-found.php` has who lands here and how the
 * closest match is chosen. One section that fits one viewport: what happened
 * and the closest published page on the left with the two ways to a price
 * under it, the rest of the site by what is in it on the right.
 *
 * @package Fenster
 */

$fenster_gone = (bool) get_query_var('fenster_gone');
$fenster_suggestions = [];

if (! $fenster_gone && function_exists('fenster_not_found_suggestions')) {
    $fenster_suggestions = fenster_not_found_suggestions((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH));
}

$fenster_routes = function_exists('fenster_not_found_routes') ? fenster_not_found_routes() : [];

get_header();
?>
<section class="fg-not-found" aria-labelledby="fg-not-found-title">
    <div class="container fg-not-found__grid">
        <div class="fg-not-found__main">
            <?php if ($fenster_gone) : ?>
                <p class="eyebrow"><?php esc_html_e('Page removed', 'fenster'); ?></p>
                <h1 id="fg-not-found-title"><?php esc_html_e('That page has gone.', 'fenster'); ?></h1>
                <p class="fg-not-found__lead"><?php esc_html_e('We took it down on purpose and it is not coming back. You can still get a price online, book a free consultation or carry on from one of the pages here.', 'fenster'); ?></p>
            <?php else : ?>
                <p class="eyebrow"><?php esc_html_e('Page not found', 'fenster'); ?></p>
                <h1 id="fg-not-found-title"><?php esc_html_e('That page is not here.', 'fenster'); ?></h1>
                <p class="fg-not-found__lead"><?php esc_html_e('The link may be out of date, or the address may have a typo in it. You can still get a price online, book a free consultation or carry on from one of the pages here.', 'fenster'); ?></p>
            <?php endif; ?>

            <?php if ($fenster_suggestions !== []) : ?>
                <div class="fg-not-found__match">
                    <h2 class="fg-not-found__label"><?php echo esc_html(count($fenster_suggestions) === 1 ? __('Closest match', 'fenster') : __('Closest matches', 'fenster')); ?></h2>
                    <ul class="fg-not-found__matches">
                        <?php foreach ($fenster_suggestions as $suggestion) : ?>
                            <li>
                                <a class="fg-not-found__match-link" href="<?php echo esc_url($suggestion['url']); ?>">
                                    <strong><?php echo esc_html($suggestion['title']); ?></strong>
                                    <span><?php echo esc_html($suggestion['path']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="button-row fg-not-found__actions">
                <a class="button" href="<?php echo esc_url(home_url('/online-quote/')); ?>"><?php esc_html_e('Get an instant price', 'fenster'); ?></a>
                <a class="button button--steel" href="<?php echo esc_url(home_url('/book-a-consultation/')); ?>"><?php esc_html_e('Book a free consultation', 'fenster'); ?></a>
            </div>
        </div>

        <?php if ($fenster_routes !== []) : ?>
            <nav class="fg-not-found__routes" aria-labelledby="fg-not-found-routes">
                <h2 id="fg-not-found-routes" class="fg-not-found__label"><?php esc_html_e('Where to next', 'fenster'); ?></h2>
                <ul class="fg-not-found__list">
                    <?php foreach ($fenster_routes as $route) : ?>
                        <li>
                            <a class="fg-not-found__route" href="<?php echo esc_url($route['url']); ?>">
                                <strong><?php echo esc_html($route['title']); ?></strong>
                                <span><?php echo esc_html($route['copy']); ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
