<?php
declare( strict_types=1 );

$heading       = esc_html( $attributes['heading']      ?? 'Project Gallery' );
$subheading    = esc_html( $attributes['subheading']   ?? '' );
$limit         = (int)  ( $attributes['limit']         ?? 12 );
$category_slug = sanitize_title( $attributes['categorySlug'] ?? '' );
// When the editor invokes SSR it passes preview=1 so we render only the
// data-driven portion (filters + grid) — heading is editable inline in edit.js.
$preview       = ! empty( $attributes['preview'] );

$query_args = [
    'post_type'      => 'tbc_project',
    'posts_per_page' => $limit > 0 ? $limit : -1,
    'orderby'        => 'menu_order date',
    'order'          => 'DESC',
    'post_status'    => 'publish',
];
if ( $category_slug ) {
    $query_args['tax_query'] = [
        [
            'taxonomy' => 'tbc_project_category',
            'field'    => 'slug',
            'terms'    => $category_slug,
        ],
    ];
}
$projects = new WP_Query( $query_args );

$cat_terms = get_terms( [ 'taxonomy' => 'tbc_project_category', 'hide_empty' => true ] );
$cat_terms = is_wp_error( $cat_terms ) ? [] : $cat_terms;

/** Render the filter + grid portion (shared by full-frontend + editor preview). */
$render_body = static function () use ( $cat_terms, $projects, $category_slug ): void {
    if ( $cat_terms && ! $category_slug ) : ?>
      <div class="flex flex-wrap gap-3 mb-12 border-b border-stone-200 pb-6" data-tbc-gallery-filters>
        <button type="button" data-tbc-filter="" class="px-6 py-2 text-sm font-bold transition-all duration-200 bg-stone-900 text-white shadow-md">All</button>
        <?php foreach ( $cat_terms as $term ) : ?>
          <button type="button" data-tbc-filter="<?php echo esc_attr( $term->slug ); ?>" class="px-6 py-2 text-sm font-bold transition-all duration-200 bg-white text-stone-600 border border-stone-200 hover:border-stone-400 hover:text-stone-900">
            <?php echo esc_html( $term->name ); ?>
          </button>
        <?php endforeach; ?>
      </div>
    <?php endif;

    if ( ! $projects->have_posts() ) : ?>
      <div class="bg-white border border-stone-200 p-12 text-center text-stone-500">
        <p class="font-serif text-2xl mb-2">No projects yet</p>
        <p class="text-sm">Add some in <strong>Projects &rarr; Add New</strong>.</p>
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
    <?php endif;
};

// Editor preview: render only the data-driven portion (no wrapper, no heading, no lightbox).
if ( $preview ) {
    $render_body();
    return;
}
?>
<div class="animate-in fade-in pt-16 pb-24 bg-[#faf8f5] min-h-screen" data-tbc-gallery>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php echo tbc_section_heading( $heading, $subheading ); ?>
    <?php $render_body(); ?>
  </div>

  <!-- Lightbox shell -->
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
