<?php
/**
 * Commercial tendering credentials.
 * ---------------------------------------------------------------------------
 * Owner instruction, 2026-08-12: "yeah mention credentials and make them visible
 * across all commercial pages." Built as one shared component rather than copied
 * into the hub and the product template, so the wording cannot drift between
 * thirteen pages.
 *
 * WHAT IS DELIBERATELY NOT HERE: FENSA and the CPA guarantee. Both are on the
 * site-wide trust strip and both are RESIDENTIAL schemes — a FENSA certificate
 * covers domestic replacement windows and doors, and `AI.md` records that FENSA
 * eligibility and CPA cover are linked. Putting either in front of a contractor
 * pricing a school would be padding at best and misleading at worst. What a
 * commercial buyer's PQQ actually asks for is Constructionline, SSIP and DBS.
 *
 * TEXT-LED ON PURPOSE. Only Constructionline has a logo asset in the theme, so a
 * logo row would sit one-third filled and two-thirds ragged. `STYLE.md` wants
 * commercial pages sober and proof-led; three equal statements do that better
 * than one badge and two gaps. If SSIP artwork is ever supplied, this is the
 * component to change once.
 *
 * The two that have their own pages link to them. DBS does not, because there is
 * nothing to link and inventing a page for it would be worse than a plain line.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$credentials = [
    [
        'title' => 'Constructionline Gold',
        'copy' => 'Pre-qualified for public and private sector tendering.',
        'url' => home_url('/constructionline-gold/'),
    ],
    [
        'title' => 'SSIP accredited',
        'copy' => 'Health and safety assessed under the Safety Schemes in Procurement umbrella.',
        'url' => home_url('/ssip-health-and-safety/'),
    ],
    [
        'title' => 'DBS-checked operatives',
        'copy' => 'For schools, care settings and any site where the check is a condition of access.',
        'url' => '',
    ],
];
?>

<section class="fg-cm-creds" aria-labelledby="fg-cm-creds-title">
    <div class="container">
        <h2 class="fg-cm-creds__title" id="fg-cm-creds-title"><?php esc_html_e('What we can put on a pre-qualification questionnaire.', 'fenster'); ?></h2>
        <ul class="fg-cm-creds__list">
            <?php foreach ($credentials as $item) : ?>
                <li>
                    <?php if ($item['url'] !== '') : ?>
                        <a href="<?php echo esc_url($item['url']); ?>"><strong><?php echo esc_html($item['title']); ?></strong></a>
                    <?php else : ?>
                        <strong><?php echo esc_html($item['title']); ?></strong>
                    <?php endif; ?>
                    <span><?php echo esc_html($item['copy']); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
