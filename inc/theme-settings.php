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

    $logo_id  = (int) get_option( 'tbone_construction_logo_id', 0 );
    $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'T-Bone Construction — Theme Settings', 'tbone-construction' ); ?></h1>
        <?php settings_errors( 'tbone_construction_settings' ); ?>

        <?php if ( isset( $_GET['tbone-setup-done'] ) ) :
            $count = (int) $_GET['tbone-setup-done'];
            ?>
            <div class="notice notice-success is-dismissible">
                <p><?php
                    if ( $count > 0 ) {
                        printf( esc_html__( 'Site setup ran. %d page(s) created.', 'tbone-construction' ), $count );
                    } else {
                        esc_html_e( 'Site setup ran. All required pages already existed.', 'tbone-construction' );
                    }
                ?></p>
            </div>
        <?php endif; ?>

        <hr/>
        <h2 class="title"><?php esc_html_e( 'Site Pages', 'tbone-construction' ); ?></h2>
        <p><?php esc_html_e( 'Creates Home, Our Story, Craft & Services, Project Gallery, Local Reviews, and Contact pages (if missing), sets Home as the front page, and assigns a Primary menu. Safe to re-run.', 'tbone-construction' ); ?></p>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-bottom:24px;">
            <?php wp_nonce_field( 'tbone_construction_reset_setup' ); ?>
            <input type="hidden" name="action" value="tbone_construction_reset_setup" />
            <button type="submit" class="button button-secondary"><?php esc_html_e( 'Create / Repair Site Pages', 'tbone-construction' ); ?></button>
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
    } );
    </script>
    <?php
}
