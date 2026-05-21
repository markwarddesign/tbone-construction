import { useBlockProps, useInnerBlocksProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

const TEMPLATE = [
	[ 'tbone-construction/service-row', { icon: 'hammer',       title: 'Decks & Railings',     description: 'Deck building is our specialty. We work with Trex, TimberTech, Eva-Last, and Sylvanix. We finish projects with premium railing systems from RDI and Trex.', features: "TrexPro® Certified\nCustom Layouts\nPremium Railings\nRainEscape® Systems" } ],
	[ 'tbone-construction/service-row', { icon: 'sun',          title: 'Canopies & Covers',    description: 'Idaho summers get hot. Create a unique outdoor oasis valuing durability that stands the test of time, from raw, rich, rough-sawn lumber to refined carpentry.',  features: "Rough-sawn lumber\nRefined Carpentry\nCustom Shade Solutions" } ],
	[ 'tbone-construction/service-row', { icon: 'shield-check', title: 'Siding Installation',  description: 'Whether you want vinyl with minimal maintenance, the warm authentic look of painted LP SmartSide, or tough metal, we have siding options to withstand weathering.', features: "Vinyl (Crack-resistant)\nLP SmartSide (Engineered Wood)\nMetal (Steel/Aluminum)" } ],
	[ 'tbone-construction/service-row', { icon: 'ruler',        title: 'Window Replacements',  description: 'New windows make a dramatic difference in comfort, appearance, and energy savings. We offer trusted brands from entry-level vinyl to high-end wood frames.',           features: "Energy Efficient\nVinyl to Wood Frames\nDraft Elimination" } ],
	[ 'tbone-construction/service-row', { icon: 'wrench',       title: 'Home Renovations',     description: 'Full kitchen remodels, peaceful bathroom updates, or quick home refreshes — we make your vision practical and stunning, guiding design choices and materials to match your style.', features: "Kitchen Remodels\nBathroom Updates\nDesign Consultation" } ],
	[ 'tbone-construction/service-row', { icon: 'trees',        title: 'Sheds & Greenhouses',  description: "We design and build customizable sheds that fit your space, style, and budget — plus durable greenhouses crafted to meet Idaho's unpredictable climate.",          features: "Custom Sheds\nDurable Greenhouses\nWeather-resistant" } ],
];

export default function Edit( { attributes, setAttributes } ) {
	const { heading, subheading } = attributes;
	const blockProps = useBlockProps( { className: 'animate-in fade-in pt-16 pb-24 bg-white' } );

	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'space-y-16 mt-16' },
		{
			allowedBlocks: [ 'tbone-construction/service-row' ],
			template:      TEMPLATE,
			orientation:   'vertical',
		}
	);

	return (
		<div { ...blockProps }>
			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div className="mb-16">
					<div className="flex items-center gap-3 mb-6">
						<div className="w-12 h-0.5 bg-[#c25e24]" />
						<Icon name="compass" className="w-5 h-5 text-[#c25e24]" />
						<div className="w-12 h-0.5 bg-[#c25e24]" />
					</div>
					<RichText tagName="h2" className="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } placeholder={ __( 'Section heading…', 'tbone-construction' ) } />
					<RichText tagName="p"  className="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed" value={ subheading } onChange={ ( v ) => setAttributes( { subheading: v } ) } placeholder={ __( 'Section subheading…', 'tbone-construction' ) } />
				</div>

				<div { ...innerBlocksProps } />
			</div>
		</div>
	);
}
