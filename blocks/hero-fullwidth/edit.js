import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const {
		badge,
		headingTop,
		headingAccent,
		body,
		primaryCtaText,
		primaryCtaUrl,
		secondaryCtaText,
		secondaryCtaUrl,
		imageUrl,
		minHeight,
	} = attributes;

	const blockProps = useBlockProps( {
		className: 'tbc-hero-overlay animate-in fade-in relative w-full overflow-hidden text-white',
		style: { minHeight: minHeight || '85vh' },
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Background Image', 'tbone-construction' ) }>
					<MediaUploadCheck>
						<MediaUpload
							allowedTypes={ [ 'image' ] }
							onSelect={ ( m ) => setAttributes( { imageUrl: m?.url || '', imageId: m?.id || 0 } ) }
							render={ ( { open } ) => (
								<Button onClick={ open } variant="secondary" style={ { width: '100%', marginBottom: 8 } }>
									{ imageUrl ? __( 'Replace Image', 'tbone-construction' ) : __( 'Select Image', 'tbone-construction' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
					<TextControl
						label={ __( 'Min Height (CSS)', 'tbone-construction' ) }
						help={ __( 'e.g. 85vh, 700px', 'tbone-construction' ) }
						value={ minHeight }
						onChange={ ( v ) => setAttributes( { minHeight: v } ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'CTAs', 'tbone-construction' ) }>
					<TextControl label="Primary CTA Text"   value={ primaryCtaText }   onChange={ ( v ) => setAttributes( { primaryCtaText: v } ) } />
					<TextControl label="Primary CTA URL"    value={ primaryCtaUrl }    onChange={ ( v ) => setAttributes( { primaryCtaUrl: v } ) } />
					<TextControl label="Secondary CTA Text" value={ secondaryCtaText } onChange={ ( v ) => setAttributes( { secondaryCtaText: v } ) } />
					<TextControl label="Secondary CTA URL"  value={ secondaryCtaUrl }  onChange={ ( v ) => setAttributes( { secondaryCtaUrl: v } ) } />
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				{ imageUrl && (
					<img src={ imageUrl } alt="" className="absolute inset-0 w-full h-full object-cover" />
				) }
				<div className="absolute inset-0 bg-gradient-to-b from-stone-900/70 via-stone-900/50 to-stone-900/80"></div>
				<div className="absolute inset-0 opacity-20 tbc-dot-grid"></div>

				<div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center" style={ { minHeight: minHeight || '85vh' } }>
					<div className="py-32 lg:py-40 max-w-3xl">
						<div className="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm px-4 py-2 border border-white/30 mb-8 transform -rotate-1">
							<Icon name="map-pin" className="w-4 h-4 text-[#c25e24]" />
							<RichText tagName="span" className="text-sm font-bold uppercase tracking-widest text-white" value={ badge } onChange={ ( v ) => setAttributes( { badge: v } ) } />
						</div>

						<h1 className="text-5xl sm:text-6xl lg:text-7xl font-serif leading-[1.1] mb-6 text-white drop-shadow-lg">
							<RichText tagName="span" value={ headingTop } onChange={ ( v ) => setAttributes( { headingTop: v } ) } /><br />
							<RichText tagName="span" className="text-[#f5a06b] italic" value={ headingAccent } onChange={ ( v ) => setAttributes( { headingAccent: v } ) } />
						</h1>

						<RichText tagName="p" className="text-lg text-stone-100 mb-10 max-w-xl leading-relaxed font-medium drop-shadow" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />

						<div className="flex flex-col sm:flex-row gap-5">
							<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white">{ primaryCtaText }</span>
							<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-white/10 backdrop-blur-sm border-white text-white">{ secondaryCtaText }</span>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
