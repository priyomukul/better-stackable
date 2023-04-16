/**
 * External dependencies
 */
import {
	Advanced,
	Alignment,
	BlockDiv,
	EffectsAnimations,
	MarginBottom,
	Separator,
	Transform,
} from '~stackable/block-components'
import { useBlockAttributesContext } from '~stackable/hooks'
import { BlockCss, BlockCssCompiler } from '~stackable/components'

/**
 * WordPress dependencies
 */
import { memo } from '@wordpress/element'
import { applyFilters } from '@wordpress/hooks'

const alignmentOptions = {
	editorSelectorCallback: getAttribute => `.stk--block-align-${ getAttribute( 'uniqueId' ) } > .block-editor-inner-blocks > .block-editor-block-list__layout`,
}

const Styles = props => {
	const propsToPass = {
		...props,
		version: props.version,
		versionAdded: '3.8.0',
		versionDeprecated: '',
	}

	return (
		<>
			<BlockCss
				{ ...propsToPass }
				styleRule="--slides-to-show"
				attrName="slidesToShow"
				key="slidesToShow"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				styleRule="--gap"
				attrName="slideColumnGap"
				key="slideColumnGap"
				format="%spx"
				responsive="all"
			/>

			{ /* Arrows */ }
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__buttons"
				styleRule="justifyContent"
				attrName="arrowJustify"
				key="arrowJustify"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__buttons"
				styleRule="alignItems"
				attrName="arrowAlign"
				key="arrowAlign"
				responsive="all"
				enabledCallback={ getAttribute => getAttribute( 'arrowPosition' ) !== 'outside' }
				dependencies={ [ 'arrowPosition' ] }
			/>
			<BlockCss
				{ ...propsToPass }
				styleRule="--button-offset"
				attrName="arrowButtonOffset"
				key="arrowButtonOffset"
				format="%spx"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				styleRule="--button-gap"
				attrName="arrowButtonGap"
				key="arrowButtonGap"
				format="%spx"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button"
				hoverSelector=".stk-block-carousel__button:hover"
				styleRule="background"
				attrName="arrowButtonColor"
				key="arrowButtonColor"
				hover="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button"
				hoverSelector=".stk-block-carousel__button:hover"
				styleRule="color"
				attrName="arrowIconColor"
				key="arrowIconColor"
				hover="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button"
				styleRule="--button-width"
				attrName="arrowWidth"
				key="arrowWidth"
				format="%spx"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button"
				styleRule="--button-height"
				attrName="arrowHeight"
				key="arrowHeight"
				format="%spx"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button"
				styleRule="borderRadius"
				attrName="arrowBorderRadius"
				key="arrowBorderRadius"
				format="%spx"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button svg"
				styleRule="width"
				attrName="arrowIconSize"
				key="arrowIconSize-width"
				format="%spx"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button svg"
				styleRule="height"
				attrName="arrowIconSize"
				key="arrowIconSize-height"
				format="%spx"
				responsive="all"
			/>
			<BlockCss
				{ ...propsToPass }
				selector=".stk-block-carousel__button"
				hoverSelector=".stk-block-carousel__button:hover"
				styleRule="opacity"
				attrName="arrowOpacity"
				key="arrowOpacity"
				hover="all"
			/>

		</>
	)
}

const BlockStyles = memo( props => {
	const columnArrangement = useBlockAttributesContext( attributes => attributes.columnArrangementMobile || attributes.columnArrangementTablet )
	const numColumns = ( columnArrangement || '' ).split( ',' ).length

	const ColumnOrderStyle = applyFilters( 'stackable.block-component.columns.column-order-style', null )

	return (
		<>
			<Alignment.Style { ...props } { ...alignmentOptions } />
			<BlockDiv.Style { ...props } />
			<MarginBottom.Style { ...props } />
			<Advanced.Style { ...props } />
			<Transform.Style { ...props } />
			<EffectsAnimations.Style { ...props } />
			<Separator.Style { ...props } />
			<Styles { ...props } />
			{ ColumnOrderStyle && <ColumnOrderStyle { ...props } numColumns={ numColumns } /> }
		</>
	)
} )

BlockStyles.defaultProps = {
	version: '',
}

BlockStyles.Content = props => {
	if ( props.attributes.generatedCss ) {
		return <style>{ props.attributes.generatedCss }</style>
	}

	const numColumns = ( props.attributes.columnArrangementMobile || props.attributes.columnArrangementTablet || '' ).split( ',' ).length
	const ColumnOrderStyle = applyFilters( 'stackable.block-component.columns.column-order-style', null )

	return (
		<BlockCssCompiler>
			<Alignment.Style.Content { ...props } { ...alignmentOptions } />
			<BlockDiv.Style.Content { ...props } />
			<MarginBottom.Style.Content { ...props } />
			<Advanced.Style.Content { ...props } />
			<Transform.Style.Content { ...props } />
			<EffectsAnimations.Style.Content { ...props } />
			<Separator.Style.Content { ...props } />
			<Styles { ...props } />
			{ ColumnOrderStyle && <ColumnOrderStyle { ...props } numColumns={ numColumns } /> }
		</BlockCssCompiler>
	)
}

BlockStyles.Content.defaultProps = {
	version: '',
	attributes: {},
}

export default BlockStyles
