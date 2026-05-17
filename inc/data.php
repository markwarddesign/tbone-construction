<?php
declare( strict_types=1 );

/**
 * Shared rendering partials. Block-specific copy now lives in each block's
 * attributes (editable in the Gutenberg editor) — this file only holds the
 * structural pieces that are reused across multiple block templates.
 */

/**
 * Reusable section heading partial.
 * Used by parent blocks that wrap an InnerBlocks region.
 */
function tbc_section_heading( string $title, string $subtitle = '', string $align = 'left', string $extra_class = '' ): string {
    ob_start();
    ?>
    <div class="mb-16 <?php echo $align === 'center' ? 'text-center mx-auto flex flex-col items-center' : ''; ?> <?php echo esc_attr( $extra_class ); ?>">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-0.5 bg-[#c25e24]"></div>
            <?php echo tw_icon( 'compass', 'w-5 h-5 text-[#c25e24]' ); ?>
            <div class="w-12 h-0.5 bg-[#c25e24]"></div>
        </div>
        <h2 class="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight"><?php echo wp_kses_post( $title ); ?></h2>
        <?php if ( $subtitle ) : ?>
            <p class="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed"><?php echo wp_kses_post( $subtitle ); ?></p>
        <?php endif; ?>
    </div>
    <?php
    return (string) ob_get_clean();
}
