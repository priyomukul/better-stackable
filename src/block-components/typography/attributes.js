import { deprecatedAddAttributes } from './deprecated'

const typographyAttributes = {
	groupSize: {
		type: 'string',
		default: '',
	},
	groupClass: {
		type: 'string',
		default: '',
	},
	isCustomized: {
		type: "boolean",
		default: false
	},
	fontSize: {
		stkResponsive: true,
		type: 'number',
		default: '',
		stkUnits: 'rem',
	},
	lineHeight: {
		stkResponsive: true,
		type: 'number',
		default: '',
		stkUnits: 'em',
	},
	fontFamily: {
		type: 'string',
		default: '',
	},
	fontStyle: {
		type: 'string',
		default: '',
	},
	fontWeight: {
		type: 'string',
		default: '',
	},
	textTransform: {
		type: 'string',
		default: '',
	},
	letterSpacing: {
		stkResponsive: true,
		type: 'number',
		default: '',
	},
	textColorType: {
		type: 'string',
		default: '',
	},
	textColorClass: {
		type: 'string',
		default: '',
	},
	textColor1: {
		type: 'string',
		stkHover: true,
		default: '',
	},
	textShadow: {
		stkHover: true,
		type: 'string',
		default: '',
	},
	textAlign: {
		stkResponsive: true,
		type: 'string',
		default: '',
	},
	hasP: {
		type: 'boolean',
		default: false,
	},
}

export const addAttributes = ( attrObject, selector = '.stk-content', options = {} ) => {
	const {
		groupSize='normal',
		hasTextTag = true,
		hasTextContent = true,
		defaultTextTag = 'p',
		attrNameTemplate = '%s',
		multiline,
		defaultText = '',
		multilineWrapperTags: __unstableMultilineWrapperTags,
	} = options

	deprecatedAddAttributes( attrObject, options )

	attrObject.add( {
		attributes: {
			...typographyAttributes,
			// TODO:Add 'show' attribute if attributeNameTemplate is not the default
			...( hasTextContent ? {
				showText: {
					type: 'boolean',
					default: true,
				},
				text: {
					type: 'string',
					default: defaultText,
				},
			} : {} ),
			...( hasTextTag ? {
				textTag: {
					type: 'string',
					default: defaultTextTag,
				},
			} : {} ),
		},
		versionAdded: '3.0.0',
		versionDeprecated: '',
		attrNameTemplate,
	} )
}
