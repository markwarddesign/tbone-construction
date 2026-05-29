<?php
declare( strict_types=1 );

$phone       = get_option( 'tbone_construction_topbar_phone',      '(208) 751-4303' );
$phone_link  = get_option( 'tbone_construction_topbar_phone_link', 'tel:+12087514303' );
$email       = get_option( 'tbone_construction_topbar_email',      'hello@tboneconst.com' );
$description = get_option( 'tbone_construction_footer_description', 'With over 25 years of hands-on experience, we help Idaho families upgrade their homes with durable outdoor living spaces, siding, windows, and practical renovations. Projects tailored specifically to your budget and lifestyle.' );

$services = [
    [ home_url( '/services/decks-railings' ),    'Decks & Railings' ],
    [ home_url( '/services/canopies-covers' ),   'Canopies & Covers' ],
    [ home_url( '/services/siding' ),            'Siding Installation' ],
    [ home_url( '/services/windows' ),           'Window Replacements' ],
    [ home_url( '/services/renovations' ),       'Home Renovations' ],
    [ home_url( '/services/sheds-greenhouses' ), 'Sheds & Greenhouses' ],
];

$logo_id  = (int) get_option( 'tbone_construction_logo_id', 0 );
$logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '';

$nap   = function_exists( 'tbc_business_nap' ) ? tbc_business_nap() : [];
$hours = $nap['hours'] ?? '';
$addr_line = '';
if ( $nap ) {
    $addr_line = trim( sprintf( '%s, %s, %s %s', $nap['street'], $nap['city'], $nap['state'], $nap['zip'] ), ', ' );
}
$map_url = $addr_line ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode( $addr_line ) : '';

$areas = function_exists( 'tbc_areas' ) ? tbc_areas() : [];

$nav = has_nav_menu( 'footer' ) ? wp_nav_menu( [
    'theme_location' => 'footer',
    'container'      => false,
    'echo'           => false,
    'items_wrap'     => '<ul class="space-y-4 list-none m-0 p-0">%3$s</ul>',
    'fallback_cb'    => false,
] ) : '';

if ( ! $nav ) {
    $items = [
        [ home_url( '/' ),        'Home' ],
        [ home_url( '/about' ),   'Our Story' ],
        [ home_url( '/gallery' ), 'Gallery' ],
        [ home_url( '/reviews' ), 'Reviews' ],
        [ home_url( '/contact' ), 'Contact' ],
    ];
    $links = '';
    foreach ( $items as [ $url, $label ] ) {
        $links .= sprintf(
            '<li class="list-none"><a href="%s" class="hover:text-white transition-colors capitalize font-medium flex items-center group"><span class="w-2 h-0.5 bg-[#c25e24] mr-2 opacity-0 group-hover:opacity-100 transition-opacity"></span>%s</a></li>',
            esc_url( $url ),
            esc_html( $label )
        );
    }
    $nav = '<ul class="space-y-4 list-none m-0 p-0">' . $links . '</ul>';
}
?>
<footer class="bg-[#1f2926] border-t-8 border-[#c25e24] text-stone-400 pt-16 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-12 mb-16">

      <div class="col-span-1 md:col-span-2 lg:col-span-2 pr-4 lg:pr-12">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mb-6 inline-block group">
          <?php if ( $logo_url ) : ?>
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="h-10 w-auto filter brightness-0 invert opacity-90 group-hover:opacity-100 transition-opacity" />
          <?php else : ?>
            <span class="inline-flex items-center">
              <?php echo tw_icon( 'wrench', 'w-6 h-6 text-[#c25e24] mr-2' ); ?>
              <span class="font-serif text-2xl text-white tracking-tight"><?php bloginfo( 'name' ); ?></span>
            </span>
          <?php endif; ?>
        </a>
        <p class="font-medium leading-relaxed mb-8"><?php echo esc_html( $description ); ?></p>
        <div class="inline-flex items-center space-x-2 bg-white/5 border border-white/10 px-4 py-2 text-sm font-bold text-white uppercase tracking-wider">
          <?php echo tw_icon( 'award', 'w-4 h-4 text-[#eab308]' ); ?>
          <span>TrexPro&reg; Partner 2024</span>
        </div>
      </div>

      <div class="col-span-1">
        <h3 class="font-serif text-white text-xl mb-6">Navigation</h3>
        <?php echo $nav; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>

      <div class="col-span-1">
        <h3 class="font-serif text-white text-xl mb-6">Services</h3>
        <ul class="space-y-4 list-none m-0 p-0">
          <?php foreach ( $services as [ $url, $label ] ) : ?>
            <li class="list-none">
              <a href="<?php echo esc_url( $url ); ?>" class="hover:text-white transition-colors font-medium">
                <?php echo esc_html( $label ); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="col-span-1 lg:col-span-2">
        <h3 class="font-serif text-white text-xl mb-6">Connect</h3>
        <ul class="space-y-4 mb-8 list-none m-0 p-0">
          <li class="list-none">
            <a href="<?php echo esc_url( $phone_link ); ?>" class="flex items-start font-medium hover:text-white transition-colors">
              <?php echo tw_icon( 'phone', 'w-5 h-5 mr-3 text-[#c25e24] shrink-0' ); ?>
              <?php echo esc_html( $phone ); ?>
            </a>
          </li>
          <li class="list-none">
            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="flex items-start font-medium hover:text-white transition-colors">
              <?php echo tw_icon( 'mail', 'w-5 h-5 mr-3 text-[#c25e24] shrink-0' ); ?>
              <?php echo esc_html( $email ); ?>
            </a>
          </li>
          <?php if ( $addr_line ) : ?>
          <li class="list-none">
            <a href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer" class="flex items-start font-medium hover:text-white transition-colors not-italic">
              <?php echo tw_icon( 'map-pin', 'w-5 h-5 mr-3 text-[#c25e24] shrink-0' ); ?>
              <address class="not-italic"><?php echo esc_html( $addr_line ); ?></address>
            </a>
          </li>
          <?php endif; ?>
          <?php if ( $hours ) : ?>
          <li class="list-none flex items-start font-medium">
            <?php echo tw_icon( 'compass', 'w-5 h-5 mr-3 text-[#c25e24] shrink-0' ); ?>
            <span><?php echo esc_html( $hours ); ?></span>
          </li>
          <?php endif; ?>
        </ul>
        <a href="https://www.trex.com" target="_blank" rel="noopener noreferrer" class="block w-full bg-[#faf8f5] p-4 group shadow-md transition-transform hover:-translate-y-1">
          <p class="text-xs font-bold uppercase tracking-widest text-stone-500 mb-1">Decking Materials</p>
          <div class="text-stone-900 font-bold flex items-center text-sm">
            Order Trex Samples
            <?php echo tw_icon( 'arrow-right', 'w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform text-[#c25e24]' ); ?>
          </div>
        </a>
      </div>
    </div>

    <?php if ( $areas ) : ?>
    <div class="pt-8 border-t border-white/10 mb-8">
      <h3 class="text-xs font-bold tracking-widest uppercase text-stone-400 mb-4">Areas We Serve</h3>
      <ul class="flex flex-wrap gap-x-6 gap-y-2 list-none m-0 p-0 text-sm">
        <?php foreach ( $areas as $slug => $area ) : ?>
          <li class="list-none">
            <a href="<?php echo esc_url( home_url( '/areas/' . $slug ) ); ?>" class="hover:text-white transition-colors font-medium">
              <?php echo esc_html( $area['name'] ); ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>

    <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center text-sm font-medium text-stone-500 gap-4">
      <p>&copy; <?php echo (int) date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
      <p class="text-stone-400">Area's only certified <span class="text-white">Trex RainEscape&reg;</span> installer.</p>
    </div>
  </div>
</footer>
