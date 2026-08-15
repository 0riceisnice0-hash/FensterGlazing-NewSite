<?php
/**
 * Dedicated consultation booking page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);
$booking_trust = [
    ['title' => 'Rated Excellent', 'copy' => 'Independent Trustpilot feedback.', 'item' => $trust_items[1] ?? null],
    ['title' => 'FENSA approved', 'copy' => 'Registered window and door installations.', 'item' => $trust_items[2] ?? null],
];
$faqs = [
    ['question' => 'Is the consultation free?', 'answer' => 'Yes. The visit, the measuring and the price are free, and they stay free whether you go ahead with us or not. There is no charge for coming out and no fee to pay if you decide against the job.'],
    ['question' => 'Will I get a hard sell?', 'answer' => 'No. It is a friendly visit rather than a pitch. We go through the options, price the job and leave the decision with you. There is no negotiating either: the price is the price, so there is no inflated opening figure and no discount that depends on signing today.'],
    ['question' => 'How long does the visit take?', 'answer' => 'An hour at most, normally. We go through the options for your property, take rough sizes so the price is right and quote the job, and that is the visit. There are no long presentations to sit through.'],
    ['question' => 'Does everyone deciding need to be there?', 'answer' => 'No. Some firms will only book a visit when every decision maker is home. We do not work that way, so come on your own if that suits you and take the price away to talk over with whoever you like.'],
    ['question' => 'Who comes out, and what will we go through?', 'answer' => 'A window and door expert, who will go through the options with you: which style suits the opening, how the glass, colour and hardware choices change things, and what is worth doing now against later. Windows, doors, glazing, repairs and roof lanterns are all fair game.'],
    ['question' => 'Can I see samples at the visit?', 'answer' => 'We bring colour swatches, and the job goes together on screen on the iPad as we price it, so you can see the choices as you make them. Full product samples stay at the showroom, so if you want to open a bifold or feel the weight of a handle, that is worth a separate trip. We can arrange one.'],
    ['question' => 'Will I get a price on the day?', 'answer' => 'Yes. We take rough sizes, then build and price the job in front of you on an iPad, using the same software and the same price list as the online quote tool on this site. It is one number for the job rather than an online figure and a different one at the door, and you are not waiting a week to find out what it is. The exact measurements come later, at the technical survey.'],
    ['question' => 'What happens after the visit?', 'answer' => 'If you are not ready to decide on the day, we send the quote over and leave it with you. It normally holds for 30 days. If you want to go ahead, we send a contract and a deposit request, typically 50%. A full technical survey follows, and that is what settles the final sizes and details before anything is made.'],
    ['question' => 'Can I get a price without booking a visit?', 'answer' => 'Yes. The online quote tool prices your sizes, styles, colours and glass as you go, and most people have a real figure inside ten minutes. A consultation is worth it when the opening is awkward, the choice is not obvious, or you would rather talk it through with someone.'],
    ['question' => 'Is my chosen time confirmed immediately?', 'answer' => 'No. Your selected date and time are a preferred appointment request. We check availability and confirm the appointment with you by phone or email.'],
    ['question' => 'Which areas do you cover?', 'answer' => 'We visit homes across Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire. Our showroom is in Milton Keynes, but the consultation happens at your property.'],
];
// FAQPage markup comes from the shared emitter in `inc/generated-pages.php`.
// Seven separate copies of this block existed across the theme until
// 2026-08-15, which is seven places for the shape to drift and five that
// had already been missed when the schema itself needed changing.
?>

<article class="fg-consultation-page">
    <section class="fg-consultation-page__hero">
        <div class="container fg-consultation-page__hero-grid">
            <div class="fg-consultation-page__hero-copy">
                <p class="eyebrow"><?php esc_html_e('Fenster Glazing · Milton Keynes and surrounding areas', 'fenster'); ?></p>
                <h1><?php esc_html_e('Book a free consultation with an expert.', 'fenster'); ?></h1>
                <p><?php esc_html_e('Choose a weekday and a preferred time, and one of our experts will come to you, go through the options for your property and price the job before they leave. The visit is free, whether you go ahead with us or not.', 'fenster'); ?></p>
                <p><?php esc_html_e('We cover Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and Hertfordshire, and we will confirm your appointment directly.', 'fenster'); ?></p>
            </div>

            <div class="fg-consultation-page__booking">
                <?php get_template_part('template-parts/components/enquiry-form', null, [
                    'class' => 'fg-consultation-form fg-consultation-page__form',
                    'id' => 'book-consultation',
                    'source' => 'Dedicated consultation booking page',
                    'button_label' => 'Request consultation',
                    'consultation_booking' => true,
                ]); ?>
                <aside class="fg-consultation-page__booking-trust" aria-label="<?php esc_attr_e('Booking reassurance', 'fenster'); ?>">
                    <?php foreach ($booking_trust as $trust) : ?>
                        <?php if (is_array($trust['item'])) : ?>
                            <div>
                                <?php if (! empty($trust['item']['url'])) : ?>
                                    <a class="fg-accreditation-logo-link" href="<?php echo esc_url((string) $trust['item']['url']); ?>"<?php echo fenster_trust_link_attrs($trust['item']); ?> aria-label="<?php echo esc_attr(sprintf(__('Learn more about %s', 'fenster'), (string) $trust['item']['alt'])); ?>">
                                <?php endif; ?>
                                <img <?php echo fenster_image_attr_string((string) $trust['item']['src'], ['alt' => (string) $trust['item']['alt'], 'loading' => 'lazy']); ?>>
                                <?php if (! empty($trust['item']['url'])) : ?></a><?php endif; ?>
                                <p><strong><?php echo esc_html($trust['title']); ?></strong><span><?php echo esc_html($trust['copy']); ?></span></p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </aside>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__story">
        <div class="container fg-consultation-page__story-grid">
            <figure class="fg-consultation-page__story-image">
                <img <?php echo fenster_image_attr_string(FENSTER_THEME_URI . '/assets/images/products/curated/sheerline-bifold-exterior.jpg', ['alt' => 'Anthracite grey bifold doors opening onto a patio', 'loading' => 'lazy']); ?>>
            </figure>
            <div class="fg-consultation-page__story-copy">
                <p class="eyebrow"><?php esc_html_e('Advice before decisions', 'fenster'); ?></p>
                <h2><?php esc_html_e('Bring the questions that are hard to answer online.', 'fenster'); ?></h2>
                <p><?php esc_html_e('Whether you are replacing one door or planning a larger extension, a free consultation gives you time to compare the options that matter before you commit. It is a friendly conversation with a window and door expert, not a sales visit.', 'fenster'); ?></p>
                <ul>
                    <li><?php esc_html_e('An expert goes through the options with you, and what suits the opening.', 'fenster'); ?></li>
                    <li><?php esc_html_e('The job is built and priced in front of you on an iPad, from rough sizes.', 'fenster'); ?></li>
                    <li><?php esc_html_e('It is the same pricing software as the online quote tool, so the number matches.', 'fenster'); ?></li>
                    <li><?php esc_html_e('No pressure and no long presentation. An hour at most, normally.', 'fenster'); ?></li>
                </ul>
                <div class="fg-consultation-page__story-contact">
                    <span><?php esc_html_e('Prefer to speak now?', 'fenster'); ?></span>
                    <a href="tel:<?php echo esc_attr($phone_href); ?>">
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.91.7 2.82a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.26-1.26a2 2 0 0 1 2.11-.45c.91.34 1.86.57 2.82.7A2 2 0 0 1 22 16.92Z"/></svg>
                        <?php echo esc_html($phone); ?>
                    </a>
                    <a href="mailto:<?php echo esc_attr($email); ?>">
                        <svg aria-hidden="true" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        <?php echo esc_html($email); ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="fg-consultation-page__faq">
        <div class="container fg-consultation-page__faq-grid">
            <div class="fg-consultation-page__section-head">
                <p class="eyebrow"><?php esc_html_e('Booking questions', 'fenster'); ?></p>
                <h2><?php esc_html_e('What to expect from the visit.', 'fenster'); ?></h2>
            </div>
            <?php /* Shares .fg-product-faq__items with the product pages so the one
                     accordion controller in main.js drives these too, rather than a
                     second copy. First item open so the section still reads with
                     JavaScript off. */ ?>
            <div class="fg-consultation-page__faq-items fg-product-faq__items">
                <?php foreach ($faqs as $index => $faq) : ?>
                    <details <?php echo $index === 0 ? 'open' : ''; ?>>
                        <summary><?php echo esc_html($faq['question']); ?></summary>
                        <div class="fg-product-faq__answer">
                            <p><?php echo esc_html($faq['answer']); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php get_template_part('template-parts/components/review-showcase', null, ['class' => 'fg-review-showcase--consultation', 'trust_items' => $trust_items, 'limit' => 7]); ?>
</article>

<?php fenster_render_faq_page_schema($faqs); ?>
