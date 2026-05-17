import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon, { IconStarFill } from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { name, date, rating, text } = attributes;
	const blockProps = useBlockProps( { className: 'bg-[#faf8f5] p-8 border border-stone-200 flex flex-col relative group' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Review', 'tbone-construction' ) }>
					<TextControl label="Date" value={ date } onChange={ ( v ) => setAttributes( { date: v } ) } />
					<RangeControl
						label="Rating"
						min={ 0 }
						max={ 5 }
						value={ rating }
						onChange={ ( v ) => setAttributes( { rating: v } ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="absolute top-6 right-6 text-stone-200">
					<Icon name="quote" className="w-12 h-12" />
				</div>
				<div className="flex items-center space-x-1 mb-6 text-[#c25e24]">
					{ Array.from( { length: rating } ).map( ( _, i ) => <IconStarFill key={ i } className="w-4 h-4" /> ) }
				</div>
				<RichText
					tagName="p"
					className="text-stone-700 leading-relaxed mb-8 relative z-10 font-medium"
					value={ text }
					onChange={ ( v ) => setAttributes( { text: v } ) }
					placeholder={ __( 'Review text…', 'tbone-construction' ) }
				/>
				<div className="mt-auto pt-6 border-t border-stone-300/50 flex justify-between items-end">
					<RichText
						tagName="span"
						className="font-serif text-lg text-stone-900"
						value={ name }
						onChange={ ( v ) => setAttributes( { name: v } ) }
						placeholder={ __( 'Name', 'tbone-construction' ) }
					/>
					<span className="text-xs font-bold text-stone-500">{ date }</span>
				</div>
			</div>
		</>
	);
}
