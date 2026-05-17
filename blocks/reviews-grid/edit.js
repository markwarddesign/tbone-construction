import { useBlockProps, useInnerBlocksProps, RichText } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import Icon, { IconStarFill } from '../_shared/icons';

const TEMPLATE = [
	[ 'tbone-construction/review-card', { name: 'Bart Schuerman',      date: '10/10/2024', rating: 5, text: 'This is my third Trex project with Travis. He is dependable efficient honest and does top quality work.' } ],
	[ 'tbone-construction/review-card', { name: 'Trex Customer',       date: '7/3/2024',   rating: 5, text: 'Knowledge of installation was incredible. Travis explains the steps necessary and was accurate about how long the project would take.' } ],
	[ 'tbone-construction/review-card', { name: 'Lu Ann Gergen',       date: '1/17/2024',  rating: 5, text: 'Professionalism, Quality' } ],
	[ 'tbone-construction/review-card', { name: 'Jose Rincon',         date: '12/11/2023', rating: 5, text: 'Travis came through. His work was great, he was very attentive and listened to all my concerns.' } ],
	[ 'tbone-construction/review-card', { name: 'Karen Baldrige',      date: '2/16/2023',  rating: 5, text: 'Travis with T-Bone Construction is very professional, timely and priced very fairly.' } ],
	[ 'tbone-construction/review-card', { name: 'Thomas Stears',       date: '1/30/2023',  rating: 5, text: 'Did good.' } ],
	[ 'tbone-construction/review-card', { name: 'Home Depot Referral', date: '5/26/2022',  rating: 5, text: 'The fence is done well. It looks great and he put in a gate. It was completed in the time frame he stated (2 days).' } ],
	[ 'tbone-construction/review-card', { name: 'Robert Humphrey',     date: '2/25/2022',  rating: 5, text: 'He replied even before we got home from the store! He has been very congenial and has worked hard to accommodate our budget.' } ],
	[ 'tbone-construction/review-card', { name: 'Rick Sandison, MD',   date: '1/2/2022',   rating: 5, text: 'Travis did a great job. He is a very friendly person. I thought the price of his work was fair.' } ],
	[ 'tbone-construction/review-card', { name: 'Tangela Schuerman',   date: '11/13/2021', rating: 5, text: 'Great Work. His attention to detail is spot on. He is very thorough with his job and makes sure you are happy.' } ],
];

export default function Edit( { attributes, setAttributes } ) {
	const { heading, subheading, averageScore, averageLabel } = attributes;
	const blockProps = useBlockProps( { className: 'animate-in fade-in pt-16 pb-24 bg-white relative' } );

	const innerBlocksProps = useInnerBlocksProps(
		{ className: 'grid md:grid-cols-2 lg:grid-cols-3 gap-6 items-start' },
		{
			allowedBlocks: [ 'tbone-construction/review-card' ],
			template:      TEMPLATE,
			orientation:   'horizontal',
		}
	);

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

				<div { ...innerBlocksProps } />
			</div>
		</div>
	);
}
