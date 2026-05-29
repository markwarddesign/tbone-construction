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
    $img1 = esc_url( tbc_image( 'Canyonmasterdeck.jpg', 'large' ) );
    $img2 = esc_url( tbc_image( 'Twostorydeck.jpg',     'large' ) );

    $hero_attrs = wp_json_encode( [
        'badge'            => 'Built for Idaho Weather',
        'headingTop'       => "Crafting Idaho's",
        'headingAccent'    => 'Outdoor Spaces',
        'body'             => 'With over 25 years of hands-on experience, we help Idaho families create beautiful, functional homes — starting with outdoor living spaces, covered patios, decks and railings. Projects tailored to your budget and lifestyle.',
        'primaryCtaText'   => 'Discuss Your Project',
        'primaryCtaUrl'    => '/contact',
        'secondaryCtaText' => 'View Our Craft',
        'secondaryCtaUrl'  => '/services',
        'image1Url'        => $img1,
        'image2Url'        => $img2,
    ] );

    return <<<HTML
<!-- wp:tbone-construction/hero {$hero_attrs} /-->

<!-- wp:tbone-construction/trex-partnership /-->

<!-- wp:tbone-construction/services -->
<!-- wp:tbone-construction/service-card {"icon":"hammer","title":"Decks & Railings","description":"Trex, TimberTech, Eva-Last, and Sylvanix decks — finished with RDI and Trex railings.","linkUrl":"/services/decks"} /-->
<!-- wp:tbone-construction/service-card {"icon":"sun","title":"Canopies & Covers","description":"Outdoor oasis solutions for hot Idaho summers — rough-sawn lumber to refined carpentry.","linkUrl":"/services/canopies"} /-->
<!-- wp:tbone-construction/service-card {"icon":"shield-check","title":"Siding Installation","description":"Vinyl, LP SmartSide, and metal siding — built to withstand Idaho weather.","linkUrl":"/services/siding"} /-->
<!-- wp:tbone-construction/service-card {"icon":"ruler","title":"Window Replacements","description":"Improve comfort, appearance, and energy savings from vinyl to wood frames.","linkUrl":"/services/windows"} /-->
<!-- wp:tbone-construction/service-card {"icon":"wrench","title":"Home Renovations","description":"Full kitchen remodels, bathroom updates, and whole-home refreshes.","linkUrl":"/services/renovations"} /-->
<!-- wp:tbone-construction/service-card {"icon":"trees","title":"Sheds & Greenhouses","description":"Customizable sheds and durable greenhouses built for Idaho's climate.","linkUrl":"/services/sheds"} /-->
<!-- /wp:tbone-construction/services -->

<!-- wp:tbone-construction/testimonial-quote /-->
HTML;
}

function tbone_construction_seed_about(): string {
    $img = esc_url( tbc_image( 'Familyphoto.JPG', 'large' ) ?: tbc_image( 'Customframing.jpeg', 'large' ) );

    $attrs = wp_json_encode( [
        'heading'      => 'Our Story & Approach',
        'subheading'   => 'Professional. Reliable. Built for Idaho.',
        'para1'        => 'With over <strong>25 years of hands-on experience</strong>, we help Idaho families create beautiful, functional homes — starting with outdoor living spaces, covered patios, decks and railings. We also handle window replacements, home renovations, siding installation, and shed builds.',
        'para2'        => "All completed with the same craftsmanship and warranty backing suited for Idaho's tough weather. Projects are tailored specifically to your budget and lifestyle.",
        'badgeTitle'   => 'Licensed & Insured',
        'badgeBody'    => 'We are committed to making your vision a reality. Ready to upgrade your home? Contact us for a free, no-obligation consultation — we are excited to discuss your project.',
        'ctaText'      => 'Schedule a Consultation',
        'ctaUrl'       => '/contact',
        'imageUrl'     => $img,
        'imageAlt'     => 'T-Bone Construction',
        'trexTitle'    => 'TrexPro® Partner',
        'trexBody'     => "As a TrexPro® professional and the area's only certified Trex RainEscape® installer, we offer a range of composite decking brands to match your preferences. Our RainEscape drainage system creates dry, usable space beneath your deck.",
        'trexLinkText' => 'Order Trex Samples',
        'trexLinkUrl'  => 'https://www.trex.com',
    ] );

    return "<!-- wp:tbone-construction/about-story {$attrs} /-->";
}

function tbone_construction_seed_services(): string {
    $rows = [
        [
            'icon'        => 'hammer',
            'title'       => 'Decks & Railings',
            'description' => 'Deck building is our specialty. We work with Trex, TimberTech, Eva-Last, and Sylvanix. We finish projects with premium railing systems from RDI and Trex.',
            'features'    => "TrexPro® Certified\nCustom Layouts\nRDI & Trex Railings\nRainEscape® Drainage",
            'image'       => 'Canyondeck.jpg',
        ],
        [
            'icon'        => 'sun',
            'title'       => 'Canopies & Covers',
            'description' => 'Our canopy services complement your needs. Idaho summers can get pretty hot, so we can create a unique outdoor oasis — valuing durability that stands the test of time. From raw, rich, rough-sawn lumber to refined carpentry.',
            'features'    => "Rough-sawn lumber\nRefined carpentry finishes\nCustom shade solutions",
            'image'       => 'Foggywharfdeck.jpeg',
        ],
        [
            'icon'        => 'shield-check',
            'title'       => 'Siding Installation',
            'description' => 'Whether you want vinyl with minimal maintenance, the warm authentic look of painted LP SmartSide, or tough metal, we have siding options to withstand weathering.',
            'features'    => "Vinyl (crack-resistant)\nLP SmartSide (engineered wood)\nMetal (steel/aluminum/insulated)",
            'image'       => '',
        ],
        [
            'icon'        => 'ruler',
            'title'       => 'Window Replacements',
            'description' => 'When you are updating your home, adding new siding, renovating your kitchen or bathroom, or completing a full refresh, new windows can make a dramatic difference in comfort, appearance, and energy savings. We offer a full range of replacement windows by trusted brands — entry-level vinyl through high-end wood frames.',
            'features'    => "Energy-efficient frames\nVinyl through to wood options\nDraft elimination",
            'image'       => '',
        ],
        [
            'icon'        => 'wrench',
            'title'       => 'Home Renovations',
            'description' => 'Whether you want a full kitchen remodel, a peaceful bathroom update, or a quick home refresh, we make your vision practical and stunning. Starting with the first consultation we guide you through design choices and materials to match your style.',
            'features'    => "Kitchen remodels\nBathroom updates\nDesign consultation",
            'image'       => 'Accentwall.jpeg',
        ],
        [
            'icon'        => 'trees',
            'title'       => 'Sheds & Greenhouses',
            'description' => "We design and build customizable sheds that fit your space, style, and budget. Idaho's unpredictable climate demands a more durable greenhouse — crafted with materials to meet your budget.",
            'features'    => "Custom sheds\nDurable greenhouses\nWeather-resistant build",
            'image'       => 'Shed.jpeg',
        ],
    ];

    $out = "<!-- wp:tbone-construction/services-detail -->\n";
    foreach ( $rows as $r ) {
        $attrs = [
            'icon'        => $r['icon'],
            'title'       => $r['title'],
            'description' => $r['description'],
            'features'    => $r['features'],
        ];
        if ( $r['image'] ) {
            $url = tbc_image( $r['image'], 'large' );
            if ( $url ) {
                $attrs['imageUrl'] = $url;
                $attrs['imageAlt'] = $r['title'];
            }
        }
        $out .= '<!-- wp:tbone-construction/service-row ' . wp_json_encode( $attrs ) . " /-->\n";
    }
    $out .= "<!-- /wp:tbone-construction/services-detail -->";
    return $out;
}

function tbone_construction_seed_gallery(): string {
    return '<!-- wp:tbone-construction/gallery /-->';
}

/**
 * Real T-Bone project posts, mapped to images you've uploaded to the Media Library.
 * Featured image = first filename. Additional filenames go into the project's gallery meta box.
 * Editors manage these via Projects → All Projects.
 */
function tbone_construction_sample_projects(): array {
    return [
        [
            'title'    => 'Canyon Master Deck',
            'category' => 'Decks',
            'images'   => [ 'Canyonmasterdeck.jpg', 'Canyonmasterdeck 2.jpg', 'Canyon.jpeg', 'Canyon2.jpeg' ],
            'content'  => 'A multi-level composite deck overlooking the canyon. Custom layout finished with premium railing — engineered to handle Idaho temperature swings without warping or fading.',
        ],
        [
            'title'    => 'Two-Story Deck',
            'category' => 'Decks',
            'images'   => [ 'Twostorydeck.jpg', 'twostorydeckframing.jpeg', 'deckframing.jpeg' ],
            'content'  => 'A full two-story deck with custom framing and white railings. Built top to bottom with attention to load engineering and clean structural lines.',
        ],
        [
            'title'    => 'Foggy Wharf Deck',
            'category' => 'Decks',
            'images'   => [ 'Foggywharfdeck.jpeg', 'foggywarfdeck2.jpeg' ],
            'content'  => 'Trex composite deck with picture-frame border detailing. Sized for entertaining and built for weather.',
        ],
        [
            'title'    => 'Pebble Grey Deck',
            'category' => 'Decks',
            'images'   => [ 'Pebblegreydeck.jpeg', 'Pebblegreydeck2.jpeg' ],
            'content'  => 'Pebble-grey composite deck with low-profile railings — a clean, modern outdoor living space.',
        ],
        [
            'title'    => 'Lake Dock',
            'category' => 'Decks',
            'images'   => [ 'Lakedock.jpeg' ],
            'content'  => 'A custom lake dock built for years of family memories on the water.',
        ],
        [
            'title'    => 'River Deck',
            'category' => 'Decks',
            'images'   => [ 'Riverdeck.jpg' ],
            'content'  => 'Riverside deck designed around the existing landscape — finished with weather-resistant materials.',
        ],
        [
            'title'    => 'Rock Harbor Deck',
            'category' => 'Decks',
            'images'   => [ 'Rockharbordeck.jpg' ],
            'content'  => 'Rock Harbor build featuring custom railings and a long, generous footprint for outdoor living.',
        ],
        [
            'title'    => 'Spice Drum Deck',
            'category' => 'Decks',
            'images'   => [ 'Spicedrumdeck.jpeg' ],
            'content'  => 'Spice-drum composite color with crisp white railing posts — a warm, inviting palette.',
        ],
        [
            'title'    => 'Custom Greenhouse',
            'category' => 'Sheds & Greenhouses',
            'images'   => [ 'Greenhouse.jpeg', 'Greenhouseinside.jpeg' ],
            'content'  => "Idaho's unpredictable climate demands a more durable greenhouse — crafted with materials chosen to handle spring snow through summer heat.",
        ],
        [
            'title'    => 'Custom Shed',
            'category' => 'Sheds & Greenhouses',
            'images'   => [ 'Shed.jpeg', 'Shedinside.jpeg' ],
            'content'  => 'Customizable shed sized for your space, style, and budget — finished with attention to detail inside and out.',
        ],
        [
            'title'    => 'Compact Garden Shed',
            'category' => 'Sheds & Greenhouses',
            'images'   => [ 'Smallshed.jpeg', 'Smallshedsideview.jpeg' ],
            'content'  => 'A compact garden shed with a clean exterior and the durability to outlast harsh weather.',
        ],
        [
            'title'    => 'Accent Wall Renovation',
            'category' => 'Renovations',
            'images'   => [ 'Accentwall.jpeg' ],
            'content'  => 'Custom interior accent wall — designed and finished with the homeowner to transform a single feature space.',
        ],
        [
            'title'    => 'Custom Framing',
            'category' => 'Renovations',
            'images'   => [ 'Customframing.jpeg' ],
            'content'  => 'Inside-the-walls craftsmanship — clean, square, plumb framing as the foundation of everything that follows.',
        ],
        [
            'title'    => 'Parade of Homes Finish Work',
            'category' => 'Renovations',
            'images'   => [ 'paradeofhomesfinishingwork.jpeg', 'finishingwork.jpeg' ],
            'content'  => 'Detail-driven finish work completed for a Parade of Homes feature build.',
        ],
    ];
}

function tbone_construction_seed_projects(): void {
    // Idempotent — skip if any tbc_project posts exist.
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

        // Resolve image filenames to attachment IDs.
        $ids = [];
        foreach ( $project['images'] as $filename ) {
            $att = tbc_image_id( $filename );
            if ( $att ) $ids[] = $att;
        }

        if ( $ids ) {
            // First image becomes the featured image.
            set_post_thumbnail( $pid, $ids[0] );
            // Remaining go into the project's gallery meta box.
            $extras = array_slice( $ids, 1 );
            if ( $extras ) {
                update_post_meta( $pid, '_tbc_gallery_ids', implode( ',', $extras ) );
            }
        }
    }
}

/** Wipe all tbc_project posts (and their meta) so reseeding can run clean. */
function tbone_construction_wipe_projects(): int {
    $ids = get_posts( [
        'post_type'      => 'tbc_project',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
    ] );
    foreach ( $ids as $id ) {
        wp_delete_post( (int) $id, true );
    }
    delete_option( 'tbone_construction_projects_seeded' );
    return count( $ids );
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

/**
 * Seed the /areas parent page + one child page per Magic Valley city, each
 * holding an area-landing block bound to that city's slug. Idempotent.
 *
 * Returns the parent page ID (0 on failure) so the caller can wire up the menu.
 */
function tbone_construction_seed_area_pages(): int {
    if ( ! function_exists( 'tbc_areas' ) ) {
        return 0;
    }

    // Parent /areas page.
    $parent = get_page_by_path( 'areas', OBJECT, 'page' );
    if ( $parent instanceof WP_Post ) {
        $parent_id = (int) $parent->ID;
    } else {
        $parent_id = (int) wp_insert_post( [
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => 'Areas We Serve',
            'post_name'    => 'areas',
            'post_content' => tbone_construction_seed_areas_index(),
        ] );
    }
    if ( $parent_id <= 0 ) {
        return 0;
    }

    foreach ( tbc_areas() as $slug => $area ) {
        $existing = get_posts( [
            'post_type'      => 'page',
            'name'           => $slug,
            'post_parent'    => $parent_id,
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'post_status'    => 'any',
        ] );
        if ( $existing ) continue;

        wp_insert_post( [
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $area['name'],
            'post_name'    => $slug,
            'post_parent'  => $parent_id,
            'post_content' => sprintf(
                '<!-- wp:tbone-construction/area-landing {"areaSlug":"%s"} /-->',
                esc_js( $slug )
            ),
        ] );
    }

    return $parent_id;
}

/** Content for the /areas index page — intro + a card link per city. */
function tbone_construction_seed_areas_index(): string {
    $cards = '';
    foreach ( tbc_areas() as $slug => $area ) {
        $cards .= sprintf(
            '<!-- wp:paragraph --><p><a href="/areas/%1$s"><strong>%2$s</strong></a> — %3$s</p><!-- /wp:paragraph -->',
            esc_attr( $slug ),
            esc_html( $area['name'] ),
            esc_html( $area['county'] )
        );
    }

    return <<<HTML
<!-- wp:group {"tagName":"section","className":"py-16 bg-[#faf8f5]"} -->
<section class="wp-block-group py-16 bg-[#faf8f5]">
<!-- wp:group {"className":"max-w-5xl mx-auto px-4 sm:px-6 lg:px-8"} -->
<div class="wp-block-group max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
<!-- wp:paragraph {"className":"text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2"} -->
<p class="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">Areas We Serve</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1,"className":"text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-8"} -->
<h1 class="wp-block-heading text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-8">Serving the Magic Valley</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"className":"text-xl text-stone-600 font-medium leading-relaxed mb-10"} -->
<p class="text-xl text-stone-600 font-medium leading-relaxed mb-10">Based in Twin Falls, T-Bone Construction builds custom decks, siding, canopies, windows, and renovations for homeowners across the Magic Valley. Choose your city below.</p>
<!-- /wp:paragraph -->
{$cards}
</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
HTML;
}

/**
 * Attach the /areas pages as a nested "Areas We Serve" group in the menu.
 * Idempotent — skips pages already present.
 */
function tbone_construction_attach_area_submenu( int $menu_id, int $areas_page_id ): int {
    if ( $areas_page_id <= 0 || ! function_exists( 'tbc_areas' ) ) {
        return 0;
    }

    $items = wp_get_nav_menu_items( $menu_id ) ?: [];

    // Find (or create) the top-level item pointing at the /areas page.
    $parent_menu_item_id = 0;
    foreach ( $items as $item ) {
        if ( (int) $item->object_id === $areas_page_id && 'page' === $item->object ) {
            $parent_menu_item_id = (int) $item->ID;
            break;
        }
    }
    if ( ! $parent_menu_item_id ) {
        $parent_menu_item_id = (int) wp_update_nav_menu_item( $menu_id, 0, [
            'menu-item-title'     => 'Areas We Serve',
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $areas_page_id,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
    }
    if ( $parent_menu_item_id <= 0 ) {
        return 0;
    }

    $present_object_ids = array_map( static fn( $i ) => (int) $i->object_id, $items );

    $added = 0;
    foreach ( tbc_areas() as $slug => $area ) {
        $page = get_posts( [
            'post_type'      => 'page',
            'name'           => $slug,
            'post_parent'    => $areas_page_id,
            'posts_per_page' => 1,
            'post_status'    => 'any',
        ] );
        if ( ! $page ) continue;

        $page_id = (int) $page[0]->ID;
        if ( in_array( $page_id, $present_object_ids, true ) ) continue;

        $result = wp_update_nav_menu_item( $menu_id, 0, [
            'menu-item-title'     => $area['name'],
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $page_id,
            'menu-item-parent-id' => $parent_menu_item_id,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
        if ( ! is_wp_error( $result ) ) {
            $added++;
        }
    }
    return $added;
}

/**
 * Blueprint for the six service sub-pages (/services/{slug}).
 * Each gets its own permalink, hero, body, features list, and CTA.
 */
function tbone_construction_service_subpages(): array {
    return [
        [
            'slug'        => 'decks',
            'title'       => 'Decks & Railings',
            'lede'        => 'Premium Trex and TimberTech deck installations, finished with RDI and Trex railing systems.',
            'description' => 'Deck building is our specialty. We work with Trex, TimberTech, Eva-Last, and Sylvanix — composite materials engineered to outlast traditional wood. Every project is finished with premium railing systems from RDI and Trex, and we are the area\'s only certified Trex RainEscape installer for dry under-deck space.',
            'features'    => [ 'TrexPro® Certified Installer', 'Custom Layouts & Design', 'Premium RDI & Trex Railings', 'Trex RainEscape® Drainage' ],
        ],
        [
            'slug'        => 'canopies',
            'title'       => 'Canopies & Covers',
            'lede'        => 'Durable outdoor oasis solutions built for hot Idaho summers.',
            'description' => 'Idaho summers get hot. We design and build covered patios, canopies, and shade structures that hold up to weather and time — from raw, rich, rough-sawn lumber to refined finish carpentry. Every project is built specifically for your space, sun angles, and the way you actually use your yard.',
            'features'    => [ 'Rough-sawn lumber options', 'Refined carpentry finishes', 'Custom shade solutions', 'Built for Idaho weather' ],
        ],
        [
            'slug'        => 'siding',
            'title'       => 'Siding Installation',
            'lede'        => 'Vinyl, LP SmartSide, and metal siding — built to withstand weathering.',
            'description' => 'Whether you want vinyl with minimal maintenance, the warm authentic look of painted LP SmartSide, or tough metal panels for the harshest conditions, we have siding options to fit your home and your budget. We handle every step from material selection to weather-tight installation.',
            'features'    => [ 'Vinyl — crack-resistant in cold, fade-resistant in sun', 'LP SmartSide — engineered wood, paintable, insect-resistant', 'Metal — steel, aluminum, and insulated panels', 'Concealed-fastener modern installs' ],
        ],
        [
            'slug'        => 'windows',
            'title'       => 'Window Replacements',
            'lede'        => 'Improve comfort, appearance, and energy savings with new windows.',
            'description' => 'When you are updating your home, adding new siding, renovating a kitchen or bathroom, or completing a full refresh, new windows can make a dramatic difference. We offer trusted brands from entry-level vinyl frames to high-end wood — sized and installed to eliminate drafts and lower heating costs.',
            'features'    => [ 'Energy-efficient frames', 'Vinyl through to wood options', 'Draft and air-leak elimination', 'Whole-home or one-room installs' ],
        ],
        [
            'slug'        => 'renovations',
            'title'       => 'Home Renovations',
            'lede'        => 'Practical and stunning kitchen, bath, and whole-home updates.',
            'description' => 'Whether you want a full kitchen remodel, a peaceful bathroom update, or a quick home refresh, we make your vision practical and stunning. Starting with the first consultation we guide you through design choices, materials, and finishes that match your style and your budget.',
            'features'    => [ 'Kitchen remodels', 'Bathroom updates', 'Whole-home refreshes', 'Design consultation included' ],
        ],
        [
            'slug'        => 'sheds',
            'title'       => 'Sheds & Greenhouses',
            'lede'        => "Custom structures built for Idaho's unpredictable climate.",
            'description' => 'We design and build customizable sheds that fit your space, style, and budget. We also build durable greenhouses, crafted with materials chosen to meet your budget and handle Idaho\'s unpredictable climate — from spring snow to summer heat.',
            'features'    => [ 'Custom shed sizing', 'Durable greenhouse construction', 'Weather-resistant materials', 'Matched to your home\'s aesthetic' ],
        ],
    ];
}

function tbone_construction_service_subpage_content( array $service ): string {
    $features_html = '';
    foreach ( $service['features'] as $f ) {
        $features_html .= '<li>' . esc_html( $f ) . '</li>';
    }
    $lede        = esc_html( $service['lede'] );
    $description = esc_html( $service['description'] );

    return <<<HTML
<!-- wp:group {"tagName":"section","className":"py-16 bg-[#faf8f5]"} -->
<section class="wp-block-group py-16 bg-[#faf8f5]">
<!-- wp:group {"className":"max-w-5xl mx-auto px-4 sm:px-6 lg:px-8"} -->
<div class="wp-block-group max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

<!-- wp:paragraph {"className":"text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2"} -->
<p class="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">Our Services</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-8"} -->
<h1 class="wp-block-heading text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-8">{$service['title']}</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"text-xl text-stone-600 font-medium leading-relaxed mb-8"} -->
<p class="text-xl text-stone-600 font-medium leading-relaxed mb-8">{$lede}</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"text-lg text-stone-700 leading-relaxed mb-10"} -->
<p class="text-lg text-stone-700 leading-relaxed mb-10">{$description}</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":2,"className":"text-2xl font-serif text-stone-900 mb-4"} -->
<h2 class="wp-block-heading text-2xl font-serif text-stone-900 mb-4">What's included</h2>
<!-- /wp:heading -->

<!-- wp:list {"className":"text-stone-700 leading-relaxed mb-10 space-y-2"} -->
<ul class="wp-block-list text-stone-700 leading-relaxed mb-10 space-y-2">{$features_html}</ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-fill"} -->
<div class="wp-block-button is-style-fill"><a class="wp-block-button__link wp-element-button" href="/contact" style="background-color:#c25e24;color:#ffffff;border:2px solid #c25e24;padding:14px 28px;font-weight:700">Get a Free Estimate</a></div>
<!-- /wp:button -->
<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
</section>
<!-- /wp:group -->
HTML;
}

/**
 * Add the six service sub-pages as submenu items under the "Craft & Services"
 * top-level menu item. Idempotent — skips items already present.
 */
function tbone_construction_attach_service_submenu( int $menu_id, int $services_page_id ): int {
    $items = wp_get_nav_menu_items( $menu_id ) ?: [];

    // Find the menu item that points at the Services page (the parent we'll nest under).
    $parent_menu_item_id = 0;
    foreach ( $items as $item ) {
        if ( (int) $item->object_id === $services_page_id && 'page' === $item->object ) {
            $parent_menu_item_id = (int) $item->ID;
            break;
        }
    }
    if ( ! $parent_menu_item_id ) {
        return 0;
    }

    // IDs already in this menu (any depth) so we don't duplicate.
    $present_object_ids = array_map( static fn( $i ) => (int) $i->object_id, $items );

    $added = 0;
    foreach ( tbone_construction_service_subpages() as $service ) {
        $page = get_posts( [
            'post_type'      => 'page',
            'name'           => $service['slug'],
            'post_parent'    => $services_page_id,
            'posts_per_page' => 1,
            'post_status'    => 'any',
        ] );
        if ( ! $page ) continue;

        $page_id = (int) $page[0]->ID;
        if ( in_array( $page_id, $present_object_ids, true ) ) continue;

        $result = wp_update_nav_menu_item( $menu_id, 0, [
            'menu-item-title'     => $service['title'],
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $page_id,
            'menu-item-parent-id' => $parent_menu_item_id,
            'menu-item-type'      => 'post_type',
            'menu-item-status'    => 'publish',
        ] );
        if ( ! is_wp_error( $result ) ) {
            $added++;
        }
    }
    return $added;
}

function tbone_construction_seed_service_subpages( int $services_page_id ): array {
    $created = [];
    if ( $services_page_id <= 0 ) return $created;

    foreach ( tbone_construction_service_subpages() as $service ) {
        // Look for an existing child with the right slug.
        $existing = get_posts( [
            'post_type'      => 'page',
            'name'           => $service['slug'],
            'post_parent'    => $services_page_id,
            'posts_per_page' => 1,
            'fields'         => 'ids',
            'post_status'    => 'any',
        ] );
        if ( $existing ) continue;

        $id = wp_insert_post( [
            'post_type'    => 'page',
            'post_status'  => 'publish',
            'post_title'   => $service['title'],
            'post_name'    => $service['slug'],
            'post_parent'  => $services_page_id,
            'post_content' => tbone_construction_service_subpage_content( $service ),
        ], true );

        if ( ! is_wp_error( $id ) && $id ) {
            $created[] = $service['slug'];
        }
    }
    return $created;
}

function tbone_construction_run_setup( bool $force = false, bool $overwrite_content = false ): array {
    if ( ! $force && get_option( TBONE_CONSTRUCTION_SETUP_FLAG ) ) {
        return [ 'created' => [], 'updated' => [], 'subpages' => [], 'skipped' => true ];
    }

    $created  = [];
    $updated  = [];
    $page_ids = [];
    $front_id = 0;

    foreach ( tbone_construction_pages_blueprint() as $page ) {
        $existing = get_page_by_path( $page['slug'], OBJECT, 'page' );

        if ( $existing instanceof WP_Post ) {
            $page_ids[ $page['slug'] ] = $existing->ID;
            if ( $page['is_front'] ) {
                $front_id = $existing->ID;
            }

            // Re-seed body content if explicitly requested.
            if ( $overwrite_content ) {
                wp_update_post( [
                    'ID'           => $existing->ID,
                    'post_content' => $page['content'],
                    'post_status'  => 'publish',
                ] );
                $updated[] = $page['slug'];
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

    // Seed individual service sub-pages under /services/{slug}.
    $services_id = $page_ids['services'] ?? 0;
    $subpages    = tbone_construction_seed_service_subpages( $services_id );

    // Attach the sub-pages as submenu items under "Craft & Services" in the Primary menu.
    if ( $menu instanceof WP_Term && $services_id > 0 ) {
        tbone_construction_attach_service_submenu( $menu->term_id, $services_id );
    }

    // Seed /areas + per-city landing pages and nest them in the Primary menu.
    $areas_id = tbone_construction_seed_area_pages();
    if ( $menu instanceof WP_Term && $areas_id > 0 ) {
        tbone_construction_attach_area_submenu( $menu->term_id, $areas_id );
    }

    // Seed example Project posts (idempotent — short-circuits if any tbc_project exists).
    tbone_construction_seed_projects();

    // Flush rewrites so new permalinks (sub-pages, /projects/{slug}) work immediately.
    flush_rewrite_rules( false );

    update_option( TBONE_CONSTRUCTION_SETUP_FLAG, time() );

    return [ 'created' => $created, 'updated' => $updated, 'subpages' => $subpages, 'skipped' => false ];
}

add_action( 'after_switch_theme', static function (): void {
    tbone_construction_run_setup();
} );

/**
 * Independent auto-seed for sample Projects. Runs once on the first admin page
 * load after activation (or after this code is deployed) and is idempotent —
 * `tbone_construction_seed_projects()` itself short-circuits if any tbc_project
 * posts already exist.
 */
add_action( 'admin_init', static function (): void {
    if ( get_option( 'tbone_construction_projects_seeded' ) ) {
        return;
    }
    if ( ! post_type_exists( 'tbc_project' ) ) {
        return; // CPT not registered yet (early-init edge case).
    }
    tbone_construction_seed_projects();
    update_option( 'tbone_construction_projects_seeded', time() );
} );

add_action( 'admin_post_tbone_construction_reset_setup', static function (): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Forbidden', 403 );
    }
    check_admin_referer( 'tbone_construction_reset_setup' );

    $result = tbone_construction_run_setup( true, false );

    $url = add_query_arg( [
        'page'             => 'tbone-construction-settings',
        'tbone-setup-done' => count( $result['created'] ),
        'tbone-subpages'   => count( $result['subpages'] ),
    ], admin_url( 'themes.php' ) );

    wp_safe_redirect( $url );
    exit;
} );

/**
 * Standalone runner for the /areas pages — seeds the parent + per-city pages
 * and nests them in the Primary menu, without touching the main marketing
 * pages or projects. Idempotent. Returns the number of city pages created.
 */
function tbone_construction_run_area_setup(): int {
    if ( ! function_exists( 'tbc_areas' ) ) {
        return 0;
    }

    // Count existing city child pages before seeding so we can report new ones.
    $before = 0;
    $parent = get_page_by_path( 'areas', OBJECT, 'page' );
    if ( $parent instanceof WP_Post ) {
        foreach ( tbc_areas() as $slug => $area ) {
            if ( get_posts( [
                'post_type'      => 'page',
                'name'           => $slug,
                'post_parent'    => $parent->ID,
                'posts_per_page' => 1,
                'fields'         => 'ids',
                'post_status'    => 'any',
            ] ) ) {
                $before++;
            }
        }
    }

    $areas_id = tbone_construction_seed_area_pages();

    $menu = wp_get_nav_menu_object( 'Primary' );
    if ( $menu instanceof WP_Term && $areas_id > 0 ) {
        tbone_construction_attach_area_submenu( $menu->term_id, $areas_id );
    }

    flush_rewrite_rules( false );

    return max( 0, count( tbc_areas() ) - $before );
}

add_action( 'admin_post_tbone_construction_seed_areas', static function (): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Forbidden', 403 );
    }
    check_admin_referer( 'tbone_construction_seed_areas' );

    $created = tbone_construction_run_area_setup();

    $url = add_query_arg( [
        'page'              => 'tbone-construction-settings',
        'tbone-areas-done'  => $created,
    ], admin_url( 'themes.php' ) );

    wp_safe_redirect( $url );
    exit;
} );

/** Destructive: deletes all tbc_project posts and reseeds with the current sample list. */
add_action( 'admin_post_tbone_construction_reset_projects', static function (): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Forbidden', 403 );
    }
    check_admin_referer( 'tbone_construction_reset_projects' );

    $wiped = tbone_construction_wipe_projects();
    tbone_construction_seed_projects();
    update_option( 'tbone_construction_projects_seeded', time() );

    $url = add_query_arg( [
        'page'                  => 'tbone-construction-settings',
        'tbone-projects-wiped'  => $wiped,
    ], admin_url( 'themes.php' ) );

    wp_safe_redirect( $url );
    exit;
} );

/** Destructive: overwrites existing pages' post_content with the current seed. */
add_action( 'admin_post_tbone_construction_reseed_content', static function (): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( 'Forbidden', 403 );
    }
    check_admin_referer( 'tbone_construction_reseed_content' );

    $result = tbone_construction_run_setup( true, true );

    $url = add_query_arg( [
        'page'              => 'tbone-construction-settings',
        'tbone-content-set' => count( $result['updated'] ),
        'tbone-subpages'    => count( $result['subpages'] ),
    ], admin_url( 'themes.php' ) );

    wp_safe_redirect( $url );
    exit;
} );
