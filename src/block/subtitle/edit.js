/**
 * Internal dependencies
 */
import { SubtitleStyles } from './style'

/**
 * External dependencies
k*/
import {
	BlockDiv,
	useGeneratedCss,
	CustomCSS,
	Responsive,
	Advanced,
	Typography,
	getTypographyClasses,
	getAlignmentClasses,
	Alignment,
	MarginBottom,
	CustomAttributes,
	EffectsAnimations,
	ConditionalDisplay,
	Transform,
	useCssGenerator,
	getGeneratedClasses
} from '~stackable/block-components'
import { version as VERSION, i18n } from 'stackable'
import classnames from 'classnames'
import { InspectorTabs } from '~stackable/components'
import {
	withBlockAttributeContext,
	withBlockWrapperIsHovered,
	withQueryLoopContext,
} from '~stackable/higher-order'
import { createBlockCompleter } from '~stackable/util'

/**
 * WordPress dependencies
 */
import { compose } from '@wordpress/compose'
import { createBlock } from '@wordpress/blocks'
import { addFilter } from '@wordpress/hooks'
import { sprintf, __ } from '@wordpress/i18n'

/**
 * Add `autocompleters` support for stackable/subtitle
 *
 * @see ~stackable/util/blocks#createBlockCompleter
 */
addFilter('editor.Autocomplete.completers', 'stackable/subtitle', (filteredCompleters, name) => {
	if (name === 'stackable/subtitle') {
		return [...filteredCompleters, createBlockCompleter()]
	}
	return filteredCompleters
})

const Edit = props => {
	const {
		clientId,
		className,
		onReplace,
		onRemove,
		mergeBlocks,
		isSelected,
		attributes,
		setAttributes
	} = props

	useGeneratedCss(attributes)

	const textClasses = getTypographyClasses(attributes)
	const blockAlignmentClass = getAlignmentClasses(attributes)

	const blockClassNames = classnames([
		className,
		'stk-block-subtitle',
	])

	const textClassNames = classnames([
		'stk-block-subtitle__text',
		'stk-subtitle',
		textClasses,
		blockAlignmentClass,
	])

	useCssGenerator(attributes, <SubtitleStyles.Content version={VERSION} attributes={attributes} />);

	return (
		<>
			{isSelected && (
				<>
					<InspectorTabs />

					<Typography.InspectorControls
						{...props}
						hasTextTag={false}
						isMultiline={false}
						initialOpen={true}
						hasTextShadow={true}
						hasOptions={true}
						disableColorPicker={true}
					/>

					<Alignment.InspectorControls labelContentAlign={sprintf(__('%s Alignment', i18n), __('Text', i18n))} />
					<BlockDiv.InspectorControls hasOptions={true} disableColorPicker={true} />
					<Advanced.InspectorControls />
					<Transform.InspectorControls />
					<EffectsAnimations.InspectorControls />
					<CustomAttributes.InspectorControls />
					<CustomCSS.InspectorControls mainBlockClass="stk-block-subtitle" />
					<Responsive.InspectorControls />
					<ConditionalDisplay.InspectorControls />
				</>
			)}

			<SubtitleStyles
				version={VERSION}
				blockState={props.blockState}
				clientId={clientId}
			/>
			<CustomCSS mainBlockClass="stk-block-subtitle" />

			<BlockDiv
				blockHoverClass={props.blockHoverClass}
				clientId={props.clientId}
				attributes={attributes}
				className={blockClassNames + ' ' + getGeneratedClasses(attributes, 'blockDiv')}
			>
				<Typography
					tagName="p"
					className={textClassNames + ' ' + getGeneratedClasses(attributes, 'element')}
					placeholder={__('Type / to choose a block', i18n)}
					onMerge={mergeBlocks}
					onRemove={onRemove}
					onReplace={onReplace}
					onSplit={(value, isOriginal) => {
						// @see https://github.com/WordPress/gutenberg/blob/trunk/packages/block-library/src/paragraph/edit.js
						let newAttributes

						if (isOriginal || value) {
							newAttributes = {
								...attributes,
								text: value,
							}
						}

						const block = createBlock('stackable/subtitle', newAttributes)

						if (isOriginal) {
							block.clientId = props.clientId
						}

						return block
					}}
				/>
			</BlockDiv>
			{props.isHovered && <MarginBottom />}
		</>
	)
}

export default compose(
	withBlockWrapperIsHovered,
	withQueryLoopContext,
	withBlockAttributeContext,
)(Edit)
