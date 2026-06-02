/**
 * Shared image slideshow for the project lightbox.
 * Used by both the Gallery block (blocks/gallery/view.js) and the single
 * project page (blocks/project-gallery/view.js) so the two stay consistent.
 * Relies on the global .tbc-lightbox__* styles in src/style.css.
 */

export function escapeHtml( s ) {
	return String( s ).replace( /[&<>"']/g, ( c ) => ( { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ] ) );
}

/**
 * Markup for the media column: large main image with prev/next arrows,
 * a counter, and a clickable thumbnail strip. `images` is an array of URLs.
 */
export function slideshowMediaHTML( images, title = '' ) {
	const main     = images[0] || '';
	const hasExtra = images.length > 1;
	if ( ! main ) return '';

	return `
		<div class="tbc-lightbox__main">
			<img src="${ main }" alt="${ escapeHtml( title ) }" data-tbc-lightbox-main />
			${ hasExtra ? `
				<button type="button" class="tbc-lightbox__nav tbc-lightbox__nav--prev" data-tbc-prev aria-label="Previous image">&#8249;</button>
				<button type="button" class="tbc-lightbox__nav tbc-lightbox__nav--next" data-tbc-next aria-label="Next image">&#8250;</button>
				<span class="tbc-lightbox__counter" data-tbc-counter>1 / ${ images.length }</span>
			` : '' }
		</div>
		${ hasExtra
			? `<div class="tbc-lightbox__thumbs">${ images.map( ( u, i ) =>
				`<button type="button" class="tbc-lightbox__thumb${ i === 0 ? ' is-active' : '' }" data-tbc-thumb="${ i }" aria-label="View image ${ i + 1 }"><img src="${ u }" alt="" /></button>`
			).join( '' ) }</div>`
			: '' }
	`;
}

/**
 * Wire navigation (thumbnails, arrows, keyboard arrows, touch swipe) inside
 * `container` — the element that holds the markup from slideshowMediaHTML.
 * Listeners bind once; call setImages() each time the content is replaced.
 * Returns a controller used by the host to drive/reset the slideshow.
 */
export function bindSlideshow( container ) {
	let images = [];
	let index  = 0;

	function show( i ) {
		if ( ! images.length ) return;
		const count = images.length;
		index = ( ( i % count ) + count ) % count;

		const mainImg = container.querySelector( '[data-tbc-lightbox-main]' );
		if ( mainImg ) mainImg.src = images[ index ];

		const counter = container.querySelector( '[data-tbc-counter]' );
		if ( counter ) counter.textContent = `${ index + 1 } / ${ count }`;

		container.querySelectorAll( '.tbc-lightbox__thumb' ).forEach( ( b, i2 ) => {
			b.classList.toggle( 'is-active', i2 === index );
			if ( i2 === index ) b.scrollIntoView( { block: 'nearest', inline: 'nearest' } );
		} );
	}

	container.addEventListener( 'click', ( e ) => {
		const thumb = e.target.closest( '[data-tbc-thumb]' );
		if ( thumb && container.contains( thumb ) ) { show( Number( thumb.getAttribute( 'data-tbc-thumb' ) ) ); return; }
		if ( e.target.closest( '[data-tbc-prev]' ) ) { show( index - 1 ); return; }
		if ( e.target.closest( '[data-tbc-next]' ) ) { show( index + 1 ); return; }
	} );

	let touchStartX = null;
	container.addEventListener( 'touchstart', ( e ) => {
		if ( e.target.closest( '.tbc-lightbox__main' ) ) touchStartX = e.changedTouches[0].clientX;
	}, { passive: true } );
	container.addEventListener( 'touchend', ( e ) => {
		if ( touchStartX === null ) return;
		const dx = e.changedTouches[0].clientX - touchStartX;
		if ( Math.abs( dx ) > 40 ) show( index + ( dx < 0 ? 1 : -1 ) );
		touchStartX = null;
	}, { passive: true } );

	return {
		show,
		next: () => show( index + 1 ),
		prev: () => show( index - 1 ),
		setImages( imgs, start = 0 ) { images = Array.isArray( imgs ) ? imgs : []; index = start; },
	};
}
