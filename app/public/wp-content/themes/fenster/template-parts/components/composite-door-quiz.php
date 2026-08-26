<?php
/**
 * "Which composite door suits you?" — four questions, one recommendation, and
 * the quote tool opening on that exact door beside it.
 *
 * WHY THIS IS NOT A CONFIGURATOR, AND THE DISTINCTION MATTERS HERE MORE THAN
 * ANYWHERE. Three home-built configurators have been removed from this site on
 * sight — the casement canvas, the heritage bar planner and this page's own
 * tabbed configurator — because they competed with the tool that configures AND
 * prices. This does the opposite: it narrows 142 doors to one and then hands
 * straight over, with the tool loaded on that door. It never draws a door it
 * invented and it never quotes.
 *
 * THE SCORING IS OFF REAL GEOMETRY, NOT ADJECTIVES. Each style's traits are
 * computed in `inc/composite-door-data.php` from the actual cassette cut-out
 * areas and positions: how much of the door is glass, how many openings, whether
 * anything curves, and which collection it belongs to. That is why the answer to
 * "as much daylight as possible" is a genuinely different door from "keep it
 * solid" rather than a hand-written mapping somebody has to maintain.
 *
 * A RESULT IS SHAREABLE AND REPRODUCIBLE. Ties break on data order rather than
 * anything random, so the same answers always give the same door, and the result
 * writes `?door=<key>` into the URL so it can be sent to somebody. Landing on
 * that URL shows the result directly.
 *
 * NO SCORE IS SHOWN AND NO DOOR IS CALLED PERFECT. It is a suggestion off four
 * questions and the copy says so; the range is right there to disagree with.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

require_once FENSTER_THEME_DIR . '/inc/composite-door-data.php';

$fg_quiz_collections = fenster_composite_door_collections();
if (empty($fg_quiz_collections)) {
    return;
}

/* One compact row per door: key, name, collection, then the four traits the
   scorer reads. Emitted as JSON rather than markup because the scorer needs all
   142 and the page only ever shows one. */
$fg_quiz_doors = [];
foreach ($fg_quiz_collections as $fg_c) {
    foreach ($fg_c['styles'] as $fg_s) {
        $fg_t = $fg_s['traits'] ?? [];
        $fg_quiz_doors[] = [
            'k' => (string) $fg_s['key'],
            'n' => (string) $fg_s['name'],
            'c' => (string) $fg_c['name'],
            'g' => (int) ($fg_t['glass'] ?? 0),
            'd' => (int) ($fg_t['detail'] ?? 0),
            'v' => (int) ($fg_t['curved'] ?? 0),
            'm' => (int) ($fg_t['modern'] ?? 0),
        ];
    }
}

$fg_quiz_questions = [
    [
        'id'    => 'm',
        'title' => __('What sort of house is it going on?', 'fenster'),
        'answers' => [
            ['label' => __('Period, or traditional in character', 'fenster'), 'value' => 0],
            ['label' => __('Modern, or recently built', 'fenster'), 'value' => 1],
            ['label' => __('Somewhere in between', 'fenster'), 'value' => null],
        ],
    ],
    [
        'id'    => 'g',
        'title' => __('How much daylight do you want in the hall?', 'fenster'),
        'answers' => [
            ['label' => __('As much as the door will give me', 'fenster'), 'value' => 3],
            ['label' => __('A decent amount', 'fenster'), 'value' => 2],
            ['label' => __('Just a little', 'fenster'), 'value' => 1],
            ['label' => __('None — I would rather it were solid', 'fenster'), 'value' => 0],
        ],
    ],
    [
        'id'    => 'd',
        'title' => __('Plain, or something with detail in it?', 'fenster'),
        'answers' => [
            ['label' => __('Clean and plain', 'fenster'), 'value' => 0],
            ['label' => __('A bit of detail', 'fenster'), 'value' => 1],
            ['label' => __('Make it a feature', 'fenster'), 'value' => 2],
        ],
    ],
    [
        'id'    => 'v',
        'title' => __('Straight lines, or a curve?', 'fenster'),
        'answers' => [
            ['label' => __('Straight lines', 'fenster'), 'value' => 0],
            ['label' => __('An arch or a curve somewhere', 'fenster'), 'value' => 1],
        ],
    ],
];
?>
<section class="fg-cdq" aria-labelledby="fg-cdq-title"
    data-fg-door-quiz
    data-fg-quiz-doors="<?php echo esc_attr((string) wp_json_encode($fg_quiz_doors)); ?>"
    data-fg-quiz-art="<?php echo esc_attr(fenster_composite_door_line_art_base()); ?>"
    data-fg-quiz-ver="<?php echo esc_attr((string) fenster_composite_door_line_art_version()); ?>"
    data-fg-quiz-quote="<?php echo esc_attr(fenster_composite_door_quote_url('__KEY__')); ?>">
    <div class="container">
        <header class="fg-cd3-head fg-cd3-head--wide">
            <p class="eyebrow"><?php esc_html_e('Narrow it down', 'fenster'); ?></p>
            <h2 id="fg-cdq-title"><?php esc_html_e('One hundred and forty two doors is too many to choose from.', 'fenster'); ?></h2>
            <p><?php esc_html_e('Four questions and we will point you at one, with the reasoning. It is a starting point rather than a verdict, and the whole range is above if you want to argue with it.', 'fenster'); ?></p>
        </header>

        <?php /* Ships hidden. With no JavaScript the range above is the answer,
                 and a quiz that cannot score is worse than no quiz. */ ?>
        <div class="fg-cdq__panel" data-fg-quiz-panel hidden>

            <form class="fg-cdq__form" data-fg-quiz-form>
                <?php foreach ($fg_quiz_questions as $fg_i => $fg_q) : ?>
                    <fieldset class="fg-cdq__q" data-fg-quiz-q="<?php echo esc_attr($fg_q['id']); ?>">
                        <legend class="fg-cdq__legend">
                            <span class="fg-cdq__num"><?php echo esc_html(sprintf('%02d', $fg_i + 1)); ?></span>
                            <?php echo esc_html($fg_q['title']); ?>
                        </legend>
                        <div class="fg-cdq__answers">
                            <?php foreach ($fg_q['answers'] as $fg_j => $fg_a) : ?>
                                <?php $fg_id = 'fg-cdq-' . $fg_q['id'] . '-' . $fg_j; ?>
                                <input
                                    class="fg-cdq__radio"
                                    type="radio"
                                    name="<?php echo esc_attr($fg_q['id']); ?>"
                                    id="<?php echo esc_attr($fg_id); ?>"
                                    value="<?php echo esc_attr($fg_a['value'] === null ? '' : (string) $fg_a['value']); ?>">
                                <label class="fg-cdq__answer" for="<?php echo esc_attr($fg_id); ?>">
                                    <?php echo esc_html($fg_a['label']); ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>
                <?php endforeach; ?>

                <p class="fg-cdq__actions">
                    <button type="submit" class="button" data-fg-quiz-submit><?php esc_html_e('Show me a door', 'fenster'); ?></button>
                    <button type="button" class="button button--steel" data-fg-quiz-reset hidden><?php esc_html_e('Start again', 'fenster'); ?></button>
                </p>
                <p class="fg-cdq__hint" data-fg-quiz-hint role="status" aria-live="polite"></p>
            </form>

            <?php /* The result. Announced politely rather than stealing focus,
                     because a screen reader user has just pressed a button and
                     knows something happened. */ ?>
            <div class="fg-cdq__result" data-fg-quiz-result hidden tabindex="-1" aria-live="polite">
                <div class="fg-cdq__verdict">
                    <p class="eyebrow"><?php esc_html_e('We think you will like', 'fenster'); ?></p>
                    <h3 class="fg-cdq__door-name" data-fg-quiz-name></h3>
                    <p class="fg-cdq__collection" data-fg-quiz-collection></p>
                    <figure class="fg-cdq__art">
                        <img data-fg-quiz-art-img src="" alt="" width="914" height="2013" decoding="async">
                    </figure>
                    <p class="fg-cdq__why" data-fg-quiz-why></p>
                    <p class="fg-cdq__result-actions">
                        <a class="button" data-fg-quiz-open href="#" target="_blank" rel="noopener"><?php esc_html_e('Open it full size', 'fenster'); ?></a>
                        <button type="button" class="button button--steel" data-fg-quiz-share><?php esc_html_e('Copy a link to this', 'fenster'); ?></button>
                    </p>
                    <p class="fg-cdq__caveat"><?php esc_html_e('Four questions cannot know your house. If it is not right, the range above has the other 141 and every one of them opens the same way.', 'fenster'); ?></p>
                </div>

                <?php /* The tool, on that door. Only ever created after somebody
                         has answered, so it costs a visitor who never uses the
                         quiz nothing at all. */ ?>
                <div class="fg-cdq__tool">
                    <div class="fg-cdq__frame" data-fg-quiz-frame data-lenis-prevent></div>
                    <p class="fg-cdq__frame-note"><?php esc_html_e('Your colour, glass and handles are chosen in here, and the price moves as you change them.', 'fenster'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
