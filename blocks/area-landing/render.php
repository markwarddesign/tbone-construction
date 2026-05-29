<?php
declare( strict_types=1 );

$slug = sanitize_title( (string) ( $attributes['areaSlug'] ?? 'twin-falls' ) );
$area = function_exists( 'tbc_area' ) ? tbc_area( $slug ) : null;

// Unknown slug — render nothing rather than a broken section.
if ( ! $area ) {
    return;
}

$city     = $area['name'];
$heading  = trim( (string) ( $attributes['heading'] ?? '' ) );
$heading  = $heading !== '' ? $heading : sprintf( 'Construction & Remodeling in %s, Idaho', $city );
$intro    = trim( (string) ( $attributes['intro'] ?? '' ) );
$intro    = $intro !== '' ? $intro : (string) $area['intro'];
$cta_text = (string) ( $attributes['ctaText'] ?? 'Get a Free Estimate' );
$cta_url  = (string) ( $attributes['ctaUrl'] ?? '/contact' );

$services = [
    [ '/services/decks',       'Decks & Railings' ],
    [ '/services/canopies',    'Canopies & Covers' ],
    [ '/services/siding',      'Siding Installation' ],
    [ '/services/windows',     'Window Replacements' ],
    [ '/services/renovations', 'Home Renovations' ],
    [ '/services/sheds',       'Sheds & Greenhouses' ],
];

$points = is_array( $area['points'] ?? null ) ? $area['points'] : [];
?>
<section class="py-16 bg-[#faf8f5]">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <p class="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">Areas We Serve · <?php echo esc_html( $area['county'] ); ?></p>

    <h1 class="text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-8"><?php echo esc_html( $heading ); ?></h1>

    <p class="text-xl text-stone-600 font-medium leading-relaxed mb-10"><?php echo esc_html( $intro ); ?></p>

    <?php if ( $points ) : ?>
      <ul class="text-lg text-stone-700 leading-relaxed mb-12 space-y-3 list-none m-0 p-0">
        <?php foreach ( $points as $point ) : ?>
          <li class="flex items-start">
            <?php echo tw_icon( 'check', 'w-6 h-6 text-[#c25e24] mr-3 shrink-0 mt-0.5' ); ?>
            <span><?php echo esc_html( (string) $point ); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <h2 class="text-3xl font-serif text-stone-900 mb-6">Our services in <?php echo esc_html( $city ); ?></h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-12">
      <?php foreach ( $services as [ $url, $label ] ) : ?>
        <a href="<?php echo esc_url( home_url( $url ) ); ?>" class="group flex items-center justify-between bg-white border border-stone-200 px-6 py-4 hover:border-[#c25e24] transition-colors">
          <span class="font-medium text-stone-800"><?php echo esc_html( $label ); ?></span>
          <?php echo tw_icon( 'arrow-right', 'w-5 h-5 text-[#c25e24] group-hover:translate-x-1 transition-transform' ); ?>
        </a>
      <?php endforeach; ?>
    </div>

    <div class="bg-[#1f2926] text-white p-8 lg:p-10 shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
      <div>
        <h2 class="font-serif text-2xl mb-1">Ready to build in <?php echo esc_html( $city ); ?>?</h2>
        <p class="text-stone-300">Free, no-obligation estimates across the Magic Valley.</p>
      </div>
      <a href="<?php echo esc_url( home_url( $cta_url ) ); ?>" class="inline-flex items-center justify-center whitespace-nowrap bg-[#c25e24] text-white font-bold px-8 py-4 hover:bg-[#a34d1c] transition-colors">
        <?php echo esc_html( $cta_text ); ?>
        <?php echo tw_icon( 'arrow-right', 'w-5 h-5 ml-2' ); ?>
      </a>
    </div>

  </div>
</section>
