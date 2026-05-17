import { useBlockProps } from '@wordpress/block-editor';
import ServerSideRender from '@wordpress/server-side-render';
import metadata from './block.json';

export default function Edit() {
	const blockProps = useBlockProps();
	return (
		<div { ...blockProps }>
			<ServerSideRender block={ metadata.name } />
			<p style={ { fontSize: '11px', color: '#888', margin: '4px 0 0' } }>
				Edit values in Appearance → Theme Settings.
			</p>
		</div>
	);
}
