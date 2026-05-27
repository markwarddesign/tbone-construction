<?php
declare( strict_types=1 );

$badge          = esc_html( $attributes['badge']            ?? 'Built for Idaho Weather' );
$heading_top    = esc_html( $attributes['headingTop']       ?? "Crafting Idaho's" );
$heading_accent = esc_html( $attributes['headingAccent']    ?? 'Outdoor Spaces' );
$body           = esc_html( $attributes['body']             ?? '' );
$cta1_text      = esc_html( $attributes['primaryCtaText']   ?? 'Discuss Your Project' );
$cta1_url       = esc_url(  $attributes['primaryCtaUrl']    ?? '/contact' );
$cta2_text      = esc_html( $attributes['secondaryCtaText'] ?? 'View Our Craft' );
$cta2_url       = esc_url(  $attributes['secondaryCtaUrl']  ?? '/services' );
$image1         = esc_url(  $attributes['image1Url']        ?? '' );
$image2         = esc_url(  $attributes['image2Url']        ?? '' );
?>
<div class="animate-in fade-in bg-[#faf8f5]">
  <div class="relative pt-16 pb-24 lg:pt-24 lg:pb-32 overflow-hidden border-b border-stone-200">
    <div class="absolute inset-0 opacity-40 tbc-dot-grid"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
      <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">

        <div class="lg:col-span-6 flex flex-col items-start text-left">
          <div class="inline-flex items-center space-x-2 bg-white px-4 py-2 border border-stone-200 shadow-sm mb-8 transform">
            <?php echo tw_icon( 'map-pin', 'w-4 h-4 text-[#c25e24]' ); ?>
            <span class="text-sm font-bold text-stone-700 uppercase tracking-widest"><?php echo $badge; ?></span>
          </div>

          <h1 class="text-5xl sm:text-6xl lg:text-7xl font-serif text-stone-900 leading-[1.1] mb-6">
            <?php echo $heading_top; ?> <br/>
            <span class="text-[#c25e24] italic"><?php echo $heading_accent; ?></span>
          </h1>

          <p class="text-lg text-stone-600 mb-10 max-w-lg leading-relaxed font-medium"><?php echo $body; ?></p>

          <div class="flex flex-col sm:flex-row gap-5 w-full sm:w-auto">
            <a href="<?php echo $cta1_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0px_0px_#7a3b16]">
              <?php echo $cta1_text; ?>
            </a>
            <a href="<?php echo $cta2_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-white border-stone-800 text-stone-800 transition-all duration-200 hover:bg-stone-800 hover:text-white">
              <?php echo $cta2_text; ?>
            </a>
          </div>

          <div class="mt-12 flex items-center gap-4 text-stone-500 font-medium text-sm">
            <div class="flex -space-x-3">
              <?php for ( $i = 0; $i < 4; $i++ ) : ?>
                <div class="w-10 h-10 rounded-full border-2 border-[#faf8f5] bg-stone-300 flex items-center justify-center overflow-hidden">
                  <?php echo tw_icon( 'star', 'w-4 h-4 text-white' ); ?>
                </div>
              <?php endfor; ?>
            </div>
            <p>Trusted by dozens of homeowners across the region.</p>
          </div>
        </div>

        <?php $has_two = $image1 && $image2; ?>
        <div class="lg:col-span-6 relative h-[500px] hidden md:block">
          <?php if ( $has_two ) : ?>
            <div class="absolute top-0 right-0 w-3/4 h-3/4 border-8 border-white shadow-xl transform rotate-3 z-10 transition-transform hover:rotate-1 hover:z-30 duration-300">
              <img src="<?php echo $image1; ?>" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="absolute bottom-0 left-0 w-2/3 h-2/3 border-8 border-white shadow-lg transform -rotate-3 z-20 transition-transform hover:-rotate-1 hover:z-30 duration-300">
              <img src="<?php echo $image2; ?>" alt="" class="w-full h-full object-cover" />
              <div class="absolute -bottom-4 -right-4 bg-[#c25e24] text-white p-3 shadow-md transform rotate-6">
                <?php echo tw_icon( 'hard-hat', 'w-6 h-6' ); ?>
              </div>
            </div>
          <?php elseif ( $image1 || $image2 ) : ?>
            <?php $solo = $image1 ?: $image2; ?>
            <div class="absolute inset-0 border-8 border-white shadow-xl">
              <img src="<?php echo $solo; ?>" alt="" class="w-full h-full object-cover" />
              <div class="absolute -bottom-4 -right-4 bg-[#c25e24] text-white p-3 shadow-md transform rotate-6">
                <?php echo tw_icon( 'hard-hat', 'w-6 h-6' ); ?>
              </div>
            </div>
          <?php endif; ?>
        </div>

      </div>
    </div>
  </div>
</div>
