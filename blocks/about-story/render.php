<?php
declare( strict_types=1 );

$heading      = esc_html(    $attributes['heading']      ?? '' );
$subheading   = esc_html(    $attributes['subheading']   ?? '' );
$para1        = wp_kses_post( $attributes['para1']       ?? '' );
$para2        = wp_kses_post( $attributes['para2']       ?? '' );
$badge_title  = wp_kses_post( $attributes['badgeTitle']  ?? '' );
$badge_body   = wp_kses_post( $attributes['badgeBody']   ?? '' );
$cta_text     = esc_html(    $attributes['ctaText']     ?? '' );
$cta_url      = esc_url(     $attributes['ctaUrl']      ?? '/contact' );
$image_url    = esc_url(     $attributes['imageUrl']    ?? '' );
$image_alt    = esc_attr(    $attributes['imageAlt']    ?? '' );
$trex_title   = wp_kses_post( $attributes['trexTitle']   ?? '' );
$trex_body    = wp_kses_post( $attributes['trexBody']    ?? '' );
$trex_link    = esc_html(    $attributes['trexLinkText']?? '' );
$trex_url     = esc_url(     $attributes['trexLinkUrl'] ?? '#' );
?>
<div class="animate-in fade-in pt-16 pb-24 bg-[#faf8f5] min-h-screen relative">
  <div class="absolute inset-0 opacity-30 tbc-dot-grid pointer-events-none"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <?php if ( $image_url ) : ?>
      <div class="lg:hidden mb-8">
        <div class="border-4 border-white shadow-2xl">
          <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" class="w-full h-auto object-cover" />
        </div>
      </div>
    <?php endif; ?>

    <?php echo tbc_section_heading( $heading, $subheading ); ?>

    <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center mt-12">
      <div class="space-y-8 text-lg text-stone-700 leading-relaxed">
        <p><?php echo $para1; ?></p>
        <p><?php echo $para2; ?></p>

        <div class="bg-white p-8 border border-stone-200 shadow-sm relative">
          <div class="absolute top-0 left-0 w-1 h-full bg-[#c25e24]"></div>
          <h4 class="font-serif text-2xl text-stone-900 mb-3 flex items-center">
            <?php echo tw_icon( 'shield-check', 'w-6 h-6 text-[#c25e24] mr-3' ); ?>
            <?php echo $badge_title; ?>
          </h4>
          <p class="text-base text-stone-600"><?php echo $badge_body; ?></p>
        </div>

        <?php if ( $cta_text ) : ?>
          <a href="<?php echo $cta_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0px_0px_#7a3b16]">
            <?php echo $cta_text; ?>
          </a>
        <?php endif; ?>
      </div>

      <div class="relative lg:pb-16">
        <?php if ( $image_url ) : ?>
          <div class="hidden lg:block border-8 border-white shadow-2xl relative z-20 transform rotate-2">
            <img src="<?php echo $image_url; ?>" alt="<?php echo $image_alt; ?>" class="w-full h-auto object-cover" />
          </div>
        <?php endif; ?>

        <div class="mt-0 relative lg:absolute lg:-bottom-10 lg:-left-10 bg-[#1f2926] text-white p-6 sm:p-8 z-30 shadow-xl w-full lg:max-w-sm border border-stone-700">
          <div class="flex items-center space-x-3 mb-4">
            <?php echo tw_icon( 'award', 'w-8 h-8 text-[#eab308]' ); ?>
            <h3 class="text-xl font-serif text-[#eab308]"><?php echo $trex_title; ?></h3>
          </div>
          <p class="text-stone-300 text-sm mb-4 leading-relaxed"><?php echo $trex_body; ?></p>
          <?php if ( $trex_link ) : ?>
            <a href="<?php echo $trex_url; ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-white font-bold hover:text-[#c25e24] transition-colors text-sm">
              <?php echo $trex_link; ?>
              <?php echo tw_icon( 'arrow-right', 'w-4 h-4 ml-2' ); ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
