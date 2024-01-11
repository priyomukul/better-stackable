import {
	Advanced,
	Alignment,
	BlockDiv,
	Style,
	ConditionalDisplay,
	CustomAttributes,
	CustomCSS,
	EffectsAnimations,
	Responsive,
	Row,
	Transform,
} from '~stackable/block-components'
import { AttributeObject } from '~stackable/util'
import { version as VERSION } from 'stackable'

export const attributes = ( version = VERSION ) => {
	const attrObject = new AttributeObject()

	BlockDiv.addAttributes( attrObject )
	Style.addAttributes( attrObject )
	Row.addAttributes( attrObject )
	Alignment.addAttributes( attrObject )
	Advanced.addAttributes( attrObject )
	Transform.addAttributes( attrObject )
	EffectsAnimations.addAttributes( attrObject )
	CustomAttributes.addAttributes( attrObject )
	CustomCSS.addAttributes( attrObject )
	Responsive.addAttributes( attrObject )
	ConditionalDisplay.addAttributes( attrObject )

	attrObject.add( {
		attributes: {
			startOpen: {
				type: 'boolean',
				default: '',
			},
			onlyOnePanelOpen: {
				type: 'boolean',
				default: '',
			},
			enableFAQ: {
				type: 'boolean',
				default: false,
			},
		},
		versionAdded: '3.0.0',
		versionDeprecated: '',
	} )

	attrObject.add( {
		attributes: {
			contentAlign: {
				stkResponsive: true,
				type: 'string',
				default: '',
			},
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
					}
				},
			},
		},
		versionAdded: '3.2.0',
		versionDeprecated: '',
	} )

	attrObject.addDefaultValues( {
		attributes: {
			htmlTag: 'details',
		},
		versionAdded: '3.0.0',
		versionDeprecated: '',
	} )

	return attrObject.getMerged( version )
}

export default attributes( VERSION )
