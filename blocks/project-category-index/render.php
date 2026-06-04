<?php
declare( strict_types=1 );

/**
 * Project Category Index — SEO landing for one tbc_project_category term.
 *
 * On the taxonomy archive the term is auto-detected from the query; a
 * `categorySlug` attribute lets the block be placed/previewed manually.
 *
 * The project grid deliberately mirrors the markup in blocks/gallery/render.php
 * (same `[data-tbc-gallery]` wrapper, `.tbc-gallery-item` cards, JSON
 * `data-project-data` scripts, and lightbox shell) so the shared lightbox
 * controller — enqueued here via block.json's viewScript pointing at
 * build/gallery/view.js — lights up without duplicating any JS.
 */

// Resolve the term: explicit attribute first, then the queried object.
$slug = sanitize_title( (string) ( $attributes['categorySlug'] ?? '' ) );
$term = $slug
    ? get_term_by( 'slug', $slug, 'tbc_project_category' )
    : ( function_exists( 'tbc_current_project_category' ) ? tbc_current_project_category() : null );

// Unknown term — render nothing rather than a broken page.
if ( ! ( $term instanceof WP_Term ) ) {
    return;
}

$meta     = tbc_project_category_meta( $term );
$projects = new WP_Query( [
    'post_type'      => 'tbc_project',
    'posts_per_page' => -1,
    'orderby'        => [ 'menu_order' => 'ASC', 'date' => 'DESC' ],
    'post_status'    => 'publish',
    'tax_query'      => [ [
        'taxonomy' => 'tbc_project_category',
        'field'    => 'slug',
        'terms'    => $term->slug,
    ] ],
] );

// Sibling categories for cross-linking (exclude the current one).
$other_terms = array_filter(
    function_exists( 'tbc_project_category_terms' ) ? tbc_project_category_terms( true ) : [],
    static fn( WP_Term $t ): bool => $t->term_id !== $term->term_id
);
?>
<div class="animate-in fade-in pt-16 pb-24 bg-[#faf8f5] min-h-screen" data-tbc-gallery>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Breadcrumb -->
    <nav class="flex flex-wrap items-center gap-2 text-sm text-stone-500 mb-8" aria-label="Breadcrumb">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#c25e24]">Home</a>
      <span aria-hidden="true">/</span>
      <a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>" class="hover:text-[#c25e24]">Projects</a>
      <span aria-hidden="true">/</span>
      <span class="text-stone-800 font-medium"><?php echo esc_html( $term->name ); ?></span>
    </nav>

    <p class="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">Project Gallery</p>
    <h1 class="text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-6"><?php echo esc_html( $term->name ); ?></h1>
    <p class="text-xl text-stone-600 font-medium leading-relaxed max-w-3xl mb-12"><?php echo esc_html( $meta['intro'] ); ?></p>

    <?php if ( ! $projects->have_posts() ) : ?>
      <div class="bg-white border border-stone-200 p-12 text-center text-stone-500">
        <p class="font-serif text-2xl mb-2">No projects in this category yet</p>
        <p class="text-sm"><a href="<?php echo esc_url( home_url( '/gallery' ) ); ?>" class="text-[#c25e24] font-bold">Browse the full gallery →</a></p>
      </div>
    <?php else : ?>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 tbc-gallery-grid" data-tbc-gallery-grid>
        <?php while ( $projects->have_posts() ) : $projects->the_post();
          $pid       = get_the_ID();
          $cat       = tbc_project_category( $pid );
          $images    = tbc_project_gallery_urls( $pid, 'large' );
          $thumb_url = $images[0] ?? '';
          $has_more  = ( get_the_content() && strlen( wp_strip_all_tags( get_the_content() ) ) > 0 ) || count( $images ) > 1;
        ?>
          <a href="<?php the_permalink(); ?>"
             class="tbc-gallery-item group bg-white p-4 shadow-md border border-stone-200 transition-all duration-300 hover:shadow-xl hover:-translate-y-2 hover:z-10 flex flex-col"
             data-category="<?php echo esc_attr( $cat['slug'] ); ?>"
             data-project-id="<?php echo (int) $pid; ?>"
             data-has-detail="<?php echo $has_more ? '1' : '0'; ?>">
            <div class="aspect-[4/3] overflow-hidden bg-stone-100 border border-stone-100">
              <?php if ( $thumb_url ) : ?>
                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" />
              <?php endif; ?>
            </div>
            <div class="mt-4 pt-2 flex flex-col items-center text-center flex-1">
              <h3 class="text-stone-900 font-serif text-lg leading-snug break-words"><?php the_title(); ?></h3>
              <?php if ( $cat['name'] ) : ?>
                <span class="text-[#c25e24] font-bold uppercase tracking-widest text-xs mt-1"><?php echo esc_html( $cat['name'] ); ?></span>
              <?php endif; ?>
            </div>
          </a>

          <script type="application/json" data-project-data="<?php echo (int) $pid; ?>"><?php
            echo wp_json_encode( [
                'id'        => (int) $pid,
                'title'     => html_entity_decode( get_the_title(), ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
                'permalink' => get_permalink(),
                'category'  => html_entity_decode( (string) $cat['name'], ENT_QUOTES | ENT_HTML5, 'UTF-8' ),
                'content'   => apply_filters( 'the_content', get_the_content() ),
                'images'    => $images,
            ] );
          ?></script>
        <?php endwhile; wp_reset_postdata(); ?>
      </div>
    <?php endif; ?>

    <?php if ( $other_terms ) : ?>
      <div class="mt-20 pt-10 border-t border-stone-200">
        <h2 class="text-3xl font-serif text-stone-900 mb-6">Browse other project categories</h2>
        <div class="flex flex-wrap gap-3">
          <?php foreach ( $other_terms as $ot ) :
            $ot_link = get_term_link( $ot );
            if ( is_wp_error( $ot_link ) ) continue; ?>
            <a href="<?php echo esc_url( $ot_link ); ?>" class="px-6 py-2 text-sm font-bold bg-white text-stone-600 border border-stone-200 hover:border-[#c25e24] hover:text-stone-900 transition-colors">
              <?php echo esc_html( $ot->name ); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if ( ! empty( $meta['services'] ) ) : ?>
      <div class="mt-16">
        <h2 class="text-3xl font-serif text-stone-900 mb-6">Related services</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <?php foreach ( $meta['services'] as [ $url, $label ] ) : ?>
            <a href="<?php echo esc_url( home_url( $url ) ); ?>" class="group flex items-center justify-between bg-white border border-stone-200 px-6 py-4 hover:border-[#c25e24] transition-colors">
              <span class="font-medium text-stone-800"><?php echo esc_html( $label ); ?></span>
              <?php echo tw_icon( 'arrow-right', 'w-5 h-5 text-[#c25e24] group-hover:translate-x-1 transition-transform' ); ?>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="mt-16 bg-[#1f2926] text-white p-8 lg:p-10 shadow-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
      <div>
        <h2 class="font-serif text-2xl mb-1">Planning a <?php echo esc_html( rtrim( $term->name, 's' ) ); ?> project?</h2>
        <p class="text-stone-300">Free, no-obligation estimates across the Magic Valley.</p>
      </div>
      <a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="inline-flex items-center justify-center whitespace-nowrap bg-[#c25e24] text-white font-bold px-8 py-4 hover:bg-[#a34d1c] transition-colors">
        Get a Free Estimate
        <?php echo tw_icon( 'arrow-right', 'w-5 h-5 ml-2' ); ?>
      </a>
    </div>

  </div>

  <!-- Lightbox shell (shared controller from build/gallery/view.js) -->
  <div class="tbc-lightbox hidden" data-tbc-lightbox role="dialog" aria-modal="true" aria-hidden="true">
    <div class="tbc-lightbox__backdrop" data-tbc-lightbox-close></div>
    <div class="tbc-lightbox__panel" role="document">
      <button type="button" class="tbc-lightbox__close" data-tbc-lightbox-close aria-label="Close">
        <?php echo tw_icon( 'x', 'w-6 h-6' ); ?>
      </button>
      <div class="tbc-lightbox__body"></div>
    </div>
  </div>
</div>
