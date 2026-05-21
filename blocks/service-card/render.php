<?php
declare( strict_types=1 );

$icon        = sanitize_key(  $attributes['icon']        ?? 'hammer' );
$title       = wp_kses_post(  $attributes['title']       ?? '' );
$description = wp_kses_post(  $attributes['description'] ?? '' );
$link_text   = esc_html(      $attributes['linkText']    ?? 'Read More' );
$link_url    = esc_url(       $attributes['linkUrl']     ?? '/services' );
?>
<div class="group bg-[#faf8f5] p-8 border border-stone-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg relative overflow-hidden cursor-pointer">
  <div class="w-14 h-14 bg-white border border-stone-200 text-[#c25e24] flex items-center justify-center mb-6 shadow-sm transform -rotate-2 group-hover:bg-[#c25e24] group-hover:text-white group-hover:border-[#c25e24] transition-colors duration-300">
    <?php echo tw_icon( $icon, 'w-7 h-7' ); ?>
  </div>
  <h3 class="text-2xl font-serif text-stone-900 mb-3"><?php echo $title; ?></h3>
  <p class="text-stone-600 mb-6 leading-relaxed line-clamp-3"><?php echo $description; ?></p>
  <a href="<?php echo $link_url; ?>" class="tbc-card-link inline-flex items-center text-[#c25e24] font-bold text-sm tracking-wide" aria-label="<?php echo esc_attr( wp_strip_all_tags( $title ) . ' — ' . $link_text ); ?>">
    <?php echo $link_text; ?>
    <?php echo tw_icon( 'arrow-right', 'w-4 h-4 ml-2' ); ?>
  </a>
</div>
