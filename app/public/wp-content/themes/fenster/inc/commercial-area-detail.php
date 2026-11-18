<?php
/**
 * Local detail for the commercial area pages.
 *
 * 18/11/2026: the 47 county pages and four city pages shared one body with the
 * place name swapped, and earned 20 clicks in 16 months. Each area now carries
 * its own copy in data/commercial-areas.json. Distances, the nearest completed
 * projects and the neighbouring areas are worked out here from coordinates, so
 * a new case study reaches the right pages by adding one line to that file.
 *
 * @package Fenster
 */

if (! defined('ABSPATH')) {
    exit;
}

function fenster_commercial_area_data(): array
{
    static $data = null;
    if (is_array($data)) {
        return $data;
    }

    $file = FENSTER_THEME_DIR . '/data/commercial-areas.json';
    $decoded = is_file($file) ? json_decode((string) file_get_contents($file), true) : null;
    $data = is_array($decoded) ? $decoded : [];

    return $data;
}

function fenster_commercial_area_detail(string $area): array
{
    $detail = fenster_commercial_area_data()['areas'][$area] ?? [];

    return is_array($detail) ? $detail : [];
}

/** How a place reads after "in": in Kent, in the West Midlands. */
function fenster_commercial_area_place(string $area, string $name): string
{
    return in_array($area, ['city-of-london', 'east-riding-of-yorkshire', 'west-midlands'], true) ? 'the ' . $name : $name;
}

/** Straight-line miles between two points. */
function fenster_commercial_area_miles(array $from, array $to): float
{
    $lat_from = deg2rad((float) ($from['lat'] ?? 0));
    $lat_to = deg2rad((float) ($to['lat'] ?? 0));
    $lat_gap = $lat_to - $lat_from;
    $lng_gap = deg2rad((float) ($to['lng'] ?? 0) - (float) ($from['lng'] ?? 0));
    $arc = sin($lat_gap / 2) ** 2 + cos($lat_from) * cos($lat_to) * sin($lng_gap / 2) ** 2;

    return 3958.8 * 2 * asin(min(1, sqrt($arc)));
}

/** Miles to the nearest five, because the area's point is only its main town. */
function fenster_commercial_area_rounded_miles(float $miles): int
{
    return (int) (round($miles / 5) * 5);
}

function fenster_commercial_area_base_miles(string $area): int
{
    $detail = fenster_commercial_area_detail($area);
    $base = fenster_commercial_area_data()['base'] ?? [];

    return $detail === [] || ! is_array($base) ? 0 : fenster_commercial_area_rounded_miles(fenster_commercial_area_miles($base, $detail));
}

/**
 * The completed commercial projects closest to an area, nearest first.
 *
 * @return array<int, array<string, mixed>>
 */
function fenster_commercial_area_projects(string $area, int $limit = 4): array
{
    $detail = fenster_commercial_area_detail($area);
    if ($detail === [] || ! function_exists('fenster_case_study') || ! function_exists('fenster_case_study_card')) {
        return [];
    }

    $projects = [];
    foreach ((array) (fenster_commercial_area_data()['projects'] ?? []) as $short => $point) {
        $study = fenster_case_study((string) $short);
        if (! is_array($study)) {
            continue;
        }
        $card = fenster_case_study_card((string) $short, $study);
        $card['miles'] = fenster_commercial_area_miles($detail, (array) $point);
        $projects[] = $card;
    }
    usort($projects, static fn (array $first, array $second): int => $first['miles'] <=> $second['miles']);

    return array_slice($projects, 0, $limit);
}

/**
 * The commercial areas closest to an area, nearest first.
 *
 * @return array<int, array{url: string, text: string}>
 */
function fenster_commercial_area_neighbours(string $area, array $profiles, int $limit = 6): array
{
    $detail = fenster_commercial_area_detail($area);
    if ($detail === []) {
        return [];
    }

    $near = [];
    foreach ((array) (fenster_commercial_area_data()['areas'] ?? []) as $slug => $other) {
        if ($slug !== $area && isset($profiles[$slug])) {
            $near[$slug] = fenster_commercial_area_miles($detail, (array) $other);
        }
    }
    asort($near);

    $links = [];
    foreach (array_slice(array_keys($near), 0, $limit) as $slug) {
        $links[] = ['url' => home_url('/commercial-glazing-' . $slug . '/'), 'text' => 'Commercial glazing in ' . fenster_commercial_area_place((string) $slug, (string) $profiles[$slug]['county'])];
    }

    return $links;
}
