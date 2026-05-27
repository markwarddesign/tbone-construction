<?php
declare( strict_types=1 );

$post_id = get_the_ID();
if ( ! $post_id ) return;

$ids_raw = (string) get_post_meta( $post_id, '_tbc_gallery_ids', true );
if ( $ids_raw === '' ) return;

$ids = array_filter( array_map( 'intval', array_map( 'trim', explode( ',', $ids_raw ) ) ) );
if ( ! $ids ) return;

$featured = (int) get_post_thumbnail_id( $post_id );
$ids = array_values( array_filter( $ids, fn( $id ) => $id !== $featured ) );
if ( ! $ids ) return;
?>
<div class="tbc-project-gallery mt-12 grid grid-cols-1 sm:grid-cols-2 gap-6">
    <?php foreach ( $ids as $id ) :
        $url = wp_get_attachment_image_url( $id, 'large' );
        if ( ! $url ) continue;
        $alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );
        ?>
        <div class="border-8 border-white shadow-lg">
            <img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $alt ); ?>" class="w-full h-auto object-cover" />
        </div>
    <?php endforeach; ?>
</div>
