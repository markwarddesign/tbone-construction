<?php
declare( strict_types=1 );

$heading    = esc_html( $attributes['heading']    ?? 'Detailed Capabilities' );
$subheading = esc_html( $attributes['subheading'] ?? '' );
?>
<div class="animate-in fade-in pt-16 pb-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php echo tbc_section_heading( $heading, $subheading ); ?>

    <div class="space-y-16 mt-16">
      <?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>
  </div>
</div>
