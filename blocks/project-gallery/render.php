<?php
declare( strict_types=1 );

$post_id = get_the_ID();
if ( ! $post_id ) return;

// Full project image set (featured first, then extras) — drives the lightbox.
$all = tbc_project_gallery_urls( $post_id, 'large' );
if ( ! $all ) return;

// On-page grid shows the extra shots only; the featured image already appears
// above via the core post-featured-image block (which view.js also makes
// clickable). Extras start at index 1 when a featured image is present, so
// clicks open the lightbox at the right slide.
$featured_present = (int) get_post_thumbnail_id( $post_id ) > 0
	|| (string) get_post_meta( $post_id, '_tbc_remote_image_url', true ) !== '';
$grid_start = $featured_present ? 1 : 0;
$grid       = array_slice( $all, $grid_start );

$title = get_the_title( $post_id );

$wrap_class = $grid
	? 'tbc-project-gallery mt-12 grid grid-cols-1 sm:grid-cols-2 gap-6'
	: 'tbc-project-gallery';
?>
<div class="<?php echo esc_attr( $wrap_class ); ?>"
     data-tbc-project-gallery
     data-tbc-images="<?php echo esc_attr( (string) wp_json_encode( $all ) ); ?>"
     data-tbc-title="<?php echo esc_attr( $title ); ?>">
    <?php foreach ( $grid as $i => $url ) :
        $index = $grid_start + $i; ?>
        <button type="button" class="tbc-project-gallery__item border-8 border-white shadow-lg block p-0 cursor-pointer" data-tbc-open="<?php echo (int) $index; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'View image %d', 'tbone-construction' ), $index + 1 ) ); ?>">
            <img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-full h-auto object-cover" />
        </button>
    <?php endforeach; ?>

    <!-- Lightbox shell (image-only; mirrors the Gallery block lightbox) -->
    <div class="tbc-lightbox hidden" data-tbc-project-lightbox role="dialog" aria-modal="true" aria-hidden="true">
        <div class="tbc-lightbox__backdrop" data-tbc-lightbox-close></div>
        <div class="tbc-lightbox__panel" role="document">
            <button type="button" class="tbc-lightbox__close" data-tbc-lightbox-close aria-label="<?php esc_attr_e( 'Close', 'tbone-construction' ); ?>">
                <?php echo tw_icon( 'x', 'w-6 h-6' ); ?>
            </button>
            <div class="tbc-lightbox__body"></div>
        </div>
    </div>
</div>
