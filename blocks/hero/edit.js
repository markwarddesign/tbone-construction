import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, RadioControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { badge, headingTop, headingAccent, body, primaryCtaText, primaryCtaUrl, secondaryCtaText, secondaryCtaUrl, image1Url, image2Url } = attributes;
	const imageCount = image2Url ? '2' : '1';
	const setImageCount = ( v ) => {
		if ( v === '1' ) setAttributes( { image2Url: '' } );
	};
	const showImg2 = imageCount === '2';
	const blockProps = useBlockProps( { className: 'animate-in fade-in bg-[#faf8f5]' } );

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'CTAs', 'tbone-construction' ) }>
					<TextControl label="Primary CTA Text"   value={ primaryCtaText }   onChange={ ( v ) => setAttributes( { primaryCtaText: v } ) } />
					<TextControl label="Primary CTA URL"    value={ primaryCtaUrl }    onChange={ ( v ) => setAttributes( { primaryCtaUrl: v } ) } />
					<TextControl label="Secondary CTA Text" value={ secondaryCtaText } onChange={ ( v ) => setAttributes( { secondaryCtaText: v } ) } />
					<TextControl label="Secondary CTA URL"  value={ secondaryCtaUrl }  onChange={ ( v ) => setAttributes( { secondaryCtaUrl: v } ) } />
				</PanelBody>
				<PanelBody title={ __( 'Images', 'tbone-construction' ) }>
					<RadioControl
						label={ __( 'Layout', 'tbone-construction' ) }
						help={ __( 'Single shows one larger image. Two displays the stacked/overlapping pair.', 'tbone-construction' ) }
						selected={ imageCount }
						options={ [
							{ label: __( 'Single image (larger)', 'tbone-construction' ), value: '1' },
							{ label: __( 'Two images (stacked)', 'tbone-construction' ), value: '2' },
						] }
						onChange={ setImageCount }
					/>
					<MediaUploadCheck>
						<MediaUpload allowedTypes={ [ 'image' ] } onSelect={ ( m ) => setAttributes( { image1Url: m?.url || '' } ) } render={ ( { open } ) => (
							<Button onClick={ open } variant="secondary" style={ { width: '100%', marginBottom: 8 } }>{ image1Url ? __( 'Replace Image', 'tbone-construction' ) : __( 'Select Image', 'tbone-construction' ) }</Button>
						) } />
					</MediaUploadCheck>
					{ image1Url && (
						<Button isDestructive variant="link" onClick={ () => setAttributes( { image1Url: '' } ) } style={ { marginBottom: 12 } }>
							{ __( 'Remove image', 'tbone-construction' ) }
						</Button>
					) }
					{ showImg2 && (
						<>
							<MediaUploadCheck>
								<MediaUpload allowedTypes={ [ 'image' ] } onSelect={ ( m ) => setAttributes( { image2Url: m?.url || '' } ) } render={ ( { open } ) => (
									<Button onClick={ open } variant="secondary" style={ { width: '100%' } }>{ image2Url ? __( 'Replace Image 2', 'tbone-construction' ) : __( 'Select Image 2', 'tbone-construction' ) }</Button>
								) } />
							</MediaUploadCheck>
							{ image2Url && (
								<Button isDestructive variant="link" onClick={ () => setAttributes( { image2Url: '' } ) }>
									{ __( 'Remove image 2', 'tbone-construction' ) }
								</Button>
							) }
						</>
					) }
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<div className="relative pt-16 pb-24 lg:pt-24 lg:pb-32 overflow-hidden border-b border-stone-200">
					<div className="absolute inset-0 opacity-40 tbc-dot-grid"></div>

					<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
						<div className="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">

							<div className="lg:col-span-6 flex flex-col items-start text-left">
								<div className="inline-flex items-center space-x-2 bg-white px-4 py-2 border border-stone-200 shadow-sm mb-8 transform">
									<Icon name="map-pin" className="w-4 h-4 text-[#c25e24]" />
									<RichText tagName="span" className="text-sm font-bold text-stone-700 uppercase tracking-widest" value={ badge } onChange={ ( v ) => setAttributes( { badge: v } ) } />
								</div>

								<h1 className="text-5xl sm:text-6xl lg:text-7xl font-serif text-stone-900 leading-[1.1] mb-6">
									<RichText tagName="span" value={ headingTop }    onChange={ ( v ) => setAttributes( { headingTop: v } ) } /><br />
									<RichText tagName="span" className="text-[#c25e24] italic" value={ headingAccent } onChange={ ( v ) => setAttributes( { headingAccent: v } ) } />
								</h1>

								<RichText tagName="p" className="text-lg text-stone-600 mb-10 max-w-lg leading-relaxed font-medium" value={ body } onChange={ ( v ) => setAttributes( { body: v } ) } />

								<div className="flex flex-col sm:flex-row gap-5">
									<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-[#c25e24] border-[#c25e24] text-white">{ primaryCtaText }</span>
									<span className="inline-flex items-center justify-center px-8 py-3.5 font-bold border-2 bg-white border-stone-800 text-stone-800">{ secondaryCtaText }</span>
								</div>
							</div>

							<div className="lg:col-span-6 relative h-[500px] hidden md:block">
								{ image1Url && image2Url ? (
									<>
										<div className="absolute top-0 right-0 w-3/4 h-3/4 border-8 border-white shadow-xl transform rotate-3 z-10">
											<img src={ image1Url } alt="" className="w-full h-full object-cover" />
										</div>
										<div className="absolute bottom-0 left-0 w-2/3 h-2/3 border-8 border-white shadow-lg transform -rotate-3 z-20">
											<img src={ image2Url } alt="" className="w-full h-full object-cover" />
											<div className="absolute -bottom-4 -right-4 bg-[#c25e24] text-white p-3 shadow-md transform rotate-6">
												<Icon name="hard-hat" className="w-6 h-6" />
											</div>
										</div>
									</>
								) : ( image1Url || image2Url ) ? (
									<div className="absolute inset-0 border-8 border-white shadow-xl">
										<img src={ image1Url || image2Url } alt="" className="w-full h-full object-cover" />
										<div className="absolute -bottom-4 -right-4 bg-[#c25e24] text-white p-3 shadow-md transform rotate-6">
											<Icon name="hard-hat" className="w-6 h-6" />
										</div>
									</div>
								) : null }
							</div>

						</div>
					</div>
				</div>
			</div>
		</>
	);
}
