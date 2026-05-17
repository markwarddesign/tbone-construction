import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { quote, attribution, subtitle, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'py-24 bg-stone-900 text-stone-100' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTA', 'tbone-construction' ) }>
					<TextControl label="CTA Text" value={ ctaText } onChange={ ( v ) => setAttributes( { ctaText: v } ) } />
					<TextControl label="CTA URL"  value={ ctaUrl }  onChange={ ( v ) => setAttributes( { ctaUrl: v } ) } />
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
					<div className="mx-auto mb-6 text-[#c25e24] flex items-center justify-center w-12 h-12 opacity-80">
						<Icon name="pen-tool" className="w-12 h-12" />
					</div>
					<RichText tagName="h2" className="text-3xl md:text-5xl font-serif leading-tight mb-8" value={ quote } onChange={ ( v ) => setAttributes( { quote: v } ) } />
					<RichText tagName="p"  className="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2" value={ attribution } onChange={ ( v ) => setAttributes( { attribution: v } ) } />
					<RichText tagName="p"  className="text-stone-400 font-medium" value={ subtitle } onChange={ ( v ) => setAttributes( { subtitle: v } ) } />
					{ ctaText && (
						<div className="mt-10">
							<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white">{ ctaText }</span>
						</div>
					) }
				</div>
			</div>
		</>
	);
}
