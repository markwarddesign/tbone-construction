<?php
declare( strict_types=1 );

$location = 'primary';

$logo_id  = isset( $attributes['logoId'] ) ? (int) $attributes['logoId'] : 0;
$logo_url = isset( $attributes['logoUrl'] ) ? esc_url_raw( (string) $attributes['logoUrl'] ) : '';
$logo_alt = isset( $attributes['logoAlt'] ) ? sanitize_text_field( (string) $attributes['logoAlt'] ) : '';

if ( ! $logo_url ) {
    $opt_logo_id = (int) get_option( 'tbone_construction_logo_id', 0 );
    if ( $opt_logo_id ) {
        $logo_url = (string) wp_get_attachment_image_url( $opt_logo_id, 'medium' );
    }
}

$cta_text = $attributes['ctaText'] ?? 'Get an Estimate';
$cta_url  = $attributes['ctaUrl']  ?? home_url( '/contact' );

$menu_html = has_nav_menu( $location ) ? wp_nav_menu( [
    'theme_location' => $location,
    'container'      => false,
    'echo'           => false,
    'items_wrap'     => '<ul class="flex space-x-1 items-center list-none m-0 p-0">%3$s</ul>',
    'walker'         => new Tbc_Primary_Nav_Walker(),
    'depth'          => 0,
    'fallback_cb'    => false,
] ) : '';

if ( ! $menu_html ) {
    $items = [
        [ home_url( '/' ),         'Home' ],
        [ home_url( '/about' ),    'Our Story' ],
        [ home_url( '/services' ), 'Craft & Services' ],
        [ home_url( '/gallery' ),  'Project Gallery' ],
        [ home_url( '/reviews' ),  'Local Reviews' ],
    ];
    $links = '';
    foreach ( $items as [ $url, $label ] ) {
        $links .= sprintf(
            '<li class="list-none"><a href="%s" class="px-4 py-2 rounded-md text-sm font-semibold text-stone-600 hover:text-stone-900 hover:bg-stone-200/50 transition-all duration-200">%s</a></li>',
            esc_url( $url ),
            esc_html( $label )
        );
    }
    $menu_html = '<ul class="flex space-x-1 items-center list-none m-0 p-0">' . $links . '</ul>';
}

$mobile_menu_html = has_nav_menu( $location ) ? wp_nav_menu( [
    'theme_location' => $location,
    'container'      => false,
    'echo'           => false,
    'items_wrap'     => '<ul class="flex flex-col list-none m-0 p-0">%3$s</ul>',
    'walker'         => new Tbc_Mobile_Nav_Walker(),
    'depth'          => 0,
    'fallback_cb'    => false,
] ) : '';

if ( ! $mobile_menu_html ) {
    $items = [
        [ home_url( '/' ),         'Home' ],
        [ home_url( '/about' ),    'Our Story' ],
        [ home_url( '/services' ), 'Craft & Services' ],
        [ home_url( '/gallery' ),  'Project Gallery' ],
        [ home_url( '/reviews' ),  'Local Reviews' ],
    ];
    $links = '';
    foreach ( $items as [ $url, $label ] ) {
        $links .= sprintf(
            '<li class="list-none"><a href="%s" class="block px-4 py-4 text-lg font-serif text-left border-b border-stone-200 text-stone-700 hover:bg-stone-100">%s</a></li>',
            esc_url( $url ),
            esc_html( $label )
        );
    }
    $mobile_menu_html = '<ul class="flex flex-col list-none m-0 p-0">' . $links . '</ul>';
}
?>
<nav class="tbc-nav sticky top-0 z-50 bg-[#faf8f5] py-4 border-b border-stone-200 transition-all duration-300" data-tbc-nav>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center group" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <?php if ( $logo_url ) : ?>
                    <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( $logo_alt ?: get_bloginfo( 'name' ) ); ?>" class="h-10 w-auto object-contain transition-transform group-hover:scale-105" />
                <?php else : ?>
                    <span class="inline-flex items-center">
                        <?php echo tw_icon( 'wrench', 'w-8 h-8 text-[#c25e24] mr-3' ); ?>
                        <span class="font-serif text-2xl text-stone-800 font-bold tracking-tight"><?php bloginfo( 'name' ); ?></span>
                    </span>
                <?php endif; ?>
            </a>

            <div class="hidden md:flex space-x-1 items-center">
                <?php echo $menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                <div class="pl-4 ml-2 border-l border-stone-300">
                    <a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex items-center justify-center py-2.5 px-6 text-sm font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white transition-all duration-200 hover:-translate-y-1 hover:-translate-x-1 hover:shadow-[4px_4px_0px_0px_#7a3b16]">
                        <?php echo esc_html( $cta_text ); ?>
                    </a>
                </div>
            </div>

            <div class="md:hidden flex items-center">
                <button type="button" class="text-stone-800 p-2 hover:bg-stone-200 rounded-md transition-colors" aria-label="Open menu" aria-expanded="false" aria-controls="tbc-mobile-menu" data-tbc-toggle>
                    <span data-tbc-icon-menu><?php echo tw_icon( 'menu', 'h-7 w-7' ); ?></span>
                    <span data-tbc-icon-close class="hidden"><?php echo tw_icon( 'x', 'h-7 w-7' ); ?></span>
                </button>
            </div>
        </div>
    </div>

    <div id="tbc-mobile-menu" class="md:hidden absolute w-full bg-[#faf8f5] text-stone-800 border-b border-stone-200 shadow-xl pb-6 hidden" data-tbc-mobile>
        <div class="px-4 pt-2">
            <?php echo $mobile_menu_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <div class="pt-6 px-0">
                <a href="<?php echo esc_url( $cta_url ); ?>" class="w-full inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white">Get a Free Estimate</a>
            </div>
        </div>
    </div>
</nav>
