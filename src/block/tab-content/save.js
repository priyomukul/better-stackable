/**
 * Internal dependencies
 */
import BlockStyles from './style'

/**
 * External dependencies
 */
import { withVersion } from '~stackable/higher-order'
import { version as VERSION } from 'stackable'
import classnames from 'classnames'
import {
	BlockDiv,
	CustomCSS,
	getAlignmentClasses,
	getResponsiveClasses,
	getRowClasses,
	Separator,
	getSeparatorClasses,
	getContentAlignmentClasses,
} from '~stackable/block-components'

/**
 * WordPress dependencies
 */
import { InnerBlocks } from '@wordpress/block-editor'
import { applyFilters } from '@wordpress/hooks'
import { compose } from '@wordpress/compose'

export const Save = props => {
	const {
		attributes,
	} = props

	const rowClass = getRowClasses( props.attributes )
	const separatorClass = getSeparatorClasses( props.attributes )
	const blockAlignmentClass = getAlignmentClasses( props.attributes )
	const responsiveClass = getResponsiveClasses( props.attributes )

	const blockClassName = classnames( [
		props.className,
		'stk-block-tab-content',
		responsiveClass,
		separatorClass,
	] )

	const contentClassNames = classnames( applyFilters( 'stackable.tab-content.save.contentClassNames', [
		[
			rowClass,
			'stk-inner-blocks',
			blockAlignmentClass,
			'stk-block-content',
		],
		getContentAlignmentClasses( props.attributes ),
	], props ) )

	return (
		<BlockDiv.Content
			className={ blockClassName }
			attributes={ attributes }
			version={ props.version }
		>
			<BlockStyles.Content version={ props.version } attributes={ attributes } />
			<CustomCSS.Content attributes={ attributes } />
			<Separator.Content attributes={ attributes }>
				<div className={ contentClassNames }>
					<InnerBlocks.Content />
				</div>
			</Separator.Content>
		</BlockDiv.Content>
	)
}

export default compose(
	withVersion( VERSION )
)( Save )
