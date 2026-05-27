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
$image          = esc_url(  $attributes['imageUrl']         ?? '' );
$min_height     = esc_attr( $attributes['minHeight']        ?? '85vh' );
$overlay_pct    = (int) ( $attributes['overlayOpacity']     ?? 70 );
$overlay_pct    = max( 0, min( 100, $overlay_pct ) );
// Scale top/bottom proportionally to the configured opacity; mid stays ~70% of top.
$overlay_top    = $overlay_pct / 100;
$overlay_mid    = ( $overlay_pct * 0.7 ) / 100;
$overlay_bot    = min( 1, ( $overlay_pct * 1.15 ) / 100 );
?>
<section class="tbc-hero-overlay animate-in fade-in relative w-full overflow-hidden text-white" style="min-height: <?php echo $min_height; ?>;">

    <?php if ( $image ) : ?>
        <img src="<?php echo $image; ?>" alt="" class="absolute inset-0 w-full h-full object-cover" />
    <?php endif; ?>

    <?php if ( $overlay_pct > 0 ) : ?>
        <div class="absolute inset-0" style="background-image: linear-gradient(to bottom, rgba(28,25,23,<?php echo $overlay_top; ?>), rgba(28,25,23,<?php echo $overlay_mid; ?>), rgba(28,25,23,<?php echo $overlay_bot; ?>));"></div>
    <?php endif; ?>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center" style="min-height: <?php echo $min_height; ?>;">
        <div class="py-32 lg:py-40 max-w-3xl">

            <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 border border-white/30 mt-12 mb-3 transform">
                <?php echo tw_icon( 'map-pin', 'w-4 h-4 text-[#c25e24]' ); ?>
                <span class="text-sm font-bold uppercase tracking-widest text-white"><?php echo $badge; ?></span>
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-serif leading-[1.1] mb-6 text-white drop-shadow-lg">
                <?php echo $heading_top; ?> <br/>
                <span class="text-[#f5a06b] italic"><?php echo $heading_accent; ?></span>
            </h1>

            <p class="text-lg text-stone-100 mb-10 max-w-xl leading-relaxed font-medium drop-shadow"><?php echo $body; ?></p>

            <div class="flex flex-col sm:flex-row gap-5 w-full sm:w-auto">
                <a href="<?php echo $cta1_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0px_0px_#7a3b16]">
                    <?php echo $cta1_text; ?>
                </a>
                <a href="<?php echo $cta2_url; ?>" class="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-white/10 backdrop-blur-sm border-white text-white transition-all duration-200 hover:bg-white hover:text-stone-900">
                    <?php echo $cta2_text; ?>
                </a>
            </div>

        </div>
    </div>
</section>
