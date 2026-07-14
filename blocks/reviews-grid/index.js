import { registerBlockType } from '@wordpress/blocks';
import { InnerBlocks } from '@wordpress/block-editor';
import Edit from './edit';
import metadata from './block.json';

/**
 * v2 stored each review as a `review-card` inner block. This deprecation lets
 * older saved content keep validating and folds those inner blocks into the
 * new `reviews` array attribute on first edit.
 */
const v2 = {
	attributes: {
		heading:      { type: 'string', default: 'Reviews' },
		subheading:   { type: 'string', default: '' },
		averageScore: { type: 'string', default: '4.9 / 5.0' },
		averageLabel: { type: 'string', default: 'Average Local Rating' },
	},
	supports: metadata.supports,
	save: () => <InnerBlocks.Content />,
	isEligible: ( attributes, innerBlocks ) => innerBlocks.length > 0,
	migrate: ( attributes, innerBlocks ) => {
		const reviews = innerBlocks.map( ( block ) => ( {
			name:   block.attributes.name   ?? '',
			date:   block.attributes.date   ?? '',
			rating: block.attributes.rating ?? 5,
			text:   block.attributes.text   ?? '',
		} ) );
		return [ { ...attributes, reviews }, [] ];
	},
};

registerBlockType( metadata.name, {
	edit: Edit,
	save: () => null,
	deprecated: [ v2 ],
} );
