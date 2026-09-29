<?php
/**
 * What is true of each town in the location matrix, for its 21 product pages.
 *
 * Owner, 2026-09-28: the town pages shared 84% of their text with the same
 * product in the next town (SEO audit, section 7) and must come down "to like
 * under 50%". The product decisions stay shared, because they are the same
 * product; what each town gets is its own homes, what they mean for windows
 * and doors, what to check before ordering, who grants permission there, the
 * postcodes and its neighbours.
 *
 * FACTS ONLY. Housing history, conservation areas and councils are public
 * record; nothing here invents a local job, a price, a review or a distance.
 * Where a conservation area's boundary is not certain, the copy says "check"
 * rather than asserting a street is in one. Wolverton's Article 4 directions
 * and our help with applications there are from our own Wolverton guide.
 *
 * `nearby` names other towns in the matrix, closest first, for the "same
 * product nearby" links; keep them to real neighbours.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_location_town_guides(): array
{
    return [
        'bletchley' => [
            'postcodes' => 'MK1, MK2 and MK3',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['furzton', 'shenley-church-end', 'woburn-sands', 'leighton-buzzard'],
            'homes' => 'Bletchley was a railway town long before Milton Keynes was drawn around it. Victorian and Edwardian terraces sit near the station and in Fenny Stratford, with 1930s bay-fronted semis and post-war estates such as the Lakes further out.',
            'means' => 'A bay-fronted semi and a 1960s estate house are different jobs. The bay has to be rebuilt around its support, while most estate houses are straight replacements where the decisions are glass, colour and opening style.',
            'check' => 'Bays carry the wall above them. Anyone quoting for a bay window here should be talking about how it is supported, not only the colour of the frame.',
            'permission' => 'Most Bletchley houses can have windows and doors replaced like for like without planning permission. On the older streets, check with Milton Keynes City Council whether your house sits in a conservation area before changing the style or material.',
        ],
        'wolverton' => [
            'postcodes' => 'MK12',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['stony-stratford', 'great-linford', 'whitehouse', 'newport-pagnell'],
            'homes' => 'Wolverton was built from 1838 for the London and Birmingham Railway\'s works, and its long, regular terraces on a tight grid still define the town, with later housing around the edges and at Wolverton Mill.',
            'means' => 'Terraced fronts look best when the replacement keeps the original proportions of each opening. Slim, flush frames and sliding sash styles usually sit better on these houses than a heavy modern profile.',
            'check' => 'Wolverton became a conservation area in 2001, and the street elevations are what people notice. Photographs of the neighbouring houses help us suggest a style that fits the terrace.',
            'permission' => 'Usually, yes. Article 4 directions from 2003 removed permitted development rights for many Wolverton houses, so even a like-for-like replacement often needs planning permission from Milton Keynes City Council. We regularly prepare these applications for Wolverton homeowners, including the site plans, heritage statement and supporting photographs.',
        ],
        'stony-stratford' => [
            'postcodes' => 'MK11',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['wolverton', 'whitehouse', 'buckingham'],
            'homes' => 'Stony Stratford grew up as a coaching town on Watling Street. The High Street has Georgian and older frontages and many listed buildings, with Victorian streets behind it and newer estates on the edges.',
            'means' => 'In the old town, character comes first: slim sightlines, sliding sash and flush casement styles and heritage colours matter more than they would on a modern estate. The newer edges are simpler replacements.',
            'check' => 'Much of the old town is a conservation area, and listed buildings need consent for any change to their windows or doors. Find out the status of your house before choosing a style.',
            'permission' => 'If your home is listed, new windows or doors need listed building consent from Milton Keynes City Council, and in the conservation area a change of style or material may need planning permission. On the newer estates, like-for-like replacements are usually permitted development.',
        ],
        'newport-pagnell' => [
            'postcodes' => 'MK16',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['great-linford', 'monkston', 'wolverton', 'brooklands'],
            'homes' => 'Newport Pagnell is an old market town, with a historic High Street and the cast iron Tickford Bridge at its centre and post-war and modern estates spreading out around it.',
            'means' => 'Two different jobs, depending on the street. Period houses near the High Street need sympathetic styling, while on the estates energy performance and colour usually lead the choice.',
            'check' => 'The town centre is a conservation area. If you live near the High Street, check before changing the look of the front of the house.',
            'permission' => 'Like-for-like replacements are usually permitted development in Newport Pagnell. In the town centre conservation area, or on a listed building, talk to Milton Keynes City Council before changing the style, material or colour of front windows and doors.',
        ],
        'woburn-sands' => [
            'postcodes' => 'MK17',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['brooklands', 'bletchley', 'ampthill', 'flitwick'],
            'homes' => 'Woburn Sands grew after its station opened in the 1840s. Victorian and Edwardian villas line its roads on the edge of Aspley Woods, with later houses and plenty of modern extensions among them.',
            'means' => 'The older villas often have tall, narrow openings that suit a slim frame and a larger area of glass. Rear extensions are where bifold doors and roof lanterns usually come in.',
            'check' => 'If you are glazing an extension and replacing windows at the same time, price them together so the colour and glass match across the house.',
            'permission' => 'Woburn Sands is covered by Milton Keynes City Council. Like-for-like replacements are usually permitted development, but the older part of the town is a conservation area, so check before changing the style of a front elevation.',
        ],
        'great-linford' => [
            'postcodes' => 'MK14',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['newport-pagnell', 'wolverton', 'oldbrook'],
            'homes' => 'Great Linford keeps a village core, with its manor house, almshouses and church beside the Grand Union Canal, wrapped in the 1970s and 1980s housing of the new city.',
            'means' => 'Most of the work here is on the estate houses, where the original frames or their first replacements are now failing: misted units, stiff handles and draughty openers.',
            'check' => 'The village core is a conservation area. On the estate streets, check your deeds for any covenant on the front elevation before changing its style.',
            'permission' => 'On Great Linford\'s estate streets, like-for-like replacements are usually permitted development. Around the historic village core, which is a conservation area, check with Milton Keynes City Council before changing the look of windows or doors.',
        ],
        'shenley-church-end' => [
            'postcodes' => 'MK5',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['furzton', 'whitehouse', 'oldbrook', 'bletchley'],
            'homes' => 'Shenley Church End is mostly 1980s housing built around the old village and its church, on the western side of the city.',
            'means' => 'The house types repeat, so replacements are predictable and tidy to plan. Most people spend their time on colour, glass and whether to change the opening style.',
            'check' => 'Original 1980s frames and first-generation replacements are now well past their best. Look for misting in the glass and wear in the hinges and handles.',
            'permission' => 'Most Shenley Church End homes can have windows and doors replaced like for like without planning permission. Around the old village centre, check with Milton Keynes City Council whether your house is in a conservation area.',
        ],
        'furzton' => [
            'postcodes' => 'MK4',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['shenley-church-end', 'bletchley', 'oldbrook'],
            'homes' => 'Furzton is a 1980s grid square built around Furzton Lake, with terraced, semi-detached and detached houses set along quiet closes.',
            'means' => 'Many homes still have their first replacement windows, or the originals, and they share a handful of designs. That makes a whole-house replacement easy to plan and to price.',
            'check' => 'Look at the garden doors as well as the windows. Patio doors from this era are often where draughts and stiff runners show up first.',
            'permission' => 'Replacing windows and doors like for like is usually permitted development in Furzton. In a flat or a leasehold house, the freeholder normally has to agree before you order.',
        ],
        'oldbrook' => [
            'postcodes' => 'MK6',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['furzton', 'shenley-church-end', 'great-linford', 'monkston'],
            'homes' => 'Oldbrook sits beside Central Milton Keynes and was built from the late 1970s, with terraces, semis, flats and housing association homes along its redways.',
            'means' => 'The houses here are usually straight replacements. Flats and shared buildings follow different rules, and the landlord or management company often has a say in what is fitted.',
            'check' => 'If you own a flat or a shared-ownership home, find out who is responsible for the windows before you get quotes. In many leases it is not the occupier.',
            'permission' => 'Most Oldbrook houses can have windows and doors replaced like for like without planning permission. For flats and leasehold or shared-ownership homes, the freeholder or housing association usually has to agree first.',
        ],
        'monkston' => [
            'postcodes' => 'MK10',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['brooklands', 'newport-pagnell', 'woburn-sands', 'oldbrook'],
            'homes' => 'Monkston was built in the late 1990s and 2000s in the east of Milton Keynes, around Monkston Park, with detached and semi-detached family houses and some townhouses.',
            'means' => 'The builders\' original windows are now twenty years old or more. Upgrades here are about warmer glass, a colour that suits the house and opening the back up to the garden.',
            'check' => 'Newer estates sometimes carry planning conditions or covenants on the front elevation. Check your deeds before changing its style or colour.',
            'permission' => 'Like-for-like replacements are usually permitted development in Monkston, but some newer estates carry planning conditions or covenants that affect the front of the house. Your deeds or Milton Keynes City Council can confirm.',
        ],
        'brooklands' => [
            'postcodes' => 'MK10',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['monkston', 'woburn-sands', 'newport-pagnell'],
            'homes' => 'Brooklands is one of the newest parts of Milton Keynes, built from around 2010 on the eastern edge of the city, with a mix of houses, townhouses and apartments.',
            'means' => 'The windows here are recent, so most enquiries are for garden doors, extensions and roof lanterns, or for replacing a builder-standard front door with something better.',
            'check' => 'Some homes are still within a builder\'s warranty, and estate rules can cover the front of the house. Check both before changing anything on the street side.',
            'permission' => 'In Brooklands, check your deeds and any estate management rules before changing the front of the house, and keep your builder\'s warranty in mind. New garden doors at the back are usually permitted development.',
        ],
        'whitehouse' => [
            'postcodes' => 'MK8',
            'council' => 'Milton Keynes City Council',
            'nearby' => ['shenley-church-end', 'stony-stratford', 'wolverton'],
            'homes' => 'Whitehouse is part of the Western Expansion Area, built from the mid-2010s, with modern family houses, townhouses and apartments.',
            'means' => 'Almost everything here is new, so the work is mostly garden doors, better front doors than the builder fitted and glazing for extensions.',
            'check' => 'Check your deeds and estate management rules before changing the front of the house, and whether your builder\'s warranty is still running.',
            'permission' => 'New garden doors at the back of a Whitehouse home are usually permitted development. For the front of the house, check the deeds and any estate rules first, and in a flat the freeholder has to agree.',
        ],
        'ampthill' => [
            'postcodes' => 'MK45',
            'council' => 'Central Bedfordshire Council',
            'nearby' => ['flitwick', 'bedford', 'toddington', 'woburn-sands'],
            'homes' => 'Ampthill is a Georgian market town. Its centre is full of period houses and listed buildings, with Victorian streets around it and newer estates on the edges.',
            'means' => 'In the old town, the look of the windows matters as much as their performance, so sliding sash and flush casement styles are the usual choice. The newer estates are simpler replacements.',
            'check' => 'The town centre is a conservation area with many listed buildings. Find out whether your house is listed before choosing a style or material.',
            'permission' => 'Ampthill is covered by Central Bedfordshire Council. Listed buildings need listed building consent for any change to windows or doors, and in the conservation area a change of style or material may need planning permission. On the newer estates, like-for-like replacements are usually permitted development.',
        ],
        'aylesbury' => [
            'postcodes' => 'HP19, HP20, HP21 and HP22',
            'council' => 'Buckinghamshire Council',
            'nearby' => ['leighton-buzzard', 'buckingham', 'dunstable'],
            'homes' => 'Aylesbury has a medieval old town around St Mary\'s church, Victorian and interwar streets around the centre, large post-war estates, and new neighbourhoods such as Berryfields and Kingsbrook.',
            'means' => 'Much of Aylesbury is interwar and post-war housing, where the choice is glass, colour and opening style. The old town and the newest estates each need their own checks.',
            'check' => 'The old town is a conservation area. On the newest estates, check your deeds and builder\'s warranty before changing the front of the house.',
            'permission' => 'Aylesbury is covered by Buckinghamshire Council. Like-for-like replacements are usually permitted development, but the old town is a conservation area with many listed buildings, and newer estates can carry planning conditions or covenants.',
        ],
        'bedford' => [
            'postcodes' => 'MK40, MK41 and MK42',
            'council' => 'Bedford Borough Council',
            'nearby' => ['ampthill', 'flitwick', 'newport-pagnell'],
            'homes' => 'Bedford has streets of Victorian and Edwardian terraces and villas close to the centre and the river, interwar semis beyond them, and large post-war and modern estates around the edge.',
            'means' => 'The Victorian and Edwardian streets often suit sash and flush casement styles, and many have bays that need proper support. The post-war estates are usually straight replacements.',
            'check' => 'Bedford has several conservation areas around the centre. In an older street, check whether your house is in one before changing the style or material.',
            'permission' => 'Bedford is covered by Bedford Borough Council. Like-for-like replacements are usually permitted development, but the town has several conservation areas and many listed buildings, where changes can need permission.',
        ],
        'buckingham' => [
            'postcodes' => 'MK18',
            'council' => 'Buckinghamshire Council',
            'nearby' => ['stony-stratford', 'whitehouse', 'aylesbury'],
            'homes' => 'Much of Buckingham\'s centre was rebuilt in brick after the fire of 1725, which gives the town its Georgian core, with Victorian streets and newer estates around it.',
            'means' => 'In the centre, windows need to respect the Georgian proportions of the houses. Slim frames, sliding sash and flush styles and heritage colours are the usual choices there.',
            'check' => 'The town centre is a conservation area with many listed buildings. Check the status of your house before you choose a style or material.',
            'permission' => 'Buckingham is covered by Buckinghamshire Council. Listed buildings need listed building consent for new windows or doors, and in the conservation area a change of style or material may need planning permission. The newer estates are usually permitted development.',
        ],
        'dunstable' => [
            'postcodes' => 'LU5 and LU6',
            'council' => 'Central Bedfordshire Council',
            'nearby' => ['luton', 'toddington', 'leighton-buzzard'],
            'homes' => 'Dunstable grew where Watling Street crosses the Icknield Way. There are older buildings around the Priory Church and the centre, but most homes are interwar and post-war, below Dunstable Downs.',
            'means' => 'Most Dunstable homes are straight replacements, where the decisions are glass, colour and whether to change the opening style. Older properties near the centre need more care.',
            'check' => 'Houses from the interwar years sometimes still have steel or timber windows. When they come out, the surrounding brickwork and lintels need checking before the new frames go in.',
            'permission' => 'Dunstable is covered by Central Bedfordshire Council. Like-for-like replacements are usually permitted development; check first if your house is listed or near the historic centre.',
        ],
        'flitwick' => [
            'postcodes' => 'MK45',
            'council' => 'Central Bedfordshire Council',
            'nearby' => ['ampthill', 'toddington', 'bedford', 'woburn-sands'],
            'homes' => 'Flitwick grew from a village into a commuter town around its station on the Midland Main Line, and most of its homes date from the 1960s onwards, from post-war houses to recent estates.',
            'means' => 'Most homes here are straight replacements. The big choices are usually the glass, the colour and whether to open up the back with new garden doors.',
            'check' => 'On the newer estates, check your deeds for covenants on the front elevation before changing its style or colour.',
            'permission' => 'Flitwick is covered by Central Bedfordshire Council. Replacing windows and doors like for like is usually permitted development; on newer estates, check your deeds for covenants first.',
        ],
        'hitchin' => [
            'postcodes' => 'SG4 and SG5',
            'council' => 'North Hertfordshire District Council',
            'nearby' => ['letchworth', 'stevenage', 'luton'],
            'homes' => 'Hitchin is an old market town with a medieval and Georgian centre, Victorian terraces around it, and interwar and post-war housing further out.',
            'means' => 'The period streets suit slim, traditional frames, often sliding sash or flush casement, and the later housing is usually a straight replacement.',
            'check' => 'Much of the town centre is a conservation area with many listed buildings, so check before changing the look of an older house.',
            'permission' => 'Hitchin is covered by North Hertfordshire District Council. Listed buildings need listed building consent, and in the conservation area a change of style or material may need planning permission. Elsewhere, like-for-like replacements are usually permitted development.',
        ],
        'leighton-buzzard' => [
            'postcodes' => 'LU7',
            'council' => 'Central Bedfordshire Council',
            'nearby' => ['bletchley', 'dunstable', 'toddington', 'aylesbury'],
            'homes' => 'Leighton Buzzard is a market town on the Grand Union Canal, with Linslade across the River Ouzel. Victorian terraces surround the centre, with large post-war and modern estates beyond.',
            'means' => 'The Victorian terraces suit traditional styles and often have bays. Most of the estate housing is a straight replacement where glass and colour lead the decision.',
            'check' => 'The town centre is a conservation area. If your house is near the High Street, check before changing the style of the front windows.',
            'permission' => 'Leighton Buzzard is covered by Central Bedfordshire Council. Like-for-like replacements are usually permitted development; in the town centre conservation area or on a listed building, check with the council first.',
        ],
        'letchworth' => [
            'postcodes' => 'SG6',
            'council' => 'North Hertfordshire District Council',
            'nearby' => ['hitchin', 'stevenage', 'luton'],
            'homes' => 'Letchworth was the world\'s first garden city, begun in 1903. Its Arts and Crafts houses, cottages and later garden city estates give it a character unlike anywhere else nearby.',
            'means' => 'Windows and doors are a large part of that character, so replacements need to respect the original proportions, glazing bar patterns and colours of these houses.',
            'check' => 'The Letchworth Garden City Heritage Foundation runs a Scheme of Management across much of the town, and its consent is needed for changes to windows and doors. Apply before you order.',
            'permission' => 'In most of Letchworth, changing windows or doors needs consent from the Letchworth Garden City Heritage Foundation, as well as any planning permission from North Hertfordshire District Council. We can provide the product details the application asks for.',
        ],
        'luton' => [
            'postcodes' => 'LU1, LU2, LU3 and LU4',
            'council' => 'Luton Borough Council',
            'nearby' => ['dunstable', 'toddington', 'hitchin'],
            'homes' => 'Luton\'s older streets grew with the hat trade, with Victorian terraces around High Town and the centre, then large interwar and post-war estates across the rest of the town.',
            'means' => 'Terraced houses here often have narrow frontages where the proportions of the windows matter. The interwar and post-war estates are usually straight replacements.',
            'check' => 'Plaiters Lea, the old hat district, is a conservation area. In the older streets near the centre, check before changing the front of the house.',
            'permission' => 'Luton is covered by Luton Borough Council. Like-for-like replacements are usually permitted development, but check first if your house is listed or in a conservation area such as Plaiters Lea.',
        ],
        'northampton' => [
            'postcodes' => 'NN1 to NN5',
            'council' => 'West Northamptonshire Council',
            'nearby' => ['wolverton', 'newport-pagnell', 'stony-stratford'],
            'homes' => 'Northampton has long streets of Victorian terraces from its boot and shoe trade, older villas and a Georgian centre, and large estates built from the 1970s when the town expanded as a new town.',
            'means' => 'The Victorian terraces often have bays and narrow frontages that suit traditional styles. The 1970s and 1980s estates are usually straight replacements of original or first-generation frames.',
            'check' => 'Northampton has several conservation areas, including the Boot and Shoe Quarter. Check the status of an older house before changing the style of its windows.',
            'permission' => 'Northampton is covered by West Northamptonshire Council. Like-for-like replacements are usually permitted development, but the town has several conservation areas and many listed buildings, where changes can need permission.',
        ],
        'stevenage' => [
            'postcodes' => 'SG1 and SG2',
            'council' => 'Stevenage Borough Council',
            'nearby' => ['hitchin', 'letchworth', 'luton'],
            'homes' => 'Stevenage was the first post-war new town, designated in 1946. Most homes are in its planned neighbourhoods from the 1950s onwards, with the older High Street in the Old Town.',
            'means' => 'Many new town houses still have first-generation replacement windows now reaching the end of their life. They share a small number of designs, which makes a whole-house replacement easy to plan.',
            'check' => 'Flats and maisonettes are common in the neighbourhoods, and for those the freeholder usually has to agree before anything is ordered.',
            'permission' => 'Stevenage is covered by Stevenage Borough Council. Like-for-like replacements are usually permitted development; the Old Town conservation area and listed buildings need more care, and flats need the freeholder\'s agreement.',
        ],
        'toddington' => [
            'postcodes' => 'LU5',
            'council' => 'Central Bedfordshire Council',
            'nearby' => ['dunstable', 'flitwick', 'luton', 'ampthill'],
            'homes' => 'Toddington is a large village around its green, close to junction 12 of the M1, with period cottages and houses in the centre and later homes around it.',
            'means' => 'The period houses around the green need traditional styles and careful detailing. Later homes are usually straight replacements where glass and colour lead.',
            'check' => 'The centre of the village is a conservation area with listed buildings. Check before changing the look of an older house.',
            'permission' => 'Toddington is covered by Central Bedfordshire Council. Listed buildings need listed building consent for new windows or doors, and in the conservation area a change of style may need permission. Elsewhere, like-for-like replacements are usually permitted development.',
        ],
    ];
}

/**
 * Up to $limit residential case studies within ten miles (16 km) of a town:
 * the nearest featuring this product first, then jobs in the town itself,
 * then the nearest.
 *
 * Real local proof, which the town pages lacked: before 2026-09-28 a town
 * showed only case studies whose location named it, so ten Milton Keynes
 * districts all showed the same two jobs and ten other towns showed none.
 * Each card still states its own location, and the heading says "in and
 * around" only when a card names the town itself. Residential studies only:
 * commercial work stays off residential pages (owner, 2026-08-11), and a
 * repair is not the installation these pages sell.
 *
 * @return array{cards: array, in_town: bool}
 */
function fenster_location_case_studies(string $town_slug, string $product_slug, int $limit = 2): array
{
    // The homepage map's table: towns and case study places, keyed like a
    // study's `location` before its comma. A place it lacks is never near.
    $places = function_exists('fenster_h30_town_coordinates') ? fenster_h30_town_coordinates() : [];
    $town_words = str_replace('-', ' ', $town_slug);
    $town_at = $places[$town_words] ?? null;
    if ($town_at === null || ! function_exists('fenster_case_studies_of_type')) {
        return ['cards' => [], 'in_town' => false];
    }

    $near = [];
    foreach (fenster_case_studies_of_type('residential') as $short => $study) {
        $location = strtolower((string) ($study['location'] ?? ''));
        $at = $places[trim(explode(',', $location)[0])] ?? null;
        if ($at === null) {
            continue;
        }
        // Kilometres, flat-earth: fine over a county.
        $km = hypot(($at[0] - $town_at[0]) * 111.2, ($at[1] - $town_at[1]) * 111.3 * cos(deg2rad($town_at[0])));
        $in_town = preg_match('/\b' . preg_quote($town_words, '/') . '\b/', $location) === 1;
        if ($km > 16 && ! $in_town) {
            continue;
        }
        $has_product = $product_slug === 'double-glazing';
        foreach ((array) ($study['products'] ?? []) as $product) {
            if (rtrim((string) wp_parse_url((string) ($product['url'] ?? ''), PHP_URL_PATH), '/') === '/' . $product_slug) {
                $has_product = true;
                break;
            }
        }
        $near[] = ['short' => (string) $short, 'study' => $study, 'km' => $in_town ? 0.0 : $km, 'in_town' => $in_town, 'has_product' => $has_product];
    }

    // The first card proves the product, the rest prove the town: a Leighton
    // Buzzard composite door page shows the nearest composite door job, then a
    // job in Leighton Buzzard itself rather than a second door 14 km away.
    usort($near, static fn (array $a, array $b): int => [$b['has_product'], $b['in_town'], $a['km']] <=> [$a['has_product'], $a['in_town'], $b['km']]);
    $rest = array_slice($near, 1);
    usort($rest, static fn (array $a, array $b): int => [$b['in_town'], $b['has_product'], $a['km']] <=> [$a['in_town'], $a['has_product'], $b['km']]);
    $near = array_slice(array_merge(array_slice($near, 0, 1), $rest), 0, max(1, $limit));

    return [
        'cards' => array_map(static fn (array $item): array => fenster_case_study_card($item['short'], $item['study']), $near),
        'in_town' => in_array(true, array_column($near, 'in_town'), true),
    ];
}

/**
 * The day the town pages' own content last changed materially, as the
 * sitemap's `<lastmod>` for all 525 of them.
 *
 * A recorded date, never a file timestamp: a timestamp would claim every
 * page changed on every deploy, which is why the site publishes no modified
 * date anywhere else (see case-studies-residential.php). Change it in the
 * commit that changes what the town pages say, and not for a new case study
 * or review, which changes a card or two on a few of them.
 */
function fenster_location_pages_revised(): string
{
    return '2026-09-29';
}
