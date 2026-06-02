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

	// Both the top bar and the nav are sticky. The nav must sit directly below
	// the top bar, so we set its `top` to the bar's (breakpoint-dependent)
	// height. The nav has no `top-0` utility class so this inline value owns it.
	if ( nav ) {
		const topbar = document.querySelector( '[data-tbc-topbar]' );
		const setNavOffset = () => {
			nav.style.top = ( topbar ? topbar.offsetHeight : 0 ) + 'px';
		};
		setNavOffset();
		window.addEventListener( 'resize', setNavOffset, { passive: true } );
	}

	// Sticky-nav style on scroll
	if ( nav ) {
		const heroOverlay = document.querySelector( '.tbc-hero-overlay' );

		const onScroll = () => {
			const scrolled = window.scrollY > 20;
			nav.classList.toggle( 'shadow-md', scrolled );
			nav.classList.toggle( 'backdrop-blur-sm', scrolled );
			nav.classList.toggle( 'py-2', scrolled );
			nav.classList.toggle( 'py-4', ! scrolled );
			// Shrink the bar height on scroll (handled in CSS, mobile only).
			nav.classList.toggle( 'tbc-nav-compact', scrolled );

			if ( heroOverlay ) {
				const heroBottom = heroOverlay.getBoundingClientRect().bottom;
				// Stay in overlay mode while the hero is still behind the nav.
				const overlay = heroBottom > 64;
				nav.classList.toggle( 'tbc-nav-overlay', overlay );
				// Once scrolled while still over the hero, add the glassy dark variant.
				nav.classList.toggle( 'tbc-nav-scrolled', overlay && scrolled );
			} else {
				nav.classList.remove( 'tbc-nav-scrolled' );
			}
		};
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}
} );
