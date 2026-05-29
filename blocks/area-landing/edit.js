import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const AREA_OPTIONS = [
	{ label: 'Twin Falls', value: 'twin-falls' },
	{ label: 'Filer', value: 'filer' },
	{ label: 'Buhl', value: 'buhl' },
	{ label: 'Jerome', value: 'jerome' },
	{ label: 'Burley', value: 'burley' },
	{ label: 'Hailey', value: 'hailey' },
];

export default function Edit( { attributes, setAttributes } ) {
	const { areaSlug, heading, intro, ctaText, ctaUrl } = attributes;
	const set = ( key ) => ( value ) => setAttributes( { [ key ]: value } );
	const cityName =
		AREA_OPTIONS.find( ( o ) => o.value === areaSlug )?.label || 'this area';
	const blockProps = useBlockProps( {
		className: 'py-16 bg-[#faf8f5]',
	} );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Service Area', 'tbone-construction' ) }>
					<SelectControl
						label={ __( 'City', 'tbone-construction' ) }
						value={ areaSlug }
						options={ AREA_OPTIONS }
						onChange={ set( 'areaSlug' ) }
						help={ __(
							'Pulls localized copy and SEO data for the selected Magic Valley city. Leave the heading and intro blank to use the city defaults.',
							'tbone-construction'
						) }
					/>
					<TextControl
						label={ __( 'CTA Text', 'tbone-construction' ) }
						value={ ctaText }
						onChange={ set( 'ctaText' ) }
					/>
					<TextControl
						label={ __( 'CTA URL', 'tbone-construction' ) }
						value={ ctaUrl }
						onChange={ set( 'ctaUrl' ) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
					<p className="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">
						{ __( 'Areas We Serve', 'tbone-construction' ) }
					</p>
					<RichText
						tagName="h1"
						className="text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-8"
						value={ heading }
						onChange={ set( 'heading' ) }
						placeholder={ `Construction in ${ cityName }, Idaho` }
					/>
					<RichText
						tagName="p"
						className="text-xl text-stone-600 font-medium leading-relaxed mb-8"
						value={ intro }
						onChange={ set( 'intro' ) }
						placeholder={ __(
							'Leave blank to use the city default intro…',
							'tbone-construction'
						) }
					/>
					<p className="text-stone-500 italic">
						{ __(
							'Localized services list, trust points, and CTA render on the live page.',
							'tbone-construction'
						) }
					</p>
				</div>
			</div>
		</>
	);
}
