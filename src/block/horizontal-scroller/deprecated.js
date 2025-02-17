import { Save } from './save'
import { attributes } from './schema'

import { withVersion } from '~stackable/higher-order'
import { deprecateBlockBackgroundColorOpacity, deprecateContainerBackgroundColorOpacity } from '~stackable/block-components'
import { addFilter } from '@wordpress/hooks'
import compareVersions from 'compare-versions'

// Previously, our horizontal scroller always had the stk--fit-content class (which was wrong).
addFilter( 'stackable.horizontal-scroller.save.contentClassNames', 'stackable/3_8_0', ( classes, props ) => {
	if ( compareVersions( props.version, '3.8.0' ) >= 0 ) { // Current version is greater than 3.6.1
		return classes
	}

	return [
		...classes,
		{ 'stk--fit-content': true },
	]
} )

const deprecated = [
	// Support the new combined opacity and color.
	{
		attributes: attributes( '3.11.9' ),
		save: withVersion( '3.11.9' )( Save ),
		isEligible: attributes => {
			const hasContainerOpacity = deprecateContainerBackgroundColorOpacity.isEligible( attributes )
			const hasBlockOpacity = deprecateBlockBackgroundColorOpacity.isEligible( attributes )

			return hasContainerOpacity || hasBlockOpacity
		},
		migrate: attributes => {
			let newAttributes = { ...attributes }

			newAttributes = deprecateContainerBackgroundColorOpacity.migrate( newAttributes )
			newAttributes = deprecateBlockBackgroundColorOpacity.migrate( newAttributes )

			return newAttributes
		},
	},
	// Support new margin-top/bottom classes.
	{
		attributes: attributes( '3.7.9' ),
		save: withVersion( '3.7.9' )( Save ),
		migrate: attributes => {
			const newAttributes = deprecateContainerBackgroundColorOpacity.migrate( attributes )
			return deprecateBlockBackgroundColorOpacity.migrate( newAttributes )
		},
	},
]
export default deprecated
