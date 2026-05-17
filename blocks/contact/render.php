<?php
declare( strict_types=1 );

$phone      = get_option( 'tbone_construction_topbar_phone',      '(555) 123-4567' );
$phone_link = get_option( 'tbone_construction_topbar_phone_link', 'tel:5551234567' );
$email      = get_option( 'tbone_construction_topbar_email',      'hello@tboneconst.com' );

$form_id = (int) ( $attributes['cf7FormId'] ?? 0 );

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
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php echo tbc_section_heading( 'Start Your Project', "Free, no obligation consultations. We're excited to hear about your vision for your home." ); ?>

    <div class="grid lg:grid-cols-3 gap-12 mt-12 bg-white border border-stone-200 shadow-xl overflow-hidden">

      <div class="lg:col-span-1 bg-[#1f2926] text-white p-10 lg:p-12 relative overflow-hidden">
        <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
          <?php echo tw_icon( 'compass', 'w-64 h-64' ); ?>
        </div>

        <div class="relative z-10 space-y-12">
          <div>
            <h3 class="font-serif text-2xl text-[#c25e24] mb-6">Contact Details</h3>
            <div class="space-y-6">
              <div class="flex items-start">
                <?php echo tw_icon( 'phone', 'w-6 h-6 text-stone-400 mr-4 shrink-0' ); ?>
                <div>
                  <p class="text-sm font-bold tracking-widest uppercase text-stone-500 mb-1">Call Us</p>
                  <a href="<?php echo esc_url( $phone_link ); ?>" class="text-lg font-medium text-white hover:text-[#c25e24]"><?php echo esc_html( $phone ); ?></a>
                </div>
              </div>
              <div class="flex items-start">
                <?php echo tw_icon( 'mail', 'w-6 h-6 text-stone-400 mr-4 shrink-0' ); ?>
                <div>
                  <p class="text-sm font-bold tracking-widest uppercase text-stone-500 mb-1">Email Us</p>
                  <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-lg font-medium text-white hover:text-[#c25e24]"><?php echo esc_html( $email ); ?></a>
                </div>
              </div>
            </div>
          </div>

          <div class="pt-8 border-t border-white/10">
            <div class="flex items-start">
              <?php echo tw_icon( 'map-pin', 'w-6 h-6 text-[#c25e24] mr-4 shrink-0' ); ?>
              <div>
                <p class="text-sm font-bold tracking-widest uppercase text-stone-500 mb-2">Service Area</p>
                <p class="text-stone-300 leading-relaxed">Proudly serving families and upgrading homes across the Idaho region.</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="lg:col-span-2 p-10 lg:p-12 tbc-cf7-wrapper">
        <?php echo $form_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
      </div>
    </div>
  </div>
</div>
