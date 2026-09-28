<?php
/**
 * Scheduled blog post (inc/blog-posts.php), rendered through the shared article
 * layout in blog-article.php.
 *
 * Photographs come from the first product the post names and no other. The
 * second product is usually the route out (repairs, replacement glass), and its
 * pictures showed things the post never mentions: the bifold post carried a
 * uPVC window handle until 2026-09-28.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$post = is_array($args['post'] ?? null) ? $args['post'] : null;

if ($post === null) {
    return;
}

/* The first heading-less section opens the post; its first paragraph is the lead. */
$lead = '';
$sections = [];

foreach ((array) ($post['sections'] ?? []) as $section) {
    $heading = trim((string) ($section['heading'] ?? ''));
    $body = array_values(array_filter(array_map('trim', (array) ($section['body'] ?? []))));

    if ($heading === '' && $lead === '' && $body !== []) {
        $lead = (string) array_shift($body);
    }

    if ($heading === '' && $body === []) {
        continue;
    }

    $sections[] = ['heading' => $heading, 'body' => $body];
}

$photographs = fenster_blog_post_image_pool($post, true);
$title = (string) ($post['title'] ?? 'Fenster Glazing');

get_template_part('template-parts/sections/blog-article', null, [
    'kind' => 'post',
    'slug' => (string) ($post['slug'] ?? ''),
    'title' => $title,
    'date' => (string) ($post['publish_date'] ?? ''),
    'lead' => $lead,
    'sections' => $sections,
    'legacy' => false,
    'hero_image' => $photographs[0] ?? null,
    'figures' => array_slice($photographs, 1, 2),
    'next_steps' => (array) ($post['next_steps'] ?? []),
    'product_links' => [],
    'products' => (array) ($post['products'] ?? []),
    'description' => (string) ($post['meta_description'] ?? ''),
    'form_source' => 'Blog: ' . $title,
]);
