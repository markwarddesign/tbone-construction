<?php
declare( strict_types=1 );

/**
 * T-Bone Construction — Theme Settings admin page.
 * Stores site-wide values used in the top bar, primary nav logo, and footer.
 * Access via Appearance → Theme Settings.
 */

function tbone_construction_register_settings(): void {
    // Top bar / contact
    register_setting( 'tbone_construction_settings', 'tbone_construction_topbar_text',       [ 'sanitize_callback' => 'sanitize_text_field' ] );
    register_setting( 'tbone_construction_settings', 'tbone_construction_topbar_phone',      [ 'sanitize_callback' => 'sanitize_text_field' ] );
    register_setting( 'tbone_construction_settings', 'tbone_construction_topbar_phone_link', [ 'sanitize_callback' => 'esc_url_raw' ] );
    register_setting( 'tbone_construction_settings', 'tbone_construction_topbar_email',      [ 'sanitize_callback' => 'sanitize_email' ] );

    // Logo
    register_setting( 'tbone_construction_settings', 'tbone_construction_logo_id', [ 'sanitize_callback' => 'absint' ] );

    // Favicon (used for browser tab + WP site icon)
    register_setting( 'tbone_construction_settings', 'tbone_construction_favicon_id', [
        'sanitize_callback' => static function ( $v ) {
            $id = absint( $v );
            // Mirror into WP's native site_icon option so admin/login pick it up too.
            if ( $id ) {
                update_option( 'site_icon', $id );
            } elseif ( (int) get_option( 'site_icon' ) === (int) get_option( 'tbone_construction_favicon_id' ) ) {
                delete_option( 'site_icon' );
            }
            return $id;
        },
    ] );

    // Footer
    register_setting( 'tbone_construction_settings', 'tbone_construction_footer_description', [ 'sanitize_callback' => 'sanitize_textarea_field' ] );
}
add_action( 'admin_init', 'tbone_construction_register_settings' );

function tbone_construction_settings_menu(): void {
    $hook = add_theme_page(
        __( 'T-Bone Construction — Theme Settings', 'tbone-construction' ),
        __( 'Theme Settings', 'tbone-construction' ),
        'manage_options',
        'tbone-construction-settings',
        'tbone_construction_render_settings_page'
    );
    add_action( "load-{$hook}", static function (): void {
        wp_enqueue_media();
    } );
}
add_action( 'admin_menu', 'tbone_construction_settings_menu' );

function tbone_construction_render_settings_page(): void {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $logo_id     = (int) get_option( 'tbone_construction_logo_id', 0 );
    $logo_url    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
    $favicon_id  = (int) get_option( 'tbone_construction_favicon_id', 0 );
    $favicon_url = $favicon_id ? wp_get_attachment_image_url( $favicon_id, 'thumbnail' ) : '';
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'T-Bone Construction — Theme Settings', 'tbone-construction' ); ?></h1>
        <?php settings_errors( 'tbone_construction_settings' ); ?>

        <?php if ( isset( $_GET['tbone-setup-done'] ) ) :
            $count    = (int) $_GET['tbone-setup-done'];
            $subpages = isset( $_GET['tbone-subpages'] ) ? (int) $_GET['tbone-subpages'] : 0;
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php
                    $bits = [];
                    $bits[] = $count > 0
                        ? sprintf( _n( '%d main page created.', '%d main pages created.', $count, 'tbone-construction' ), $count )
                        : __( 'All main pages already existed.', 'tbone-construction' );
                    if ( $subpages > 0 ) {
                        $bits[] = sprintf( _n( '%d service sub-page created.', '%d service sub-pages created.', $subpages, 'tbone-construction' ), $subpages );
                    }
                    echo esc_html( implode( ' ', $bits ) );
                ?></p>
            </div>
        <?php endif; ?>

        <?php if ( isset( $_GET['tbone-content-set'] ) ) :
            $count    = (int) $_GET['tbone-content-set'];
            $subpages = isset( $_GET['tbone-subpages'] ) ? (int) $_GET['tbone-subpages'] : 0;
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php
                    $bits = [];
                    if ( $count > 0 ) {
                        $bits[] = sprintf( _n( 'Reset content on %d page.', 'Reset content on %d pages.', $count, 'tbone-construction' ), $count );
                    }
                    if ( $subpages > 0 ) {
                        $bits[] = sprintf( _n( 'Added %d new service sub-page.', 'Added %d new service sub-pages.', $subpages, 'tbone-construction' ), $subpages );
                    }
                    if ( ! $bits ) {
                        $bits[] = __( 'Already up to date — nothing to update.', 'tbone-construction' );
                    }
                    echo esc_html( implode( ' ', $bits ) );
                ?></p>
            </div>
        <?php endif; ?>

        <hr/>
        <h2 class="title"><?php esc_html_e( 'Site Pages', 'tbone-construction' ); ?></h2>
        <p><?php esc_html_e( 'Creates the main pages (Home, Our Story, Services, Gallery, Reviews, Contact) and the six service sub-pages (decks, canopies, siding, windows, renovations, sheds). Safe to re-run — existing pages are not touched.', 'tbone-construction' ); ?></p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:inline-block;margin:0 12px 24px 0;">
            <?php wp_nonce_field( 'tbone_construction_reset_setup' ); ?>
            <input type="hidden" name="action" value="tbone_construction_reset_setup" />
            <button type="submit" class="button button-secondary"><?php esc_html_e( 'Create / Repair Site Pages', 'tbone-construction' ); ?></button>
        </form>

        <p style="margin-top:16px;color:#a00;"><strong><?php esc_html_e( 'Destructive:', 'tbone-construction' ); ?></strong>
        <?php esc_html_e( 'Overwrites the body content of every main page with the latest seed. Use this when block markup has changed (e.g. after a theme update) and existing pages look wrong. Custom edits will be lost.', 'tbone-construction' ); ?></p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-bottom:24px;" onsubmit="return confirm( <?php echo esc_attr( wp_json_encode( __( 'This will replace the content of all main pages (Home, Our Story, Services, Gallery, Reviews, Contact) with the default seed. Continue?', 'tbone-construction' ) ) ); ?> );">
            <?php wp_nonce_field( 'tbone_construction_reseed_content' ); ?>
            <input type="hidden" name="action" value="tbone_construction_reseed_content" />
            <button type="submit" class="button button-primary" style="background:#a00;border-color:#a00;"><?php esc_html_e( 'Reset Page Content (destructive)', 'tbone-construction' ); ?></button>
        </form>

        <?php if ( isset( $_GET['tbone-projects-wiped'] ) ) :
            $wiped = (int) $_GET['tbone-projects-wiped'];
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php printf( esc_html__( 'Deleted %d old project(s) and reseeded with sample projects from the media library.', 'tbone-construction' ), $wiped ); ?></p>
            </div>
        <?php endif; ?>

        <hr/>
        <h2 class="title"><?php esc_html_e( 'Projects', 'tbone-construction' ); ?></h2>
        <p style="color:#a00;"><strong><?php esc_html_e( 'Destructive:', 'tbone-construction' ); ?></strong>
        <?php esc_html_e( 'Deletes every existing Project (tbc_project) post and reseeds with the current sample list. Featured images and gallery shots are pulled from your Media Library by filename. Use this after uploading new project photos or to start over.', 'tbone-construction' ); ?></p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-bottom:24px;" onsubmit="return confirm( <?php echo esc_attr( wp_json_encode( __( 'This will permanently delete ALL existing Projects and replace them with the seed list. Continue?', 'tbone-construction' ) ) ); ?> );">
            <?php wp_nonce_field( 'tbone_construction_reset_projects' ); ?>
            <input type="hidden" name="action" value="tbone_construction_reset_projects" />
            <button type="submit" class="button button-primary" style="background:#a00;border-color:#a00;"><?php esc_html_e( 'Wipe & Reseed Projects (destructive)', 'tbone-construction' ); ?></button>
        </form>

        <form method="post" action="options.php">
            <?php settings_fields( 'tbone_construction_settings' ); ?>

            <h2 class="title"><?php esc_html_e( 'Contact & Top Bar', 'tbone-construction' ); ?></h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="tbone_construction_topbar_text">Tagline</label></th>
                    <td>
                        <input type="text" id="tbone_construction_topbar_text" name="tbone_construction_topbar_text" class="large-text"
                               value="<?php echo esc_attr( get_option( 'tbone_construction_topbar_text', 'Locally Owned in Idaho' ) ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="tbone_construction_topbar_phone">Phone</label></th>
                    <td>
                        <input type="text" id="tbone_construction_topbar_phone" name="tbone_construction_topbar_phone" class="regular-text"
                               value="<?php echo esc_attr( get_option( 'tbone_construction_topbar_phone', '(555) 123-4567' ) ); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="tbone_construction_topbar_phone_link">Phone Link</label></th>
                    <td>
                        <input type="text" id="tbone_construction_topbar_phone_link" name="tbone_construction_topbar_phone_link" class="regular-text"
                               value="<?php echo esc_attr( get_option( 'tbone_construction_topbar_phone_link', 'tel:5551234567' ) ); ?>" />
                        <p class="description"><?php esc_html_e( 'e.g. tel:5551234567', 'tbone-construction' ); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="tbone_construction_topbar_email">Email</label></th>
                    <td>
                        <input type="email" id="tbone_construction_topbar_email" name="tbone_construction_topbar_email" class="regular-text"
                               value="<?php echo esc_attr( get_option( 'tbone_construction_topbar_email', 'hello@tboneconst.com' ) ); ?>" />
                    </td>
                </tr>
            </table>

            <hr/>
            <h2 class="title"><?php esc_html_e( 'Logo', 'tbone-construction' ); ?></h2>
            <p><?php esc_html_e( 'Optional. If empty, a wrench icon + site name is used in the navigation.', 'tbone-construction' ); ?></p>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><?php esc_html_e( 'Logo Image', 'tbone-construction' ); ?></th>
                    <td>
                        <input type="hidden" id="tbone_construction_logo_id" name="tbone_construction_logo_id" value="<?php echo esc_attr( (string) ( $logo_id ?: '' ) ); ?>" />
                        <div id="tw-logo-preview" style="margin-bottom:12px;">
                            <?php if ( $logo_url ) : ?>
                                <img src="<?php echo esc_url( $logo_url ); ?>" style="max-height:80px;max-width:320px;display:block;border:1px solid #ddd;padding:4px;" alt="" />
                            <?php endif; ?>
                        </div>
                        <button type="button" id="tw-logo-upload" class="button button-secondary"><?php esc_html_e( 'Upload / Select Image', 'tbone-construction' ); ?></button>
                        <button type="button" id="tw-logo-remove" class="button" <?php echo $logo_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'tbone-construction' ); ?></button>
                    </td>
                </tr>
            </table>

            <hr/>
            <h2 class="title"><?php esc_html_e( 'Favicon', 'tbone-construction' ); ?></h2>
            <p><?php esc_html_e( 'Shown in browser tabs and bookmarks. Square PNG, at least 512×512 recommended. Also applied as the WordPress site icon for the admin and login screen.', 'tbone-construction' ); ?></p>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><?php esc_html_e( 'Favicon Image', 'tbone-construction' ); ?></th>
                    <td>
                        <input type="hidden" id="tbone_construction_favicon_id" name="tbone_construction_favicon_id" value="<?php echo esc_attr( (string) ( $favicon_id ?: '' ) ); ?>" />
                        <div id="tw-favicon-preview" style="margin-bottom:12px;">
                            <?php if ( $favicon_url ) : ?>
                                <img src="<?php echo esc_url( $favicon_url ); ?>" style="width:64px;height:64px;object-fit:cover;border:1px solid #ddd;padding:4px;background:#fff;" alt="" />
                            <?php endif; ?>
                        </div>
                        <button type="button" id="tw-favicon-upload" class="button button-secondary"><?php esc_html_e( 'Upload / Select Image', 'tbone-construction' ); ?></button>
                        <button type="button" id="tw-favicon-remove" class="button" <?php echo $favicon_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'tbone-construction' ); ?></button>
                    </td>
                </tr>
            </table>

            <hr/>
            <h2 class="title"><?php esc_html_e( 'Footer', 'tbone-construction' ); ?></h2>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="tbone_construction_footer_description">Brand Description</label></th>
                    <td>
                        <textarea id="tbone_construction_footer_description" name="tbone_construction_footer_description" rows="4" class="large-text"><?php echo esc_textarea( get_option( 'tbone_construction_footer_description', 'With over 25 years of hands-on experience, we help Idaho families upgrade their homes with durable outdoor living spaces, siding, windows, and practical renovations. Projects tailored specifically to your budget and lifestyle.' ) ); ?></textarea>
                    </td>
                </tr>
            </table>

            <?php submit_button( __( 'Save Settings', 'tbone-construction' ) ); ?>
        </form>
    </div>

    <script>
    jQuery( function ( $ ) {
        var frame;
        $( '#tw-logo-upload' ).on( 'click', function ( e ) {
            e.preventDefault();
            if ( frame ) { frame.open(); return; }
            frame = wp.media( { title: 'Select Logo Image', button: { text: 'Use as Logo' }, multiple: false, library: { type: 'image' } } );
            frame.on( 'select', function () {
                var a = frame.state().get( 'selection' ).first().toJSON();
                $( '#tbone_construction_logo_id' ).val( a.id );
                $( '#tw-logo-preview' ).html( '<img src="' + a.url + '" style="max-height:80px;max-width:320px;display:block;border:1px solid #ddd;padding:4px;" alt="" />' );
                $( '#tw-logo-remove' ).show();
            } );
            frame.open();
        } );
        $( '#tw-logo-remove' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '#tbone_construction_logo_id' ).val( '' );
            $( '#tw-logo-preview' ).html( '' );
            $( this ).hide();
        } );

        var favFrame;
        $( '#tw-favicon-upload' ).on( 'click', function ( e ) {
            e.preventDefault();
            if ( favFrame ) { favFrame.open(); return; }
            favFrame = wp.media( { title: 'Select Favicon Image', button: { text: 'Use as Favicon' }, multiple: false, library: { type: 'image' } } );
            favFrame.on( 'select', function () {
                var a = favFrame.state().get( 'selection' ).first().toJSON();
                $( '#tbone_construction_favicon_id' ).val( a.id );
                $( '#tw-favicon-preview' ).html( '<img src="' + a.url + '" style="width:64px;height:64px;object-fit:cover;border:1px solid #ddd;padding:4px;background:#fff;" alt="" />' );
                $( '#tw-favicon-remove' ).show();
            } );
            favFrame.open();
        } );
        $( '#tw-favicon-remove' ).on( 'click', function ( e ) {
            e.preventDefault();
            $( '#tbone_construction_favicon_id' ).val( '' );
            $( '#tw-favicon-preview' ).html( '' );
            $( this ).hide();
        } );
    } );
    </script>
    <?php
}
