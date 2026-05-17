import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Notice, Spinner, ExternalLink } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';

export default function Edit( { attributes, setAttributes } ) {
	const { cf7FormId } = attributes;
	const blockProps    = useBlockProps();

	const [ loading, setLoading ] = useState( true );
	const [ active,  setActive  ] = useState( true );
	const [ forms,   setForms   ] = useState( [] );

	useEffect( () => {
		let cancelled = false;
		apiFetch( { path: '/tbone-construction/v1/cf7-forms' } )
			.then( ( res ) => {
				if ( cancelled ) return;
				setActive( !! res.active );
				setForms( Array.isArray( res.forms ) ? res.forms : [] );
			} )
			.catch( () => { if ( ! cancelled ) setActive( false ); } )
			.finally( () => { if ( ! cancelled ) setLoading( false ); } );
		return () => { cancelled = true; };
	}, [] );

	const options = [
		{ label: __( '— Select a form —', 'tbone-construction' ), value: 0 },
		...forms.map( ( f ) => ( { label: f.title || `#${ f.id }`, value: f.id } ) ),
	];

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Contact Form 7', 'tbone-construction' ) }>
					{ loading && <Spinner /> }

					{ ! loading && ! active && (
						<Notice status="warning" isDismissible={ false }>
							<p>{ __( 'Contact Form 7 is not active.', 'tbone-construction' ) }</p>
							<ExternalLink href="https://wordpress.org/plugins/contact-form-7/">
								{ __( 'Install Contact Form 7', 'tbone-construction' ) }
							</ExternalLink>
						</Notice>
					) }

					{ ! loading && active && forms.length === 0 && (
						<Notice status="info" isDismissible={ false }>
							{ __( 'No forms found. Create one in Contact → Add New, then come back.', 'tbone-construction' ) }
						</Notice>
					) }

					{ ! loading && active && forms.length > 0 && (
						<SelectControl
							label={ __( 'Form', 'tbone-construction' ) }
							value={ cf7FormId }
							options={ options }
							onChange={ ( v ) => setAttributes( { cf7FormId: parseInt( v, 10 ) || 0 } ) }
						/>
					) }
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<ServerSideRender block={ metadata.name } attributes={ attributes } />
			</div>
		</>
	);
}
