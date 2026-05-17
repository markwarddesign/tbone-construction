<?php
declare( strict_types=1 );

$heading      = esc_html( $attributes['heading']    ?? 'Detailed Capabilities' );
$subheading   = esc_html( $attributes['subheading'] ?? '' );
$cta_heading  = esc_html( $attributes['ctaHeading'] ?? '' );
$cta_body     = esc_html( $attributes['ctaBody']    ?? '' );
$cta_text     = esc_html( $attributes['ctaText']    ?? '' );
$cta_url      = esc_url(  $attributes['ctaUrl']     ?? '/contact' );
?>
<div class="animate-in fade-in pt-16 pb-24 bg-white min-h-screen">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php echo tbc_section_heading( $heading, $subheading ); ?>

    <div class="space-y-16 mt-16">
      <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>

    <?php if ( $cta_heading || $cta_text ) : ?>
      <div class="mt-24 bg-[#1f2926] text-white p-12 lg:p-16 text-center relative overflow-hidden shadow-xl">
        <div class="absolute inset-0 opacity-10 tbc-dot-grid"></div>
        <div class="relative z-10">
          <?php if ( $cta_heading ) : ?>
            <h3 class="text-3xl md:text-4xl font-serif mb-6"><?php echo $cta_heading; ?></h3>
          <?php endif; ?>
          <?php if ( $cta_body ) : ?>
            <p class="text-lg text-stone-300 mb-8 max-w-2xl mx-auto leading-relaxed"><?php echo $cta_body; ?></p>
          <?php endif; ?>
          <?php if ( $cta_text ) : ?>
            <a href="<?php echo $cta_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:shadow-[4px_4px_0px_0px_#000]"><?php echo $cta_text; ?></a>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
