/**
 * BLOCK: Divider Block
 */
/**
 * External dependencies
 */
import { DividerIcon } from '~stackable/icons'

/**
 * Internal dependencies
 */
import edit from './edit'
import schema from './schema'
import metadata from './block.json'
import example from './example'
import deprecated from './deprecated'

export const settings = {
	...metadata,
	icon: DividerIcon,
	attributes: schema,
	supports: {
		align: [ 'center', 'wide', 'full' ],
		anchor: true,
		spacing: true,
	},
	example,

	deprecated,
	edit,
	save : () => null,
}
