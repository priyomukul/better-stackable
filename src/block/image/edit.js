/**
 * Internal dependencies
 */
import BlockStyles from './style'

/**
 * External dependencies
 */
import classnames from 'classnames'
import { version as VERSION, i18n } from 'stackable'
import { InspectorTabs, AlignButtonsControl } from '~stackable/components'
import { useBlockContext } from '~stackable/hooks'
import {
	BlockDiv,
	useGeneratedCss,
	Image,
	Advanced,
	CustomCSS,
	Responsive,
	CustomAttributes,
	EffectsAnimations,
	ConditionalDisplay,
	MarginBottom,
	Transform,
	getAlignmentClasses,
	Link,
	Alignment,
	Typography,
	getTypographyClasses,
} from '~stackable/block-components'
import {
	withBlockAttributeContext,
	withBlockWrapperIsHovered,
	withQueryLoopContext,
} from '~stackable/higher-order'

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { compose } from '@wordpress/compose'
import { useBlockEditContext } from '@wordpress/block-editor'
import { applyFilters, addFilter } from '@wordpress/hooks'

const heightUnit = [ 'px', 'vh', '%' ]

const Edit = props => {
	const {
		clientId,
		className,
		isSelected,
	} = props

	useGeneratedCss( props.attributes )

	const figcaptionClassnames = classnames(
		getTypographyClasses( props.attributes, 'figcaption%s' ),
		'stk-img-figcaption'

	)

	const blockAlignmentClass = getAlignmentClasses( props.attributes )
	const { parentBlock } = useBlockContext( clientId )

	// Allow special or layout blocks to disable the link for the image block,
	// e.g. image box doesn't need the image to have a link since it has it's
	// own link.
	const enableLink = applyFilters( 'stackable.edit.image.enable-link', true, parentBlock )

	const blockClassNames = classnames( [
		className,
		'stk-block-image',
		blockAlignmentClass,
	] )

	return (
		<>
			{ isSelected && (
				<>
					<InspectorTabs />

					<Alignment.InspectorControls />
					<Image.InspectorControls
						{ ...props }
						initialOpen={ true }
						heightUnits={ heightUnit }
						hasLightbox
					/>
					{ enableLink && <Link.InspectorControls hasTitle={ true } isAdvancedTab={ true } /> }
					<BlockDiv.InspectorControls />
					<Advanced.InspectorControls />
					<Transform.InspectorControls />
					<EffectsAnimations.InspectorControls />
					<CustomAttributes.InspectorControls />
					<CustomCSS.InspectorControls mainBlockClass="stk-block-image" />
					<Responsive.InspectorControls />
					<ConditionalDisplay.InspectorControls />
					<Typography.InspectorControls
						label={ __( 'Caption', i18n ) }
						attrNameTemplate="figcaption%s"
						hasToggle={ true }
						hasTextTag={ false }
						hasTextContent={ true }
						initialOpen={ false }
					/>
				</>
			) }

			<BlockStyles
				version={ VERSION }
				blockState={ props.blockState }
				clientId={ clientId }
			/>
			<CustomCSS mainBlockClass="stk-block-image" />

			<BlockDiv
				blockHoverClass={ props.blockHoverClass }
				clientId={ props.clientId }
				attributes={ props.attributes }
				className={ blockClassNames }
			>
				<Image
					showTooltips
					heightUnits={ heightUnit }
					defaultWidth="100"
					defaultHeight="auto"
				/>
				{ props.attributes.figcaptionShow &&
					<Typography
						className={ figcaptionClassnames }
						attrNameTemplate="figcaption%s"
						placeholder={ __( 'Image Caption', i18n ) }
					/>
				}
			</BlockDiv>
			{ props.isHovered && <MarginBottom /> }
		</>
	)
}

export default compose(
	withBlockWrapperIsHovered,
	withQueryLoopContext,
	withBlockAttributeContext,
)( Edit )

addFilter( 'stackable.block-component.typography.before', 'stackable/image', ( output, props ) => {
	const { name } = useBlockEditContext()

	if ( name !== 'stackable/image' ) {
		return output
	}

	if ( props.attrNameTemplate !== 'figcaption%s' ) {
		return output
	}

	return (
		<>
			<AlignButtonsControl
				label={ __( 'Caption Alignment', i18n ) }
				attribute="figcaptionAlignment"
			/>
		</>
	)
} )
