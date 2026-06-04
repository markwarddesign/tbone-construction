import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { __ } from '@wordpress/i18n';

export default function Edit( { attributes, setAttributes } ) {
	const { categorySlug } = attributes;
	const blockProps = useBlockProps( { className: 'pt-16 pb-24 bg-[#faf8f5]' } );

	const terms = useSelect(
		( select ) =>
			select( coreStore ).getEntityRecords( 'taxonomy', 'tbc_project_category', {
				per_page: -1,
			} ),
		[]
	);

	const options = [
		{ label: __( 'Auto (use the queried category)', 'tbone-construction' ), value: '' },
		...( terms || [] ).map( ( t ) => ( { label: t.name, value: t.slug } ) ),
	];

	const selected =
		( terms || [] ).find( ( t ) => t.slug === categorySlug )?.name ||
		__( 'the queried category', 'tbone-construction' );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Project Category', 'tbone-construction' ) }>
					<SelectControl
						label={ __( 'Category', 'tbone-construction' ) }
						value={ categorySlug }
						options={ options }
						onChange={ ( value ) => setAttributes( { categorySlug: value } ) }
						help={ __(
							'Leave on "Auto" inside the category archive template — the page renders the category being viewed. Pick a category to hard-bind this block elsewhere.',
							'tbone-construction'
						) }
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
					<p className="text-[#c25e24] font-bold tracking-widest uppercase text-sm mb-2">
						{ __( 'Project Gallery', 'tbone-construction' ) }
					</p>
					<h1 className="text-5xl md:text-6xl font-serif text-stone-900 leading-tight mb-4">
						{ selected }
					</h1>
					<p className="text-stone-500 italic">
						{ __(
							'Intro copy, the category project grid (with lightbox), related categories, services, and CTA render on the live page.',
							'tbone-construction'
						) }
					</p>
				</div>
			</div>
		</>
	);
}
