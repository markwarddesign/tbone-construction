<?php
declare( strict_types=1 );

/**
 * Auto-create the site's pages + primary menu on first theme activation.
 *
 * Idempotent: stores a flag in wp_options and skips on subsequent loads.
 * The "Create / Repair Site Pages" button in Theme Settings re-runs setup;
 * it will not overwrite the content of existing pages.
 */

const TBONE_CONSTRUCTION_SETUP_FLAG = 'tbone_construction_setup_complete';

function tbone_construction_pages_blueprint(): array {
    return [
        [ 'slug' => 'home',     'title' => 'Home',             'is_front' => true,  'content' => tbone_construction_seed_home()     ],
        [ 'slug' => 'about',    'title' => 'Our Story',        'is_front' => false, 'content' => tbone_construction_seed_about()    ],
        [ 'slug' => 'services', 'title' => 'Craft & Services', 'is_front' => false, 'content' => tbone_construction_seed_services() ],
        [ 'slug' => 'gallery',  'title' => 'Project Gallery',  'is_front' => false, 'content' => tbone_construction_seed_gallery()  ],
        [ 'slug' => 'reviews',  'title' => 'Local Reviews',    'is_front' => false, 'content' => tbone_construction_seed_reviews()  ],
        [ 'slug' => 'contact',  'title' => 'Contact',          'is_front' => false, 'content' => tbone_construction_seed_contact()  ],
    ];
}

function tbone_construction_seed_home(): string {
    return <<<HTML
<!-- wp:tbone-construction/hero /-->

<!-- wp:tbone-construction/trex-partnership /-->

<!-- wp:tbone-construction/services -->
<!-- wp:tbone-construction/service-card {"icon":"hammer","title":"Decks & Railings","description":"Premium Trex and TimberTech deck installations.","linkUrl":"/services"} /-->
<!-- wp:tbone-construction/service-card {"icon":"sun","title":"Canopies & Covers","description":"Durable outdoor oasis solutions for hot Idaho summers.","linkUrl":"/services"} /-->
<!-- wp:tbone-construction/service-card {"icon":"shield-check","title":"Siding Installation","description":"Vinyl, LP SmartSide, and Metal siding options.","linkUrl":"/services"} /-->
<!-- wp:tbone-construction/service-card {"icon":"ruler","title":"Window Replacements","description":"Improve comfort, appearance, and energy savings.","linkUrl":"/services"} /-->
<!-- wp:tbone-construction/service-card {"icon":"wrench","title":"Home Renovations","description":"Practical and stunning kitchen and bath updates.","linkUrl":"/services"} /-->
<!-- wp:tbone-construction/service-card {"icon":"trees","title":"Sheds & Greenhouses","description":"Custom structures for Idaho's unpredictable climate.","linkUrl":"/services"} /-->
<!-- /wp:tbone-construction/services -->

<!-- wp:tbone-construction/testimonial-quote /-->
HTML;
}

function tbone_construction_seed_about(): string {
    return '<!-- wp:tbone-construction/about-story /-->';
}

function tbone_construction_seed_services(): string {
    return <<<HTML
<!-- wp:tbone-construction/services-detail -->
<!-- wp:tbone-construction/service-row {"icon":"hammer","title":"Decks & Railings","description":"Deck building is our specialty. We work with Trex, TimberTech, Eva-Last, and Sylvanix. We finish projects with premium railing systems from RDI and Trex.","features":"TrexPro® Certified\\nCustom Layouts\\nPremium Railings\\nRainEscape® Systems"} /-->
<!-- wp:tbone-construction/service-row {"icon":"sun","title":"Canopies & Covers","description":"Idaho summers get hot. Create a unique outdoor oasis valuing durability that stands the test of time, from raw, rich, rough-sawn lumber to refined carpentry.","features":"Rough-sawn lumber\\nRefined Carpentry\\nCustom Shade Solutions"} /-->
<!-- wp:tbone-construction/service-row {"icon":"shield-check","title":"Siding Installation","description":"Whether you want vinyl with minimal maintenance, the warm authentic look of painted LP SmartSide, or tough metal, we have siding options to withstand weathering.","features":"Vinyl (Crack-resistant)\\nLP SmartSide (Engineered Wood)\\nMetal (Steel/Aluminum)"} /-->
<!-- wp:tbone-construction/service-row {"icon":"ruler","title":"Window Replacements","description":"New windows make a dramatic difference in comfort, appearance, and energy savings. We offer trusted brands from entry-level vinyl to high-end wood frames.","features":"Energy Efficient\\nVinyl to Wood Frames\\nDraft Elimination"} /-->
<!-- wp:tbone-construction/service-row {"icon":"wrench","title":"Home Renovations","description":"Full kitchen remodels, peaceful bathroom updates, or quick home refreshes — we make your vision practical and stunning.","features":"Kitchen Remodels\\nBathroom Updates\\nDesign Consultation"} /-->
<!-- wp:tbone-construction/service-row {"icon":"trees","title":"Sheds & Greenhouses","description":"We design and build customizable sheds that fit your space, style, and budget — plus durable greenhouses crafted to meet Idaho's unpredictable climate.","features":"Custom Sheds\\nDurable Greenhouses\\nWeather-resistant"} /-->
<!-- /wp:tbone-construction/services-detail -->
HTML;
}

function tbone_construction_seed_gallery(): string {
    return '<!-- wp:tbone-construction/gallery /-->';
}

/**
 * Sample Project posts created on first activation.
 * Editors manage these via Projects → All Projects.
 */
function tbone_construction_sample_projects(): array {
    return [
        [ 'title' => 'Trex Composite Deck',  'category' => 'Decks',       'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', 'content' => 'A premium Trex composite deck with white RDI railings. Engineered to handle Idaho temperature swings without warping or fading.' ],
        [ 'title' => 'Modern Siding',        'category' => 'Exteriors',   'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', 'content' => 'Full-home LP SmartSide installation with concealed fasteners for a clean modern look. Painted finish chosen with the homeowner.' ],
        [ 'title' => 'Kitchen Remodel',      'category' => 'Renovations', 'image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', 'content' => 'Top-to-bottom kitchen renovation. New cabinetry, quartz counters, custom island, and energy-efficient lighting throughout.' ],
        [ 'title' => 'Covered Patio',        'category' => 'Decks',       'image' => 'https://images.unsplash.com/photo-1605810730635-1d898e826b15?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', 'content' => 'Rough-sawn lumber covered patio designed for shade and durability in hot Idaho summers.' ],
        [ 'title' => 'Window Replacement',   'category' => 'Exteriors',   'image' => 'https://images.unsplash.com/photo-1510627498534-fc0280eb4cd8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', 'content' => 'Whole-home window replacement with energy-efficient vinyl frames. Eliminated drafts and significantly improved heating costs.' ],
        [ 'title' => 'Bathroom Update',      'category' => 'Renovations', 'image' => 'https://images.unsplash.com/photo-1589939705384-5185137a7f0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80', 'content' => 'Peaceful bathroom refresh with new fixtures, tilework, and improved storage.' ],
    ];
}

function tbone_construction_seed_projects(): void {
    // Only seed if no projects exist yet.
    $existing = get_posts( [ 'post_type' => 'tbc_project', 'posts_per_page' => 1, 'fields' => 'ids' ] );
    if ( $existing ) return;

    foreach ( tbone_construction_sample_projects() as $project ) {
        $pid = wp_insert_post( [
            'post_type'    => 'tbc_project',
            'post_status'  => 'publish',
            'post_title'   => $project['title'],
            'post_content' => $project['content'],
        ], true );
        if ( is_wp_error( $pid ) || ! $pid ) continue;

        wp_set_object_terms( $pid, [ $project['category'] ], 'tbc_project_category', false );

        // Note: we store the remote image URL on a private meta key. Users can replace
        // the featured image via the editor — this just gives the lightbox something
        // to display on day one.
        update_post_meta( $pid, '_tbc_remote_image_url', esc_url_raw( $project['image'] ) );
    }
}

function tbone_construction_seed_reviews(): string {
    return <<<HTML
<!-- wp:tbone-construction/reviews-grid -->
<!-- wp:tbone-construction/review-card {"name":"Bart Schuerman","date":"10/10/2024","rating":5,"text":"This is my third Trex project with Travis. He is dependable efficient honest and does top quality work."} /-->
<!-- wp:tbone-construction/review-card {"name":"Trex Customer","date":"7/3/2024","rating":5,"text":"Knowledge of installation was incredible. Travis explains the steps necessary and was accurate about how long the project would take."} /-->
<!-- wp:tbone-construction/review-card {"name":"Lu Ann Gergen","date":"1/17/2024","rating":5,"text":"Professionalism, Quality"} /-->
<!-- wp:tbone-construction/review-card {"name":"Jose Rincon","date":"12/11/2023","rating":5,"text":"Travis came through. His work was great, he was very attentive and listened to all my concerns."} /-->
<!-- wp:tbone-construction/review-card {"name":"Karen Baldrige","date":"2/16/2023","rating":5,"text":"Travis with T-Bone Construction is very professional, timely and priced very fairly."} /-->
<!-- wp:tbone-construction/review-card {"name":"Thomas Stears","date":"1/30/2023","rating":5,"text":"Did good."} /-->
<!-- wp:tbone-construction/review-card {"name":"Home Depot Referral","date":"5/26/2022","rating":5,"text":"The fence is done well. It looks great and he put in a gate. It was completed in the time frame he stated (2 days)."} /-->
<!-- wp:tbone-construction/review-card {"name":"Robert Humphrey","date":"2/25/2022","rating":5,"text":"He replied even before we got home from the store! He has been very congenial and has worked hard to accommodate our budget."} /-->
<!-- wp:tbone-construction/review-card {"name":"Rick Sandison, MD","date":"1/2/2022","rating":5,"text":"Travis did a great job. He is a very friendly person. I thought the price of his work was fair."} /-->
<!-- wp:tbone-construction/review-card {"name":"Tangela Schuerman","date":"11/13/2021","rating":5,"text":"Great Work. His attention to detail is spot on. He is very thorough with his job and makes sure you are happy."} /-->
<!-- /wp:tbone-construction/reviews-grid -->
HTML;
}

function tbone_construction_seed_contact(): string {
    return '<!-- wp:tbone-construction/contact /-->';
}

function tbone_construction_run_setup( bool $force = false ): array {
    if ( ! $force && get_option( TBONE_CONSTRUCTION_SETUP_FLAG ) ) {
        return [ 'created' => [], 'skipped' => true ];
    }

    $created  = [];
    $page_ids = [];
    $front_id = 0;

    foreach ( tbone_construction_pages_blueprint() as $page ) {
        $existing = get_page_by_path( $page['slug'], OBJECT, 'page' );

        if ( $existing instanceof WP_Post ) {
            $page_ids[ $page['slug'] ] = $existing->ID;
            if ( $page['is_front'] ) {
                $front_id = $existing->ID;
            }
            continue;
        }

        $id = wp_insert_post( [
            'post_title'   => $page['title'],
            'post_name'    => $page['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => $page['content'],
            'post_author'  => get_current_user_id() ?: 1,
        ], true );

        if ( ! is_wp_error( $id ) && $id ) {
            $page_ids[ $page['slug'] ] = $id;
            $created[]                 = $page['slug'];
            if ( $page['is_front'] ) {
                $front_id = $id;
            }
        }
    }

    if ( $front_id ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $front_id );
    }

    // Primary menu — auto-create + assign to primary + footer locations.
    $menu_name = 'Primary';
    $menu      = wp_get_nav_menu_object( $menu_name );
    if ( ! $menu ) {
        $menu_id = wp_create_nav_menu( $menu_name );
        if ( ! is_wp_error( $menu_id ) ) {
            $menu = wp_get_nav_menu_object( $menu_id );
        }
    }

    if ( $menu instanceof WP_Term ) {
        $existing_items = wp_get_nav_menu_items( $menu->term_id ) ?: [];
        $existing_objs  = array_map( static fn( $i ) => (int) $i->object_id, $existing_items );

        foreach ( tbone_construction_pages_blueprint() as $page ) {
            if ( 'home' === $page['slug'] ) continue;
            $pid = $page_ids[ $page['slug'] ] ?? 0;
            if ( ! $pid || in_array( $pid, $existing_objs, true ) ) continue;

            wp_update_nav_menu_item( $menu->term_id, 0, [
                'menu-item-title'     => $page['title'],
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $pid,
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
            ] );
        }

        $locations              = get_theme_mod( 'nav_menu_locations', [] );
        $locations['primary']   = $menu->term_id;
        $locations['footer']    = $locations['footer'] ?? $menu->term_id;
        set_theme_mod( 'nav_menu_locations', $locations );
    }

    // Seed example Project posts (first time only).
    tbone_construction_seed_projects();

    // Flush rewrites so /projects/{slug} permalinks work immediately.
    flush_rewrite_rules( false );

    update_option( TBONE_CONSTRUCTION_SETUP_FLAG, time() );

    return [ 'created' => $created, 'skipped' => false ];
}

add_action( 'after_switch_theme', static function (): void {
    tbone_construction_run_setup();
} );

add_action( 'admin_post_tbone_construction_reset_setup', static function (): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Forbidden', 403 );
    }
    check_admin_referer( 'tbone_construction_reset_setup' );

    $result = tbone_construction_run_setup( true );

    $url = add_query_arg( [
        'page'             => 'tbone-construction-settings',
        'tbone-setup-done' => count( $result['created'] ),
    ], admin_url( 'themes.php' ) );

    wp_safe_redirect( $url );
    exit;
} );
