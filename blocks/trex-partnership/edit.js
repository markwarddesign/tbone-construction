import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { badge, headline1, headline2, headline3, body, sidebarText, buttonText, buttonUrl } = attributes;
	const blockProps = useBlockProps( { className: 'bg-[#1f2926] text-white py-16 border-t-4 border-[#c25e24] relative overflow-hidden' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Button', 'tbone-construction' ) }>
					<TextControl label="Button Text" value={ buttonText } onChange={ ( v ) => setAttributes( { buttonText: v } ) } />
					<TextControl label="Button URL"  value={ buttonUrl }  onChange={ ( v ) => setAttributes( { buttonUrl: v } ) } />
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
					<div className="grid lg:grid-cols-3 gap-12 items-center">
						<div className="lg:col-span-2 space-y-6">
							<div className="flex items-center space-x-3 mb-2">
								<Icon name="award" className="w-8 h-8 text-[#eab308]" />
								<RichText tagName="span" className="text-[#eab308] font-bold tracking-widest uppercase text-sm" value={ badge } onChange={ ( v ) => setAttributes( { badge: v } ) } />
							</div>
							<h2 className="text-3xl md:text-4xl font-serif leading-tight">
								<RichText tagName="span" value={ headline1 } onChange={ ( v ) => setAttributes( { headline1: v } ) } />
								<br />
								<RichText tagName="span" className="text-[#c25e24] italic" value={ headline2 } onChange={ ( v ) => setAttributes( { headline2: v } ) } />
								{ ' ' }
								<RichText tagName="span" value={ headline3 } onChange={ ( v ) => setAttributes( { headline3: v } ) } />
							</h2>
							<RichText tagName="p" className="text-stone-400 text-lg max-w-2xl leading-relaxed" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />
						</div>
						<div className="lg:col-span-1 bg-white/5 p-8 border border-white/10 rounded-sm">
							<RichText tagName="p" className="text-stone-300 font-medium mb-6" value={ sidebarText } onChange={ ( v ) => setAttributes( { sidebarText: v } ) } />
							<span className="flex items-center justify-between w-full bg-white text-stone-900 px-6 py-4 font-bold">
								{ buttonText }
								<Icon name="arrow-right" className="w-5 h-5 text-[#c25e24]" />
							</span>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
