<?php
declare( strict_types=1 );

/**
 * Project-category index views — centralized SEO copy + meta/title output for
 * the `tbc_project_category` taxonomy archives served at /project-category/{slug}.
 *
 * The on-page layout lives in blocks/project-category-index (surfaced through
 * templates/taxonomy-tbc_project_category.html); JSON-LD lives in inc/schema.php.
 * This file is the single source of truth for the per-category copy those pieces
 * read, mirroring how inc/areas.php backs the area-landing pages.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Curated SEO/intro copy keyed by category term slug.
 *
 * Any term without an entry here still gets a working page via the generated
 * fallbacks in tbc_project_category_meta(); add an entry to take control of the
 * title, meta description, intro lede, focus keyphrase, and related-service links.
 *
 * Field guide:
 *   intro    — on-page lede paragraph (used when the term has no native description)
 *   title    — SEO <title> (brand auto-appended; aim ≤ 60 chars before brand)
 *   meta     — meta description (aim 140–160 chars)
 *   keyword  — focus keyphrase
 *   services — [ url, label ] related service links shown on the index
 */
function tbc_project_category_seo(): array {
    $brand = function_exists( 'tbc_seo_brand_suffix' ) ? tbc_seo_brand_suffix() : 'T-Bone Construction';

    return [
        'decks' => [
            'intro'   => 'Browse custom deck and railing projects built across the Magic Valley — composite Trex, TimberTech, and Eva-Last surfaces with premium railing systems, engineered for Idaho weather.',
            'title'   => "Custom Deck Projects in Idaho | {$brand}",
            'meta'    => 'See real custom deck and railing builds from T-Bone Construction across the Magic Valley — composite decks, custom layouts, and TrexPro® certified craftsmanship.',
            'keyword' => 'custom deck projects idaho',
            'services'=> [
                [ '/services/decks',    'Decks & Railings' ],
                [ '/services/canopies', 'Canopies & Covers' ],
            ],
        ],
        'sheds-greenhouses' => [
            'intro'   => 'Explore custom sheds, garden structures, and greenhouses built for Idaho snow loads and sun — every structure engineered and finished in-house.',
            'title'   => "Custom Shed & Greenhouse Projects in Idaho | {$brand}",
            'meta'    => 'Custom shed, garden building, and greenhouse projects across the Magic Valley — built to your size and style and engineered for Idaho weather.',
            'keyword' => 'custom shed projects idaho',
            'services'=> [
                [ '/services/sheds',  'Sheds & Greenhouses' ],
                [ '/services/decks',  'Decks & Railings' ],
            ],
        ],
        'renovations' => [
            'intro'   => 'See kitchen remodels, bathroom updates, and whole-home renovations completed across the Magic Valley — one project lead, on-site daily, with weekly written updates.',
            'title'   => "Home Renovation Projects in Idaho | {$brand}",
            'meta'    => 'Real kitchen, bath, and whole-home renovation projects from T-Bone Construction across the Magic Valley. Family-run, licensed, and fully insured.',
            'keyword' => 'home renovation projects idaho',
            'services'=> [
                [ '/services/renovations', 'Home Renovations' ],
                [ '/services/windows',     'Window Replacements' ],
            ],
        ],
        'canopies' => [
            'intro'   => 'See custom patio canopies and outdoor covers built across the Magic Valley — louvered, solid, and pergola-style designs engineered for Idaho sun and snow.',
            'title'   => "Patio Canopy & Cover Projects in Idaho | {$brand}",
            'meta'    => 'Custom canopy and patio-cover projects from T-Bone Construction across the Magic Valley — engineered, permitted, and installed in-house for Idaho weather.',
            'keyword' => 'patio canopy projects idaho',
            'services'=> [
                [ '/services/canopies', 'Canopies & Covers' ],
                [ '/services/decks',    'Decks & Railings' ],
            ],
        ],
        'siding' => [
            'intro'   => 'Browse full siding installation projects across the Magic Valley — vinyl, LP SmartSide®, and metal, installed weather-tight from tear-off to finish.',
            'title'   => "Siding Installation Projects in Idaho | {$brand}",
            'meta'    => 'Real siding projects from T-Bone Construction across the Magic Valley — vinyl, LP SmartSide®, and metal, engineered to outlast Idaho weather.',
            'keyword' => 'siding projects idaho',
            'services'=> [
                [ '/services/siding',  'Siding Installation' ],
                [ '/services/windows', 'Window Replacements' ],
            ],
        ],
        'windows' => [
            'intro'   => 'See energy-efficient window replacement projects across the Magic Valley — vinyl, wood, and composite frames, most homes finished in 1–2 days.',
            'title'   => "Window Replacement Projects in Idaho | {$brand}",
            'meta'    => 'Real window replacement projects from T-Bone Construction across the Magic Valley — energy-efficient frames installed by a local crew with manufacturer warranties.',
            'keyword' => 'window replacement projects idaho',
            'services'=> [
                [ '/services/windows', 'Window Replacements' ],
                [ '/services/siding',  'Siding Installation' ],
            ],
        ],
    ];
}

/**
 * Resolve display + SEO copy for a category term.
 *
 * The on-page intro prefers the term's native description (editable in
 * Projects → Project Categories), then the curated preset, then a generated
 * fallback. Title/description always resolve so the <head> output is never blank.
 *
 * @return array{intro:string,title:string,description:string,keyword:string,services:array<int,array{0:string,1:string}>}
 */
function tbc_project_category_meta( WP_Term $term ): array {
    $brand   = function_exists( 'tbc_seo_brand_suffix' ) ? tbc_seo_brand_suffix() : 'T-Bone Construction';
    $presets = tbc_project_category_seo();
    $preset  = $presets[ $term->slug ] ?? [];
    $name    = $term->name;

    $desc_meta = trim( wp_strip_all_tags( (string) $term->description ) );

    $intro = $desc_meta !== ''
        ? $desc_meta
        : ( $preset['intro'] ?? sprintf( 'Browse recent %s projects completed by T-Bone Construction across the Magic Valley.', strtolower( $name ) ) );

    $title = $preset['title'] ?? "{$name} Projects in Idaho | {$brand}";

    $description = $preset['meta']
        ?? ( $desc_meta !== ''
            ? $desc_meta
            : sprintf( 'Browse %s projects from T-Bone Construction across the Magic Valley. Licensed, insured, and built for Idaho weather.', strtolower( $name ) ) );

    return [
        'intro'       => $intro,
        'title'       => $title,
        'description' => $description,
        'keyword'     => $preset['keyword'] ?? strtolower( "{$name} projects idaho" ),
        'services'    => $preset['services'] ?? [],
    ];
}

/**
 * Auto-generated local-SEO sentence tying a category to the service area, e.g.
 * "T-Bone Construction builds custom decks for homeowners across the Magic
 * Valley — including Twin Falls, Filer, …". Returns '' if the area data is
 * unavailable. Copy stays in sync with inc/areas.php (tbc_areas()).
 */
function tbc_project_category_areas_blurb( WP_Term $term ): string {
    if ( ! function_exists( 'tbc_area_names' ) ) {
        return '';
    }
    $names = array_values( tbc_area_names() );
    if ( ! $names ) {
        return '';
    }

    // Oxford-comma list: "A, B, and C" (or "A and B" / "A").
    if ( count( $names ) > 2 ) {
        $last = array_pop( $names );
        $list = implode( ', ', $names ) . ', and ' . $last;
    } else {
        $list = implode( ' and ', $names );
    }

    return sprintf(
        'T-Bone Construction builds custom %s for homeowners across the Magic Valley — including %s. Wherever you are in southern Idaho, the same local, family-run crew handles your project from the first walkthrough to the final punch list, with materials engineered for the area\'s weather.',
        strtolower( $term->name ),
        $list
    );
}

/**
 * The project-category term for the current request, or null when we're not on
 * a tbc_project_category archive. Used by the index block and the schema output.
 */
function tbc_current_project_category(): ?WP_Term {
    if ( ! is_tax( 'tbc_project_category' ) ) {
        return null;
    }
    $term = get_queried_object();
    return ( $term instanceof WP_Term && 'tbc_project_category' === $term->taxonomy ) ? $term : null;
}

/**
 * A manual Yoast SEO override stored on the term, or '' if none. Yoast keeps
 * taxonomy SEO in the `wpseo_taxonomy_meta` option (not term meta), so an editor
 * who fills in the Yoast box for a category should always win over our presets.
 */
function tbc_project_category_yoast_override( WP_Term $term, string $key ): string {
    $opt = get_option( 'wpseo_taxonomy_meta', [] );
    $val = $opt['tbc_project_category'][ $term->term_id ][ $key ] ?? '';
    return is_string( $val ) ? trim( $val ) : '';
}

if ( defined( 'WPSEO_VERSION' ) ) {
    // Yoast owns the <head> tags — feed our curated copy through its own filters
    // (only when the editor hasn't set a manual per-term override).
    add_filter( 'wpseo_title', static function ( $title ) {
        $term = tbc_current_project_category();
        if ( ! $term || '' !== tbc_project_category_yoast_override( $term, 'wpseo_title' ) ) {
            return $title;
        }
        return tbc_project_category_meta( $term )['title'];
    } );

    add_filter( 'wpseo_metadesc', static function ( $desc ) {
        $term = tbc_current_project_category();
        if ( ! $term || '' !== tbc_project_category_yoast_override( $term, 'wpseo_desc' ) ) {
            return $desc;
        }
        return tbc_project_category_meta( $term )['description'];
    } );
} else {
    // No Yoast — emit the title, meta description, and canonical ourselves.
    add_filter( 'pre_get_document_title', static function ( string $title ): string {
        $term = tbc_current_project_category();
        return $term ? tbc_project_category_meta( $term )['title'] : $title;
    } );

    add_action( 'wp_head', static function (): void {
        $term = tbc_current_project_category();
        if ( ! $term ) {
            return;
        }
        $meta = tbc_project_category_meta( $term );
        $link = get_term_link( $term );

        printf( "\n<meta name=\"description\" content=\"%s\" />\n", esc_attr( $meta['description'] ) );
        if ( ! is_wp_error( $link ) ) {
            printf( "<link rel=\"canonical\" href=\"%s\" />\n", esc_url( $link ) );
        }
    }, 1 );
}
