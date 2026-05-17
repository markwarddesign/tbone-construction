import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, Notice, Spinner, ExternalLink } from '@wordpress/components';
import { useEffect, useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import Icon from '../_shared/icons';

export default function Edit( { attributes, setAttributes } ) {
	const { heading, subheading, sidebarHeading, callLabel, emailLabel, areaLabel, areaText, cf7FormId } = attributes;
	const set = ( k ) => ( v ) => setAttributes( { [ k ]: v } );
	const blockProps = useBlockProps( { className: 'animate-in fade-in pt-16 pb-24 bg-[#faf8f5]' } );

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

	const formOptions = [
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
							{ __( 'No forms found. Create one in Contact → Add New.', 'tbone-construction' ) }
						</Notice>
					) }

					{ ! loading && active && forms.length > 0 && (
						<SelectControl
							label={ __( 'Form', 'tbone-construction' ) }
							value={ cf7FormId }
							options={ formOptions }
							onChange={ ( v ) => setAttributes( { cf7FormId: parseInt( v, 10 ) || 0 } ) }
						/>
					) }
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
						<RichText tagName="h2" className="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight" value={ heading } onChange={ set( 'heading' ) } placeholder={ __( 'Section heading…', 'tbone-construction' ) } />
						<RichText tagName="p"  className="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed" value={ subheading } onChange={ set( 'subheading' ) } placeholder={ __( 'Subheading…', 'tbone-construction' ) } />
					</div>

					<div className="grid lg:grid-cols-3 gap-12 mt-12 bg-white border border-stone-200 shadow-xl overflow-hidden">
						<div className="lg:col-span-1 bg-[#1f2926] text-white p-10 lg:p-12 relative overflow-hidden">
							<div className="relative z-10 space-y-12">
								<div>
									<RichText tagName="h3" className="font-serif text-2xl text-[#c25e24] mb-6" value={ sidebarHeading } onChange={ set( 'sidebarHeading' ) } placeholder={ __( 'Sidebar heading…', 'tbone-construction' ) } />
									<div className="space-y-6">
										<div className="flex items-start">
											<Icon name="phone" className="w-6 h-6 text-stone-400 mr-4 shrink-0" />
											<div>
												<RichText tagName="p" className="text-sm font-bold tracking-widest uppercase text-stone-500 mb-1" value={ callLabel } onChange={ set( 'callLabel' ) } />
												<p className="text-lg font-medium text-white">{ __( '(phone — set in Theme Settings)', 'tbone-construction' ) }</p>
											</div>
										</div>
										<div className="flex items-start">
											<Icon name="mail" className="w-6 h-6 text-stone-400 mr-4 shrink-0" />
											<div>
												<RichText tagName="p" className="text-sm font-bold tracking-widest uppercase text-stone-500 mb-1" value={ emailLabel } onChange={ set( 'emailLabel' ) } />
												<p className="text-lg font-medium text-white">{ __( '(email — set in Theme Settings)', 'tbone-construction' ) }</p>
											</div>
										</div>
									</div>
								</div>

								<div className="pt-8 border-t border-white/10">
									<div className="flex items-start">
										<Icon name="map-pin" className="w-6 h-6 text-[#c25e24] mr-4 shrink-0" />
										<div>
											<RichText tagName="p" className="text-sm font-bold tracking-widest uppercase text-stone-500 mb-2" value={ areaLabel } onChange={ set( 'areaLabel' ) } />
											<RichText tagName="p" className="text-stone-300 leading-relaxed" value={ areaText } onChange={ set( 'areaText' ) } placeholder={ __( 'Service area description…', 'tbone-construction' ) } />
										</div>
									</div>
								</div>
							</div>
						</div>

						<div className="lg:col-span-2 p-10 lg:p-12 tbc-cf7-wrapper">
							{ ! loading && active && cf7FormId > 0 ? (
								<div className="bg-stone-100 border border-dashed border-stone-300 p-10 text-center text-stone-500">
									<p className="font-serif text-xl mb-1">Contact Form 7</p>
									<p className="text-sm">{ ( forms.find( ( f ) => f.id === cf7FormId )?.title ) || `#${ cf7FormId }` }</p>
								</div>
							) : (
								<div className="bg-amber-50 border border-amber-300 text-amber-900 p-6">
									<p className="font-bold mb-1">{ ! active ? __( 'CF7 not active', 'tbone-construction' ) : __( 'No form selected', 'tbone-construction' ) }</p>
									<p className="text-sm">{ ! active ? __( 'Install Contact Form 7.', 'tbone-construction' ) : __( 'Pick a form from the block sidebar.', 'tbone-construction' ) }</p>
								</div>
							) }
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
