import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button, TextControl } from '@wordpress/components';
import ServerSideRender from '@wordpress/server-side-render';
import { __ } from '@wordpress/i18n';
import metadata from './block.json';

export default function Edit( { attributes, setAttributes } ) {
	const { logoId, logoUrl, logoAlt, ctaText, ctaUrl } = attributes;
	const blockProps = useBlockProps();

	const resolveMediaUrl = ( m ) => m?.url || m?.source_url || m?.sizes?.full?.url || '';

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Logo', 'tbone-construction' ) }>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={ media => setAttributes( {
								logoId: media?.id || 0,
								logoUrl: resolveMediaUrl( media ),
								logoAlt: media?.alt || logoAlt || '',
							} ) }
							allowedTypes={ [ 'image', 'image/svg+xml' ] }
							value={ logoId }
							render={ ( { open } ) => (
								<Button onClick={ open } variant="secondary" style={ { width: '100%' } }>
									{ logoUrl ? __( 'Replace Logo', 'tbone-construction' ) : __( 'Select Logo', 'tbone-construction' ) }
								</Button>
							) }
						/>
					</MediaUploadCheck>
					{ logoUrl && (
						<>
							<TextControl label={ __( 'Logo Alt Text', 'tbone-construction' ) } value={ logoAlt } onChange={ v => setAttributes( { logoAlt: v } ) } />
							<Button onClick={ () => setAttributes( { logoId: 0, logoUrl: '', logoAlt: '' } ) } variant="link" isDestructive>{ __( 'Remove Logo', 'tbone-construction' ) }</Button>
						</>
					) }
				</PanelBody>
				<PanelBody title={ __( 'CTA Button', 'tbone-construction' ) }>
					<TextControl label="Button Text" value={ ctaText } onChange={ v => setAttributes( { ctaText: v } ) } />
					<TextControl label="Button URL"  value={ ctaUrl  } onChange={ v => setAttributes( { ctaUrl:  v } ) } />
				</PanelBody>
			</InspectorControls>
			<div { ...blockProps }>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}
