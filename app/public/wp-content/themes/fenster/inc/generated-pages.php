<?php
/**
 * Generated hardcoded page rendering from the scrape.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_generated_pages_payload(): array
{
    static $payload = null;

    if (is_array($payload)) {
        return $payload;
    }

    $file = FENSTER_THEME_DIR . '/data/pages.json';
    if (! file_exists($file)) {
        $payload = ['pages' => []];
        return $payload;
    }

    $decoded = json_decode((string) file_get_contents($file), true);
    $payload = is_array($decoded) ? $decoded : ['pages' => []];

    return $payload;
}

function fenster_generated_pages_index(): array
{
    static $index = null;

    if (is_array($index)) {
        return $index;
    }

    $index = [];
    foreach (fenster_generated_pages_payload()['pages'] ?? [] as $page) {
        if (! empty($page['slug'])) {
            $index[$page['slug']] = $page;
        }
    }

    return $index;
}

function fenster_location_matrix_towns(): array
{
    return [
        'ampthill' => 'Ampthill',
        'aylesbury' => 'Aylesbury',
        'bedford' => 'Bedford',
        'buckingham' => 'Buckingham',
        'dunstable' => 'Dunstable',
        'flitwick' => 'Flitwick',
        'hitchin' => 'Hitchin',
        'leighton-buzzard' => 'Leighton Buzzard',
        'letchworth' => 'Letchworth',
        'luton' => 'Luton',
        'northampton' => 'Northampton',
        'stevenage' => 'Stevenage',
        'toddington' => 'Toddington',
    ];
}

function fenster_location_matrix_products(): array
{
    return [
        'double-glazing' => 'Double Glazing',
        'casement-windows' => 'Casement Windows',
        'flush-casement-windows' => 'Flush Casement Windows',
        'sliding-sash-windows' => 'Sliding Sash Windows',
        'french-casement-windows' => 'French Casement Windows',
        'tilt-turn-windows' => 'Tilt and Turn Windows',
        'bow-bay-windows' => 'Bow and Bay Windows',
        'aluminium-windows' => 'Aluminium Windows',
        'aluminium-flush-windows' => 'Aluminium Flush Windows',
        'heritage-windows' => 'Heritage Windows',
        'aluminium-bifold-doors' => 'Aluminium Bifold Doors',
        'slide-fold-doors' => 'Slide and Fold Doors',
        'aluminium-sliding-doors' => 'Aluminium Sliding Doors',
        'aluminium-doors' => 'Aluminium Doors',
        'heritage-aluminium-doors' => 'Heritage Aluminium Doors',
        'composite-doors' => 'Composite Doors',
        'upvc-doors' => 'uPVC Doors',
        'patio-doors' => 'Patio Doors',
        'french-doors' => 'French Doors',
        'integral-blinds' => 'Integral Blinds',
        'roof-lanterns' => 'Roof Lanterns',
    ];
}

function fenster_location_matrix_town_profiles(): array
{
    return [
        'ampthill' => ['property' => 'character properties and modernised family homes', 'priority' => 'careful sightlines, colour choice and existing brickwork'],
        'aylesbury' => ['property' => 'new estates, older homes and growing family spaces', 'priority' => 'security, warmth and survey-led fitting'],
        'bedford' => ['property' => 'riverside homes, terraces and family renovation projects', 'priority' => 'varied property styles, access and measured installation detail'],
        'buckingham' => ['property' => 'market-town homes, village properties and extensions', 'priority' => 'traditional proportions, modern comfort and reliable finishing'],
        'dunstable' => ['property' => 'homes near exposed roads, hillsides and established estates', 'priority' => 'noise-aware glass, weathering and day-to-day durability'],
        'flitwick' => ['property' => 'commuter homes and practical family renovations', 'priority' => 'efficient frames, neat thresholds and low-maintenance finishes'],
        'hitchin' => ['property' => 'town properties and conservation-sensitive upgrades', 'priority' => 'balanced style, slim profiles and practical performance'],
        'leighton-buzzard' => ['property' => 'market-town homes and villages west of Milton Keynes', 'priority' => 'older brickwork, newer estates and busy family entrances'],
        'letchworth' => ['property' => 'garden city homes and sympathetic renovation projects', 'priority' => 'neat sightlines, colour control and architectural fit'],
        'luton' => ['property' => 'busy streets, extensions and replacement projects', 'priority' => 'secure hardware, noise-aware glazing and low-maintenance frames'],
        'northampton' => ['property' => 'terraces, detached houses and extension projects', 'priority' => 'mixed property ages, busier roads and secure fitting'],
        'stevenage' => ['property' => 'homes, extensions and replacement glazing projects', 'priority' => 'low-maintenance frames, reliable locking and practical survey checks'],
        'toddington' => ['property' => 'village homes, period properties and modern extensions', 'priority' => 'character details, newer openings and a tidy durable finish'],
    ];
}

function fenster_location_matrix_product_profiles(): array
{
    return [
        'double-glazing' => ['intent' => 'warmer rooms, quieter glass and joined-up window or door upgrades', 'decision' => 'frames, sealed units, ventilation and fitting detail'],
        'casement-windows' => ['intent' => 'practical ventilation, secure locking and easy maintenance', 'decision' => 'opening style, frame colour, handles and room-by-room use'],
        'flush-casement-windows' => ['intent' => 'neater traditional styling with modern insulation and security', 'decision' => 'flush frame position, colour, hardware and reveal depth'],
        'sliding-sash-windows' => ['intent' => 'period proportions, smooth operation and better draught control', 'decision' => 'sash model, horn detail, colour, furniture and glazing bars'],
        'french-casement-windows' => ['intent' => 'wide openings without a fixed central mullion', 'decision' => 'paired sash layout, hinges, security and clearance'],
        'tilt-turn-windows' => ['intent' => 'flexible ventilation, inward opening and easier cleaning', 'decision' => 'handle position, safety, clearances and upper-floor access'],
        'bow-bay-windows' => ['intent' => 'more daylight, kerb appeal and a refreshed feature window', 'decision' => 'bay structure, projection, cills, drainage and internal finish'],
        'aluminium-windows' => ['intent' => 'slim sightlines, strong frames and a sharper modern finish', 'decision' => 'RAL colour, glass size, thermal break and frame proportions'],
        'aluminium-flush-windows' => ['intent' => 'flush aluminium lines with slim modern strength', 'decision' => 'sash finish, reveal depth, colour and opening style'],
        'heritage-windows' => ['intent' => 'slim character-led frames with modern comfort', 'decision' => 'bar layout, colour, hardware and sensitive replacement detail'],
        'aluminium-bifold-doors' => ['intent' => 'wide garden openings, folding panels and slim aluminium frames', 'decision' => 'panel count, traffic door, threshold, colour and drainage'],
        'slide-fold-doors' => ['intent' => 'flexible glazed openings with practical panel movement', 'decision' => 'stacking space, panel movement, threshold and glass specification'],
        'aluminium-sliding-doors' => ['intent' => 'large panes, smooth sliding operation and minimal sightlines', 'decision' => 'track layout, sash size, threshold, locking and colour'],
        'aluminium-doors' => ['intent' => 'strong modern entrances and secure everyday access', 'decision' => 'door style, panel design, threshold, hardware and glass'],
        'heritage-aluminium-doors' => ['intent' => 'heritage-style aluminium with slim bars and secure operation', 'decision' => 'bar spacing, configuration, colour, threshold and glazing'],
        'composite-doors' => ['intent' => 'secure insulated entrances with a stronger first impression', 'decision' => 'door style, slab colour, glass design, furniture and threshold'],
        'upvc-doors' => ['intent' => 'low-maintenance doors with reliable security and everyday access', 'decision' => 'panel style, glass, colour, locking and opening direction'],
        'patio-doors' => ['intent' => 'sliding garden access, daylight and straightforward operation', 'decision' => 'track condition, frame colour, threshold, glass and handle position'],
        'french-doors' => ['intent' => 'paired garden doors with traditional styling and flexible ventilation', 'decision' => 'opening direction, side panels, threshold, colour and hardware'],
        'integral-blinds' => ['intent' => 'privacy and light control sealed safely inside the glass', 'decision' => 'control type, blind colour, glass size and door compatibility'],
        'roof-lanterns' => ['intent' => 'overhead daylight, slim aluminium structure and brighter extensions', 'decision' => 'lantern size, upstand, frame colour, solar control and glazing'],
    ];
}

function fenster_location_matrix_page(string $slug, ?array $index = null): ?array
{
    $slug = trim($slug, '/');
    $towns = fenster_location_matrix_towns();
    $products = fenster_location_matrix_products();
    $town_profiles = fenster_location_matrix_town_profiles();
    $product_profiles = fenster_location_matrix_product_profiles();
    $index = is_array($index) ? $index : fenster_generated_pages_index();

    foreach ($towns as $town_slug => $town_label) {
        if (! str_ends_with($slug, '-' . $town_slug)) {
            continue;
        }

        $product_slug = substr($slug, 0, -strlen('-' . $town_slug));
        if (! isset($products[$product_slug])) {
            return null;
        }

        $source = $index[$slug] ?? $index[$product_slug] ?? $index['double-glazing-' . $town_slug] ?? $index['double-glazing'] ?? null;
        if (! is_array($source)) {
            return null;
        }

        $title = $products[$product_slug] . ' ' . $town_label;
        $town_profile = $town_profiles[$town_slug] ?? ['property' => $town_label . ' homes', 'priority' => 'survey-led fitting and a tidy finish'];
        $product_profile = $product_profiles[$product_slug] ?? ['intent' => 'warmer, safer and better-looking glazing', 'decision' => 'style, performance, colour and installation detail'];
        $source['slug'] = $slug;
        $source['title'] = $title;
        $source['url'] = home_url('/' . $slug . '/');
        $source['seo']['title_tag'] = $products[$product_slug] . ' in ' . $town_label . ' | Survey & Installation';
        $source['seo']['meta_description'] = sprintf(
            '%s in %s for %s. Fenster helps plan %s around %s before survey and installation.',
            $products[$product_slug],
            $town_label,
            $town_profile['property'],
            $product_profile['decision'],
            $town_profile['priority']
        );
        $source['seo']['canonical'] = 'https://fensterglazing.com/' . $slug . '/';
        unset($source['seo']['robots']);

        return $source;
    }

    return null;
}

function fenster_location_matrix_pages(): array
{
    $pages = [];
    $index = fenster_generated_pages_index();

    foreach (fenster_location_matrix_towns() as $town_slug => $town_label) {
        foreach (fenster_location_matrix_products() as $product_slug => $product_label) {
            $slug = $product_slug . '-' . $town_slug;
            $page = fenster_location_matrix_page($slug, $index);
            if (is_array($page)) {
                $pages[$slug] = $page;
            }
        }
    }

    return $pages;
}

function fenster_commercial_county_profiles(): array
{
    return [
        'bedfordshire' => ['county' => 'Bedfordshire', 'region' => 'Bedfordshire and the M1 corridor', 'towns' => ['Bedford', 'Luton', 'Dunstable', 'Leighton Buzzard', 'Biggleswade', 'Flitwick'], 'context' => 'logistics sites, education buildings, business parks and occupied public buildings'],
        'berkshire' => ['county' => 'Berkshire', 'region' => 'the Thames Valley', 'towns' => ['Reading', 'Slough', 'Maidenhead', 'Bracknell', 'Newbury', 'Windsor'], 'context' => 'office refurbishments, retail units, hotels and high-traffic commercial entrances'],
        'bristol' => ['county' => 'Bristol', 'region' => 'Bristol and the West of England', 'towns' => ['Bristol city centre', 'Clifton', 'Redland', 'Filton', 'Avonmouth', 'Bedminster'], 'context' => 'city-centre access, mixed-use buildings, hospitality settings and phased glass replacement'],
        'buckinghamshire' => ['county' => 'Buckinghamshire', 'region' => 'Buckinghamshire and nearby Milton Keynes routes', 'towns' => ['Aylesbury', 'High Wycombe', 'Amersham', 'Chesham', 'Beaconsfield', 'Marlow', 'Buckingham', 'Princes Risborough'], 'context' => 'schools, business estates, managed buildings, rural sites and town-centre refurbishments'],
        'cambridgeshire' => ['county' => 'Cambridgeshire', 'region' => 'Cambridge, Peterborough and surrounding business corridors', 'towns' => ['Cambridge', 'Peterborough', 'Huntingdon', 'Ely', 'Wisbech', 'St Neots'], 'context' => 'science parks, education estates, healthcare buildings and growth-area commercial sites'],
        'cheshire' => ['county' => 'Cheshire', 'region' => 'Cheshire and the North West', 'towns' => ['Chester', 'Crewe', 'Warrington', 'Macclesfield', 'Northwich', 'Congleton'], 'context' => 'business parks, hospitality sites, managed offices and multi-building refurbishment programmes'],
        'city-of-london' => ['county' => 'City of London', 'region' => 'central London commercial districts', 'towns' => ['Bank', 'Barbican', 'Blackfriars', 'Farringdon', 'Liverpool Street', 'St Pauls'], 'context' => 'constrained access, high-footfall entrances, office refurbishments and heritage-sensitive commercial buildings'],
        'cornwall' => ['county' => 'Cornwall', 'region' => 'Cornwall and coastal commercial settings', 'towns' => ['Truro', 'St Austell', 'Falmouth', 'Penzance', 'Newquay', 'Bodmin'], 'context' => 'coastal exposure, hospitality buildings, retail units and replacement glazing for live premises'],
        'cumbria' => ['county' => 'Cumbria', 'region' => 'Cumbria and northern commercial sites', 'towns' => ['Carlisle', 'Kendal', 'Barrow-in-Furness', 'Workington', 'Whitehaven', 'Penrith'], 'context' => 'weather-exposed buildings, public-sector property, hospitality settings and access-sensitive sites'],
        'derbyshire' => ['county' => 'Derbyshire', 'region' => 'Derbyshire and the East Midlands', 'towns' => ['Derby', 'Chesterfield', 'Buxton', 'Ilkeston', 'Matlock', 'Long Eaton'], 'context' => 'industrial estates, education buildings, healthcare property and town-centre commercial refurbishments'],
        'devon' => ['county' => 'Devon', 'region' => 'Devon and the South West', 'towns' => ['Exeter', 'Plymouth', 'Torquay', 'Barnstaple', 'Newton Abbot', 'Tiverton'], 'context' => 'coastal and inland sites, hospitality buildings, public estates and phased window replacement'],
        'dorset' => ['county' => 'Dorset', 'region' => 'Dorset and the south coast', 'towns' => ['Bournemouth', 'Poole', 'Dorchester', 'Weymouth', 'Christchurch', 'Ferndown'], 'context' => 'coastal exposure, leisure buildings, retail units and live-site door replacement'],
        'durham' => ['county' => 'Durham', 'region' => 'County Durham and the North East', 'towns' => ['Durham', 'Darlington', 'Hartlepool', 'Bishop Auckland', 'Seaham', 'Consett'], 'context' => 'public buildings, education sites, commercial estates and planned replacement glazing'],
        'east-riding-of-yorkshire' => ['county' => 'East Riding of Yorkshire', 'region' => 'Hull, the Humber and East Yorkshire', 'towns' => ['Hull', 'Beverley', 'Bridlington', 'Goole', 'Driffield', 'Hessle'], 'context' => 'port-linked buildings, schools, retail property and weather-exposed glazing packages'],
        'east-sussex' => ['county' => 'East Sussex', 'region' => 'East Sussex and the south coast', 'towns' => ['Brighton', 'Eastbourne', 'Lewes', 'Hastings', 'Bexhill', 'Uckfield'], 'context' => 'coastal buildings, hospitality sites, heritage-sensitive properties and occupied commercial premises'],
        'essex' => ['county' => 'Essex', 'region' => 'Essex and the eastern home counties', 'towns' => ['Chelmsford', 'Colchester', 'Basildon', 'Harlow', 'Southend-on-Sea', 'Braintree'], 'context' => 'retail parks, offices, education buildings and phased estate refurbishment'],
        'gloucestershire' => ['county' => 'Gloucestershire', 'region' => 'Gloucestershire and the Cotswolds', 'towns' => ['Gloucester', 'Cheltenham', 'Stroud', 'Tewkesbury', 'Cirencester', 'Dursley'], 'context' => 'heritage-sensitive settings, schools, offices and commercial entrances'],
        'greater-london' => ['county' => 'Greater London', 'region' => 'Greater London boroughs', 'towns' => ['Croydon', 'Enfield', 'Ealing', 'Hounslow', 'Romford', 'Wimbledon'], 'context' => 'urban access restrictions, retail frontages, office refurbishments and high-use entrance doors'],
        'greater-manchester' => ['county' => 'Greater Manchester', 'region' => 'Greater Manchester and the North West', 'towns' => ['Manchester', 'Bolton', 'Stockport', 'Oldham', 'Wigan', 'Rochdale'], 'context' => 'city offices, education buildings, healthcare property and multi-site commercial estates'],
        'hampshire' => ['county' => 'Hampshire', 'region' => 'Hampshire and the south coast', 'towns' => ['Southampton', 'Portsmouth', 'Winchester', 'Basingstoke', 'Andover', 'Fareham'], 'context' => 'coastal sites, offices, public buildings and logistics-linked commercial property'],
        'herefordshire' => ['county' => 'Herefordshire', 'region' => 'Herefordshire and the Welsh border', 'towns' => ['Hereford', 'Leominster', 'Ross-on-Wye', 'Ledbury', 'Bromyard', 'Kington'], 'context' => 'rural commercial buildings, schools, healthcare settings and planned replacement glass'],
        'hertfordshire' => ['county' => 'Hertfordshire', 'region' => 'Hertfordshire and the northern home counties', 'towns' => ['Watford', 'St Albans', 'Stevenage', 'Hemel Hempstead', 'Hitchin', 'Letchworth'], 'context' => 'business parks, healthcare environments, education estates and commuter-town commercial sites'],
        'kent' => ['county' => 'Kent', 'region' => 'Kent and the south east', 'towns' => ['Maidstone', 'Canterbury', 'Dartford', 'Ashford', 'Dover', 'Tunbridge Wells'], 'context' => 'retail property, schools, offices, healthcare buildings and transport-linked sites'],
        'lancashire' => ['county' => 'Lancashire', 'region' => 'Lancashire and the north west coast', 'towns' => ['Preston', 'Blackpool', 'Lancaster', 'Burnley', 'Blackburn', 'Ormskirk'], 'context' => 'coastal premises, education sites, industrial property and phased refurbishment programmes'],
        'leicestershire' => ['county' => 'Leicestershire', 'region' => 'Leicestershire and the East Midlands', 'towns' => ['Leicester', 'Loughborough', 'Hinckley', 'Melton Mowbray', 'Market Harborough', 'Coalville'], 'context' => 'logistics parks, education buildings, retail units and mixed commercial estates'],
        'lincolnshire' => ['county' => 'Lincolnshire', 'region' => 'Lincolnshire and the east coast', 'towns' => ['Lincoln', 'Grimsby', 'Scunthorpe', 'Boston', 'Grantham', 'Skegness'], 'context' => 'large rural sites, coastal exposure, public buildings and planned glazing upgrades'],
        'merseyside' => ['county' => 'Merseyside', 'region' => 'Merseyside and the Liverpool city region', 'towns' => ['Liverpool', 'Birkenhead', 'Southport', 'St Helens', 'Bootle', 'Wallasey'], 'context' => 'city-centre buildings, education estates, healthcare sites and high-use commercial doors'],
        'norfolk' => ['county' => 'Norfolk', 'region' => 'Norfolk and the east coast', 'towns' => ['Norwich', 'Great Yarmouth', 'Kings Lynn', 'Thetford', 'Dereham', 'Cromer'], 'context' => 'coastal and rural sites, hospitality property, public buildings and replacement glass programmes'],
        'north-yorkshire' => ['county' => 'North Yorkshire', 'region' => 'North Yorkshire and York', 'towns' => ['York', 'Harrogate', 'Scarborough', 'Middlesbrough', 'Ripon', 'Northallerton'], 'context' => 'heritage-sensitive commercial buildings, coastal premises, education sites and public estates'],
        'northamptonshire' => ['county' => 'Northamptonshire', 'region' => 'Northamptonshire and the M1 corridor', 'towns' => ['Northampton', 'Kettering', 'Corby', 'Wellingborough', 'Daventry', 'Towcester'], 'context' => 'logistics sites, healthcare projects, schools, business parks and live-building refurbishments'],
        'northumberland' => ['county' => 'Northumberland', 'region' => 'Northumberland and northern England', 'towns' => ['Morpeth', 'Blyth', 'Hexham', 'Alnwick', 'Cramlington', 'Ashington'], 'context' => 'weather-exposed buildings, rural estates, public-sector sites and access-led glazing replacement'],
        'nottinghamshire' => ['county' => 'Nottinghamshire', 'region' => 'Nottinghamshire and the East Midlands', 'towns' => ['Nottingham', 'Mansfield', 'Newark-on-Trent', 'Worksop', 'Retford', 'Beeston'], 'context' => 'offices, education buildings, healthcare property and mixed commercial estates'],
        'oxfordshire' => ['county' => 'Oxfordshire', 'region' => 'Oxfordshire and the Thames Valley', 'towns' => ['Oxford', 'Banbury', 'Bicester', 'Abingdon', 'Witney', 'Didcot'], 'context' => 'science and business parks, education estates, heritage buildings and planned refurbishments'],
        'rutland' => ['county' => 'Rutland', 'region' => 'Rutland and the East Midlands', 'towns' => ['Oakham', 'Uppingham', 'Ketton', 'Cottesmore', 'Greetham', 'Empingham'], 'context' => 'smaller commercial estates, schools, rural premises and carefully planned replacement glazing'],
        'shropshire' => ['county' => 'Shropshire', 'region' => 'Shropshire and the West Midlands border', 'towns' => ['Shrewsbury', 'Telford', 'Oswestry', 'Bridgnorth', 'Ludlow', 'Market Drayton'], 'context' => 'rural sites, schools, public buildings and heritage-sensitive commercial refurbishments'],
        'somerset' => ['county' => 'Somerset', 'region' => 'Somerset and the South West', 'towns' => ['Taunton', 'Bath', 'Weston-super-Mare', 'Yeovil', 'Bridgwater', 'Frome'], 'context' => 'coastal premises, hospitality buildings, public estates and occupied commercial sites'],
        'south-yorkshire' => ['county' => 'South Yorkshire', 'region' => 'South Yorkshire and the Sheffield city region', 'towns' => ['Sheffield', 'Doncaster', 'Rotherham', 'Barnsley', 'Mexborough', 'Penistone'], 'context' => 'industrial property, education estates, offices and live-site door replacement'],
        'staffordshire' => ['county' => 'Staffordshire', 'region' => 'Staffordshire and the West Midlands', 'towns' => ['Stoke-on-Trent', 'Stafford', 'Lichfield', 'Cannock', 'Burton upon Trent', 'Tamworth'], 'context' => 'manufacturing sites, schools, healthcare settings and phased commercial glazing programmes'],
        'suffolk' => ['county' => 'Suffolk', 'region' => 'Suffolk and the east coast', 'towns' => ['Ipswich', 'Bury St Edmunds', 'Lowestoft', 'Felixstowe', 'Sudbury', 'Newmarket'], 'context' => 'coastal exposure, port-linked property, schools and planned replacement glass'],
        'surrey' => ['county' => 'Surrey', 'region' => 'Surrey and the southern home counties', 'towns' => ['Guildford', 'Woking', 'Epsom', 'Reigate', 'Farnham', 'Camberley'], 'context' => 'offices, retail units, schools, healthcare settings and high-specification commercial refurbishments'],
        'tyne-and-wear' => ['county' => 'Tyne and Wear', 'region' => 'Tyne and Wear and the North East', 'towns' => ['Newcastle upon Tyne', 'Sunderland', 'Gateshead', 'South Shields', 'Tynemouth', 'Washington'], 'context' => 'city-centre sites, healthcare buildings, public estates and coastal commercial premises'],
        'warwickshire' => ['county' => 'Warwickshire', 'region' => 'Warwickshire and the Midlands', 'towns' => ['Warwick', 'Rugby', 'Nuneaton', 'Stratford-upon-Avon', 'Leamington Spa', 'Atherstone'], 'context' => 'business parks, heritage-sensitive premises, schools and hospitality buildings'],
        'west-midlands' => ['county' => 'West Midlands', 'region' => 'the West Midlands conurbation', 'towns' => ['Birmingham', 'Coventry', 'Wolverhampton', 'Solihull', 'Dudley', 'Walsall'], 'context' => 'urban commercial sites, public buildings, retail frontages and high-use entrance packages'],
        'west-sussex' => ['county' => 'West Sussex', 'region' => 'West Sussex and the south coast', 'towns' => ['Chichester', 'Crawley', 'Worthing', 'Horsham', 'Bognor Regis', 'Haywards Heath'], 'context' => 'airport-linked property, coastal buildings, offices and planned commercial window replacement'],
        'west-yorkshire' => ['county' => 'West Yorkshire', 'region' => 'West Yorkshire and the Leeds city region', 'towns' => ['Leeds', 'Bradford', 'Wakefield', 'Huddersfield', 'Halifax', 'Keighley'], 'context' => 'city offices, education estates, healthcare property and phased refurbishment programmes'],
        'wiltshire' => ['county' => 'Wiltshire', 'region' => 'Wiltshire and the south west', 'towns' => ['Swindon', 'Salisbury', 'Chippenham', 'Trowbridge', 'Marlborough', 'Devizes'], 'context' => 'business parks, public buildings, heritage-sensitive settings and live-building replacements'],
        'worcestershire' => ['county' => 'Worcestershire', 'region' => 'Worcestershire and the West Midlands', 'towns' => ['Worcester', 'Redditch', 'Kidderminster', 'Bromsgrove', 'Malvern', 'Evesham'], 'context' => 'schools, offices, healthcare premises and mixed commercial refurbishment sites'],
    ];
}

function fenster_commercial_county_page(string $slug): ?array
{
    $slug = trim($slug, '/');
    $prefix = 'commercial-glazing-';
    if (! str_starts_with($slug, $prefix)) {
        return null;
    }

    $county_slug = substr($slug, strlen($prefix));
    $profiles = fenster_commercial_county_profiles();
    if (! isset($profiles[$county_slug])) {
        return null;
    }

    $profile = $profiles[$county_slug];
    $county = (string) $profile['county'];
    $region = (string) ($profile['region'] ?? $county);
    $towns = is_array($profile['towns'] ?? null) ? array_values($profile['towns']) : [];
    $town_summary = implode(', ', array_slice($towns, 0, 3));
    $context = (string) ($profile['context'] ?? 'commercial buildings and phased refurbishment projects');
    $meta_description = sprintf(
        'Commercial glazing for %s sites around %s. Fenster plans windows, doors, curtain walling and replacement glass for %s.',
        $county,
        $town_summary !== '' ? $town_summary : $region,
        $context
    );

    return [
        'slug' => $slug,
        'title' => 'Commercial Glazing ' . $county,
        'url' => home_url('/' . $slug . '/'),
        'seo' => [
            'title_tag' => 'Commercial Glazing ' . $county . ' | Windows, Doors & Curtain Walling',
            'meta_description' => $meta_description,
            'canonical' => 'https://fensterglazing.com/' . $slug . '/',
            'robots' => 'max-image-preview:large',
        ],
        'sections' => [],
        'images' => [],
        'links' => [],
    ];
}

function fenster_commercial_county_pages(): array
{
    $pages = [];
    foreach (array_keys(fenster_commercial_county_profiles()) as $county_slug) {
        $slug = 'commercial-glazing-' . $county_slug;
        $page = fenster_commercial_county_page($slug);
        if (is_array($page)) {
            $pages[$slug] = $page;
        }
    }

    return $pages;
}

function fenster_current_generated_slug(): string
{
    $path = trim((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH), '/');
    $home_path = trim((string) wp_parse_url(home_url('/'), PHP_URL_PATH), '/');

    if ($home_path && str_starts_with($path, $home_path)) {
        $path = trim(substr($path, strlen($home_path)), '/');
    }

    return $path ?: 'home';
}

function fenster_get_generated_page(?string $slug = null): ?array
{
    $slug = $slug ?: fenster_current_generated_slug();
    static $page_cache = [];

    if (array_key_exists($slug, $page_cache)) {
        return $page_cache[$slug];
    }

    if ($slug === 'home') {
        $index = fenster_generated_pages_index();
        $page = $index['home'] ?? [
            'slug' => 'home',
            'title' => 'Fenster Glazing',
            'url' => home_url('/'),
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
        $page['seo']['title_tag'] = 'Double Glazing Milton Keynes | Windows & Doors | Fenster Glazing';
        $page['seo']['meta_description'] = 'Fenster Glazing supplies and installs double glazing, windows, doors, bifolds and roof lanterns across Milton Keynes, Bedfordshire and Buckinghamshire.';
        $page['seo']['canonical'] = 'https://fensterglazing.com/';
        $page['seo']['robots'] = 'max-image-preview:large';

        return $page_cache[$slug] = $page;
    }

    $launch_seo_overrides = [
        'contact' => [
            'title_tag' => 'Contact Fenster Glazing | Milton Keynes Showroom & Quotes',
            'meta_description' => 'Contact Fenster Glazing in Milton Keynes for window, door, bifold, roof lantern and glazing enquiries, showroom visits and survey-led quotations.',
        ],
        'online-quote' => [
            'title_tag' => 'Online Window and Door Quote | Fenster Glazing',
            'meta_description' => 'Start an online quote for Fenster Glazing windows, doors, bifolds and roof lanterns, then our team can confirm survey details and next steps.',
        ],
    ];

    if (isset($launch_seo_overrides[$slug])) {
        $index = fenster_generated_pages_index();
        $page = $index[$slug] ?? [
            'slug' => $slug,
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'url' => home_url('/' . $slug . '/'),
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
        $page['seo']['title_tag'] = $launch_seo_overrides[$slug]['title_tag'];
        $page['seo']['meta_description'] = $launch_seo_overrides[$slug]['meta_description'];
        $page['seo']['canonical'] = 'https://fensterglazing.com/' . $slug . '/';
        $page['seo']['robots'] = 'max-image-preview:large';

        return $page_cache[$slug] = $page;
    }

    if ($slug === 'areas-we-cover') {
        return $page_cache[$slug] = [
            'slug' => 'areas-we-cover',
            'title' => 'Areas We Cover',
            'url' => home_url('/areas-we-cover/'),
            'seo' => [
                'title_tag' => 'Areas We Cover | Fenster Glazing',
                'meta_description' => 'Fenster Glazing supplies and installs windows, doors and glazing across Milton Keynes, Buckinghamshire, Bedfordshire, Northamptonshire and nearby towns.',
                'canonical' => 'https://fensterglazing.com/areas-we-cover/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    if ($slug === 'privacy-policy') {
        return $page_cache[$slug] = [
            'slug' => 'privacy-policy',
            'title' => 'Privacy Policy',
            'url' => home_url('/privacy-policy/'),
            'seo' => [
                'title_tag' => 'Privacy Policy | Fenster Glazing',
                'meta_description' => 'How Fenster Glazing collects, uses and protects personal information from enquiries, quote tools, cookies, analytics and customer communications.',
                'canonical' => 'https://fensterglazing.com/privacy-policy/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [
                [
                    'heading' => 'Who this privacy policy is for',
                    'body' => [
                        'This privacy policy explains how Fenster Glazing uses personal information when you visit the website, contact the team, submit an enquiry, use the online quote or WindowCAD tool, request a survey, send project details or become a customer.',
                        'Fenster Glazing is based in Milton Keynes and provides window, door, glazing, repair and commercial glazing services. If you have a question about this policy or your data, contact the team using the details on the Contact page.',
                    ],
                ],
                [
                    'heading' => 'Information you may give Fenster',
                    'body' => [
                        'You may give Fenster information such as your name, email address, phone number, postcode, address, company name, project type, timescale, message, drawings, schedules, photos or other files that help the team understand your enquiry.',
                        'If you use the online quote or WindowCAD tool, the details you enter into that tool may be sent to Fenster so the team can follow up, check the specification and manage the lead.',
                    ],
                ],
                [
                    'heading' => 'Accounts and email updates',
                    'body' => [
                        'This website does not currently provide customer account registration, customer dashboards or an email newsletter sign-up. If you contact Fenster, your details are used to deal with your enquiry or project rather than to create a public website account or mailing-list membership.',
                    ],
                ],
                [
                    'heading' => 'How Fenster uses your information',
                    'body' => [
                        'Fenster uses enquiry and project information to respond to your request, prepare quotations, arrange surveys, discuss products, manage orders, provide installation or repair services, handle aftercare and keep appropriate business records.',
                        'Fenster may also use information to improve the website, understand which pages and services are useful, prevent spam or misuse, and meet legal, tax, insurance or regulatory obligations.',
                    ],
                ],
                [
                    'heading' => 'Lead systems and service providers',
                    'body' => [
                        'Website enquiries are stored securely in WordPress as private enquiry records and may be emailed to the Fenster team. Leads from the online quote or WindowCAD tool may also be passed into AdminBase so the business can manage follow-up and customer records.',
                        'Fenster may use trusted service providers for website hosting, email delivery, analytics, CRM, quote tools, payment administration, file storage, IT support or similar business operations. These providers should only use information as needed to provide their service to Fenster.',
                    ],
                ],
                [
                    'heading' => 'Cookies, analytics and tracking',
                    'body' => [
                        'The website uses necessary cookies for basic site functions. Optional analytics and marketing tools, such as Google Tag Manager, Microsoft Clarity or Meta Pixel, should only run after you accept optional cookies through the site cookie banner.',
                        'Analytics tools can help Fenster understand page views, clicks, scroll behaviour, quote-tool use and form performance. Marketing tools may help measure advertising performance. You can reject optional cookies and still use the website.',
                    ],
                ],
                [
                    'heading' => 'Legal reasons for using information',
                    'body' => [
                        'Fenster usually uses enquiry information because it is necessary to respond before entering into a contract, to perform a contract, or because Fenster has a legitimate interest in managing customer enquiries and business records.',
                        'Where optional analytics or marketing cookies are used, Fenster relies on your consent. You can change your cookie choice using the cookie settings control on the website where available.',
                    ],
                ],
                [
                    'heading' => 'How long information is kept',
                    'body' => [
                        'Fenster keeps enquiry, quotation, order, installation and aftercare records only for as long as they are reasonably needed for customer service, accounting, warranty, insurance, legal or business administration purposes.',
                        'Uploaded files, drawings and project photos may be kept with the related enquiry or customer record where they are needed to understand the project, quote, installation or aftercare history.',
                    ],
                ],
                [
                    'heading' => 'Your rights',
                    'body' => [
                        'Depending on the situation, you may have rights to ask for a copy of your personal information, ask for corrections, ask for deletion, object to certain use, restrict processing, or withdraw consent for optional tracking.',
                        'To make a privacy request, contact Fenster with enough information to identify you and the enquiry or project involved. You also have the right to complain to the UK Information Commissioner if you are unhappy with how your information is handled. The ICO website is ico.org.uk.',
                    ],
                ],
                [
                    'heading' => 'Keeping this policy current',
                    'body' => [
                        'This policy may be updated when the website, lead systems, cookie tools, analytics setup or business processes change. The latest version should always be available from the website footer.',
                        'Last updated: 6 July 2026.',
                    ],
                ],
            ],
            'images' => [],
            'links' => [
                ['text' => 'Contact Fenster', 'url' => home_url('/contact/')],
                ['text' => 'Terms and Conditions', 'url' => home_url('/terms-conditions/')],
                ['text' => 'Start a quote', 'url' => home_url('/online-quote/')],
            ],
        ];
    }

    if ($slug === 'cookie-policy') {
        return $page_cache[$slug] = [
            'slug' => 'cookie-policy',
            'title' => 'Cookie Policy',
            'url' => home_url('/cookie-policy/'),
            'seo' => [
                'title_tag' => 'Cookie Policy | Fenster Glazing',
                'meta_description' => 'How Fenster Glazing uses necessary cookies, cookie choices, analytics and marketing tags on the website.',
                'canonical' => 'https://fensterglazing.com/cookie-policy/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [
                [
                    'heading' => 'What this cookie policy covers',
                    'body' => [
                        'This cookie policy explains how the Fenster Glazing website uses cookies, browser storage and similar technologies.',
                        'The website is mainly an information and enquiry site. It does not currently offer customer account registration, member-only areas or an email newsletter sign-up.',
                    ],
                ],
                [
                    'heading' => 'Strictly necessary cookies and storage',
                    'body' => [
                        'Some cookies or browser storage may be needed for basic website functions, security, spam prevention, form handling, embedded quote tools or remembering your cookie choice.',
                        'The cookie banner stores your choice in your browser using local storage under the name fenster_cookie_consent. This lets the site remember whether you accepted or rejected optional tracking.',
                    ],
                ],
                [
                    'heading' => 'Optional analytics and marketing tools',
                    'body' => [
                        'If you accept optional cookies, the site may load Google Tag Manager, Microsoft Clarity and Meta Pixel. These tools can help Fenster understand which pages are useful, how visitors move through the site, how quote tools and forms perform, and whether advertising is working.',
                        'These optional tools are blocked until you accept them through the cookie banner. You can reject them and still use the website, read pages, call Fenster, email the team or send an enquiry.',
                    ],
                ],
                [
                    'heading' => 'What Fenster does not use cookies for',
                    'body' => [
                        'Fenster does not currently use website cookies for customer account logins, account dashboards, email newsletter membership, public comments, shopping baskets, checkout accounts or on-site user surveys.',
                        'If those website features are added in future, this policy should be updated before they go live.',
                    ],
                ],
                [
                    'heading' => 'Changing your choice',
                    'body' => [
                        'You can use the Cookies button on the website to open the cookie banner again and change your choice.',
                        'You can also clear cookies and site data in your browser settings. Browser controls vary, but most browsers let you delete cookies, block cookies for specific sites, or clear local storage.',
                    ],
                ],
                [
                    'heading' => 'More information',
                    'body' => [
                        'For more detail on how Fenster uses personal information from enquiries, quote tools and analytics, read the Privacy Policy.',
                        'Last updated: 7 July 2026.',
                    ],
                ],
            ],
            'images' => [],
            'links' => [
                ['text' => 'Privacy Policy', 'url' => home_url('/privacy-policy/')],
                ['text' => 'Contact Fenster', 'url' => home_url('/contact/')],
                ['text' => 'Start a quote', 'url' => home_url('/online-quote/')],
            ],
        ];
    }

    if ($slug === 'terms-conditions') {
        return $page_cache[$slug] = [
            'slug' => 'terms-conditions',
            'title' => 'Terms and Conditions',
            'url' => home_url('/terms-conditions/'),
            'seo' => [
                'title_tag' => 'Terms and Conditions | Fenster Glazing',
                'meta_description' => 'Fenster Glazing terms and conditions for website use, quotations, orders, surveys, installation, guarantees and customer responsibilities.',
                'canonical' => 'https://fensterglazing.com/terms-conditions/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [
                [
                    'heading' => 'Using this website',
                    'body' => [
                        'This website is owned and operated by Fenster Glazing & Locks Ltd. The information on the site is provided for general guidance about our products, services and company. By using the website, you agree to use it lawfully and not to interfere with its security, availability or content.',
                        'We try to keep product information, images and guidance accurate, but website content should not be treated as a final technical specification. Your final quotation, survey notes, order documentation and any agreed written terms take priority.',
                    ],
                ],
                [
                    'heading' => 'Quotations and pricing',
                    'body' => [
                        'Online prices, guide prices and initial estimates are indicative unless confirmed in writing by Fenster Glazing. Final pricing can depend on survey findings, measurements, access, specification choices, structural requirements, glass options, hardware, colour, disposal and installation conditions.',
                        'A quotation is valid for the period stated on the quotation. If no period is stated, Fenster may review the quotation before accepting an order, especially where supplier costs, material prices or project scope have changed.',
                    ],
                ],
                [
                    'heading' => 'Surveys, orders and specification',
                    'body' => [
                        'Most made-to-measure window, door and glazing products require a survey before manufacture. The survey is used to confirm measurements, opening details, access, thresholds, drainage, fixing conditions and other practical requirements.',
                        'Once an order is accepted and manufacture has started, changes may not be possible or may involve extra cost. The customer is responsible for checking order details, names, addresses, contact details and agreed specification documents before approval.',
                    ],
                ],
                [
                    'heading' => 'Installation and site access',
                    'body' => [
                        'The customer must provide safe and reasonable access to the property on agreed survey and installation dates. This includes access to working areas, parking where available, clear internal access and notice of any restrictions that could affect the work.',
                        'Fenster will take reasonable care during installation. Some making good, decoration, specialist building work, electrical work, alarm work, flooring adjustment or structural work may be outside the agreed glazing package unless specifically included in writing.',
                    ],
                ],
                [
                    'heading' => 'Payments',
                    'body' => [
                        'Payment terms, deposits, staged payments and final balances are set out in the quotation, invoice or order documentation. Payments should be made by the agreed method and by the agreed due date.',
                        'Fenster may pause ordering, manufacture, installation or aftercare where payments are overdue, subject to any statutory rights that apply.',
                    ],
                ],
                [
                    'heading' => 'Guarantees and aftercare',
                    'body' => [
                        'Guarantees apply as described in the relevant order documentation, manufacturer warranty information and insurance-backed guarantee documents where applicable. Guarantee cover can vary by product, component, hardware, glass unit and installation type.',
                        'Guarantees do not normally cover misuse, accidental damage, lack of maintenance, third-party alteration, movement in the building, condensation caused by property conditions, or damage caused by issues outside Fenster control.',
                    ],
                ],
                [
                    'heading' => 'Website content and intellectual property',
                    'body' => [
                        'The text, photography, video, branding, layout and other content on this website belong to Fenster Glazing or are used with permission. You may view the site for personal or business enquiry purposes, but you must not copy, republish or commercially reuse the content without permission.',
                    ],
                ],
                [
                    'heading' => 'Questions about these terms',
                    'body' => [
                        'If you have questions about these terms, a quotation, an order or a guarantee, contact Fenster Glazing before placing an order or approving a specification.',
                    ],
                ],
            ],
            'images' => [],
            'links' => [],
        ];
    }

    if ($slug === 'why-trust-fenster') {
        return $page_cache[$slug] = [
            'slug' => 'why-trust-fenster',
            'title' => 'Why Trust Fenster Glazing',
            'url' => home_url('/why-trust-fenster/'),
            'seo' => [
                'title_tag' => 'Why Trust Fenster Glazing | Honest Pricing, Reviews and Trained Fitters',
                'meta_description' => 'See why customers trust Fenster Glazing: established in 2018, around 25 years of combined experience, transparent upfront pricing, trained fitters and public reviews.',
                'canonical' => 'https://fensterglazing.com/why-trust-fenster/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    if ($slug === 'obscured-glass') {
        return $page_cache[$slug] = [
            'slug' => 'obscured-glass',
            'title' => 'Obscured Glass',
            'url' => home_url('/obscured-glass/'),
            'seo' => [
                'title_tag' => 'Obscured Glass Options | Fenster Glazing',
                'meta_description' => 'Compare obscured glass patterns and privacy levels for Fenster Glazing windows, doors and replacement glass.',
                'canonical' => 'https://fensterglazing.com/obscured-glass/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    if ($slug === 'window-handles') {
        return $page_cache[$slug] = [
            'slug' => 'window-handles',
            'title' => 'Window Handles',
            'url' => home_url('/window-handles/'),
            'seo' => [
                'title_tag' => 'Window Handle Options | Fenster Glazing',
                'meta_description' => 'Compare Fenster Glazing window handle finishes including white, black, chrome, gold, satin silver and monkey tail styles.',
                'canonical' => 'https://fensterglazing.com/window-handles/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    if (in_array($slug, ['colour-options', 'upvc-colours', 'aluminium-colours'], true)) {
        $title = $slug === 'upvc-colours'
            ? 'uPVC Colours'
            : ($slug === 'aluminium-colours' ? 'Aluminium Colours' : 'Colour Options');

        return $page_cache[$slug] = [
            'slug' => $slug,
            'title' => $title,
            'url' => home_url('/' . $slug . '/'),
            'seo' => [
                'title_tag' => $title . ' | Fenster Glazing',
                'meta_description' => 'Compare uPVC and aluminium frame colour options for Fenster Glazing windows, doors, bifolds and glazing projects.',
                'canonical' => 'https://fensterglazing.com/' . $slug . '/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    if ($slug === 'commercial-areas') {
        return $page_cache[$slug] = [
            'slug' => 'commercial-areas',
            'title' => 'Commercial Areas',
            'url' => home_url('/commercial-areas/'),
            'seo' => [
                'title_tag' => 'Commercial Areas | Fenster Glazing',
                'meta_description' => 'Temporary review page for Fenster commercial glazing county landing pages.',
                'canonical' => 'https://fensterglazing.com/commercial-areas/',
                'robots' => 'noindex,follow,max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    $commercial_county_page = fenster_commercial_county_page($slug);
    if (is_array($commercial_county_page)) {
        return $page_cache[$slug] = $commercial_county_page;
    }

    if ($slug === 'commercial-projects') {
        return $page_cache[$slug] = [
            'slug' => 'commercial-projects',
            'title' => 'Commercial Projects',
            'url' => home_url('/commercial-projects/'),
            'seo' => [
                'title_tag' => 'Commercial Projects | Fenster Glazing',
                'meta_description' => 'Explore Fenster Glazing commercial projects across healthcare, hospitality, offices and larger glazing schemes.',
                'canonical' => 'https://fensterglazing.com/commercial-projects/',
                'robots' => 'max-image-preview:large',
            ],
            'sections' => [],
            'images' => [],
            'links' => [],
        ];
    }

    $index = fenster_generated_pages_index();
    $location_matrix_page = fenster_location_matrix_page($slug, $index);
    if (is_array($location_matrix_page)) {
        return $page_cache[$slug] = $location_matrix_page;
    }

    $product_aliases = [
        'aluminium-flush-windows' => [
            'source' => 'aluminium-windows',
            'title' => 'Aluminium Flush Windows',
            'description' => 'Explore aluminium flush windows with slim frames, strong thermal performance and made-to-measure RAL colour options.',
        ],
        'aluminium-sliding-doors' => [
            'source' => 'patio-doors',
            'title' => 'Aluminium Sliding Doors',
            'description' => 'Explore aluminium sliding doors with slim sightlines, large glass areas and dual or triple-track configurations.',
        ],
    ];

    if (isset($product_aliases[$slug])) {
        $alias = $product_aliases[$slug];
        $source = $index[$alias['source']] ?? null;

        if (is_array($source)) {
            $source['slug'] = $slug;
            $source['title'] = $alias['title'];
            $source['url'] = home_url('/' . $slug . '/');
            $source['seo']['title_tag'] = $alias['title'] . ' | Fenster Glazing';
            $source['seo']['meta_description'] = $alias['description'];
            $source['seo']['canonical'] = 'https://fensterglazing.com/' . $slug . '/';

            return $page_cache[$slug] = $source;
        }
    }

    if ($slug === 'cat-and-dog-flaps' && isset($index[$slug]) && is_array($index[$slug])) {
        $page = $index[$slug];
        $page['title'] = 'Cat and Dog Flaps';
        $page['url'] = home_url('/cat-and-dog-flaps/');
        $page['seo']['title_tag'] = 'Cat and Dog Flaps | Pet Flap Glazing | Fenster Glazing';
        $page['seo']['meta_description'] = 'Cat and dog flaps fitted into suitable door panels or new sealed glass units, with manual, lockable and microchip options checked before order.';
        $page['seo']['canonical'] = 'https://fensterglazing.com/cat-and-dog-flaps/';
        $page['seo']['robots'] = 'max-image-preview:large';

        return $page_cache[$slug] = $page;
    }

    return $page_cache[$slug] = ($index[$slug] ?? null);
}

function fenster_generated_url(string $url): string
{
    if ($url === '') {
        return '';
    }

    $parsed = wp_parse_url($url);
    $host = strtolower($parsed['host'] ?? '');
    $path = (string) ($parsed['path'] ?? $url);
    $theme_asset_prefix = '/wp-content/themes/fenster/';

    if (str_starts_with($path, $theme_asset_prefix)) {
        return FENSTER_THEME_URI . '/' . ltrim(substr($path, strlen($theme_asset_prefix)), '/');
    }

    if (in_array($host, ['fensterglazing.com', 'www.fensterglazing.com', 'test.fensterglazing.com'], true)) {
        return home_url($path);
    }

    if (str_starts_with($url, '/wp-content/')) {
        return home_url($url);
    }

    return $url;
}

/**
 * Removed test/debris routes that should return 410 Gone.
 */
function fenster_gone_slugs(): array
{
    return [
        'nick-test-baboon' => true,
        'our-new-website' => true,
        'case-studies' => true,
        'case-studies/bespoke-windows-woburn-water-end-barn' => true,
        'case-studies/double-glazing-rushden' => true,
        'case-studies/test' => true,
        'case-studies/template-new' => true,
        'case-studies/water-stratford' => true,
        'commercial-glazing-isle-of-wight' => true,
    ];
}

/**
 * Permanent redirects for duplicate, renamed and superseded routes.
 * Returns the destination slug, or '' when the slug should not redirect.
 */
function fenster_redirect_target(string $slug): string
{
    $map = [
        'dunstable-casement-windows' => 'casement-windows-dunstable',
        'bow-and-bay-windows-northampton' => 'bow-bay-windows-northampton',
        'tilt-and-turn-windows-northampton' => 'tilt-turn-windows-northampton',
        'commercial-glazing-london-2' => 'commercial-glazing-greater-london',
        'healthcare_safeguarding_in_construction' => 'healthcare-construction',
        'enquire-now' => 'online-quote',
        'instant-pricing' => 'online-quote',
        'obscure-glass' => 'obscured-glass',
        'upvc-colours' => 'colour-options',
        'aluminium-colours' => 'colour-options',
        'door-designer' => 'online-quote',
    ];

    if (isset($map[$slug])) {
        return $map[$slug];
    }

    if (str_ends_with($slug, '-designer')) {
        $base = substr($slug, 0, -strlen('-designer'));
        if ($base === 'tilt-and-turn-windows') {
            $base = 'tilt-turn-windows';
        }

        if (isset(fenster_generated_pages_index()[$base]) || isset(fenster_location_matrix_products()[$base])) {
            return $base;
        }

        return 'online-quote';
    }

    return '';
}

/**
 * Routes that should stay reachable but tell search engines not to index them:
 * live ad landing pages and thin archive shells.
 */
function fenster_slug_is_noindex(string $slug): bool
{
    $noindex_slugs = [
        'apecs-terms-conditions' => true,
        'brochures' => true,
        'customer-portal' => true,
        'downloads' => true,
        'fenster-partners' => true,
        'gallery' => true,
        'instant-pricing-meta-ads' => true,
        'pricing-gads' => true,
        'ppc-landing-page-composite-doors' => true,
        'refer-a-friend' => true,
        'roof-lanterns-landing-page' => true,
        'videos' => true,
    ];

    if (isset($noindex_slugs[$slug])) {
        return true;
    }

    foreach (['category/', 'tag/', 'author/', 'blog/page/'] as $archive_prefix) {
        if (str_starts_with($slug, $archive_prefix)) {
            return true;
        }
    }

    return false;
}

function fenster_send_public_cache_headers(int $browser_max_age = 600, int $shared_max_age = 3600): void
{
    if (is_user_logged_in()) {
        return;
    }

    header_remove('Cache-Control');
    header_remove('Pragma');
    header_remove('Expires');
    header(
        sprintf(
            'Cache-Control: public, max-age=%d, s-maxage=%d, stale-while-revalidate=86400',
            max(0, $browser_max_age),
            max(0, $shared_max_age)
        )
    );
}

add_action('template_redirect', 'fenster_maybe_render_generated_page', 0);
function fenster_maybe_render_generated_page(): void
{
    if (is_admin() || wp_doing_ajax() || is_feed() || is_preview()) {
        return;
    }

    $slug = fenster_current_generated_slug();
    $path = trim((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH), '/');
    $query = (string) wp_parse_url(add_query_arg([]), PHP_URL_QUERY);
    $is_file_request = (bool) preg_match('/\.[a-z0-9]{2,8}$/i', $path);
    $lower_slug = strtolower($slug);

    if ($slug !== $lower_slug && (fenster_redirect_target($lower_slug) !== '' || isset(fenster_gone_slugs()[$lower_slug]) || fenster_get_generated_page($lower_slug))) {
        $target = home_url('/' . $lower_slug . '/');
        wp_safe_redirect($query !== '' ? $target . '?' . $query : $target, 301);
        exit;
    }

    $redirect_target = fenster_redirect_target($slug);
    if ($redirect_target !== '') {
        wp_safe_redirect(home_url('/' . $redirect_target . '/'), 301);
        exit;
    }

    if (isset(fenster_gone_slugs()[$slug])) {
        global $wp_query;
        if ($wp_query instanceof WP_Query) {
            $wp_query->set_404();
        }
        status_header(410);
        nocache_headers();
        include get_query_template('404');
        exit;
    }

    $page = fenster_get_generated_page();
    if (! $page) {
        return;
    }

    if ($slug !== 'home' && ! $is_file_request && ! str_ends_with((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH), '/')) {
        $target = home_url('/' . $slug . '/');
        wp_safe_redirect($query !== '' ? $target . '?' . $query : $target, 301);
        exit;
    }

    global $wp_query;
    if ($wp_query instanceof WP_Query) {
        $wp_query->is_404 = false;
        $wp_query->is_page = true;
        $wp_query->is_singular = true;
    }

    status_header(200);
    fenster_send_public_cache_headers();

    remove_action('wp_head', 'rel_canonical');

    set_query_var('fenster_generated_page', $page);
    get_header();
    get_template_part('template-parts/sections/generated-page');
    get_footer();
    exit;
}

add_action('parse_request', 'fenster_maybe_render_generated_sitemap', 0);
add_action('template_redirect', 'fenster_maybe_render_generated_sitemap', -1);
function fenster_maybe_render_generated_sitemap(): void
{
    $path = trim((string) wp_parse_url(add_query_arg([]), PHP_URL_PATH), '/');

    if (! in_array($path, ['sitemap.xml', 'sitemap_index.xml', 'page-sitemap.xml'], true)) {
        return;
    }

    status_header(200);
    header('Content-Type: application/xml; charset=' . get_bloginfo('charset'));
    fenster_send_public_cache_headers(3600, 21600);

    if (in_array($path, ['sitemap.xml', 'sitemap_index.xml'], true)) {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        echo "  <sitemap>\n";
        echo '    <loc>' . esc_xml(home_url('/page-sitemap.xml')) . "</loc>\n";
        echo '    <lastmod>' . esc_xml(gmdate('c')) . "</lastmod>\n";
        echo "  </sitemap>\n";
        echo "</sitemapindex>\n";
        exit;
    }

    $seen = [];
    $excluded_slugs = [
        'case-studies/template-new' => true,
        'case-studies/test' => true,
        'category/doors-milton-keynes' => true,
        'category/windows-milton-keynes' => true,
        'commercial-glazing-milton-keynes' => true,
        'commercial-glazing-northamptonshire' => true,
        'double-glazing-buckinghamshire' => true,
        'double-glazing-northamptonshire' => true,
        'nick-test-baboon' => true,
        'our-new-website' => true,
        'wcad-thank-you' => true,
    ];
    $location_matrix_pages = fenster_location_matrix_pages();
    $commercial_county_pages = fenster_commercial_county_pages();

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

    foreach (fenster_generated_pages_payload()['pages'] ?? [] as $page) {
        $slug = (string) ($page['slug'] ?? '');
        if (isset($excluded_slugs[$slug])) {
            continue;
        }
        if (isset($location_matrix_pages[$slug])) {
            continue;
        }
        if (isset($commercial_county_pages[$slug])) {
            continue;
        }
        if (isset(fenster_gone_slugs()[$slug]) || fenster_redirect_target($slug) !== '' || fenster_slug_is_noindex($slug)) {
            continue;
        }

        $robots = strtolower((string) ($page['seo']['robots'] ?? ''));
        if (str_contains($robots, 'noindex')) {
            continue;
        }

        $loc = fenster_generated_url((string) ($page['seo']['canonical'] ?? $page['url'] ?? ''));
        if (! $loc || isset($seen[$loc])) {
            continue;
        }

        $seen[$loc] = true;
        echo "  <url>\n";
        echo '    <loc>' . esc_xml($loc) . "</loc>\n";
        echo '    <changefreq>' . esc_xml($page['slug'] === 'home' ? 'weekly' : 'monthly') . "</changefreq>\n";
        echo "  </url>\n";
    }

    foreach ($location_matrix_pages as $page) {
        $loc = fenster_generated_url((string) ($page['seo']['canonical'] ?? $page['url'] ?? ''));
        if (! $loc || isset($seen[$loc])) {
            continue;
        }

        $seen[$loc] = true;
        echo "  <url>\n";
        echo '    <loc>' . esc_xml($loc) . "</loc>\n";
        echo "    <changefreq>monthly</changefreq>\n";
        echo "  </url>\n";
    }

    foreach ($commercial_county_pages as $page) {
        $loc = fenster_generated_url((string) ($page['seo']['canonical'] ?? $page['url'] ?? ''));
        if (! $loc || isset($seen[$loc])) {
            continue;
        }

        $seen[$loc] = true;
        echo "  <url>\n";
        echo '    <loc>' . esc_xml($loc) . "</loc>\n";
        echo "    <changefreq>monthly</changefreq>\n";
        echo "  </url>\n";
    }

    foreach (['terms-conditions', 'why-trust-fenster', 'obscured-glass', 'window-handles', 'colour-options', 'upvc-colours', 'aluminium-colours', 'commercial-projects', 'aluminium-flush-windows', 'aluminium-sliding-doors'] as $virtual_slug) {
        if (isset(fenster_gone_slugs()[$virtual_slug]) || fenster_redirect_target($virtual_slug) !== '' || fenster_slug_is_noindex($virtual_slug)) {
            continue;
        }

        $virtual_page = fenster_get_generated_page($virtual_slug);
        $virtual_loc = fenster_generated_url((string) ($virtual_page['seo']['canonical'] ?? ''));
        if ($virtual_loc && ! isset($seen[$virtual_loc])) {
            $seen[$virtual_loc] = true;
            echo "  <url>\n";
            echo '    <loc>' . esc_xml($virtual_loc) . "</loc>\n";
            echo "    <changefreq>monthly</changefreq>\n";
            echo "  </url>\n";
        }
    }

    echo "</urlset>\n";
    exit;
}

// The theme serves its own complete sitemap; the core one would advertise a
// parallel, incomplete URL set (and a users sitemap) to search engines.
add_filter('wp_sitemaps_enabled', '__return_false');

add_filter('robots_txt', 'fenster_generated_robots_txt', 10, 2);
function fenster_generated_robots_txt(string $output, bool $public): string
{
    if (! $public) {
        return $output;
    }

    $lines = array_filter(
        preg_split('/\r\n|\r|\n/', $output) ?: [],
        static function (string $line): bool {
            $line = trim($line);

            return stripos($line, 'Sitemap:') !== 0 && stripos($line, 'Crawl-delay:') !== 0;
        }
    );

    $output = trim(implode("\n", $lines));
    $output .= "\n\nSitemap: " . home_url('/sitemap.xml') . "\n";

    return $output;
}

add_filter('pre_get_document_title', 'fenster_generated_document_title');
function fenster_generated_document_title(string $title): string
{
    $page = fenster_get_generated_page();

    if (! $page) {
        return $title;
    }

    if (! empty($page['seo']['title_tag'])) {
        return (string) $page['seo']['title_tag'];
    }

    if (! empty($page['title'])) {
        return $page['title'] . ' - ' . get_bloginfo('name');
    }

    return $title;
}

add_filter('wpseo_frontend_presenters', 'fenster_disable_plugin_seo_head', PHP_INT_MAX);
add_filter('wpseo_frontend_presenter_classes', 'fenster_disable_plugin_seo_head', PHP_INT_MAX);
add_filter('rank_math/frontend/disable_integration', 'fenster_disable_rank_math_frontend', PHP_INT_MAX);
function fenster_disable_plugin_seo_head(array $presenters): array
{
    return fenster_get_generated_page() ? [] : $presenters;
}

function fenster_disable_rank_math_frontend(bool $disabled): bool
{
    return fenster_get_generated_page() ? true : $disabled;
}

add_action('wp_head', 'fenster_prepare_generated_seo_head', 0);
function fenster_prepare_generated_seo_head(): void
{
    if (! fenster_get_generated_page()) {
        return;
    }

    remove_action('wp_head', '_wp_render_title_tag', 1);
    remove_action('wp_head', 'rel_canonical');
}

add_action('wp_head', 'fenster_render_generated_seo', 1);
function fenster_render_generated_seo(): void
{
    $page = fenster_get_generated_page();
    if (! $page || empty($page['seo']) || ! is_array($page['seo'])) {
        return;
    }

    $seo = $page['seo'];
    $canonical = (string) ($seo['canonical'] ?? '');
    $social_title = (string) ($seo['title_tag'] ?? $page['title'] ?? get_bloginfo('name'));
    $social_description = (string) ($seo['meta_description'] ?? '');
    $default_social_image = FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png';
    $is_bad_seo_content = static function (string $content): bool {
        $trimmed = trim($content);

        if ($trimmed === '' || in_array(strtolower($trimmed), ['0', '1', 'null'], true)) {
            return true;
        }

        if (str_starts_with($trimmed, '{') || str_starts_with($trimmed, '[')) {
            return true;
        }

        return (bool) preg_match('/test\.fensterglazing\.com|registered you will be taken to our custom design software|online designer tool|3d designer tool|WindowCAD/i', $trimmed);
    };
    $is_valid_social_image = static function (string $content) use ($is_bad_seo_content): bool {
        if ($is_bad_seo_content($content)) {
            return false;
        }

        $path = (string) (wp_parse_url($content, PHP_URL_PATH) ?? $content);

        return (bool) preg_match('/\.(avif|gif|jpe?g|png|webp)$/i', $path);
    };

    if (! $is_bad_seo_content($social_title)) {
        printf("\n<title>%s</title>\n", esc_html($social_title));
    }

    if (! empty($seo['meta_description'])) {
        printf("\n<meta name=\"description\" content=\"%s\">\n", esc_attr($seo['meta_description']));
    }

    if (fenster_slug_is_noindex((string) ($page['slug'] ?? ''))) {
        echo "<meta name=\"robots\" content=\"noindex,follow\">\n";
    } elseif (! empty($seo['robots']) && $seo['robots'] !== 'max-image-preview:large') {
        printf("<meta name=\"robots\" content=\"%s\">\n", esc_attr($seo['robots']));
    }

    if ($canonical !== '') {
        printf("<link rel=\"canonical\" href=\"%s\">\n", esc_url($canonical));
    }

    printf("<meta property=\"og:title\" content=\"%s\">\n", esc_attr($social_title));
    if (! $is_bad_seo_content($social_description)) {
        printf("<meta property=\"og:description\" content=\"%s\">\n", esc_attr($social_description));
    }
    if ($canonical !== '') {
        printf("<meta property=\"og:url\" content=\"%s\">\n", esc_url($canonical));
    }
    echo "<meta property=\"og:type\" content=\"website\">\n";
    printf("<meta property=\"og:image\" content=\"%s\">\n", esc_url($default_social_image));
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    printf("<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr($social_title));
    if (! $is_bad_seo_content($social_description)) {
        printf("<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr($social_description));
    }
    printf("<meta name=\"twitter:image\" content=\"%s\">\n", esc_url($default_social_image));

    foreach (($seo['open_graph'] ?? []) as $tag) {
        if (empty($tag['key']) || empty($tag['content'])) {
            continue;
        }

        $key = (string) $tag['key'];
        $content = (string) $tag['content'];

        if (in_array($key, ['og:title', 'og:description', 'og:url', 'og:type', 'og:image'], true)) {
            continue;
        }

        if ($key === 'og:url' && $canonical !== '') {
            $content = $canonical;
        }

        if ($is_bad_seo_content($content)) {
            continue;
        }

        if ($key === 'og:image' && ! $is_valid_social_image($content)) {
            continue;
        }

        printf(
            "<meta property=\"%s\" content=\"%s\">\n",
            esc_attr($key),
            esc_attr($content)
        );
    }

    foreach (($seo['twitter'] ?? []) as $tag) {
        if (empty($tag['key']) || empty($tag['content'])) {
            continue;
        }

        $key = (string) $tag['key'];
        $content = (string) $tag['content'];

        if (in_array($key, ['twitter:card', 'twitter:title', 'twitter:description', 'twitter:image'], true)) {
            continue;
        }

        if ($is_bad_seo_content($content)) {
            continue;
        }

        if ($key === 'twitter:image' && ! $is_valid_social_image($content)) {
            continue;
        }

        printf(
            "<meta name=\"%s\" content=\"%s\">\n",
            esc_attr($key),
            esc_attr($content)
        );
    }

    // Imported schema_json_ld from the scrape is intentionally not rendered.
    // It contains old designer-tool VideoObject markup, test-domain image URLs
    // and unsubstantiated aggregateRating values. Fresh schema is generated in
    // fenster_render_site_schema() and the product FAQ section instead.
}

add_action('wp_head', 'fenster_render_site_schema', 2);
function fenster_render_site_schema(): void
{
    $brand = fenster_data('brand', []);
    $page = fenster_get_generated_page();

    $business_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'HomeAndConstructionBusiness',
        '@id' => home_url('/#business'),
        'name' => (string) ($brand['name'] ?? 'Fenster Glazing'),
        'description' => 'Windows, doors, bifolds and glazing systems supplied and installed across Milton Keynes, Buckinghamshire, Bedfordshire and Northamptonshire.',
        'url' => home_url('/'),
        'telephone' => '+44' . ltrim(preg_replace('/\D+/', '', (string) ($brand['phone'] ?? '01908 429200')), '0'),
        'email' => (string) ($brand['email'] ?? 'info@fensterglazing.com'),
        'image' => FENSTER_THEME_URI . '/assets/images/about/fenster-showroom.png',
        'logo' => FENSTER_THEME_URI . '/assets/brand/favicon-512.png',
        'priceRange' => '££',
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => '97-98 Alston Drive, Bradwell Abbey',
            'addressLocality' => 'Milton Keynes',
            'addressRegion' => 'Buckinghamshire',
            'postalCode' => 'MK13 9HF',
            'addressCountry' => 'GB',
        ],
        'openingHoursSpecification' => [
            [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'opens' => '08:30',
                'closes' => '17:00',
            ],
        ],
        'areaServed' => ['Milton Keynes', 'Buckinghamshire', 'Bedfordshire', 'Northamptonshire', 'Hertfordshire'],
    ];

    printf(
        "<script type=\"application/ld+json\">%s</script>\n",
        wp_json_encode($business_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    );

    if (! is_array($page)) {
        return;
    }

    $slug = (string) ($page['slug'] ?? '');
    if ($slug === 'home') {
        return;
    }

    $breadcrumb_items = [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => home_url('/'),
        ],
    ];

    if (str_starts_with($slug, 'commercial-glazing-') && $slug !== 'commercial-glazing') {
        $breadcrumb_items[] = [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Commercial Glazing',
            'item' => home_url('/commercial-glazing/'),
        ];
    }

    $breadcrumb_items[] = [
        '@type' => 'ListItem',
        'position' => count($breadcrumb_items) + 1,
        'name' => (string) ($page['title'] ?? get_bloginfo('name')),
        'item' => fenster_generated_url((string) ($page['seo']['canonical'] ?? $page['url'] ?? home_url('/' . $slug . '/'))),
    ];

    $breadcrumb_schema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        '@id' => fenster_generated_url((string) ($page['seo']['canonical'] ?? $page['url'] ?? home_url('/' . $slug . '/'))) . '#breadcrumb',
        'itemListElement' => $breadcrumb_items,
    ];

    printf(
        "<script type=\"application/ld+json\">%s</script>\n",
        wp_json_encode($breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
    );
}
