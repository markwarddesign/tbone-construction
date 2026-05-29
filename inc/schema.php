<?php
declare( strict_types=1 );

/**
 * LocalBusiness (GeneralContractor) JSON-LD output.
 *
 * Emits a sitewide structured-data block in <head> using the NAP from Theme
 * Settings (with tbc_business_nap() fallbacks) and the Magic Valley service
 * area from tbc_areas(). On a single /areas/{city} page it narrows
 * areaServed to that city for a stronger local signal.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Parse "Mon–Fri 8 AM – 5 PM"-style hours into schema openingHours, falling
 * back to a sane default. Kept intentionally simple — the business currently
 * runs standard weekday hours.
 */
function tbc_schema_opening_hours(): array {
    return [
        [
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' ],
            'opens'     => '08:00',
            'closes'    => '17:00',
        ],
    ];
}

function tbc_schema_area_served(): array {
    if ( ! function_exists( 'tbc_areas' ) ) {
        return [];
    }

    // On a single area page, narrow to just that city.
    if ( is_page() ) {
        $post = get_queried_object();
        if ( $post instanceof WP_Post ) {
            $parent = $post->post_parent ? get_post( $post->post_parent ) : null;
            if ( $parent instanceof WP_Post && 'areas' === $parent->post_name ) {
                $area = tbc_area( $post->post_name );
                if ( $area ) {
                    return [ [
                        '@type' => 'City',
                        'name'  => $area['name'] . ', ID',
                    ] ];
                }
            }
        }
    }

    $served = [];
    foreach ( tbc_areas() as $area ) {
        $served[] = [
            '@type' => 'City',
            'name'  => $area['name'] . ', ID',
        ];
    }
    return $served;
}

function tbc_localbusiness_schema(): void {
    if ( ! function_exists( 'tbc_business_nap' ) ) {
        return;
    }

    $nap     = tbc_business_nap();
    $logo_id = (int) get_option( 'tbone_construction_logo_id', 0 );
    $logo    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

    $phone_digits = preg_replace( '/[^0-9+]/', '', (string) $nap['phone_link'] );

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => [ 'GeneralContractor', 'LocalBusiness' ],
        '@id'         => home_url( '/#business' ),
        'name'        => $nap['name'],
        'url'         => home_url( '/' ),
        'telephone'   => $phone_digits ?: $nap['phone'],
        'email'       => $nap['email'],
        'priceRange'  => '$$',
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $nap['street'],
            'addressLocality' => $nap['city'],
            'addressRegion'   => $nap['state'],
            'postalCode'      => $nap['zip'],
            'addressCountry'  => 'US',
        ],
        'geo'         => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $nap['lat'],
            'longitude' => $nap['long'],
        ],
        'openingHoursSpecification' => tbc_schema_opening_hours(),
        'areaServed'  => tbc_schema_area_served(),
    ];

    if ( $logo ) {
        $schema['logo']  = $logo;
        $schema['image'] = $logo;
    }

    echo "\n<script type=\"application/ld+json\">"
        . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE )
        . "</script>\n";
}
add_action( 'wp_head', 'tbc_localbusiness_schema', 20 );
