<?php
/**
 * Order process rail.
 *
 * One markup for every process rail on the site. Before 2026-07-29 this was
 * copied into three templates with six different step sets between them, which
 * is how the town pages ended up describing a different process from the
 * product pages.
 *
 * The steps default to the canonical set in `inc/site-data.php`. Pass `steps`
 * only where the journey genuinely differs, which currently means commercial
 * and pet flaps.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$order_process = fenster_data('order_process', []);
$order_process = is_array($order_process) ? $order_process : [];

$steps = is_array($args['steps'] ?? null) ? $args['steps'] : (is_array($order_process['steps'] ?? null) ? $order_process['steps'] : []);

if (empty($steps)) {
    return;
}

$eyebrow       = (string) ($args['eyebrow'] ?? ($order_process['eyebrow'] ?? 'Order process'));
$heading       = (string) ($args['heading'] ?? ($order_process['heading'] ?? ''));
$copy          = (string) ($args['copy'] ?? ($order_process['intro'] ?? ''));
$extra_class   = (string) ($args['class'] ?? '');
$action_label  = (string) ($args['action_label'] ?? '');
$action_href   = (string) ($args['action_href'] ?? '');
?>
<section class="fg-order-process<?php echo $extra_class !== '' ? ' ' . esc_attr($extra_class) : ''; ?>">
    <div class="container">
        <div class="section-heading section-heading--wide">
            <?php if ($eyebrow !== '') : ?>
                <p class="eyebrow"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($heading !== '') : ?>
                <h2><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ($copy !== '') : ?>
                <p><?php echo esc_html($copy); ?></p>
            <?php endif; ?>
        </div>
        <div class="fg-order-process__rail">
            <?php foreach ($steps as $step) : ?>
                <article>
                    <span class="fg-order-process__number"><?php echo esc_html((string) ($step['step'] ?? '')); ?></span>
                    <div class="fg-order-process__card">
                        <h3><?php echo esc_html((string) ($step['title'] ?? '')); ?></h3>
                        <p><?php echo esc_html((string) ($step['copy'] ?? '')); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php if ($action_label !== '' && $action_href !== '') : ?>
            <div class="fg-order-process__action">
                <a class="button" href="<?php echo esc_url($action_href); ?>"><?php echo esc_html($action_label); ?></a>
            </div>
        <?php endif; ?>
    </div>
</section>
