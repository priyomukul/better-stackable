/**
 * WordPress dependencies
 */
import{ renderToString } from "react-dom/server"

export const useCssGenerator = (attributes, StyleComponent) => {
	const uniqueClass = '.stk-' + attributes.uniqueId;
	const tag = attributes.htmlTag ? attributes.htmlTag : 'div';

	/**
	 * Removed .stk-block from replacement as this class not exists in all cases.
	 */
	attributes.rawCss = renderToString(StyleComponent)
		.replaceAll(uniqueClass, `${tag}${uniqueClass}`);
}
