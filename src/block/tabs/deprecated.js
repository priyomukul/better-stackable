import { deprecateBlockBackgroundColorOpacity, deprecateContainerBackgroundColorOpacity } from '~stackable/block-components'
import { Save } from './save'
import { attributes } from './schema'

import { withVersion } from '~stackable/higher-order'

const deprecated = [
	{
		attributes: attributes( '3.12.3' ),
		migrate: attributes => {
			let newAttributes = { ...attributes }

			// Also add the older migration rules because they will not be applied.
			const hasContainerOpacity = deprecateContainerBackgroundColorOpacity.isEligible( attributes )
			if ( hasContainerOpacity ) {
				newAttributes = deprecateContainerBackgroundColorOpacity.migrate( newAttributes )
			}

			const hasBlockOpacity = deprecateBlockBackgroundColorOpacity.isEligible( attributes )
			if ( hasBlockOpacity ) {
				newAttributes = deprecateBlockBackgroundColorOpacity.migrate( newAttributes )
			}

			return {
				...newAttributes,
				equalTabHeight: true,
			}
		},
		save: withVersion( '3.12.3' )( Save ),
	},
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
]
export default deprecated
