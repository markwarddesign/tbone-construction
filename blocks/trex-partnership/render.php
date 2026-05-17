<?php
declare( strict_types=1 );

$badge       = wp_kses_post( $attributes['badge']       ?? '' );
$headline1   = wp_kses_post( $attributes['headline1']   ?? '' );
$headline2   = wp_kses_post( $attributes['headline2']   ?? '' );
$headline3   = wp_kses_post( $attributes['headline3']   ?? '' );
$body        = wp_kses_post( $attributes['body']        ?? '' );
$sidebar     = wp_kses_post( $attributes['sidebarText'] ?? '' );
$button_text = esc_html(     $attributes['buttonText']  ?? 'Order Trex Samples' );
$button_url  = esc_url(      $attributes['buttonUrl']   ?? 'https://www.trex.com' );
?>
<div class="bg-[#1f2926] text-white py-16 border-t-4 border-[#c25e24] relative overflow-hidden">
  <div class="absolute right-0 top-0 opacity-5 pointer-events-none transform translate-x-1/4 -translate-y-1/4">
    <?php echo tw_icon( 'sun', 'w-96 h-96' ); ?>
  </div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="grid lg:grid-cols-3 gap-12 items-center">
      <div class="lg:col-span-2 space-y-6">
        <div class="flex items-center space-x-3 mb-2">
          <?php echo tw_icon( 'award', 'w-8 h-8 text-[#eab308]' ); ?>
          <span class="text-[#eab308] font-bold tracking-widest uppercase text-sm"><?php echo $badge; ?></span>
        </div>
        <h2 class="text-3xl md:text-4xl font-serif leading-tight">
          <?php echo $headline1; ?> <br/><span class="text-[#c25e24] italic"><?php echo $headline2; ?></span> <?php echo $headline3; ?>
        </h2>
        <p class="text-stone-400 text-lg max-w-2xl leading-relaxed"><?php echo $body; ?></p>
      </div>
      <div class="lg:col-span-1 bg-white/5 p-8 border border-white/10 rounded-sm">
        <p class="text-stone-300 font-medium mb-6"><?php echo $sidebar; ?></p>
        <a href="<?php echo $button_url; ?>" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between w-full bg-white text-stone-900 px-6 py-4 font-bold hover:bg-stone-200 transition-colors shadow-[4px_4px_0px_0px_rgba(255,255,255,0.2)]">
          <?php echo $button_text; ?>
          <?php echo tw_icon( 'arrow-right', 'w-5 h-5 text-[#c25e24]' ); ?>
        </a>
      </div>
    </div>
  </div>
</div>
