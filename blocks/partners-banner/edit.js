import { useBlockProps, RichText, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { Button, PanelBody, TextControl, ToggleControl, SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const SIZE_MAP = {
	small:  { box: 'w-14 md:w-20',  img: 'max-h-10 md:max-h-12' },
	medium: { box: 'w-20 md:w-28',  img: 'max-h-14 md:max-h-16' },
	large:  { box: 'w-28 md:w-36',  img: 'max-h-20 md:max-h-24' },
};

export default function Edit( { attributes, setAttributes } ) {
	const { heading, partners = [], grayscale = true, size = 'small' } = attributes;
	const blockProps = useBlockProps( { className: 'py-16 md:py-20 bg-white border-t border-stone-200' } );

	const updatePartner = ( idx, patch ) => {
		const next = partners.map( ( p, i ) => ( i === idx ? { ...p, ...patch } : p ) );
		setAttributes( { partners: next } );
	};

	const removePartner = ( idx ) => {
		setAttributes( { partners: partners.filter( ( _, i ) => i !== idx ) } );
	};

	const addPartners = ( media ) => {
		const items = Array.isArray( media ) ? media : [ media ];
		const next  = [
			...partners,
			...items.map( ( m ) => ( {
				id:   m?.id   || 0,
				url:  m?.url  || '',
				name: m?.alt  || m?.title || m?.filename || '',
			} ) ),
		];
		setAttributes( { partners: next } );
	};

	const sizing  = SIZE_MAP[ size ] || SIZE_MAP.small;
	const toneCls = grayscale ? 'grayscale opacity-60' : 'opacity-90';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Display', 'tbone-construction' ) } initialOpen>
					<ToggleControl
						label={ __( 'Black & white logos', 'tbone-construction' ) }
						help={ __( 'Apply a grayscale filter; restored on hover.', 'tbone-construction' ) }
						checked={ grayscale }
						onChange={ ( v ) => setAttributes( { grayscale: v } ) }
					/>
					<SelectControl
						label={ __( 'Logo size', 'tbone-construction' ) }
						value={ size }
						options={ [
							{ label: __( 'Small',  'tbone-construction' ), value: 'small' },
							{ label: __( 'Medium', 'tbone-construction' ), value: 'medium' },
							{ label: __( 'Large',  'tbone-construction' ), value: 'large' },
						] }
						onChange={ ( v ) => setAttributes( { size: v } ) }
					/>
				</PanelBody>

				<PanelBody title={ __( 'Partner Logos', 'tbone-construction' ) } initialOpen>
					<MediaUploadCheck>
						<MediaUpload
							multiple
							gallery
							allowedTypes={ [ 'image' ] }
							value={ partners.map( ( p ) => p.id ).filter( Boolean ) }
							onSelect={ addPartners }
							render={ ( { open } ) => (
								<Button onClick={ open } variant="primary" style={ { width: '100%', marginBottom: 12 } }>
									{ partners.length ? __( 'Add / Replace Logos', 'tbone-construction' ) : __( 'Select Logos', 'tbone-construction' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>

					{ partners.map( ( p, idx ) => (
						<div key={ idx } style={ { display: 'flex', alignItems: 'center', gap: 8, marginBottom: 12, padding: 8, border: '1px solid #ddd' } }>
							{ p.url && <img src={ p.url } alt="" style={ { width: 48, height: 48, objectFit: 'contain', background: '#f6f6f6' } } /> }
							<div style={ { flex: 1 } }>
								<TextControl
									label={ __( 'Name', 'tbone-construction' ) }
									value={ p.name || '' }
									onChange={ ( v ) => updatePartner( idx, { name: v } ) }
								/>
							</div>
							<Button isDestructive variant="tertiary" onClick={ () => removePartner( idx ) }>
								{ __( 'Remove', 'tbone-construction' ) }
							</Button>
						</div>
					) ) }
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
					<RichText
						tagName="p"
						className="text-sm font-bold tracking-widest text-stone-400 uppercase mb-10"
						value={ heading }
						onChange={ ( v ) => setAttributes( { heading: v } ) }
						placeholder={ __( 'Section heading…', 'tbone-construction' ) }
					/>

					{ partners.length > 0 ? (
						<div className="flex flex-wrap justify-center items-center gap-8 md:gap-12 lg:gap-16">
							{ partners.map( ( p, idx ) => (
								<div key={ idx } title={ p.name } className={ `${ sizing.box } flex items-center justify-center ${ toneCls }` }>
									<img src={ p.url } alt={ p.name } className={ `${ sizing.img } w-auto object-contain mix-blend-multiply` } />
								</div>
							) ) }
						</div>
					) : (
						<div className="py-8 text-stone-400 italic">
							{ __( 'Use the sidebar to add partner logos from the media library.', 'tbone-construction' ) }
						</div>
					) }
				</div>
			</section>
		</>
	);
}
