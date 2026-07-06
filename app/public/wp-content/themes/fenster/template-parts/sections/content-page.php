<?php
/**
 * Generic content output.
 *
 * @package Fenster
 */
?>
<article <?php post_class('content-band'); ?>>
    <div class="container prose">
        <p class="eyebrow"><?php echo esc_html(get_post_type()); ?></p>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </div>
</article>
