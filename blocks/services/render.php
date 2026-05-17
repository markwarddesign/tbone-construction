<?php
declare( strict_types=1 );

$heading    = esc_html( $attributes['heading']    ?? 'Our Craft & Services' );
$subheading = esc_html( $attributes['subheading'] ?? '' );
$cta_text   = esc_html( $attributes['ctaText']    ?? 'Explore All Options' );
$cta_url    = esc_url(  $attributes['ctaUrl']     ?? '/services' );
?>
<section class="py-24 bg-white relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php echo tbc_section_heading( $heading, $subheading, 'center' ); ?>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>

    <?php if ( $cta_text ) : ?>
      <div class="mt-16 text-center">
        <a href="<?php echo $cta_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-transparent border-stone-800 text-stone-800 transition-all duration-200 hover:bg-stone-800 hover:text-white">
          <?php echo $cta_text; ?>
        </a>
      </div>
    <?php endif; ?>
  </div>
</section>
