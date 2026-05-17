import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const a = attributes;
	const set = ( k ) => ( v ) => setAttributes( { [ k ]: v } );
	const blockProps = useBlockProps( { className: 'animate-in fade-in pt-16 pb-24 bg-[#faf8f5] relative' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTA', 'tbone-construction' ) }>
					<TextControl label="CTA Text" value={ a.ctaText } onChange={ set( 'ctaText' ) } />
					<TextControl label="CTA URL"  value={ a.ctaUrl }  onChange={ set( 'ctaUrl' ) } />
				</PanelBody>
				<PanelBody title={ __( 'Image', 'tbone-construction' ) }>
					<MediaUploadCheck>
						<MediaUpload allowedTypes={ [ 'image' ] } onSelect={ ( m ) => setAttributes( { imageUrl: m?.url || '', imageAlt: m?.alt || a.imageAlt || '' } ) } render={ ( { open } ) => (
							<Button onClick={ open } variant="secondary" style={ { width: '100%' } }>{ a.imageUrl ? __( 'Replace Image', 'tbone-construction' ) : __( 'Select Image', 'tbone-construction' ) }</Button>
						) } />
					</MediaUploadCheck>
					{ a.imageUrl && <TextControl label="Alt" value={ a.imageAlt } onChange={ set( 'imageAlt' ) } /> }
				</PanelBody>
				<PanelBody title={ __( 'Trex Badge', 'tbone-construction' ) }>
					<TextControl label="Link Text" value={ a.trexLinkText } onChange={ set( 'trexLinkText' ) } />
					<TextControl label="Link URL"  value={ a.trexLinkUrl }  onChange={ set( 'trexLinkUrl' ) } />
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div className="mb-16">
						<div className="flex items-center gap-3 mb-6">
							<div className="w-12 h-0.5 bg-[#c25e24]" />
							<Icon name="compass" className="w-5 h-5 text-[#c25e24]" />
							<div className="w-12 h-0.5 bg-[#c25e24]" />
						</div>
						<RichText tagName="h2" className="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight" value={ a.heading } onChange={ set( 'heading' ) } />
						<RichText tagName="p"  className="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed" value={ a.subheading } onChange={ set( 'subheading' ) } />
					</div>

					<div className="grid lg:grid-cols-2 gap-16 items-center mt-12">
						<div className="space-y-8 text-lg text-stone-700 leading-relaxed">
							<RichText tagName="p" value={ a.para1 } onChange={ set( 'para1' ) } />
							<RichText tagName="p" value={ a.para2 } onChange={ set( 'para2' ) } />

							<div className="bg-white p-8 border border-stone-200 shadow-sm relative">
								<div className="absolute top-0 left-0 w-1 h-full bg-[#c25e24]" />
								<h4 className="font-serif text-2xl text-stone-900 mb-3 flex items-center">
									<Icon name="shield-check" className="w-6 h-6 text-[#c25e24] mr-3" />
									<RichText tagName="span" value={ a.badgeTitle } onChange={ set( 'badgeTitle' ) } />
								</h4>
								<RichText tagName="p" className="text-base text-stone-600" value={ a.badgeBody } onChange={ set( 'badgeBody' ) } />
							</div>

							{ a.ctaText && (
								<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white">{ a.ctaText }</span>
							) }
						</div>

						<div className="relative">
							{ a.imageUrl && (
								<div className="border-8 border-white shadow-2xl relative z-20 transform rotate-2">
									<img src={ a.imageUrl } alt={ a.imageAlt } className="w-full h-auto object-cover" />
								</div>
							) }

							<div className="absolute -bottom-10 -left-10 bg-[#1f2926] text-white p-8 z-30 shadow-xl max-w-sm border border-stone-700">
								<div className="flex items-center space-x-3 mb-4">
									<Icon name="award" className="w-8 h-8 text-[#eab308]" />
									<RichText tagName="h3" className="text-xl font-serif text-[#eab308]" value={ a.trexTitle } onChange={ set( 'trexTitle' ) } />
								</div>
								<RichText tagName="p" className="text-stone-300 text-sm mb-4 leading-relaxed" value={ a.trexBody } onChange={ set( 'trexBody' ) } />
								<span className="inline-flex items-center text-white font-bold text-sm">
									{ a.trexLinkText }
									<Icon name="arrow-right" className="w-4 h-4 ml-2" />
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
