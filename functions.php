<?php
declare( strict_types=1 );

define( 'TBONE_CONSTRUCTION_VERSION', '1.0.0' );
define( 'TBONE_CONSTRUCTION_DIR', get_template_directory() );
define( 'TBONE_CONSTRUCTION_URI', get_template_directory_uri() );

require_once TBONE_CONSTRUCTION_DIR . '/inc/svg.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/data.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/areas.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/nav-walker.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/post-types.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/project-categories.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/project-order.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/setup.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/theme-settings.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/seo-presets.php';
require_once TBONE_CONSTRUCTION_DIR . '/inc/schema.php';

// ---------------------------------------------------------------------------
// Theme setup
// ---------------------------------------------------------------------------
function tbone_construction_setup(): void {
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/style.css' );
    add_theme_support( 'menus' );

    register_nav_menus( [
        'primary'         => __( 'Primary Navigation', 'tbone-construction' ),
        'footer'          => __( 'Footer Navigation', 'tbone-construction' ),
        'footer_services' => __( 'Footer Services', 'tbone-construction' ),
    ] );
}
add_action( 'after_setup_theme', 'tbone_construction_setup' );

// ---------------------------------------------------------------------------
// Frontend styles
// ---------------------------------------------------------------------------
function tbone_construction_enqueue_assets(): void {
    $css_path = TBONE_CONSTRUCTION_DIR . '/assets/css/style.css';
    $css_ver  = file_exists( $css_path ) ? (string) filemtime( $css_path ) : TBONE_CONSTRUCTION_VERSION;

    wp_enqueue_style(
        'tbone-construction-styles',
        TBONE_CONSTRUCTION_URI . '/assets/css/style.css',
        [],
        $css_ver
    );
}
add_action( 'wp_enqueue_scripts', 'tbone_construction_enqueue_assets' );

// ---------------------------------------------------------------------------
// Editor styles — same Tailwind CSS, same output
// ---------------------------------------------------------------------------
function tbone_construction_enqueue_editor_assets(): void {
    $css_path = TBONE_CONSTRUCTION_DIR . '/assets/css/style.css';
    $css_ver  = file_exists( $css_path ) ? (string) filemtime( $css_path ) : TBONE_CONSTRUCTION_VERSION;

    wp_enqueue_style(
        'tbone-construction-editor-styles',
        TBONE_CONSTRUCTION_URI . '/assets/css/style.css',
        [],
        $css_ver
    );
}
add_action( 'enqueue_block_editor_assets', 'tbone_construction_enqueue_editor_assets' );

// ---------------------------------------------------------------------------
// Custom block category
// ---------------------------------------------------------------------------
function tbone_construction_block_categories( array $categories ): array {
    return array_merge(
        [
            [
                'slug'  => 'tbone-construction',
                'title' => 'T-Bone Construction',
                'icon'  => null,
            ],
        ],
        $categories
    );
}
add_filter( 'block_categories_all', 'tbone_construction_block_categories' );

// ---------------------------------------------------------------------------
// Auto-register every block that ships a block.json
// ---------------------------------------------------------------------------
function tbone_construction_register_blocks(): void {
    $blocks_dir = TBONE_CONSTRUCTION_DIR . '/blocks';

    if ( ! is_dir( $blocks_dir ) ) {
        return;
    }

    foreach ( glob( $blocks_dir . '/*/block.json' ) ?: [] as $block_json ) {
        register_block_type( dirname( $block_json ) );
    }
}
add_action( 'init', 'tbone_construction_register_blocks' );

// ---------------------------------------------------------------------------
// Contact Form 7 integration helpers
// ---------------------------------------------------------------------------
function tbone_construction_cf7_active(): bool {
    return defined( 'WPCF7_VERSION' ) || class_exists( 'WPCF7_ContactForm' );
}

/** REST: list CF7 forms for the contact block's form-picker SelectControl. */
add_action( 'rest_api_init', static function (): void {
    register_rest_route( 'tbone-construction/v1', '/cf7-forms', [
        'methods'             => 'GET',
        'permission_callback' => static fn() => current_user_can( 'edit_posts' ),
        'callback'            => static function (): WP_REST_Response {
            if ( ! tbone_construction_cf7_active() ) {
                return new WP_REST_Response( [ 'active' => false, 'forms' => [] ], 200 );
            }

            $forms = get_posts( [
                'post_type'      => 'wpcf7_contact_form',
                'posts_per_page' => 100,
                'orderby'        => 'title',
                'order'          => 'ASC',
            ] );

            $out = array_map(
                static fn( $p ) => [ 'id' => $p->ID, 'title' => $p->post_title ],
                $forms
            );

            return new WP_REST_Response( [ 'active' => true, 'forms' => $out ], 200 );
        },
    ] );
} );

/** Admin notice when the contact block is in play but CF7 is missing. */
add_action( 'admin_notices', static function (): void {
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen || ! current_user_can( 'manage_options' ) ) return;
    if ( tbone_construction_cf7_active() ) return;
    if ( 'themes' !== $screen->base && 'site-editor' !== $screen->base && 'appearance_page_tbone-construction-settings' !== $screen->id ) return;
    $install_url = wp_nonce_url( self_admin_url( 'update.php?action=install-plugin&plugin=contact-form-7' ), 'install-plugin_contact-form-7' );
    ?>
    <div class="notice notice-warning">
        <p>
            <strong>T-Bone Construction:</strong>
            The Contact block uses Contact Form 7 to deliver estimate requests.
            <a href="<?php echo esc_url( $install_url ); ?>" class="button button-secondary" style="margin-left:8px;">Install Contact Form 7</a>
        </p>
    </div>
    <?php
} );

// ---------------------------------------------------------------------------
// Allow SVG uploads (admins only)
// ---------------------------------------------------------------------------
function tbone_construction_allow_svg_uploads( array $mimes, $user = null ): array {
    $can_upload = null !== $user ? user_can( $user, 'upload_files' ) : current_user_can( 'upload_files' );

    if ( ! $can_upload ) {
        return $mimes;
    }

    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'tbone_construction_allow_svg_uploads' );

function tbone_construction_fix_svg_mime_type( array $data, $file, $filename, $mimes, $real_mime ): array {
    unset( $file, $mimes, $real_mime );

    if ( ! current_user_can( 'upload_files' ) ) {
        return $data;
    }

    $ext = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

    if ( 'svg' === $ext ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'tbone_construction_fix_svg_mime_type', 10, 5 );

function tbone_construction_allow_svg_for_unsupported_mime_check( bool $prevent, ?string $mime_type ): bool {
    if ( 'image/svg+xml' === $mime_type && current_user_can( 'upload_files' ) ) {
        return false;
    }

    return $prevent;
}
add_filter( 'wp_prevent_unsupported_mime_type_uploads', 'tbone_construction_allow_svg_for_unsupported_mime_check', 10, 2 );
