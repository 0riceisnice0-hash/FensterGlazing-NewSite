<?php
/**
 * "Which composite door are you?" — a stylised four-question quiz that ends on
 * one door, with the quote tool open on it.
 *
 * THIS IS BUILT TO BE SHARED, which is the whole reason it looks the way it
 * does. It runs one question at a time on a bordered white card, the answers
 * are real door drawings rather than words where a drawing can carry the
 * question, and the result is a reveal. A visitor who would never read a
 * specification will answer five questions about their own hallway.
 *
 * THE ANSWERS ARE THE PRODUCT, NOT ICONOGRAPHY. Every illustrated answer is a
 * real door from the range, drawn by WindowCAD, chosen because it is the clearest
 * example of what the answer means. Nobody has to imagine what "a decent amount
 * of glass" looks like — it is the picture they are pressing.
 *
 * IT IS NOT A CONFIGURATOR. Three have been removed from this site on sight for
 * competing with the tool that configures AND prices. This narrows 142 doors to
 * one and hands straight over with the tool loaded on that door. It draws no
 * door it invented and it quotes nothing.
 *
 * THE SCORING IS OFF REAL GEOMETRY, AND GLASS IS A FILTER RATHER THAN A SCORE.
 * Traits in `inc/composite-door-data.php` come from actual cassette cut-out
 * areas, measured with the browser's own `getBBox()` — a hand-rolled path
 * parser read only an arc's endpoint, so a semicircular Half Moon cut-out
 * measured as zero height and five glazed doors were filed as solid. Answering
 * "keep it solid" returned a door with a window in it.
 *
 * Glass now filters the pool before anything is scored, because the house, the
 * detail and the curve are taste and taste does not get to overrule a
 * requirement. The generator sweeps all 72 answer combinations and asserts every
 * one comes back at the glass level that was asked for.
 *
 * REPRODUCIBLE, BECAUSE IT IS SHAREABLE. Ties break on data order and never
 * randomly; the result writes `?door=<key>` and landing on that URL opens the
 * result directly. A shared link that showed somebody a different door than the
 * sender saw would be worse than no sharing at all.
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

/**
 * WindowCAD carries pricing shorthand in one style name — "ESC08 POA" — and it
 * surfaced as "We think you will like the ESC08 POA", which is jargon shouted at
 * somebody who has just answered four friendly questions. The suffix is stripped
 * for display and kept as a flag, so the result can say plainly that this one is
 * priced on application rather than pretending or hiding it.
 */
$fg_quiz_doors = [];
foreach ($fg_quiz_collections as $fg_c) {
    foreach ($fg_c['styles'] as $fg_s) {
        $fg_raw = (string) $fg_s['name'];
        $fg_poa = (bool) preg_match('/\bPOA\b/i', $fg_raw);
        $fg_t = $fg_s['traits'] ?? [];
        $fg_quiz_doors[] = [
            'k' => (string) $fg_s['key'],
            'n' => trim((string) preg_replace('/\s*\bPOA\b/i', '', $fg_raw)),
            'c' => (string) $fg_c['name'],
            'p' => $fg_poa ? 1 : 0,
            'g' => (int) ($fg_t['glass'] ?? 0),
            'd' => (int) ($fg_t['detail'] ?? 0),
            'v' => (int) ($fg_t['curved'] ?? 0),
            'm' => (int) ($fg_t['modern'] ?? 0),
        ];
    }
}

$fg_art = fenster_composite_door_line_art_base();
$fg_ver = fenster_composite_door_line_art_version();
$fg_pic = static fn (string $key): string => $fg_art . rawurlencode($key) . '.svg?v=' . $fg_ver;

/* Every illustrated answer is a real door, picked as the clearest example of
   what that answer means. Keys are checked against the data below, so a style
   that ever leaves the range fails loudly at build rather than rendering a
   broken image. */
/**
 * COLOUR, AND WHY THESE ARE THE SAFE ONES.
 *
 * `colour=` takes the PALETTE key, not the colour collection entry key —
 * `getExternalColours()` returns palette colours. Passing the entry key does
 * nothing at all and the door renders white, which is exactly what happened on
 * the first attempt: Anthracite grey is palette 115, not entry 15.
 *
 * Every door style points at one of two colour collections, and a key only
 * works if that colour is in the collection the chosen style uses. Thirty-two
 * palette entries appear in BOTH, so those are the only ones safe to offer
 * against a door the quiz picked rather than one the visitor picked. These
 * eight come from that set.
 *
 * The hexes are WindowCAD's own, so the chip matches what the tool renders.
 */
$fg_colours = [
    ['key' => 115, 'name' => __('Anthracite grey', 'fenster'), 'hex' => '#373F43'],
    ['key' => 114, 'name' => __('Slate grey', 'fenster'),      'hex' => '#51565C'],
    ['key' => 116, 'name' => __('Black brown', 'fenster'),     'hex' => '#211F20'],
    ['key' => 120, 'name' => __('Steel blue', 'fenster'),      'hex' => '#232C3F'],
    ['key' => 123, 'name' => __('Chartwell green', 'fenster'), 'hex' => '#86AD8F'],
    ['key' => 129, 'name' => __('Ruby red', 'fenster'),        'hex' => '#8D1D2C'],
    ['key' => 107, 'name' => __('Cream', 'fenster'),           'hex' => '#EFEBDC'],
    ['key' => 99,  'name' => __('White', 'fenster'),           'hex' => '#F4F8F4'],
];

$fg_questions = [
    [
        'id'    => 'm',
        'kicker' => __('The house', 'fenster'),
        'title' => __('What are you putting it on?', 'fenster'),
        'answers' => [
            ['label' => __('Something period', 'fenster'),  'sub' => __('Older, with character', 'fenster'), 'value' => 0, 'pic' => '26'],
            ['label' => __('Something modern', 'fenster'),  'sub' => __('Newer, cleaner lines', 'fenster'), 'value' => 1, 'pic' => '117'],
            ['label' => __('Honestly, neither', 'fenster'), 'sub' => __('Skip this one', 'fenster'),        'value' => null, 'pic' => ''],
        ],
    ],
    [
        'id'    => 'g',
        'kicker' => __('The light', 'fenster'),
        'title' => __('How bright do you want the hall?', 'fenster'),
        'answers' => [
            ['label' => __('Flood it', 'fenster'),        'sub' => __('As much glass as it takes', 'fenster'), 'value' => 3, 'pic' => '247'],
            ['label' => __('A good amount', 'fenster'),   'sub' => __('Light, but still a door', 'fenster'),   'value' => 2, 'pic' => '7'],
            ['label' => __('Just a bit', 'fenster'),      'sub' => __('A window, not a wall of it', 'fenster'), 'value' => 1, 'pic' => '71'],
            ['label' => __('Keep it solid', 'fenster'),   'sub' => __('No glass at all', 'fenster'),          'value' => 0, 'pic' => '25'],
        ],
    ],
    [
        'id'    => 'd',
        'kicker' => __('The face', 'fenster'),
        'title' => __('Plain, or something going on?', 'fenster'),
        'answers' => [
            ['label' => __('Keep it plain', 'fenster'),  'sub' => __('Let the colour do it', 'fenster'),   'value' => 0, 'pic' => '95'],
            ['label' => __('A bit of detail', 'fenster'), 'sub' => __('Some shape in the face', 'fenster'), 'value' => 1, 'pic' => '33'],
            ['label' => __('Make it a feature', 'fenster'), 'sub' => __('People should notice', 'fenster'), 'value' => 2, 'pic' => '4'],
        ],
    ],
    [
        'id'    => 'v',
        'kicker' => __('The shape', 'fenster'),
        'title' => __('Straight lines, or a curve?', 'fenster'),
        'answers' => [
            ['label' => __('Straight', 'fenster'), 'sub' => __('Square and quiet', 'fenster'),      'value' => 0, 'pic' => '28'],
            ['label' => __('A curve', 'fenster'),  'sub' => __('An arch somewhere in it', 'fenster'), 'value' => 1, 'pic' => '1'],
        ],
    ],
    /* Colour is last, and it is the only question that does NOT narrow the
       range: every door comes in every colour, so scoring on it would invent a
       constraint that does not exist. It decides how the door is SHOWN — the
       tool opens in it. Without this every result was a white door, and nobody
       pictures their own front door white. */
    [
        'id'       => 'c',
        'kicker'   => __('The colour', 'fenster'),
        'title'    => __('And what colour?', 'fenster'),
        'swatches' => true,
        'answers'  => [],
    ],
];

foreach ($fg_colours as $fg_col) {
    $fg_questions[4]['answers'][] = [
        'label' => $fg_col['name'],
        'sub'   => '',
        'value' => $fg_col['key'],
        'pic'   => '',
        'hex'   => $fg_col['hex'],
    ];
}

$fg_known = array_column($fg_quiz_doors, 'k');
$fg_total = count($fg_questions);
?>
<section class="fg-cdq" aria-labelledby="fg-cdq-title"
    data-fg-door-quiz
    data-fg-quiz-doors="<?php echo esc_attr((string) wp_json_encode($fg_quiz_doors)); ?>"
    data-fg-quiz-art="<?php echo esc_attr($fg_art); ?>"
    data-fg-quiz-ver="<?php echo esc_attr((string) $fg_ver); ?>"
    data-fg-quiz-quote="<?php echo esc_attr(fenster_composite_door_quote_url('__KEY__')); ?>">
    <div class="container">

        <header class="fg-cdq__head">
            <p class="eyebrow"><?php esc_html_e('Five questions', 'fenster'); ?></p>
            <h2 id="fg-cdq-title"><?php esc_html_e('Which composite door are you?', 'fenster'); ?></h2>
            <p><?php esc_html_e('One hundred and forty two doors is too many to choose from cold. Answer five questions about your house and we will point at one, with the reasoning, and open it in the pricing tool in the colour you picked.', 'fenster'); ?></p>
        </header>

        <?php /* Ships hidden. Without JavaScript the range above is the answer,
                 and a quiz that cannot score is worse than no quiz at all. */ ?>
        <div class="fg-cdq__panel" data-fg-quiz-panel hidden>

            <div class="fg-cdq__progress" data-fg-quiz-progress>
                <?php for ($fg_i = 0; $fg_i < $fg_total; $fg_i++) : ?>
                    <span class="fg-cdq__pip" data-fg-quiz-pip="<?php echo esc_attr((string) $fg_i); ?>"></span>
                <?php endfor; ?>
                <span class="fg-cdq__count" data-fg-quiz-count aria-live="polite"></span>
            </div>

            <div class="fg-cdq__stage">
                <?php foreach ($fg_questions as $fg_i => $fg_q) : ?>
                    <div class="fg-cdq__q" data-fg-quiz-q="<?php echo esc_attr($fg_q['id']); ?>" data-fg-quiz-step="<?php echo esc_attr((string) $fg_i); ?>" hidden>
                        <p class="fg-cdq__kicker"><?php echo esc_html($fg_q['kicker']); ?></p>
                        <h3 class="fg-cdq__title"><?php echo esc_html($fg_q['title']); ?></h3>
                        <div class="fg-cdq__answers fg-cdq__answers--<?php echo esc_attr((string) count($fg_q['answers'])); ?><?php echo ! empty($fg_q['swatches']) ? ' fg-cdq__answers--swatches' : ''; ?>">
                            <?php foreach ($fg_q['answers'] as $fg_a) : ?>
                                <?php
                                $fg_key = (string) $fg_a['pic'];
                                $fg_has = $fg_key !== '' && in_array($fg_key, $fg_known, true);
                                ?>
                                <?php $fg_hex = (string) ($fg_a['hex'] ?? ''); ?>
                                <button type="button"
                                    class="fg-cdq__answer<?php echo ($fg_has || $fg_hex !== '') ? '' : ' fg-cdq__answer--plain'; ?><?php echo $fg_hex !== '' ? ' fg-cdq__answer--swatch' : ''; ?>"
                                    data-fg-quiz-answer="<?php echo esc_attr($fg_a['value'] === null ? '' : (string) $fg_a['value']); ?>">
                                    <?php if ($fg_hex !== '') : ?>
                                        <span class="fg-cdq__chip" style="background:<?php echo esc_attr($fg_hex); ?>"></span>
                                    <?php elseif ($fg_has) : ?>
                                        <span class="fg-cdq__answer-art">
                                            <img src="<?php echo esc_url($fg_pic($fg_key)); ?>" alt="" loading="lazy" decoding="async" width="914" height="2013">
                                        </span>
                                    <?php endif; ?>
                                    <span class="fg-cdq__answer-text">
                                        <strong><?php echo esc_html($fg_a['label']); ?></strong>
                                        <?php if (trim((string) $fg_a['sub']) !== '') : ?>
                                            <small><?php echo esc_html($fg_a['sub']); ?></small>
                                        <?php endif; ?>
                                    </span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="fg-cdq__back" data-fg-quiz-back hidden aria-label="<?php esc_attr_e('Back to the previous question', 'fenster'); ?>">
                            <?php esc_html_e('Back', 'fenster'); ?>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="fg-cdq__result" data-fg-quiz-result hidden tabindex="-1">
                <div class="fg-cdq__reveal">
                    <p class="fg-cdq__reveal-kicker"><?php esc_html_e('You are a', 'fenster'); ?></p>
                    <h3 class="fg-cdq__door-name" data-fg-quiz-name></h3>
                    <p class="fg-cdq__collection" data-fg-quiz-collection></p>
                    <p class="fg-cdq__chosen-colour" data-fg-quiz-colour hidden></p>
                    <figure class="fg-cdq__art">
                        <img data-fg-quiz-art-img src="" alt="" width="914" height="2013" decoding="async">
                    </figure>
                    <p class="fg-cdq__why" data-fg-quiz-why></p>
                    <p class="fg-cdq__poa" data-fg-quiz-poa hidden><?php esc_html_e('This one is priced on application rather than instantly, so the tool will take you as far as the design and we will follow up with the number.', 'fenster'); ?></p>
                    <p class="fg-cdq__result-actions">
                        <button type="button" class="button" data-fg-quiz-share><?php esc_html_e('Share your door', 'fenster'); ?></button>
                        <a class="button button--light" data-fg-quiz-open href="#" target="_blank" rel="noopener"><?php esc_html_e('Open full size', 'fenster'); ?></a>
                        <button type="button" class="button button--light" data-fg-quiz-reset><?php esc_html_e('Try again', 'fenster'); ?></button>
                    </p>
                    <p class="fg-cdq__caveat"><?php esc_html_e('Five questions cannot know your house. If it is not right, the range above has the other 141 and every one of them opens the same way.', 'fenster'); ?></p>
                </div>

                <?php /* The tool, on that door. Built on submit rather than
                         shipped, so a visitor who never answers never loads it. */ ?>
                <div class="fg-cdq__tool">
                    <div class="fg-cdq__frame" data-fg-quiz-frame data-lenis-prevent></div>
                    <p class="fg-cdq__frame-note"><?php esc_html_e('Colour, glass and handles are chosen in here, and the price moves as you change them.', 'fenster'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
