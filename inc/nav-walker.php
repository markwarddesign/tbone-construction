<?php
declare( strict_types=1 );

/**
 * Tailwind-styled nav walkers with submenu support.
 * Desktop: hover/focus-revealed dropdown.
 * Mobile: accordion toggle (JS in primary-nav/view.js).
 */

if ( ! class_exists( 'Walker_Nav_Menu' ) ) {
    return;
}

class Tbc_Primary_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        // Top-level dropdown panel.
        if ( 0 === $depth ) {
            $output .= '<ul class="tbc-submenu absolute left-0 top-full min-w-[16rem] bg-white border border-stone-200 shadow-lg py-2 z-50 invisible opacity-0 translate-y-1 group-hover/has-sub:visible group-hover/has-sub:opacity-100 group-hover/has-sub:translate-y-0 group-focus-within/has-sub:visible group-focus-within/has-sub:opacity-100 group-focus-within/has-sub:translate-y-0 transition-all duration-200 list-none m-0 p-0 py-2">';
            return;
        }
        // Nested deeper levels (kept simple).
        $output .= '<ul class="tbc-submenu-deep pl-4 list-none m-0 p-0">';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $is_active = (
            in_array( 'current-menu-item',     (array) $item->classes, true ) ||
            in_array( 'current-menu-parent',   (array) $item->classes, true ) ||
            in_array( 'current-menu-ancestor', (array) $item->classes, true )
        );

        $has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );

        $url   = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
        $title = apply_filters( 'the_title', $item->title, $item->ID );

        if ( 0 === $depth ) {
            $li_class  = 'list-none relative' . ( $has_children ? ' group/has-sub' : '' );
            $link_base = 'inline-flex items-center px-4 py-2 rounded-md text-sm font-semibold transition-all duration-200';
            $state     = $is_active
                ? 'text-[#c25e24] bg-[#c25e24]/10'
                : 'text-stone-600 hover:text-stone-900 hover:bg-stone-200/50';
            $chevron   = $has_children
                ? '<svg class="w-3 h-3 ml-1.5 transition-transform group-hover/has-sub:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>'
                : '';
        } else {
            $li_class  = 'list-none';
            $link_base = 'block px-4 py-2.5 text-sm transition-colors';
            $state     = $is_active
                ? 'text-[#c25e24] font-semibold bg-[#c25e24]/5'
                : 'text-stone-700 hover:bg-stone-100 hover:text-stone-900';
            $chevron   = '';
        }

        $output .= sprintf(
            '<li class="%s"><a href="%s" class="%s">%s%s</a>',
            esc_attr( $li_class ),
            $url,
            esc_attr( "$link_base $state" ),
            esc_html( $title ),
            $chevron
        );
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}

class Tbc_Mobile_Nav_Walker extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '<ul class="tbc-mobile-sub hidden bg-stone-100/50 list-none m-0 p-0" data-tbc-mobile-sub>';
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $output .= '</ul>';
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $is_active    = in_array( 'current-menu-item', (array) $item->classes, true );
        $has_children = in_array( 'menu-item-has-children', (array) $item->classes, true );

        $url    = ! empty( $item->url ) ? esc_url( $item->url ) : '#';
        $title  = apply_filters( 'the_title', $item->title, $item->ID );

        if ( 0 === $depth ) {
            $base  = 'block px-4 py-4 text-lg font-serif text-left border-b border-stone-200 grow';
            $state = $is_active ? 'text-[#c25e24] font-bold' : 'text-stone-700 hover:bg-stone-100';
        } else {
            $base  = 'block px-8 py-3 text-base text-left border-b border-stone-200';
            $state = $is_active ? 'text-[#c25e24] font-bold' : 'text-stone-700 hover:bg-stone-100';
        }

        if ( $has_children && 0 === $depth ) {
            // Parent item: a flex row (link + toggle), with the submenu UL placed below as a sibling inside the LI.
            $output .= '<li class="list-none border-b border-stone-200" data-tbc-mobile-parent>';
            $output .= '<div class="flex items-stretch">';
            $output .= sprintf(
                '<a href="%s" class="%s">%s</a>',
                $url,
                esc_attr( "block px-4 py-4 text-lg font-serif text-left grow $state" ),
                esc_html( $title )
            );
            $output .= '<button type="button" class="px-4 text-stone-500 hover:text-stone-900 transition-transform" data-tbc-mobile-toggle aria-label="Toggle submenu" aria-expanded="false">';
            $output .= '<svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
            $output .= '</button>';
            $output .= '</div>';
        } else {
            $output .= sprintf(
                '<li class="list-none"><a href="%s" class="%s">%s</a>',
                $url,
                esc_attr( "$base $state" ),
                esc_html( $title )
            );
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }
}
