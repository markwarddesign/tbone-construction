import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextareaControl, TextControl, Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon, { ICON_OPTIONS } from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { icon, title, description, features, imageUrl, imageAlt } = attributes;
	const blockProps = useBlockProps( { className: 'tbc-service-row flex flex-col md:flex-row gap-8 lg:gap-16 items-start' } );

	const featureList = ( features || '' ).split( '\n' ).map( ( s ) => s.trim() ).filter( Boolean );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Service Row', 'tbone-construction' ) }>
					<SelectControl
						label="Icon"
						value={ icon }
						options={ ICON_OPTIONS }
						onChange={ ( v ) => setAttributes( { icon: v } ) }
					/>
					<TextareaControl
						label={ __( 'Features (one per line)', 'tbone-construction' ) }
						value={ features }
						onChange={ ( v ) => setAttributes( { features: v } ) }
					/>
				</PanelBody>
				<PanelBody title={ __( 'Image', 'tbone-construction' ) }>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ ( m ) => setAttributes( {
								imageUrl: m?.url || '',
								imageAlt: m?.alt || imageAlt || '',
							} ) }
							allowedTypes={ [ 'image' ] }
							render={ ( { open } ) => (
								<Button onClick={ open } variant="secondary" style={ { width: '100%' } }>
									{ imageUrl ? __( 'Replace Image', 'tbone-construction' ) : __( 'Select Image', 'tbone-construction' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
					{ imageUrl && (
						<>
							<TextControl label="Alt Text" value={ imageAlt } onChange={ ( v ) => setAttributes( { imageAlt: v } ) } />
							<Button isDestructive variant="link" onClick={ () => setAttributes( { imageUrl: '', imageAlt: '' } ) }>{ __( 'Remove image', 'tbone-construction' ) }</Button>
						</>
					) }
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="md:w-1/2 space-y-6">
					<div className="flex items-center space-x-4 mb-2">
						<div className="p-3 bg-[#faf8f5] border border-stone-200 text-[#c25e24] shadow-sm">
							<Icon name={ icon } className="w-7 h-7" />
						</div>
						<RichText
							tagName="h2"
							className="text-3xl lg:text-4xl font-serif text-stone-900"
							value={ title }
							onChange={ ( v ) => setAttributes( { title: v } ) }
							placeholder={ __( 'Service title…', 'tbone-construction' ) }
						/>
					</div>

					<RichText
						tagName="p"
						className="text-lg text-stone-600 leading-relaxed font-medium"
						value={ description }
						onChange={ ( v ) => setAttributes( { description: v } ) }
						placeholder={ __( 'Long-form description…', 'tbone-construction' ) }
					/>

					{ featureList.length > 0 && (
						<ul className="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-stone-100 list-none p-0">
							{ featureList.map( ( f, i ) => (
								<li key={ i } className="flex items-center text-stone-800 font-medium">
									<Icon name="check-circle-2" className="w-5 h-5 text-[#c25e24] mr-3 shrink-0" />
									{ f }
								</li>
							) ) }
						</ul>
					) }
				</div>

				<div className="md:w-1/2 w-full">
					{ imageUrl ? (
						<div className="border border-stone-200 overflow-hidden shadow-sm">
							<img src={ imageUrl } alt={ imageAlt } className="w-full h-auto object-cover" />
						</div>
					) : (
						<div className="bg-stone-100 border border-stone-200 aspect-[4/3] w-full flex items-center justify-center p-8 text-center">
							<p className="font-serif text-stone-400">{ __( 'Add an image →', 'tbone-construction' ) }</p>
						</div>
					) }
				</div>
			</div>
		</>
	);
}
