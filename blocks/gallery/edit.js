import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl, SelectControl, ExternalLink } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import ServerSideRender from '@wordpress/server-side-render';
import Icon from '../_shared/icons';
import metadata from './block.json';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, subheading, limit, categorySlug } = attributes;
	const blockProps = useBlockProps( { className: 'animate-in fade-in pt-16 pb-24 bg-[#faf8f5]' } );

	const terms = useSelect(
		( select ) => select( 'core' ).getEntityRecords( 'taxonomy', 'tbc_project_category', { per_page: -1 } ),
		[]
	);

	const categoryOptions = [
		{ label: __( 'All categories', 'tbone-construction' ), value: '' },
		...( terms || [] ).map( ( t ) => ( { label: t.name, value: t.slug } ) ),
	];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Source', 'tbone-construction' ) }>
					<p style={ { marginTop: 0 } }>
						{ __( 'Items come from the Projects post type.', 'tbone-construction' ) }
						{ ' ' }
						<ExternalLink href="/wp-admin/edit.php?post_type=tbc_project">
							{ __( 'Manage Projects', 'tbone-construction' ) }
						</ExternalLink>
					</p>
					<RangeControl
						label={ __( 'Maximum items', 'tbone-construction' ) }
						min={ 1 }
						max={ 60 }
						value={ limit }
						onChange={ ( v ) => setAttributes( { limit: v } ) }
					/>
					<SelectControl
						label={ __( 'Filter to category', 'tbone-construction' ) }
						value={ categorySlug }
						options={ categoryOptions }
						onChange={ ( v ) => setAttributes( { categorySlug: v } ) }
					/>
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
						<RichText tagName="h2" className="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p"  className="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed" value={ subheading } onChange={ ( v ) => setAttributes( { subheading: v } ) } />
					</div>

					<ServerSideRender
						block={ metadata.name }
						attributes={ attributes }
						EmptyResponsePlaceholder={ () => (
							<div className="bg-white border border-stone-200 p-12 text-center text-stone-500">
								<p className="font-serif text-2xl mb-2">No projects yet</p>
								<p className="text-sm">Add some in Projects → Add New.</p>
							</div>
						) }
					/>
				</div>
			</div>
		</>
	);
}
