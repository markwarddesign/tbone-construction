document.addEventListener( 'DOMContentLoaded', () => {
	document.querySelectorAll( '[data-tbc-gallery]' ).forEach( ( gallery ) => {
		const filters = gallery.querySelectorAll( '[data-tbc-filter]' );
		const items   = gallery.querySelectorAll( '.tbc-gallery-item' );
		const lightbox      = gallery.querySelector( '[data-tbc-lightbox]' );
		// Move lightbox to <body> so it escapes any ancestor stacking context
		// (e.g. the gallery wrapper's animate-in transform) and overlays the sticky nav.
		if ( lightbox && lightbox.parentNode !== document.body ) {
			document.body.appendChild( lightbox );
		}
		const lightboxBody  = lightbox?.querySelector( '.tbc-lightbox__body' );
		const lightboxClose = lightbox?.querySelectorAll( '[data-tbc-lightbox-close]' );

		const activeBtn = [ 'bg-stone-900', 'text-white', 'shadow-md' ];
		const idleBtn   = [ 'bg-white', 'text-stone-600', 'border', 'border-stone-200', 'hover:border-stone-400', 'hover:text-stone-900' ];

		// Filter buttons
		filters.forEach( ( btn ) => {
			btn.addEventListener( 'click', () => {
				const slug = btn.getAttribute( 'data-tbc-filter' );

				filters.forEach( ( b ) => {
					idleBtn.forEach( ( c ) => b.classList.add( c ) );
					activeBtn.forEach( ( c ) => b.classList.remove( c ) );
				} );
				idleBtn.forEach( ( c ) => btn.classList.remove( c ) );
				activeBtn.forEach( ( c ) => btn.classList.add( c ) );

				items.forEach( ( item ) => {
					const cat = item.getAttribute( 'data-category' );
					item.style.display = ( ! slug || cat === slug ) ? '' : 'none';
				} );
			} );
		} );

		// Lightbox open
		items.forEach( ( item ) => {
			item.addEventListener( 'click', ( e ) => {
				if ( ! lightbox ) return;
				const pid = item.getAttribute( 'data-project-id' );
				const node = gallery.querySelector( `script[data-project-data="${ pid }"]` );
				if ( ! node ) {
					// No data — let the link navigate normally to the single page.
					return;
				}
				let data;
				try { data = JSON.parse( node.textContent ); } catch ( _ ) { return; }
				e.preventDefault();
				openLightbox( data );
			} );
		} );

		// Lightbox close
		lightboxClose?.forEach( ( el ) => el.addEventListener( 'click', closeLightbox ) );
		document.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Escape' && lightbox && ! lightbox.classList.contains( 'hidden' ) ) closeLightbox();
		} );

		function openLightbox( data ) {
			if ( ! lightboxBody || ! lightbox ) return;
			const hasContent = ( data.content && data.content.replace( /<[^>]+>/g, '' ).trim().length > 0 );
			const hasExtra   = ( Array.isArray( data.images ) && data.images.length > 1 );

			const main      = data.images?.[0] || '';
			const thumbnails = ( data.images || [] ).slice( 1 );

			lightboxBody.innerHTML = `
				<div class="tbc-lightbox__header">
					${ data.category ? `<span class="tbc-lightbox__cat">${ escapeHtml( data.category ) }</span>` : '' }
					<h2 class="tbc-lightbox__title">${ escapeHtml( data.title || '' ) }</h2>
				</div>
				<div class="tbc-lightbox__scroll">
					<div class="tbc-lightbox__grid${ hasContent ? '' : ' tbc-lightbox__grid--single' }">
						<div class="tbc-lightbox__media">
							${ main ? `<div class="tbc-lightbox__main"><img src="${ main }" alt="${ escapeHtml( data.title || '' ) }" /></div>` : '' }
							${ thumbnails.length ? `<div class="tbc-lightbox__thumbs">${ thumbnails.map( ( u ) => `<img src="${ u }" alt="" />` ).join( '' ) }</div>` : '' }
						</div>
						<div class="tbc-lightbox__info">
							${ hasContent ? `<div class="tbc-lightbox__content">${ data.content }</div>` : '' }
							${ hasExtra && data.permalink
								? `<a class="tbc-lightbox__view" href="${ data.permalink }">View full project →</a>`
								: '' }
						</div>
					</div>
				</div>
			`;

			lightbox.classList.remove( 'hidden' );
			lightbox.setAttribute( 'aria-hidden', 'false' );
			document.body.style.overflow = 'hidden';
		}

		function closeLightbox() {
			if ( ! lightbox ) return;
			lightbox.classList.add( 'hidden' );
			lightbox.setAttribute( 'aria-hidden', 'true' );
			if ( lightboxBody ) lightboxBody.innerHTML = '';
			document.body.style.overflow = '';
		}

		function escapeHtml( s ) {
			return String( s ).replace( /[&<>"']/g, ( c ) => ( { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[ c ] ) );
		}
	} );
} );
