import { useBlockProps, useInnerBlocksProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

const TEMPLATE = [
	[ 'tbone-construction/service-card', { icon: 'hammer',       title: 'Decks & Railings',     description: 'Premium Trex and TimberTech deck installations.',     linkUrl: '/services' } ],
	[ 'tbone-construction/service-card', { icon: 'sun',          title: 'Canopies & Covers',    description: 'Durable outdoor oasis solutions for hot Idaho summers.', linkUrl: '/services' } ],
	[ 'tbone-construction/service-card', { icon: 'shield-check', title: 'Siding Installation',  description: 'Vinyl, LP SmartSide, and Metal siding options.',     linkUrl: '/services' } ],
	[ 'tbone-construction/service-card', { icon: 'ruler',        title: 'Window Replacements',  description: 'Improve comfort, appearance, and energy savings.',   linkUrl: '/services' } ],
	[ 'tbone-construction/service-card', { icon: 'wrench',       title: 'Home Renovations',     description: 'Practical and stunning kitchen and bath updates.',   linkUrl: '/services' } ],
	[ 'tbone-construction/service-card', { icon: 'trees',        title: 'Sheds & Greenhouses',  description: "Custom structures for Idaho's unpredictable climate.", linkUrl: '/services' } ],
];

export default function Edit( { attributes, setAttributes } ) {
	const { heading, subheading, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps( { className: 'py-24 bg-white relative' } );

	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'grid md:grid-cols-2 lg:grid-cols-3 gap-8' },
		{
			allowedBlocks: [ 'tbone-construction/service-card' ],
			template:      TEMPLATE,
			orientation:   'horizontal',
		}
	);

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTA Button', 'tbone-construction' ) }>
					<TextControl label="Button Text" value={ ctaText } onChange={ ( v ) => setAttributes( { ctaText: v } ) } />
					<TextControl label="Button URL"  value={ ctaUrl }  onChange={ ( v ) => setAttributes( { ctaUrl: v } ) } />
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
					<div className="mb-16 text-center mx-auto flex flex-col items-center">
						<div className="flex items-center gap-3 mb-6">
							<div className="w-12 h-0.5 bg-[#c25e24]" />
							<Icon name="compass" className="w-5 h-5 text-[#c25e24]" />
							<div className="w-12 h-0.5 bg-[#c25e24]" />
						</div>
						<RichText
							tagName="h2"
							className="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight"
							value={ heading }
							onChange={ ( v ) => setAttributes( { heading: v } ) }
							placeholder={ __( 'Section heading…', 'tbone-construction' ) }
						/>
						<RichText
							tagName="p"
							className="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed"
							value={ subheading }
							onChange={ ( v ) => setAttributes( { subheading: v } ) }
							placeholder={ __( 'Section subheading…', 'tbone-construction' ) }
						/>
					</div>

					<div { ...innerBlocksProps } />

					{ ctaText && (
						<div className="mt-16 text-center">
							<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-transparent border-stone-800 text-stone-800">
								{ ctaText }
							</span>
						</div>
					) }
				</div>
			</section>
		</>
	);
}
