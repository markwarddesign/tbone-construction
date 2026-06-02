<?php
declare( strict_types=1 );

$phone      = get_option( 'tbone_construction_topbar_phone',      '(208) 751-4303' );
$phone_link = get_option( 'tbone_construction_topbar_phone_link', 'tel:+12087514303' );
$email      = get_option( 'tbone_construction_topbar_email',      'hello@tboneconst.com' );
$tagline    = get_option( 'tbone_construction_topbar_text',       'Locally Owned in Idaho' );
?>
<div class="bg-[#1f2926] text-stone-300 py-2.5 px-4 sm:px-6 lg:px-8 text-sm flex justify-between items-center border-b border-stone-700/50 sticky top-0 z-40" data-tbc-topbar>
    <div class="flex space-x-8">
        <a href="<?php echo esc_url( $phone_link ); ?>" class="flex items-center hover:text-white transition-colors">
            <?php echo tw_icon( 'phone', 'w-4 h-4 mr-2 text-[#c25e24]' ); ?>
            <?php echo esc_html( $phone ); ?>
        </a>
        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="hidden sm:flex items-center hover:text-white transition-colors">
            <?php echo tw_icon( 'mail', 'w-4 h-4 mr-2 text-[#c25e24]' ); ?>
            <?php echo esc_html( $email ); ?>
        </a>
    </div>
    <div class="flex items-center space-x-2 text-stone-300 font-medium tracking-wide">
        <?php echo tw_icon( 'award', 'w-4 h-4 text-[#c25e24]' ); ?>
        <span><?php echo esc_html( $tagline ); ?></span>
    </div>
</div>
