<?php
declare( strict_types=1 );

$icon        = sanitize_key( $attributes['icon']        ?? 'hammer' );
$title       = wp_kses_post( $attributes['title']       ?? '' );
$description = wp_kses_post( $attributes['description'] ?? '' );
$image_url   = esc_url(      $attributes['imageUrl']    ?? '' );
$image_alt   = esc_attr(     $attributes['imageAlt']    ?? '' );
$link_url    = esc_url(      $attributes['linkUrl']     ?? '' );
$link_text   = esc_html(     $attributes['linkText']    ?? 'Learn more' );

$features_raw = (string) ( $attributes['features'] ?? '' );
$features     = array_values( array_filter( array_map( 'trim', explode( "\n", $features_raw ) ) ) );
?>
<div class="tbc-service-row flex flex-col md:flex-row gap-8 lg:gap-16 items-start md:[&:nth-child(even)]:flex-row-reverse">
  <div class="md:w-1/2 space-y-6">
    <div class="space-y-4 mb-2">
      <div class="inline-flex p-3 bg-[#faf8f5] border border-stone-200 text-[#c25e24] shadow-sm">
        <?php echo tw_icon( $icon, 'w-7 h-7' ); ?>
      </div>
      <h2 class="text-3xl lg:text-4xl font-serif text-stone-900"><?php echo $title; ?></h2>
    </div>

    <p class="text-lg text-stone-600 leading-relaxed font-medium"><?php echo $description; ?></p>

    <?php if ( $features ) : ?>
      <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-stone-100 list-none p-0">
        <?php foreach ( $features as $feature ) : ?>
          <li class="flex items-center text-stone-800 font-medium">
            <?php echo tw_icon( 'check-circle-2', 'w-5 h-5 text-[#c25e24] mr-3 shrink-0' ); ?>
            <?php echo esc_html( $feature ); ?>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if ( $link_url ) : ?>
      <a href="<?php echo $link_url; ?>" class="inline-flex items-center gap-2 text-[#c25e24] font-bold uppercase tracking-widest text-sm hover:gap-3 transition-all duration-200">
        <?php echo $link_text; ?>
        <?php echo tw_icon( 'arrow-right', 'w-4 h-4' ); ?>
      </a>
    <?php endif; ?>
  </div>

  <div class="md:w-1/2 w-full">
    <?php if ( $image_url ) : ?>
      <div class="border border-stone-200 overflow-hidden shadow-sm">
        <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" class="w-full h-auto object-cover" />
      </div>
    <?php else : ?>
      <div class="bg-stone-100 border border-stone-200 aspect-[4/3] w-full flex items-center justify-center p-8 relative overflow-hidden shadow-sm group">
        <div class="absolute inset-0 opacity-20 tbc-dot-grid"></div>
        <div class="absolute inset-0 flex items-center justify-center opacity-[0.03] text-stone-900">
          <?php echo tw_icon( $icon, 'w-64 h-64' ); ?>
        </div>
        <div class="relative z-10 text-center">
          <h3 class="font-serif text-2xl text-stone-400 mb-2"><?php echo $title; ?> Gallery</h3>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>
