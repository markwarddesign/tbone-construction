<?php
declare( strict_types=1 );

$quote       = esc_html( $attributes['quote']       ?? '' );
$attribution = esc_html( $attributes['attribution'] ?? '' );
$subtitle    = esc_html( $attributes['subtitle']    ?? '' );
$cta_text    = esc_html( $attributes['ctaText']     ?? 'Read All Reviews' );
$cta_url     = esc_url(  $attributes['ctaUrl']      ?? '/reviews' );
?>
<section class="py-24 bg-stone-900 text-stone-100">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <div class="mx-auto mb-6 opacity-80 text-[#c25e24] w-12 h-12 flex items-center justify-center">
      <?php echo tw_icon( 'pen-tool', 'w-12 h-12' ); ?>
    </div>
    <h2 class="text-3xl md:text-5xl font-serif leading-tight mb-8">&ldquo;<?php echo $quote; ?>&rdquo;</h2>
    <p class="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">&mdash; <?php echo $attribution; ?></p>
    <p class="text-stone-400 font-medium"><?php echo $subtitle; ?></p>
    <div class="mt-10">
      <a href="<?php echo $cta_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0px_0px_#7a3b16]">
        <?php echo $cta_text; ?>
      </a>
    </div>
  </div>
</section>
