<?php
/**
 * Hardcoded meet-the-team page.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

$page = is_array($args['page'] ?? null) ? $args['page'] : get_query_var('fenster_generated_page');
$brand = is_array($args['brand'] ?? null) ? $args['brand'] : fenster_data('brand', []);
$related_links = is_array($args['related_links'] ?? null) ? $args['related_links'] : [];
$trust_items = is_array($args['trust_items'] ?? null) ? $args['trust_items'] : [];
$sections = is_array($page['sections'] ?? null) ? $page['sections'] : [];
$images = is_array($page['images'] ?? null) ? $page['images'] : [];
$phone = (string) ($brand['phone'] ?? '01908 429200');
$email = (string) ($brand['email'] ?? 'info@fensterglazing.com');
$phone_href = preg_replace('/\s+/', '', $phone);

$members = [];
foreach ($sections as $index => $section) {
    $name = trim((string) ($section['heading'] ?? ''));
    $body = array_values(array_filter(array_map('trim', $section['body'] ?? [])));
    $role = $body[0] ?? '';
    $copy = $body[1] ?? '';

    if ($index < 2 || $name === '' || $role === '' || $copy === '') {
        continue;
    }

    if (strtolower($name) === 'aurora') {
        continue;
    }

    $image = $images[$index - 2]['src'] ?? '';
    $alt = $images[$index - 2]['alt'] ?? $name;

    if ($name === 'Nick Fortella') {
        $name = 'Zac Bartley';
        $role = 'Marketing Executive';
        $copy = 'Zac Bartley leads marketing at Fenster Glazing, covering the website (hi), digital advertising, social media, content and brand development. With a background in marketing, web development and online content creation, Zac combines creativity with a data-driven approach to support the company\'s growth. Outside work, he enjoys coding, spending time with friends, walking the dogs and keeping up with Formula 1.';
        $image = '/wp-content/themes/fenster/assets/team/zac-bartley-bw.jpg';
        $alt = 'Zac Bartley';
    }

    if ($name === 'Perry Giffin') {
        $image = '/wp-content/themes/fenster/assets/team/perry-giffin-cropped-bw.jpg';
        $alt = 'Perry Giffin';
    }

    $members[] = [
        'name' => $name,
        'role' => $role,
        'copy' => $copy,
        'image' => $image,
        'alt' => $alt,
    ];
}

$steve_member = [
    'name' => 'Steve Freezer',
    'role' => 'Technical Advisor',
    'copy' => 'Steve Freezer is a Technical Advisor within Fenster Glazing\'s commercial team, helping interpret client specifications, technical requirements and product details accurately. With strong glazing system knowledge, he provides practical support to customers and colleagues from enquiry through to completion. Outside work, Steve trains in Brazilian jiu-jitsu and judo and enjoys staying active.',
    'image' => '/wp-content/themes/fenster/assets/team/steve-freezer-cropped-bw.jpg',
    'alt' => 'Steve Freezer',
];
$insert_after = array_search('Zac Bartley', array_column($members, 'name'), true);
if ($insert_after === false) {
    $members[] = $steve_member;
} else {
    array_splice($members, $insert_after + 1, 0, [$steve_member]);
}

$aaron_member = [
    'name' => 'Aaron Isaacs',
    'role' => 'Installer',
    'copy' => 'Aaron Isaacs is a skilled installer at Fenster Glazing, bringing over 10 years of experience in the trade. Reliable and detail-focused, he takes pride in completing every installation cleanly, efficiently and to a high standard. Outside of work, Aaron enjoys hiking, spending time with his family and exploring the outdoors, including completing the challenging climb up High Cup Nick.',
    'image' => '/wp-content/themes/fenster/assets/team/aaron-isaacs-cropped-bw.jpg',
    'alt' => 'Aaron Isaacs',
];
$insert_after = array_search('Zac Rugman', array_column($members, 'name'), true);
if ($insert_after === false) {
    $members[] = $aaron_member;
} else {
    array_splice($members, $insert_after + 1, 0, [$aaron_member]);
}

$members[] = [
    'name' => 'Legend',
    'role' => 'Chief Meow Officer',
    'copy' => 'Legend is Fenster Glazing\'s Chief Meow Officer, responsible for office morale, daily supervision from the nearest chair and making sure staff meet his attention requirements. With years of experience sleeping through meetings and demanding snacks at inconvenient times, he is an indispensable member of the team. Outside work, Legend enjoys drinking from the tap, hiding in boxes far too small for him and calling naps important strategic planning sessions.',
    'image' => '/wp-content/themes/fenster/assets/team/legend-bw.jpg',
    'alt' => 'Legend',
];

$bosses = array_slice($members, 0, 2);
$team_members = array_slice($members, 2);
?>

<article class="fg-team-page">
    <section class="fg-team-hero">
        <div class="container fg-team-hero__copy">
            <p class="eyebrow"><?php esc_html_e('Meet the team', 'fenster'); ?></p>
            <h1><?php esc_html_e('The people behind Fenster Glazing.', 'fenster'); ?></h1>
            <p><?php esc_html_e('From first enquiry and estimating through to survey, installation, service and aftercare, these are the people who help customers and projects move smoothly.', 'fenster'); ?></p>
            <div class="button-row">
                <a class="button" href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact the team', 'fenster'); ?></a>
                <a class="button button--light" href="<?php echo esc_url(home_url('/commercial-projects/')); ?>"><?php esc_html_e('View project work', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <section class="fg-team-people">
        <div class="container">
            <?php if (! empty($bosses)) : ?>
                <div class="fg-team-bosses">
                    <?php foreach ($bosses as $member) : ?>
                        <article id="<?php echo esc_attr(sanitize_title($member['name'])); ?>" class="fg-team-person fg-team-person--boss fg-team-person--<?php echo esc_attr(sanitize_title($member['name'])); ?>">
                            <?php if ($member['image'] !== '') : ?>
                                <img src="<?php echo esc_url(fenster_generated_url($member['image'])); ?>" alt="<?php echo esc_attr($member['name']); ?>" loading="<?php echo $member['name'] === 'Zac Bartley' ? 'eager' : 'lazy'; ?>">
                            <?php endif; ?>
                            <div>
                                <span><?php echo esc_html($member['role']); ?></span>
                                <h2><?php echo esc_html($member['name']); ?></h2>
                                <p><?php echo esc_html($member['copy']); ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="fg-team-lanes">
                <?php foreach ($team_members as $member) : ?>
                    <article id="<?php echo esc_attr(sanitize_title($member['name'])); ?>" class="fg-team-person fg-team-person--<?php echo esc_attr(sanitize_title($member['name'])); ?>">
                        <?php if ($member['image'] !== '') : ?>
                            <img src="<?php echo esc_url(fenster_generated_url($member['image'])); ?>" alt="<?php echo esc_attr($member['name']); ?>" loading="<?php echo $member['name'] === 'Zac Bartley' ? 'eager' : 'lazy'; ?>">
                        <?php endif; ?>
                        <div>
                            <span><?php echo esc_html($member['role']); ?></span>
                            <h3><?php echo esc_html($member['name']); ?></h3>
                            <p><?php echo esc_html($member['copy']); ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="fg-team-contact">
        <div class="container fg-team-contact__inner">
            <div>
                <p class="eyebrow"><?php esc_html_e('Talk to Fenster', 'fenster'); ?></p>
                <h2><?php esc_html_e('Need help choosing products or planning a glazing project?', 'fenster'); ?></h2>
                <p><?php esc_html_e('Call, email or visit the showroom. The team can help with home projects, commercial glazing, repairs and replacement glass.', 'fenster'); ?></p>
            </div>
            <div class="fg-team-contact__links">
                <a href="tel:<?php echo esc_attr($phone_href); ?>"><?php echo esc_html($phone); ?></a>
                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact page', 'fenster'); ?></a>
            </div>
        </div>
    </section>

    <?php if (! empty($trust_items)) : ?>
        <?php
        get_template_part('template-parts/components/review-showcase', null, [
            'class' => 'fg-review-showcase--team',
            'eyebrow' => 'Reviews and accreditations',
            'title' => 'Reviewed, accredited and backed by proven product systems.',
            'copy' => 'Fenster combines local installation experience with recognised accreditations and trusted glazing system partners.',
            'trust_items' => $trust_items,
            'limit' => 7,
        ]);
        ?>
    <?php endif; ?>

    <?php if (! empty($related_links)) : ?>
        <section class="fg-links-band">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow"><?php esc_html_e('Useful pages', 'fenster'); ?></p>
                    <h2><?php esc_html_e('Products, services and project examples', 'fenster'); ?></h2>
                </div>
                <div class="generated-links">
                    <?php foreach (array_slice(array_values($related_links), 0, 18) as $link) : ?>
                        <a href="<?php echo esc_url(fenster_generated_url($link['url'])); ?>"><?php echo esc_html($link['text']); ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</article>
