/**
 * External dependencies
 */
import {
	BlockDiv,
	Style,
	Alignment,
	EffectsAnimations,
	ConditionalDisplay,
	CustomAttributes,
	ContainerDiv,
	CustomCSS,
	Responsive,
	Advanced,
	MarginBottom,
	Transform,
} from '~stackable/block-components'
import { AttributeObject } from '~stackable/util'
import { version as VERSION } from 'stackable'

export const attributes = ( version = VERSION ) => {
	const attrObject = new AttributeObject()

	BlockDiv.addAttributes( attrObject )
	Style.addAttributes( attrObject )
	MarginBottom.addAttributes( attrObject )
	ContainerDiv.addAttributes( attrObject )
	Alignment.addAttributes( attrObject )
	Advanced.addAttributes( attrObject )
	Transform.addAttributes( attrObject )
	EffectsAnimations.addAttributes( attrObject )
	CustomAttributes.addAttributes( attrObject )
	ConditionalDisplay.addAttributes( attrObject )
	CustomCSS.addAttributes( attrObject )
	Responsive.addAttributes( attrObject )

	attrObject.add( {
		attributes: {
			// This keeps track of the version of the block, just when we need
			// to force update the block with new attributes and the save markup
			// doesn't change.
			version: {
				type: 'number',
				source: 'attribute',
				attribute: 'data-v',
				default: undefined,
			},
		},
		versionAdded: '3.0.0',
		versionDeprecated: '',
	} )

	attrObject.addDefaultValues( {
		attributes: {
			htmlTag: 'blockquote',
		},
		versionAdded: '3.0.0',
		versionDeprecated: '',
	} )

	attrObject.addDefaultValues( {
		attributes: {
			version: 2,
		},
		versionAdded: '3.8.0',
		versionDeprecated: '',
	} )

	attrObject.add({
		attributes: {
			generatedClasses: {
				type: 'object',
				default: {
					blockBorderRadius2:{
						type: 'blockDiv'
					},
					blockPadding: {
						type: 'blockDiv',
					},
					blockMargin: {
						type: 'blockDiv',
					},
					containerBorderRadius2:{
						type: 'container'
					},
					containerPadding: {
						type: 'container'
					},
				},
			},
		},
		versionAdded: '3.5.0',
		versionDeprecated:''
	});

	return attrObject.getMerged( version )
}

export default attributes( VERSION )
