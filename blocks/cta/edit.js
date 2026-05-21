import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, body, text, url } = attributes;
	const blockProps = useBlockProps( { className: 'animate-in fade-in py-16' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTA Button', 'tbone-construction' ) }>
					<TextControl label="Button Text" value={ text } onChange={ ( v ) => setAttributes( { text: v } ) } />
					<TextControl label="Button URL"  value={ url }  onChange={ ( v ) => setAttributes( { url: v } ) } />
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div className="bg-[#1f2926] text-white p-12 lg:p-16 text-center relative overflow-hidden shadow-xl">
						<div className="absolute inset-0 opacity-10 tbc-dot-grid" />
						<div className="relative z-10">
							<RichText tagName="h3" className="text-3xl md:text-4xl font-serif mb-6" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } placeholder={ __( 'CTA heading…', 'tbone-construction' ) } />
							<RichText tagName="p"  className="text-lg text-stone-300 mb-8 max-w-2xl mx-auto leading-relaxed" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } placeholder={ __( 'CTA body…', 'tbone-construction' ) } />
							{ text && (
								<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white">{ text }</span>
							) }
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
