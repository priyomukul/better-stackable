/**
 * Based on: https://github.com/WordPress/gutenberg/blob/master/packages/editor/src/components/convert-to-group-buttons/index.js
 */

/**
 * Internal dependencies
 */
import ConvertToGroupButton from './buttons'

/**
 * WordPress dependencies
 */
import { withSelect } from '@wordpress/data'

const Buttons = withSelect( select => {
	const { getSelectedBlockClientIds } = select( 'core/block-editor' )
	return {
		clientIds: getSelectedBlockClientIds(),
	}
} )( ConvertToGroupButton )

export default Buttons
