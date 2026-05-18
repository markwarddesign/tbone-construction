<?php
declare( strict_types=1 );

$heading   = esc_html( $attributes['heading'] ?? 'Trusted By & Partnering With Local Experts' );
$grayscale = ! empty( $attributes['grayscale'] );
$size      = in_array( ( $attributes['size'] ?? 'small' ), [ 'small', 'medium', 'large' ], true ) ? $attributes['size'] : 'small';
$partners  = is_array( $attributes['partners'] ?? null ) ? $attributes['partners'] : [];

$size_map = [
    'small'  => [ 'box' => 'w-14 md:w-20',  'img' => 'max-h-10 md:max-h-12' ],
    'medium' => [ 'box' => 'w-20 md:w-28',  'img' => 'max-h-14 md:max-h-16' ],
    'large'  => [ 'box' => 'w-28 md:w-36',  'img' => 'max-h-20 md:max-h-24' ],
];
$box_cls = $size_map[ $size ]['box'];
$img_cls = $size_map[ $size ]['img'];

$tone_cls = $grayscale
    ? 'grayscale hover:grayscale-0 opacity-60 hover:opacity-100'
    : 'opacity-90 hover:opacity-100';
?>
<section class="py-16 md:py-20 bg-white border-t border-stone-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <?php if ( $heading ) : ?>
            <p class="text-sm font-bold tracking-widest text-stone-400 uppercase mb-10"><?php echo $heading; ?></p>
        <?php endif; ?>

        <?php if ( ! empty( $partners ) ) : ?>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12 lg:gap-16">
                <?php foreach ( $partners as $p ) :
                    $src  = esc_url( (string) ( $p['url']  ?? '' ) );
                    $name = esc_attr( (string) ( $p['name'] ?? '' ) );
                    if ( ! $src ) { continue; }
                ?>
                    <div title="<?php echo $name; ?>" class="<?php echo esc_attr( $box_cls ); ?> flex items-center justify-center transition-all duration-500 <?php echo esc_attr( $tone_cls ); ?>">
                        <img src="<?php echo $src; ?>" alt="<?php echo $name; ?>" class="<?php echo esc_attr( $img_cls ); ?> w-auto object-contain mix-blend-multiply" />
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
