<?php
declare( strict_types=1 );

$phone      = get_option( 'tbone_construction_topbar_phone',      '(208) 751-4303' );
$phone_link = get_option( 'tbone_construction_topbar_phone_link', 'tel:+12087514303' );
$email      = get_option( 'tbone_construction_topbar_email',      'hello@tboneconst.com' );

$heading         = esc_html(    $attributes['heading']        ?? 'Start Your Project' );
$subheading      = esc_html(    $attributes['subheading']     ?? '' );
$sidebar_heading = wp_kses_post( $attributes['sidebarHeading'] ?? 'Contact Details' );
$call_label      = wp_kses_post( $attributes['callLabel']      ?? 'Call Us' );
$email_label     = wp_kses_post( $attributes['emailLabel']     ?? 'Email Us' );
$area_label      = wp_kses_post( $attributes['areaLabel']      ?? 'Service Area' );
$area_text       = wp_kses_post( $attributes['areaText']       ?? '' );
$form_id         = (int)        ( $attributes['cf7FormId']      ?? 0 );

$cf7_active = function_exists( 'tbone_construction_cf7_active' ) && tbone_construction_cf7_active();

ob_start();
if ( ! $cf7_active ) {
    ?>
    <div class="bg-amber-50 border border-amber-300 text-amber-900 p-6">
        <p class="font-bold mb-1">Contact form not configured.</p>
        <p class="text-sm">Install &amp; activate <strong>Contact Form 7</strong>, then select a form in the block editor.</p>
    </div>
    <?php
} elseif ( $form_id <= 0 ) {
    ?>
    <div class="bg-stone-100 border border-stone-300 text-stone-700 p-6">
        <p class="font-bold mb-1">No form selected.</p>
        <p class="text-sm">Open this block in the editor and choose a Contact Form 7 form from the sidebar.</p>
    </div>
    <?php
} else {
    echo do_shortcode( sprintf( '[contact-form-7 id="%d"]', $form_id ) );
}
$form_markup = (string) ob_get_clean();
?>
<div class="animate-in fade-in pt-16 pb-24 bg-[#faf8f5] min-h-screen">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php echo tbc_section_heading( $heading, $subheading ); ?>

    <div class="mt-12 bg-[#1f2926] text-white p-8 lg:p-10 shadow-xl">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-10">
        <div class="flex items-start">
          <?php echo tw_icon( 'phone', 'w-6 h-6 text-[#c25e24] mr-4 shrink-0 mt-1' ); ?>
          <div class="min-w-0">
            <p class="text-xs font-bold tracking-widest uppercase text-stone-400 mb-1"><?php echo $call_label; ?></p>
            <a href="<?php echo esc_url( $phone_link ); ?>" class="text-lg font-medium text-white hover:text-[#c25e24] break-words"><?php echo esc_html( $phone ); ?></a>
          </div>
        </div>
        <div class="flex items-start">
          <?php echo tw_icon( 'mail', 'w-6 h-6 text-[#c25e24] mr-4 shrink-0 mt-1' ); ?>
          <div class="min-w-0">
            <p class="text-xs font-bold tracking-widest uppercase text-stone-400 mb-1"><?php echo $email_label; ?></p>
            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-lg font-medium text-white hover:text-[#c25e24] break-words"><?php echo esc_html( $email ); ?></a>
          </div>
        </div>
      </div>

      <?php if ( $area_label || $area_text ) : ?>
        <div class="mt-8 pt-8 border-t border-white/10 flex items-start">
          <?php echo tw_icon( 'map-pin', 'w-6 h-6 text-[#c25e24] mr-4 shrink-0 mt-1' ); ?>
          <div class="min-w-0">
            <?php if ( $area_label ) : ?>
              <p class="text-xs font-bold tracking-widest uppercase text-stone-400 mb-2"><?php echo $area_label; ?></p>
            <?php endif; ?>
            <?php if ( $area_text ) : ?>
              <p class="text-stone-200 leading-snug"><?php echo $area_text; ?></p>
            <?php endif; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="mt-8 bg-white border border-stone-200 shadow-xl p-8 lg:p-12 tbc-cf7-wrapper">
      <?php if ( $sidebar_heading ) : ?>
        <h3 class="font-serif text-2xl text-stone-900 mb-6"><?php echo $sidebar_heading; ?></h3>
      <?php endif; ?>
      <?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>
  </div>
</div>
