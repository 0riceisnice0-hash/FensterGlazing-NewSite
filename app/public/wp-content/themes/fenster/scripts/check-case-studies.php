<?php
/**
 * Case study data harness.
 *
 * Run before every case study deploy. It needs no WordPress and no running
 * site, which is the point: `CASESTUDIES.md` forbids verifying a study on the
 * Local site, and this is the check that can honestly run without one.
 *
 *   & '<php>' scripts/check-case-studies.php
 *
 * Exits non-zero on any failure so it can gate a deploy.
 *
 * It exists because three faults sat in the data unnoticed until a one-off
 * script went looking on 2026-08-25: one study carrying no `seo` block at all,
 * and two meta descriptions over the 160 character cap that `CASESTUDIES.md`
 * has specified all along. None of them broke a page, which is exactly why
 * nobody saw them. A rule nothing measures is a rule that drifts.
 *
 * @package Fenster
 */

// The data file expects WordPress. Give it the four functions it actually uses.
define('ABSPATH', __DIR__);
define('FENSTER_THEME_URI', 'https://fensterglazing.com/wp-content/themes/fenster');

function home_url(string $path = ''): string
{
    return 'https://fensterglazing.com' . $path;
}

function esc_url(string $url): string
{
    return $url;
}

function sanitize_title(string $text): string
{
    return strtolower(trim((string) preg_replace('/[^a-z0-9]+/i', '-', trim($text)), '-'));
}

$theme = dirname(__DIR__);
require $theme . '/inc/case-studies-data.php';

const META_CAP = 160;

$failures = [];
$images_checked = 0;

/** Record a failure against a study. */
$fail = static function (string $where, string $message) use (&$failures): void {
    $failures[] = $where . ': ' . $message;
};

/** Assert a referenced theme asset is actually on disk. */
$check_asset = static function (string $url, string $where) use ($theme, $fail, &$images_checked): void {
    $images_checked++;
    $relative = str_replace(FENSTER_THEME_URI, '', $url);
    if (! is_file($theme . $relative)) {
        $fail($where, 'missing file ' . $relative);
    }
};

/* Em and en dashes are banned in customer-facing copy by STYLE.md, and the
   data file is nothing but customer-facing copy. Walk every string rather than
   checking named fields, because the next field added would not be checked. */
$walk_text = static function ($node, string $where) use (&$walk_text, $fail): void {
    if (is_array($node)) {
        foreach ($node as $key => $value) {
            $walk_text($value, $where . '.' . $key);
        }

        return;
    }

    if (! is_string($node)) {
        return;
    }

    foreach (["\u{2014}" => 'em dash', "\u{2013}" => 'en dash'] as $char => $name) {
        if (strpos($node, $char) !== false) {
            /* NOT mb_substr: Local's CLI PHP has no mbstring, so this line
               would have thrown the first time the check ever fired, which a
               fault-injection run found on the day it was written. PCRE's /u
               is UTF-8 aware on its own and cannot split a character. */
            $preview = (string) preg_replace('/^(.{0,60}).*$/us', '$1', $node);
            $fail($where, $name . ' in "' . $preview . '"');
        }
    }
};

foreach (fenster_case_studies() as $slug => $study) {
    foreach (['title', 'location', 'type', 'date', 'summary', 'lead'] as $required) {
        if (empty($study[$required])) {
            $fail($slug, 'missing required field `' . $required . '`');
        }
    }

    if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) ($study['date'] ?? ''))) {
        $fail($slug, 'date is not ISO yyyy-mm-dd: "' . ($study['date'] ?? '') . '"');
    }

    /* Both SEO fields, on every study. The route falls back to the title and
       the card summary when they are absent, which reads fine and is why this
       went unnoticed, but it means the study is not carrying copy anyone
       chose. */
    foreach (['title_tag', 'meta_description'] as $seo_field) {
        if (empty($study['seo'][$seo_field])) {
            $fail($slug, 'missing `seo.' . $seo_field . '`');
        }
    }

    $meta = (string) ($study['seo']['meta_description'] ?? '');
    if (strlen($meta) > META_CAP) {
        $fail($slug, sprintf('meta_description is %d chars, cap is %d', strlen($meta), META_CAP));
    }

    foreach (($study['images'] ?? []) as $index => $image) {
        $check_asset((string) ($image['src'] ?? ''), $slug . '.images[' . $index . ']');
        if (empty($image['caption'])) {
            $fail($slug, 'images[' . $index . '] has no caption, so it has no alt text');
        }
    }

    if (! empty($study['card_image']['src'])) {
        $check_asset((string) $study['card_image']['src'], $slug . '.card_image');
    }

    if (! empty($study['video'])) {
        $check_asset((string) ($study['video']['src'] ?? ''), $slug . '.video.src');
        $check_asset((string) ($study['video']['poster'] ?? ''), $slug . '.video.poster');
    }

    /* An install story is somebody else's photographs and words, so the credit
       is not optional. See the `story` section of CASESTUDIES.md. */
    if (! empty($study['story'])) {
        if (empty($study['story']['source']['label'])) {
            $fail($slug, 'story has no `source.label`, so the photographs are uncredited');
        }

        foreach (($study['story']['steps'] ?? []) as $index => $step) {
            $where = $slug . '.story.steps[' . $index . ']';
            $check_asset((string) ($step['src'] ?? ''), $where);
            if (empty($step['caption'])) {
                $fail($where, 'no caption, so the photograph has no alt text');
            }
        }
    }

    foreach (($study['installers'] ?? []) as $index => $person) {
        foreach (['name', 'role'] as $field) {
            if (empty($person[$field])) {
                $fail($slug, 'installers[' . $index . '] has no `' . $field . '`');
            }
        }
    }

    $walk_text($study, $slug);
}

$studies = fenster_case_studies();
printf(
    "%d studies, %d assets checked, %d failures\n",
    count($studies),
    $images_checked,
    count($failures)
);

if ($failures !== []) {
    echo "\n";
    foreach ($failures as $failure) {
        echo '  FAIL  ' . $failure . "\n";
    }
    exit(1);
}

echo "OK\n";
exit(0);
