<?php
declare( strict_types=1 );

$heading       = esc_html( $attributes['heading']      ?? 'Reviews' );
$subheading    = esc_html( $attributes['subheading']   ?? '' );
$average_score = esc_html( $attributes['averageScore'] ?? '4.9 / 5.0' );
$average_label = esc_html( $attributes['averageLabel'] ?? 'Average Local Rating' );
$reviews       = is_array( $attributes['reviews'] ?? null ) ? $attributes['reviews'] : [];
?>
<div class="animate-in fade-in pt-16 pb-24 bg-white min-h-screen relative">
  <div class="absolute top-0 left-0 w-full h-64 bg-[#faf8f5] border-b border-stone-200"></div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
      <?php echo tbc_section_heading( $heading, $subheading, 'left', 'mb-0' ); ?>

      <div class="mt-8 md:mt-0 flex flex-col items-start md:items-end bg-white p-6 shadow-md border border-stone-100 transform rotate-1">
        <div class="flex items-center space-x-1 mb-2 text-[#c25e24]">
          <?php for ( $i = 0; $i < 5; $i++ ) echo tw_icon_star_fill( 'w-5 h-5' ); ?>
        </div>
        <span class="font-serif text-2xl text-stone-900"><?php echo $average_score; ?></span>
        <span class="text-xs font-bold text-stone-500 uppercase tracking-widest"><?php echo $average_label; ?></span>
      </div>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 items-start">
      <?php foreach ( $reviews as $review ) :
        $r_name   = wp_kses_post( $review['name']   ?? '' );
        $r_date   = esc_html(     $review['date']   ?? '' );
        $r_rating = max( 0, min( 5, (int) ( $review['rating'] ?? 5 ) ) );
        $r_text   = wp_kses_post( $review['text']   ?? '' );
      ?>
        <div class="bg-[#faf8f5] p-8 border border-stone-200 flex flex-col relative transition-all duration-300 hover:shadow-lg group">
          <div class="absolute top-6 right-6 text-stone-200 group-hover:text-stone-300 transition-colors">
            <?php echo tw_icon( 'quote', 'w-12 h-12' ); ?>
          </div>
          <div class="flex items-center space-x-1 mb-6 text-[#c25e24]">
            <?php for ( $i = 0; $i < $r_rating; $i++ ) echo tw_icon_star_fill( 'w-4 h-4' ); ?>
          </div>
          <p class="text-stone-700 leading-relaxed mb-8 relative z-10 font-medium">&ldquo;<?php echo $r_text; ?>&rdquo;</p>
          <div class="mt-auto pt-6 border-t border-stone-300/50 flex justify-between items-end">
            <span class="font-serif text-lg text-stone-900"><?php echo $r_name; ?></span>
            <span class="text-xs font-bold text-stone-500"><?php echo $r_date; ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
