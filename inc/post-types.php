<?php
declare( strict_types=1 );

/**
 * Project custom post type + category taxonomy.
 * Powers the Gallery block and `/projects/{slug}` single pages.
 */

add_action( 'init', static function (): void {
    register_post_type( 'tbc_project', [
        'label'         => __( 'Projects', 'tbone-construction' ),
        'labels'        => [
            'singular_name'   => __( 'Project',    'tbone-construction' ),
            'add_new'         => __( 'Add Project', 'tbone-construction' ),
            'add_new_item'    => __( 'Add New Project', 'tbone-construction' ),
            'edit_item'       => __( 'Edit Project', 'tbone-construction' ),
            'all_items'       => __( 'All Projects', 'tbone-construction' ),
            'menu_name'       => __( 'Projects', 'tbone-construction' ),
        ],
        'public'        => true,
        'has_archive'   => 'projects',
        'rewrite'       => [ 'slug' => 'projects', 'with_front' => false ],
        'show_in_rest'  => true,
        'menu_position' => 20,
        'menu_icon'     => 'dashicons-format-gallery',
        'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ],
        'taxonomies'    => [ 'tbc_project_category' ],
    ] );

    register_taxonomy( 'tbc_project_category', [ 'tbc_project' ], [
        'label'             => __( 'Project Categories', 'tbone-construction' ),
        'hierarchical'      => false,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'rewrite'           => [ 'slug' => 'project-category' ],
    ] );
} );

/** Add a "Gallery Images" meta box for additional shots beyond the featured image. */
add_action( 'add_meta_boxes', static function (): void {
    add_meta_box(
        'tbc_project_gallery',
        __( 'Additional Gallery Images', 'tbone-construction' ),
        'tbc_render_project_gallery_box',
        'tbc_project',
        'normal',
        'default'
    );
} );

function tbc_render_project_gallery_box( WP_Post $post ): void {
    wp_nonce_field( 'tbc_project_gallery_save', 'tbc_project_gallery_nonce' );
    wp_enqueue_media();

    $ids_raw = (string) get_post_meta( $post->ID, '_tbc_gallery_ids', true );
    $ids     = array_filter( array_map( 'absint', explode( ',', $ids_raw ) ) );
    ?>
    <p><?php esc_html_e( 'Optional extra images shown in the project lightbox.', 'tbone-construction' ); ?></p>
    <input type="hidden" id="tbc_gallery_ids" name="tbc_gallery_ids" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>" />
    <div id="tbc_gallery_preview" style="display:flex;flex-wrap:wrap;gap:8px;margin:12px 0;">
        <?php foreach ( $ids as $id ) :
            $thumb = wp_get_attachment_image_url( $id, 'thumbnail' );
            if ( ! $thumb ) continue; ?>
            <div data-id="<?php echo esc_attr( (string) $id ); ?>" style="position:relative;">
                <img src="<?php echo esc_url( $thumb ); ?>" style="width:80px;height:80px;object-fit:cover;border:1px solid #ccc;" alt="" />
                <button type="button" class="tbc-gallery-remove" style="position:absolute;top:-6px;right:-6px;background:#c00;color:#fff;border:0;border-radius:50%;width:20px;height:20px;cursor:pointer;line-height:1;">&times;</button>
            </div>
        <?php endforeach; ?>
    </div>
    <button type="button" class="button button-secondary" id="tbc_gallery_add"><?php esc_html_e( 'Add Images', 'tbone-construction' ); ?></button>
    <script>
    jQuery( function ( $ ) {
        function syncIds() {
            var ids = $( '#tbc_gallery_preview > div' ).map( function () { return $( this ).data( 'id' ); } ).get();
            $( '#tbc_gallery_ids' ).val( ids.join( ',' ) );
        }
        $( '#tbc_gallery_add' ).on( 'click', function ( e ) {
            e.preventDefault();
            var frame = wp.media( { title: 'Select images', multiple: true, library: { type: 'image' } } );
            frame.on( 'select', function () {
                frame.state().get( 'selection' ).each( function ( a ) {
                    var id = a.id, url = a.attributes.sizes && a.attributes.sizes.thumbnail ? a.attributes.sizes.thumbnail.url : a.attributes.url;
                    if ( $( '#tbc_gallery_preview > div[data-id="' + id + '"]' ).length ) return;
                    $( '#tbc_gallery_preview' ).append(
                        '<div data-id="' + id + '" style="position:relative;">' +
                        '<img src="' + url + '" style="width:80px;height:80px;object-fit:cover;border:1px solid #ccc;" alt="" />' +
                        '<button type="button" class="tbc-gallery-remove" style="position:absolute;top:-6px;right:-6px;background:#c00;color:#fff;border:0;border-radius:50%;width:20px;height:20px;cursor:pointer;line-height:1;">&times;</button>' +
                        '</div>'
                    );
                } );
                syncIds();
            } );
            frame.open();
        } );
        $( '#tbc_gallery_preview' ).on( 'click', '.tbc-gallery-remove', function () {
            $( this ).parent().remove();
            syncIds();
        } );
    } );
    </script>
    <?php
}

add_action( 'save_post_tbc_project', static function ( int $post_id ): void {
    if ( ! isset( $_POST['tbc_project_gallery_nonce'] ) || ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['tbc_project_gallery_nonce'] ) ), 'tbc_project_gallery_save' ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    $raw = sanitize_text_field( wp_unslash( $_POST['tbc_gallery_ids'] ?? '' ) );
    $ids = array_filter( array_map( 'absint', explode( ',', $raw ) ) );
    update_post_meta( $post_id, '_tbc_gallery_ids', implode( ',', $ids ) );
} );

/** Helper: collected gallery image URLs (featured + extras). */
function tbc_project_gallery_urls( int $post_id, string $size = 'large' ): array {
    $urls = [];

    $featured_id = (int) get_post_thumbnail_id( $post_id );
    if ( $featured_id ) {
        $u = wp_get_attachment_image_url( $featured_id, $size );
        if ( $u ) $urls[] = $u;
    } else {
        // Fallback to a remote URL stored at seed time, until the editor uploads a real featured image.
        $remote = (string) get_post_meta( $post_id, '_tbc_remote_image_url', true );
        if ( $remote ) $urls[] = $remote;
    }

    $extra = (string) get_post_meta( $post_id, '_tbc_gallery_ids', true );
    foreach ( array_filter( array_map( 'absint', explode( ',', $extra ) ) ) as $id ) {
        $u = wp_get_attachment_image_url( $id, $size );
        if ( $u ) $urls[] = $u;
    }

    return array_values( array_unique( $urls ) );
}

/** Helper: primary category slug + name. */
function tbc_project_category( int $post_id ): array {
    $terms = get_the_terms( $post_id, 'tbc_project_category' );
    if ( is_wp_error( $terms ) || empty( $terms ) ) {
        return [ 'slug' => '', 'name' => '' ];
    }
    $t = $terms[0];
    return [ 'slug' => $t->slug, 'name' => $t->name ];
}
