<?php
declare( strict_types=1 );

/**
 * Magic Valley service-area data — the single source of truth for the
 * area-landing block, the /areas page seeder, the LocalBusiness schema,
 * the footer "Areas We Serve" column, and the per-area SEO presets.
 *
 * Edit a city here and it propagates everywhere.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Default business NAP. Theme Settings (address fields) override these at
 * runtime; the constants are the fallback when a setting is blank.
 */
function tbc_business_nap(): array {
    return [
        'name'    => get_bloginfo( 'name' ) ?: 'T-Bone Construction',
        'street'  => (string) get_option( 'tbone_construction_address_street', '2325 Village St' ),
        'city'    => (string) get_option( 'tbone_construction_address_city',   'Twin Falls' ),
        'state'   => (string) get_option( 'tbone_construction_address_state',  'ID' ),
        'zip'     => (string) get_option( 'tbone_construction_address_zip',    '83301' ),
        'phone'   => (string) get_option( 'tbone_construction_topbar_phone',      '(208) 751-4303' ),
        'phone_link' => (string) get_option( 'tbone_construction_topbar_phone_link', 'tel:+12087514303' ),
        'email'   => (string) get_option( 'tbone_construction_topbar_email',      'hello@tboneconst.com' ),
        'hours'   => (string) get_option( 'tbone_construction_hours',           'Mon–Fri 8 AM – 5 PM' ),
        'lat'     => 42.5558,
        'long'    => -114.4701,
    ];
}

/**
 * The Magic Valley cities we build in. Keyed by URL slug.
 *
 * Field guide:
 *   name    — display name
 *   county  — Idaho county (used in localized copy)
 *   zip     — primary ZIP (schema postal coverage)
 *   lat/long— geo center (schema)
 *   intro   — lede paragraph for the landing hero
 *   points  — 2–3 localized trust/relevance lines shown on the page
 */
function tbc_areas(): array {
    return [
        'twin-falls' => [
            'name'   => 'Twin Falls',
            'county' => 'Twin Falls County',
            'zip'    => '83301',
            'lat'    => 42.5558,
            'long'   => -114.4701,
            'intro'  => 'T-Bone Construction is based right here in Twin Falls, building custom decks, siding, canopies, windows, and renovations for homeowners across the city and the wider Magic Valley.',
            'points' => [
                'Local crew based in Twin Falls — short drive times and fast estimates.',
                'Decks and outdoor spaces engineered for the Snake River Canyon rim climate.',
                "The area's only certified Trex RainEscape® dry-deck installer.",
            ],
        ],
        'filer' => [
            'name'   => 'Filer',
            'county' => 'Twin Falls County',
            'zip'    => '83328',
            'lat'    => 42.5705,
            'long'   => -114.6088,
            'intro'  => 'From custom decks to full siding replacements, T-Bone Construction brings 25+ years of craftsmanship to Filer homeowners — just minutes from our Twin Falls shop.',
            'points' => [
                'Composite and wood decks built for Filer’s farm-country weather.',
                'LP SmartSide®, vinyl, and metal siding installed weather-tight.',
                'Free, no-obligation estimates across Twin Falls County.',
            ],
        ],
        'buhl' => [
            'name'   => 'Buhl',
            'county' => 'Twin Falls County',
            'zip'    => '83316',
            'lat'    => 42.5996,
            'long'   => -114.7591,
            'intro'  => 'T-Bone Construction serves Buhl with custom decks, patio canopies, siding, window replacements, and home renovations — all handled in-house by one local crew.',
            'points' => [
                'Covered patios and canopies sized for hot Magic Valley summers.',
                'Energy-efficient window replacements, most homes done in 1–2 days.',
                'Family-run, licensed, and insured throughout Twin Falls County.',
            ],
        ],
        'jerome' => [
            'name'   => 'Jerome',
            'county' => 'Jerome County',
            'zip'    => '83338',
            'lat'    => 42.7241,
            'long'   => -114.5188,
            'intro'  => 'T-Bone Construction builds decks, siding, canopies, sheds, and renovations for Jerome homeowners, with a local reputation built on dependable, detail-driven work.',
            'points' => [
                'Custom sheds and greenhouses engineered for Jerome County snow loads.',
                'Kitchen, bath, and whole-home renovations with weekly written updates.',
                'TrexPro® certified decks with premium RDI and Trex railings.',
            ],
        ],
        'burley' => [
            'name'   => 'Burley',
            'county' => 'Cassia County',
            'zip'    => '83318',
            'lat'    => 42.5357,
            'long'   => -113.7928,
            'intro'  => 'Serving Burley and the eastern Magic Valley, T-Bone Construction delivers custom decks, siding, windows, and renovations built to outlast Idaho weather.',
            'points' => [
                'Durable decks and railings for Burley’s wind and sun exposure.',
                'Full-service siding tear-off, inspection, and weather-tight install.',
                'One project lead, on-site daily from first walkthrough to punch list.',
            ],
        ],
        'hailey' => [
            'name'   => 'Hailey',
            'county' => 'Blaine County',
            'zip'    => '83333',
            'lat'    => 43.5196,
            'long'   => -114.3153,
            'intro'  => 'From the Wood River Valley to the rest of Blaine County, T-Bone Construction builds custom decks, canopies, siding, and renovations engineered for mountain-town winters.',
            'points' => [
                'Decks and covers engineered for Hailey’s heavy snow loads.',
                'Premium composite materials that handle freeze-thaw cycles.',
                'Licensed, insured, and TrexPro® certified craftsmanship.',
            ],
        ],
    ];
}

/** Resolve one area by slug, or null. */
function tbc_area( string $slug ): ?array {
    $areas = tbc_areas();
    return $areas[ $slug ] ?? null;
}

/** Comma list of city names — used in copy and schema fallbacks. */
function tbc_area_names(): array {
    return array_map( static fn( array $a ): string => $a['name'], tbc_areas() );
}
