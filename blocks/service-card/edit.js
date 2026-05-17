import { useBlockProps, RichText, InspectorControls, __experimentalLinkControl as LinkControl } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl, Popover, Button } from '@wordpress/components';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import Icon, { ICON_OPTIONS } from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { icon, title, description, linkText, linkUrl } = attributes;
	const blockProps = useBlockProps( {
		className: 'group bg-[#faf8f5] p-8 border border-stone-200 relative overflow-hidden',
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Service Card', 'tbone-construction' ) }>
					<SelectControl
						label="Icon"
						value={ icon }
						options={ ICON_OPTIONS }
						onChange={ ( v ) => setAttributes( { icon: v } ) }
					/>
					<TextControl
						label="Link Text"
						value={ linkText }
						onChange={ ( v ) => setAttributes( { linkText: v } ) }
					/>
					<TextControl
						label="Link URL"
						value={ linkUrl }
						onChange={ ( v ) => setAttributes( { linkUrl: v } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="w-14 h-14 bg-white border border-stone-200 text-[#c25e24] flex items-center justify-center mb-6 shadow-sm transform -rotate-2">
					<Icon name={ icon } className="w-7 h-7" />
				</div>
				<RichText
					tagName="h3"
					className="text-2xl font-serif text-stone-900 mb-3"
					value={ title }
					onChange={ ( v ) => setAttributes( { title: v } ) }
					placeholder={ __( 'Service title…', 'tbone-construction' ) }
				/>
				<RichText
					tagName="p"
					className="text-stone-600 mb-6 leading-relaxed"
					value={ description }
					onChange={ ( v ) => setAttributes( { description: v } ) }
					placeholder={ __( 'Short description…', 'tbone-construction' ) }
				/>
				<div className="inline-flex items-center text-[#c25e24] font-bold text-sm tracking-wide">
					{ linkText }
					<Icon name="arrow-right" className="w-4 h-4 ml-2" />
				</div>
			</div>
		</>
	);
}
