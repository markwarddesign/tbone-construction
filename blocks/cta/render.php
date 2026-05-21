<?php
declare( strict_types=1 );

$heading = esc_html( $attributes['heading'] ?? '' );
$body    = esc_html( $attributes['body']    ?? '' );
$text    = esc_html( $attributes['text']    ?? '' );
$url     = esc_url(  $attributes['url']     ?? '/contact' );
?>
<div class="animate-in fade-in py-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-[#1f2926] text-white p-12 lg:p-16 text-center relative overflow-hidden shadow-xl">
      <div class="absolute inset-0 opacity-10 tbc-dot-grid"></div>
      <div class="relative z-10">
        <?php if ( $heading ) : ?>
          <h3 class="text-3xl md:text-4xl font-serif mb-6"><?php echo $heading; ?></h3>
        <?php endif; ?>
        <?php if ( $body ) : ?>
          <p class="text-lg text-stone-300 mb-8 max-w-2xl mx-auto leading-relaxed"><?php echo $body; ?></p>
        <?php endif; ?>
        <?php if ( $text ) : ?>
          <a href="<?php echo $url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:shadow-[4px_4px_0px_0px_#000]"><?php echo $text; ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
