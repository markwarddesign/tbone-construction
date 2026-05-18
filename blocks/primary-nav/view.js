document.addEventListener( 'DOMContentLoaded', () => {
	const nav    = document.querySelector( '[data-tbc-nav]' );
	const toggle = document.querySelector( '[data-tbc-toggle]' );
	const mobile = document.querySelector( '[data-tbc-mobile]' );

	// Mobile drawer open/close
	if ( toggle && mobile ) {
		const iconMenu  = toggle.querySelector( '[data-tbc-icon-menu]' );
		const iconClose = toggle.querySelector( '[data-tbc-icon-close]' );

		toggle.addEventListener( 'click', () => {
			const isHidden = mobile.classList.toggle( 'hidden' );
			const open     = ! isHidden;
			toggle.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			iconMenu?.classList.toggle( 'hidden', open );
			iconClose?.classList.toggle( 'hidden', ! open );
		} );
	}

	// Mobile submenu accordion toggles
	document.querySelectorAll( '[data-tbc-mobile-toggle]' ).forEach( ( btn ) => {
		btn.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			const parent = btn.closest( '[data-tbc-mobile-parent]' );
			const sub    = parent?.querySelector( ':scope > [data-tbc-mobile-sub]' );
			if ( ! sub ) return;
			const open = sub.classList.toggle( 'hidden' ) === false;
			btn.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
			btn.style.transform = open ? 'rotate(180deg)' : '';
		} );
	} );

	// Sticky-nav style on scroll
	if ( nav ) {
		const heroOverlay = document.querySelector( '.tbc-hero-overlay' );

		const onScroll = () => {
			const scrolled = window.scrollY > 20;
			nav.classList.toggle( 'shadow-md', scrolled );
			nav.classList.toggle( 'backdrop-blur-sm', scrolled );
			nav.classList.toggle( 'py-2', scrolled );
			nav.classList.toggle( 'py-4', ! scrolled );

			if ( heroOverlay ) {
				const heroBottom = heroOverlay.getBoundingClientRect().bottom;
				// Stay in overlay mode while the hero is still behind the nav.
				nav.classList.toggle( 'tbc-nav-overlay', heroBottom > 64 );
			}
		};
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}
} );
