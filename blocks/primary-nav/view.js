document.addEventListener( 'DOMContentLoaded', () => {
	const nav    = document.querySelector( '[data-tbc-nav]' );
	const toggle = document.querySelector( '[data-tbc-toggle]' );
	const mobile = document.querySelector( '[data-tbc-mobile]' );

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

	if ( nav ) {
		const onScroll = () => {
			const scrolled = window.scrollY > 20;
			nav.classList.toggle( 'shadow-md', scrolled );
			nav.classList.toggle( 'backdrop-blur-sm', scrolled );
			nav.classList.toggle( 'py-2', scrolled );
			nav.classList.toggle( 'py-4', ! scrolled );
		};
		window.addEventListener( 'scroll', onScroll, { passive: true } );
		onScroll();
	}
} );
