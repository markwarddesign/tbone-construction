<?php
declare( strict_types=1 );

$name   = wp_kses_post( $attributes['name']   ?? '' );
$date   = esc_html(     $attributes['date']   ?? '' );
$rating = max( 0, min( 5, (int) ( $attributes['rating'] ?? 5 ) ) );
$text   = wp_kses_post( $attributes['text']   ?? '' );
?>
<div class="bg-[#faf8f5] p-8 border border-stone-200 flex flex-col relative transition-all duration-300 hover:shadow-lg group">
  <div class="absolute top-6 right-6 text-stone-200 group-hover:text-stone-300 transition-colors">
    <?php echo tw_icon( 'quote', 'w-12 h-12' ); ?>
  </div>
  <div class="flex items-center space-x-1 mb-6 text-[#c25e24]">
    <?php for ( $i = 0; $i < $rating; $i++ ) echo tw_icon_star_fill( 'w-4 h-4' ); ?>
  </div>
  <p class="text-stone-700 leading-relaxed mb-8 relative z-10 font-medium">&ldquo;<?php echo $text; ?>&rdquo;</p>
  <div class="mt-auto pt-6 border-t border-stone-300/50 flex justify-between items-end">
    <span class="font-serif text-lg text-stone-900"><?php echo $name; ?></span>
    <span class="text-xs font-bold text-stone-500"><?php echo $date; ?></span>
  </div>
</div>
