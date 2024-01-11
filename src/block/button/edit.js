/**
 * External dependencies
 */
import classnames from 'classnames'
import { version as VERSION, i18n } from 'stackable'
import { InspectorTabs } from '~stackable/components'
import {
	getTypographyClasses,
	BlockDiv,
	useGeneratedCss,
	Advanced,
	CustomCSS,
	Responsive,
	Button,
	Typography,
	BlockStyle,
	CustomAttributes,
	EffectsAnimations,
	ConditionalDisplay,
	Transform,
	getAlignmentClasses,
	useCssGenerator,
	getGeneratedClasses
} from '~stackable/block-components'
import { useBlockStyle } from '~stackable/hooks'
import {
	withBlockAttributeContext,
	withBlockWrapper,
	withQueryLoopContext,
} from '~stackable/higher-order'

/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n'
import { compose } from '@wordpress/compose'
import { createBlock } from '@wordpress/blocks'
import { AlignmentToolbar, BlockControls } from '@wordpress/block-editor'

/**
 * Internal dependencies
 */
import { ButtonStyles } from './style'
import { blockStyles } from './block-styles'

const Edit = props => {
	const {
		className,
		onReplace,
		attributes,
		setAttributes,
		clientId,
		isSelected,
	} = props

	useGeneratedCss( props.attributes )
	useCssGenerator(attributes, <ButtonStyles.Content {...props} version={ VERSION }/>)

	const typographyInnerClasses = getTypographyClasses( props.attributes )
	const customAttributes = CustomAttributes.getCustomAttributes( props.attributes )

	const blockAlignmentClass = getAlignmentClasses( props.attributes )

	const blockStyle = useBlockStyle( blockStyles )

	const blockClassNames = classnames( [
		className,
		'stk-block-button',
		blockAlignmentClass,
		// We need to add the blockStyle here to append the class alongside `.stk-block`
		// Only in the editor.
		{
			[ `is-style-${ blockStyle }` ]: blockStyle,
		},
	] )

	const typographyInnerClassNames = classnames( [
		typographyInnerClasses,
		'stk-button__inner-text',
	] );
	return (
		<>
			{ isSelected && (
				<>
					<BlockControls>
						<AlignmentToolbar
							value={ attributes.contentAlign }
							onChange={ contentAlign => setAttributes( { contentAlign } ) }
						/>
					</BlockControls>

					<InspectorTabs hasLayoutPanel={ false } />

					<BlockStyle.InspectorControls styles={ blockStyles }>
						<Button.InspectorControls.HoverEffects />
					</BlockStyle.InspectorControls>
					<Button.InspectorControls
						blockState={ props.blockState }
						borderSelector=".stk-button"
						hasFullWidth={ true }
						hasOptions={true}
						disableColorPicker={true}
					/>
					<Typography.InspectorControls
						{ ...props }
						hasTextTag={ false }
						initialOpen={ false }
						hasColor={ false }
						hasOptions={true}
					/>

					<BlockDiv.InspectorControls initialOpen="spacing" hasOptions={true} disableColorPicker={true}/>

					<Advanced.InspectorControls />
					<Transform.InspectorControls />
					<EffectsAnimations.InspectorControls />
					<CustomAttributes.InspectorControls />
					<CustomCSS.InspectorControls mainBlockClass="stk-block-button" />
					<Responsive.InspectorControls />
					<ConditionalDisplay.InspectorControls />
				</>
			) }

			<ButtonStyles
				version={ VERSION }
				blockState={ props.blockState }
				clientId={ clientId }
			/>
			<CustomCSS mainBlockClass="stk-block-button" />

			<BlockDiv
				blockHoverClass={ props.blockHoverClass }
				clientId={ props.clientId }
				attributes={ props.attributes }
				className={ getGeneratedClasses(attributes, 'blockDiv', blockClassNames) }
				applyAdvancedAttributes={ false }
				applyCustomAttributes={ false }
			>
				<Button
					buttonProps={ {
						tagName: props.attributes.linkTag,
						id: props.attributes.anchor || undefined,
						...customAttributes,
					} }
					className={getGeneratedClasses(attributes,'element')}
				>
					<Typography
						tagName="span"
						className={getGeneratedClasses(attributes, 'text', typographyInnerClassNames)}
						placeholder={ __( 'Button text', i18n ) }
						withoutInteractiveFormatting={ true }
						onReplace={ onReplace }
						onSplit={ value => createBlock(
							'stackable/button',
							{
								...props.attributes, text: value,
							}
						) }
					/>
				</Button>
			</BlockDiv>

		</>
	)
}

export default compose(
	withBlockWrapper,
	withQueryLoopContext,
	withBlockAttributeContext,
)( Edit )
