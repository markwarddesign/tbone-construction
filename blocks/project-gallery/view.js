import { slideshowMediaHTML, bindSlideshow } from '../../src/lightbox';

document.addEventListener( 'DOMContentLoaded', () => {
	document.querySelectorAll( '[data-tbc-project-gallery]' ).forEach( ( gallery ) => {
		const lightbox = gallery.querySelector( '[data-tbc-project-lightbox]' );
		if ( ! lightbox ) return;
		// Move to <body> so it overlays everything and escapes ancestor transforms.
		if ( lightbox.parentNode !== document.body ) document.body.appendChild( lightbox );

		const lightboxBody  = lightbox.querySelector( '.tbc-lightbox__body' );
		const lightboxClose = lightbox.querySelectorAll( '[data-tbc-lightbox-close]' );

		let images = [];
		try { images = JSON.parse( gallery.getAttribute( 'data-tbc-images' ) || '[]' ); } catch ( _ ) { images = []; }
		const title = gallery.getAttribute( 'data-tbc-title' ) || '';
		if ( ! images.length || ! lightboxBody ) return;

		const slideshow = bindSlideshow( lightboxBody );

		function openLightbox( startIndex ) {
			lightboxBody.innerHTML = `
				<div class="tbc-lightbox__scroll">
					<div class="tbc-lightbox__grid tbc-lightbox__grid--single">
						<div class="tbc-lightbox__media">${ slideshowMediaHTML( images, title ) }</div>
					</div>
				</div>
			`;
			slideshow.setImages( images, startIndex );
			slideshow.show( startIndex );

			lightbox.classList.remove( 'hidden' );
			lightbox.setAttribute( 'aria-hidden', 'false' );
			document.body.style.overflow = 'hidden';
		}

		function closeLightbox() {
			lightbox.classList.add( 'hidden' );
			lightbox.setAttribute( 'aria-hidden', 'true' );
			lightboxBody.innerHTML = '';
			document.body.style.overflow = '';
		}

		gallery.querySelectorAll( '[data-tbc-open]' ).forEach( ( btn ) => {
			btn.addEventListener( 'click', () => openLightbox( Number( btn.getAttribute( 'data-tbc-open' ) ) || 0 ) );
		} );

		// The featured image (core post-featured-image block) is index 0 of the set —
		// make it open the lightbox on the first slide too.
		const featured = document.querySelector( '.wp-block-post-featured-image' );
		if ( featured ) {
			featured.style.cursor = 'zoom-in';
			featured.addEventListener( 'click', () => openLightbox( 0 ) );
		}

		lightboxClose.forEach( ( el ) => el.addEventListener( 'click', closeLightbox ) );
		document.addEventListener( 'keydown', ( e ) => {
			if ( lightbox.classList.contains( 'hidden' ) ) return;
			if ( e.key === 'Escape' ) closeLightbox();
			else if ( e.key === 'ArrowRight' ) slideshow.next();
			else if ( e.key === 'ArrowLeft' ) slideshow.prev();
		} );
	} );
} );
