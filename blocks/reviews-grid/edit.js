import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import Icon, { IconStarFill } from '../_shared/icons';

const BLANK_REVIEW = { name: '', date: '', rating: 5, text: '' };

/** Clickable 1–5 star picker matching the frontend rating row. */
function StarRating( { rating, onChange } ) {
	return (
		<div className="flex items-center space-x-1 mb-6">
			{ [ 1, 2, 3, 4, 5 ].map( ( n ) => (
				<button
					key={ n }
					type="button"
					aria-label={ `${ n } star${ n > 1 ? 's' : '' }` }
					aria-pressed={ n <= rating }
					onClick={ () => onChange( n ) }
					className="p-0 bg-transparent border-0 cursor-pointer leading-none"
				>
					{ n <= rating ? (
						<IconStarFill className="w-4 h-4 text-[#c25e24]" />
					) : (
						<Icon name="star" className="w-4 h-4 text-stone-300" />
					) }
				</button>
			) ) }
		</div>
	);
}

function ReviewCard( { review, index, count, onChange, onRemove, onMove } ) {
	const { name, date, rating, text } = review;

	return (
		<div className="bg-[#faf8f5] p-8 border border-stone-200 flex flex-col relative group">
			{ /* Reorder / remove controls, revealed on hover */ }
			<div className="absolute top-2 left-2 flex gap-1 opacity-0 group-hover:opacity-100 focus-within:opacity-100 transition-opacity z-20">
				<Button
					icon="arrow-up-alt2"
					label={ __( 'Move up', 'tbone-construction' ) }
					size="small"
					disabled={ index === 0 }
					onClick={ () => onMove( -1 ) }
				/>
				<Button
					icon="arrow-down-alt2"
					label={ __( 'Move down', 'tbone-construction' ) }
					size="small"
					disabled={ index === count - 1 }
					onClick={ () => onMove( 1 ) }
				/>
				<Button
					icon="trash"
					label={ __( 'Remove review', 'tbone-construction' ) }
					size="small"
					isDestructive
					onClick={ onRemove }
				/>
			</div>

			<div className="absolute top-6 right-6 text-stone-200">
				<Icon name="quote" className="w-12 h-12" />
			</div>

			<StarRating rating={ rating } onChange={ ( v ) => onChange( { rating: v } ) } />

			<RichText
				tagName="p"
				className="text-stone-700 leading-relaxed mb-8 relative z-10 font-medium"
				value={ text }
				onChange={ ( v ) => onChange( { text: v } ) }
				placeholder={ __( 'Review text…', 'tbone-construction' ) }
			/>

			<div className="mt-auto pt-6 border-t border-stone-300/50 flex justify-between items-end gap-3">
				<RichText
					tagName="span"
					className="font-serif text-lg text-stone-900"
					value={ name }
					onChange={ ( v ) => onChange( { name: v } ) }
					placeholder={ __( 'Name', 'tbone-construction' ) }
				/>
				<input
					type="text"
					value={ date }
					onChange={ ( e ) => onChange( { date: e.target.value } ) }
					placeholder={ __( 'Date', 'tbone-construction' ) }
					className="text-xs font-bold text-stone-500 bg-transparent text-right w-24 border-0 p-0 focus:outline-none placeholder:text-stone-400"
				/>
			</div>
		</div>
	);
}

export default function Edit( { attributes, setAttributes } ) {
	const { heading, subheading, averageScore, averageLabel, reviews } = attributes;
	const blockProps = useBlockProps( { className: 'animate-in fade-in pt-16 pb-24 bg-white relative' } );

	const updateReview = ( index, patch ) =>
		setAttributes( { reviews: reviews.map( ( r, i ) => ( i === index ? { ...r, ...patch } : r ) ) } );

	const addReview = () => setAttributes( { reviews: [ ...reviews, { ...BLANK_REVIEW } ] } );

	const removeReview = ( index ) =>
		setAttributes( { reviews: reviews.filter( ( _, i ) => i !== index ) } );

	const moveReview = ( index, dir ) => {
		const target = index + dir;
		if ( target < 0 || target >= reviews.length ) return;
		const next = [ ...reviews ];
		[ next[ index ], next[ target ] ] = [ next[ target ], next[ index ] ];
		setAttributes( { reviews: next } );
	};

	return (
		<div { ...blockProps }>
			<div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div className="flex flex-col md:flex-row justify-between items-start md:items-end mb-16">
					<div className="flex-1">
						<div className="flex items-center gap-3 mb-6">
							<div className="w-12 h-0.5 bg-[#c25e24]" />
							<Icon name="compass" className="w-5 h-5 text-[#c25e24]" />
							<div className="w-12 h-0.5 bg-[#c25e24]" />
						</div>
						<RichText tagName="h2" className="text-4xl md:text-5xl font-serif text-stone-800 tracking-tight mb-6 leading-tight" value={ heading } onChange={ ( v ) => setAttributes( { heading: v } ) } />
						<RichText tagName="p"  className="text-lg text-stone-600 max-w-2xl font-medium leading-relaxed" value={ subheading } onChange={ ( v ) => setAttributes( { subheading: v } ) } />
					</div>
					<div className="mt-8 md:mt-0 flex flex-col items-start md:items-end bg-white p-6 shadow-md border border-stone-100 transform rotate-1">
						<div className="flex items-center space-x-1 mb-2 text-[#c25e24]">
							{ [ 1, 2, 3, 4, 5 ].map( ( i ) => <IconStarFill key={ i } className="w-5 h-5" /> ) }
						</div>
						<RichText tagName="span" className="font-serif text-2xl text-stone-900" value={ averageScore } onChange={ ( v ) => setAttributes( { averageScore: v } ) } />
						<RichText tagName="span" className="text-xs font-bold text-stone-500 uppercase tracking-widest" value={ averageLabel } onChange={ ( v ) => setAttributes( { averageLabel: v } ) } />
					</div>
				</div>

				<div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
					{ reviews.map( ( review, index ) => (
						<ReviewCard
							key={ index }
							review={ review }
							index={ index }
							count={ reviews.length }
							onChange={ ( patch ) => updateReview( index, patch ) }
							onRemove={ () => removeReview( index ) }
							onMove={ ( dir ) => moveReview( index, dir ) }
						/>
					) ) }

					<button
						type="button"
						onClick={ addReview }
						className="min-h-[220px] flex flex-col items-center justify-center gap-2 border-2 border-dashed border-stone-300 text-stone-500 font-medium cursor-pointer bg-transparent hover:border-[#c25e24] hover:text-[#c25e24] transition-colors"
					>
						<span className="text-3xl leading-none">+</span>
						{ __( 'Add review', 'tbone-construction' ) }
					</button>
				</div>
			</div>
		</div>
	);
}
