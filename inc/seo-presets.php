<?php
declare( strict_types=1 );

/**
 * T-Bone SEO Presets
 *
 * Provides a Tools → SEO Presets admin page that writes a curated set of
 * Yoast SEO meta keys (title / description / focus keyword / OG / Twitter)
 * onto the core marketing pages of the site.
 *
 * Yoast does NOT need to be installed for the data to be written — the meta
 * keys live in postmeta either way. Once Yoast is activated it picks them up
 * automatically.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * The brand suffix used on every SEO title.
 * Kept short so titles stay within Google's ~60-char display limit.
 */
function tbc_seo_brand_suffix(): string {
    return 'T-Bone Construction';
}

/**
 * The full curated preset list.
 *
 * Each entry is keyed by page slug. Add or edit copy here and re-apply from
 * Tools → SEO Presets to push the new values out.
 *
 * Field guide:
 *   title       — Yoast SEO title           (aim ≤ 60 chars; brand is auto-appended)
 *   description — Yoast meta description    (aim 140–160 chars; lead with value, end with action)
 *   keyword     — Yoast focus keyphrase     (the term you most want this page to rank for)
 *   og_title    — Open Graph / social title (falls back to `title` if blank)
 *   og_desc     — Open Graph / social desc  (falls back to `description` if blank)
 */
function tbc_seo_presets(): array {
    $brand = tbc_seo_brand_suffix();

    return [
        'home' => [
            'label'       => 'Home',
            'title'       => "Custom Decks, Siding & Renovations in Idaho | {$brand}",
            'description' => "25+ years building custom decks, canopies, siding, windows, and renovations across the Treasure Valley. Licensed, insured, and TrexPro® certified. Get a free estimate.",
            'keyword'     => 'Idaho custom construction',
            'og_title'    => "Idaho's Trusted Builder for Decks, Siding & Renovations",
            'og_desc'     => 'Custom-built decks, canopies, siding, windows, and home renovations — crafted for Idaho weather. Free estimates, 25 years of experience.',
        ],
        'about' => [
            'label'       => 'About',
            'title'       => "About Us — Family-Run Idaho Builders | {$brand}",
            'description' => "Meet T-Bone Construction — a family-run Idaho contractor with 25+ years building decks, canopies, siding, and renovations across the Treasure Valley.",
            'keyword'     => 'Idaho construction company',
            'og_title'    => 'About T-Bone Construction — 25 Years of Idaho Craftsmanship',
            'og_desc'     => 'Family-run, TrexPro® certified, licensed and insured. We build for Idaho weather and the families that live in it.',
        ],
        'services' => [
            'label'       => 'Services',
            'title'       => "Our Services — Decks, Siding, Windows & More | {$brand}",
            'description' => "Explore every service we offer: custom decks & railings, canopies, siding, window replacements, home renovations, and shed builds — all done in-house.",
            'keyword'     => 'Idaho home improvement services',
            'og_title'    => 'Construction Services in the Treasure Valley',
            'og_desc'     => 'Decks, canopies, siding, windows, renovations, and sheds — one local, in-house crew handles every project from start to finish.',
        ],
        'services/decks' => [
            'label'       => 'Decks & Railings',
            'title'       => "Custom Decks & Railings in Idaho — TrexPro® Certified | {$brand}",
            'description' => "Premium composite decks built with Trex, TimberTech, and Eva-Last. Certified Trex RainEscape® installer serving the Treasure Valley. Free estimates.",
            'keyword'     => 'custom decks Idaho',
            'og_title'    => 'Composite Decks Built for Idaho Weather',
            'og_desc'     => 'TrexPro® certified deck installations with premium railings, custom layouts, and the area\'s only certified RainEscape® dry-deck system.',
        ],
        'services/canopies' => [
            'label'       => 'Canopies & Covers',
            'title'       => "Patio Canopies & Outdoor Covers in Idaho | {$brand}",
            'description' => "Custom canopies and patio covers built to handle Idaho sun and snow. Louvered, solid, and pergola-style designs — engineered, permitted, and installed in-house.",
            'keyword'     => 'patio canopy Idaho',
            'og_title'    => 'Custom Patio Canopies & Outdoor Covers',
            'og_desc'     => 'Extend your outdoor season with a custom canopy designed for Idaho weather. Louvered, solid, and pergola options available.',
        ],
        'services/siding' => [
            'label'       => 'Siding Installation',
            'title'       => "Siding Installation in Idaho — Vinyl, LP, Metal | {$brand}",
            'description' => "Full-service siding installation across the Treasure Valley. Vinyl, LP SmartSide®, and metal options — engineered to outlast Idaho weather. Free estimates.",
            'keyword'     => 'siding installation Idaho',
            'og_title'    => 'Siding Installation Built for Idaho Weather',
            'og_desc'     => 'New siding from a local crew that handles tear-off, inspection, and install. Vinyl, LP SmartSide®, and metal options.',
        ],
        'services/windows' => [
            'label'       => 'Window Replacements',
            'title'       => "Window Replacement in Idaho — Energy-Efficient | {$brand}",
            'description' => "Replace drafty windows with energy-efficient vinyl, wood, or composite frames. Most homes finished in 1–2 days. Local install crew, manufacturer warranty.",
            'keyword'     => 'window replacement Idaho',
            'og_title'    => 'Energy-Efficient Window Replacement',
            'og_desc'     => 'Drop your energy bill and modernize your home with new windows from trusted brands. Most installs finished in 1–2 days.',
        ],
        'services/renovations' => [
            'label'       => 'Home Renovations',
            'title'       => "Home Renovations & Remodels in Idaho | {$brand}",
            'description' => "Kitchen remodels, bathroom updates, and full home refreshes across the Treasure Valley. One project lead, daily on-site, weekly written updates.",
            'keyword'     => 'home renovations Idaho',
            'og_title'    => 'Kitchen, Bath, and Whole-Home Renovations',
            'og_desc'     => 'A clear, communicated renovation process from first walkthrough to final punch list. Idaho-based, family-run, fully insured.',
        ],
        'services/sheds' => [
            'label'       => 'Sheds & Greenhouses',
            'title'       => "Custom Sheds & Greenhouses in Idaho | {$brand}",
            'description' => "Custom-built sheds, garden structures, and greenhouses engineered for Idaho snow loads and sun. Foundation to finish — every structure handled in-house.",
            'keyword'     => 'custom sheds Idaho',
            'og_title'    => 'Custom Sheds & Greenhouses',
            'og_desc'     => 'Built to your size, style, and budget — and engineered for Idaho weather. Sheds, garden buildings, and greenhouses.',
        ],
        'reviews' => [
            'label'       => 'Reviews',
            'title'       => "Reviews — What Our Clients Say | {$brand}",
            'description' => "Honest reviews from Treasure Valley homeowners. See what neighbors say about working with T-Bone Construction on decks, siding, and renovations.",
            'keyword'     => 'T-Bone Construction reviews',
            'og_title'    => 'Client Reviews — T-Bone Construction',
            'og_desc'     => 'Real reviews from Idaho homeowners we\'ve worked with — see why neighbors recommend us.',
        ],
        'gallery' => [
            'label'       => 'Gallery',
            'title'       => "Project Gallery — Idaho Decks, Siding, Renovations | {$brand}",
            'description' => "Browse recent T-Bone Construction projects across the Treasure Valley. Custom decks, canopies, siding, windows, sheds, and full home renovations.",
            'keyword'     => 'construction project gallery Idaho',
            'og_title'    => 'Project Gallery — T-Bone Construction',
            'og_desc'     => 'A few of the recent decks, canopies, siding jobs, and renovations our crew has finished across Idaho.',
        ],
        'contact' => [
            'label'       => 'Contact',
            'title'       => "Contact Us — Free Estimates in Idaho | {$brand}",
            'description' => "Request a free estimate or ask a question. Call or message T-Bone Construction — local, family-run, and serving the Treasure Valley for 25+ years.",
            'keyword'     => 'Idaho contractor contact',
            'og_title'    => 'Contact T-Bone Construction',
            'og_desc'     => 'Reach out for a free estimate on your next deck, canopy, siding, window, or renovation project. Serving the Treasure Valley.',
        ],
    ];
}

/**
 * Maps Yoast meta keys to the preset fields. Centralised so the apply logic
 * and the diff view stay in sync.
 */
function tbc_seo_yoast_field_map(): array {
    return [
        '_yoast_wpseo_title'                  => 'title',
        '_yoast_wpseo_metadesc'               => 'description',
        '_yoast_wpseo_focuskw'                => 'keyword',
        '_yoast_wpseo_opengraph-title'        => 'og_title',
        '_yoast_wpseo_opengraph-description'  => 'og_desc',
        '_yoast_wpseo_twitter-title'          => 'og_title',
        '_yoast_wpseo_twitter-description'    => 'og_desc',
    ];
}

/**
 * Resolve a slug to a published page ID.
 */
function tbc_seo_resolve_page_id( string $slug ): ?int {
    $page = get_page_by_path( $slug );
    if ( $page instanceof WP_Post ) {
        return (int) $page->ID;
    }
    return null;
}

/**
 * Apply a single preset to its page. Returns number of meta keys written.
 */
function tbc_seo_apply_preset( string $slug, array $preset ): int {
    $page_id = tbc_seo_resolve_page_id( $slug );
    if ( ! $page_id ) {
        return 0;
    }
    $written = 0;
    foreach ( tbc_seo_yoast_field_map() as $meta_key => $field ) {
        $value = $preset[ $field ] ?? '';
        if ( $value === '' ) {
            continue;
        }
        update_post_meta( $page_id, $meta_key, $value );
        $written++;
    }
    return $written;
}

/**
 * Apply every preset; returns [ slug => meta_keys_written ].
 */
function tbc_seo_apply_all(): array {
    $report = [];
    foreach ( tbc_seo_presets() as $slug => $preset ) {
        $report[ $slug ] = tbc_seo_apply_preset( $slug, $preset );
    }
    return $report;
}

/**
 * Admin menu — Tools → SEO Presets
 */
function tbc_seo_register_admin_page(): void {
    add_management_page(
        __( 'SEO Presets', 'tbone-construction' ),
        __( 'SEO Presets', 'tbone-construction' ),
        'manage_options',
        'tbc-seo-presets',
        'tbc_seo_render_admin_page'
    );
}
add_action( 'admin_menu', 'tbc_seo_register_admin_page' );

/**
 * Renders the admin page: status, diff table, apply button.
 */
function tbc_seo_render_admin_page(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'You do not have permission to view this page.', 'tbone-construction' ) );
    }

    $applied_report = null;
    if (
        isset( $_POST['tbc_seo_apply'], $_POST['_wpnonce'] )
        && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'tbc_seo_apply' )
    ) {
        $applied_report = tbc_seo_apply_all();
    }

    $presets    = tbc_seo_presets();
    $yoast_on   = defined( 'WPSEO_VERSION' ) || is_plugin_active( 'wordpress-seo/wp-seo.php' );
    $field_map  = tbc_seo_yoast_field_map();
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'SEO Presets', 'tbone-construction' ); ?></h1>

        <?php if ( $applied_report ) : ?>
            <div class="notice notice-success is-dismissible">
                <p>
                    <?php
                    $total = array_sum( $applied_report );
                    $pages = count( array_filter( $applied_report ) );
                    printf(
                        /* translators: 1: meta keys, 2: pages */
                        esc_html__( 'Applied %1$d Yoast meta values across %2$d pages.', 'tbone-construction' ),
                        (int) $total,
                        (int) $pages
                    );
                    ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if ( ! $yoast_on ) : ?>
            <div class="notice notice-warning">
                <p>
                    <strong><?php esc_html_e( 'Yoast SEO is not active.', 'tbone-construction' ); ?></strong>
                    <?php esc_html_e( 'The meta values can still be written to postmeta now — once you install and activate Yoast SEO, they\'ll start rendering in <head> automatically.', 'tbone-construction' ); ?>
                </p>
            </div>
        <?php endif; ?>

        <p>
            <?php esc_html_e( 'These presets push curated SEO titles, meta descriptions, focus keyphrases, and Open Graph copy to every key marketing page. Edit the source at:', 'tbone-construction' ); ?>
            <code>wp-content/themes/tbone-construction/inc/seo-presets.php</code>
        </p>

        <form method="post" style="margin: 1em 0;">
            <?php wp_nonce_field( 'tbc_seo_apply' ); ?>
            <button type="submit" name="tbc_seo_apply" class="button button-primary button-large">
                <?php esc_html_e( 'Apply All SEO Presets', 'tbone-construction' ); ?>
            </button>
            <span class="description" style="margin-left:1em;">
                <?php esc_html_e( 'Overwrites the listed Yoast meta on every matched page. Safe to re-run.', 'tbone-construction' ); ?>
            </span>
        </form>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th style="width: 12em;"><?php esc_html_e( 'Page', 'tbone-construction' ); ?></th>
                    <th><?php esc_html_e( 'SEO Title', 'tbone-construction' ); ?></th>
                    <th><?php esc_html_e( 'Meta Description', 'tbone-construction' ); ?></th>
                    <th style="width: 12em;"><?php esc_html_e( 'Focus Keyphrase', 'tbone-construction' ); ?></th>
                    <th style="width: 8em;"><?php esc_html_e( 'Status', 'tbone-construction' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $presets as $slug => $preset ) :
                    $page_id     = tbc_seo_resolve_page_id( $slug );
                    $current_title = $page_id ? (string) get_post_meta( $page_id, '_yoast_wpseo_title', true )   : '';
                    $current_desc  = $page_id ? (string) get_post_meta( $page_id, '_yoast_wpseo_metadesc', true ) : '';
                    $matches       = $page_id && $current_title === $preset['title'] && $current_desc === $preset['description'];
                ?>
                    <tr>
                        <td>
                            <strong><?php echo esc_html( $preset['label'] ); ?></strong><br />
                            <code>/<?php echo esc_html( $slug ); ?></code>
                            <?php if ( ! $page_id ) : ?>
                                <br /><span style="color:#b32d2e;"><?php esc_html_e( 'page not found', 'tbone-construction' ); ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo esc_html( $preset['title'] ); ?>
                            <br />
                            <small style="color:#666;">
                                <?php echo (int) strlen( $preset['title'] ); ?> chars
                            </small>
                        </td>
                        <td>
                            <?php echo esc_html( $preset['description'] ); ?>
                            <br />
                            <small style="color:#666;">
                                <?php echo (int) strlen( $preset['description'] ); ?> chars
                            </small>
                        </td>
                        <td><code><?php echo esc_html( $preset['keyword'] ); ?></code></td>
                        <td>
                            <?php if ( ! $page_id ) : ?>
                                <span style="color:#b32d2e;">—</span>
                            <?php elseif ( $matches ) : ?>
                                <span style="color:#2a8d2a;">✓ <?php esc_html_e( 'in sync', 'tbone-construction' ); ?></span>
                            <?php else : ?>
                                <span style="color:#b58105;">● <?php esc_html_e( 'will overwrite', 'tbone-construction' ); ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p style="margin-top: 1.5em;">
            <small>
                <?php esc_html_e( 'Meta keys written:', 'tbone-construction' ); ?>
                <code><?php echo esc_html( implode( ', ', array_keys( $field_map ) ) ); ?></code>
            </small>
        </p>
    </div>
    <?php
}

/**
 * Make is_plugin_active() available before plugins.php has loaded.
 */
function tbc_seo_require_plugin_helpers(): void {
    if ( ! function_exists( 'is_plugin_active' ) ) {
        require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
}
add_action( 'admin_init', 'tbc_seo_require_plugin_helpers' );
