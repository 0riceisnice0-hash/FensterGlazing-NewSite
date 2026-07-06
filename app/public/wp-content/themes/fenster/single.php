<?php
/**
 * Single post template.
 *
 * @package Fenster
 */

get_header();

while (have_posts()) :
    the_post();
    get_template_part('template-parts/sections/content-page');
endwhile;

get_footer();

