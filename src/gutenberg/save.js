/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Internal dependencies
 */
import { blockStyle } from './index';

const Save = () => {
	const blockProps = useBlockProps.save({ style: blockStyle });
	
	const meta = wp.data.select('core/editor').getEditedPostAttribute('meta');

	return (
		<div {...blockProps}>
			<h4>Summary:</h4>
			{ meta['tldrgpt_summary'] }
		</div>
	);
};
export default Save;