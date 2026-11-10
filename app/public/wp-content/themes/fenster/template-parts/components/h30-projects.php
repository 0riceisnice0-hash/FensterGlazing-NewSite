<?php
/**
 * Recent projects as listings: the Homepage 3.0 project rail.
 *
 * Moved out of template-parts/sections/home-30.php (10/11/2026) so the homepage
 * A/B variants can show the same thing. It must sit inside a `.fg-h30` wrapper
 * (the 3.0 styles are scoped to it), and the page must load the home30 assets:
 * see fenster_h30_assets(). Its script starts itself when this markup is there.
 *
 * Args: projects (fenster_h30_projects()), title, lede, kicker.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$h30_projects = (array) ($args['projects'] ?? fenster_h30_projects(6));
$h30_title = (string) ($args['title'] ?? 'Real homes. A fresh look.');
$h30_lede = (string) ($args['lede'] ?? 'Real homes, real streets. Have a look at what your neighbours chose.');
$h30_kicker = (string) ($args['kicker'] ?? 'A little local inspiration');
?>
    <?php if ($h30_projects !== []) : ?>
        <section class="fg-h30-projects" id="fg-h30-projects" data-h30-projects aria-labelledby="fg-h30-projects-title">
            <div class="fg-h30-shell">
                <div class="fg-h30-head fg-h30-head--row">
                    <div>
                        <?php if ($h30_kicker !== '') : ?><p class="fg-h30-kicker"><?php echo esc_html($h30_kicker); ?></p><?php endif; ?>
                        <h2 id="fg-h30-projects-title"><?php echo esc_html($h30_title); ?></h2>
                        <?php if ($h30_lede !== '') : ?><p><?php echo esc_html($h30_lede); ?></p><?php endif; ?>
                    </div>
                    <a class="fg-h30-head__more" href="<?php echo esc_url(home_url('/case-studies/')); ?>">
                        See all projects
                        <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M6 3l5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>

                <div class="fg-h30-projects__toolbar" data-h30-project-toolbar hidden>
                    <div class="fg-h30-projects__filters" aria-label="Filter recent projects">
                        <button type="button" data-h30-project-filter="all" aria-pressed="true">All projects</button>
                        <button type="button" data-h30-project-filter="windows" aria-pressed="false">Windows</button>
                        <button type="button" data-h30-project-filter="doors" aria-pressed="false">Doors</button>
                        <button type="button" data-h30-project-filter="together" aria-pressed="false">Windows &amp; doors</button>
                    </div>
                    <div class="fg-h30-projects__nav">
                        <p data-h30-project-count role="status" aria-live="polite"></p>
                        <button type="button" class="fg-h30-projects__arrow" data-h30-rail-prev aria-label="Previous projects">
                            <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="M10 3 5 8l5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" class="fg-h30-projects__arrow" data-h30-rail-next aria-label="Next projects">
                            <svg viewBox="0 0 16 16" aria-hidden="true" focusable="false"><path d="m6 3 5 5-5 5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                </div>
                <ul class="fg-h30-projects__grid fg-h30-projects__rail" id="fg-h30-project-results" data-h30-rail data-h30-reveal aria-roledescription="carousel" aria-label="Recent projects">
                    <?php foreach ($h30_projects as $h30_project) : ?>
                        <li class="fg-h30-listing" data-h30-project-types="<?php echo esc_attr(implode(' ', $h30_project['types'])); ?>">
                            <a class="fg-h30-listing__link" href="<?php echo esc_url($h30_project['url']); ?>">
                                <span class="fg-h30-listing__media">
                                    <img
                                        src="<?php echo esc_url((string) ($h30_project['image']['src'] ?? $h30_project['image']['url'] ?? '')); ?>"
                                        alt="<?php echo esc_attr((string) ($h30_project['image']['alt'] ?? $h30_project['location'])); ?>"
                                        width="800"
                                        height="600"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                    <?php if ($h30_project['colour'] !== '') : ?>
                                        <span class="fg-h30-listing__tag"><?php echo esc_html($h30_project['colour']); ?></span>
                                    <?php endif; ?>


                                </span>
                                <span class="fg-h30-listing__body">
                                    <span class="fg-h30-listing__place"><?php echo esc_html($h30_project['location']); ?></span>
                                    <?php if ($h30_project['products'] !== []) : ?>
                                        <span class="fg-h30-listing__what"><?php echo esc_html(implode(' · ', $h30_project['products'])); ?></span>
                                    <?php endif; ?>
                                    <span class="fg-h30-listing__summary"><?php echo esc_html($h30_project['summary']); ?></span>
                                    <?php if ($h30_project['date'] !== '') : ?>
                                        <span class="fg-h30-listing__meta">Completed <?php echo esc_html($h30_project['date']); ?><span aria-hidden="true">&rarr;</span></span>
                                    <?php endif; ?>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
    <?php endif; ?>
