/**
 * External dependencies
 */
import { i18n } from 'stackable'
import {
	 AdvancedToolbarControl,
	 ColorPaletteControl,
	 ShadowControl,
	 FourRangeControl,
} from '~stackable/components'
import ConditionalControl from "~stackable/components/conditional-control";
import {BORDER_RADIUS} from "~stackable/config/constants";

/**
 * WordPress dependencies
 */
import { Fragment } from '@wordpress/element'
import { __ } from '@wordpress/i18n'
import { useAttributeEditHandlers } from '~stackable/hooks'
import { applyFilters } from '@wordpress/hooks'

const BORDER_CONTROLS = [
	{
		value: '',
		title: __( 'None', i18n ),
	},
	{
		value: 'solid',
		title: __( 'Solid', i18n ),
	},
	{
		value: 'dashed',
		title: __( 'Dashed', i18n ),
	},
	{
		value: 'dotted',
		title: __( 'Dotted', i18n ),
	},
]

export const BorderControls = props => {
	const {
		getAttribute,
		getAttrName,
		updateAttributes,
		getAttributes,
	} = useAttributeEditHandlers( props.attrNameTemplate )

	const borderTypeValue = getAttribute( 'borderType' ) || props.borderTypeValue

	applyFilters( 'stackable.block-component.helpers.borders', null, getAttribute, updateAttributes )

	return (
		<Fragment>
			{ props.hasBorderType &&
				<AdvancedToolbarControl
					label={ __( 'Borders', i18n ) }
					controls={ BORDER_CONTROLS }
					className="ugb-border-controls__border-type-toolbar"
					attribute={ getAttrName( 'borderType' ) }
					fullwidth={ true }
					isSmall={ true }
				/>
			}

			{ borderTypeValue && props.hasBorderControls &&
				<FourRangeControl
					label={ __( 'Border Width', i18n ) }
					attribute={ getAttrName( 'borderWidth' ) }
					responsive="all"
					hover="all"
					min={ 0 }
					max={ 99 }
					step={ 1 }
					sliderMax={ 5 }
					defaultLocked={ true }
				/>
			}

			{ borderTypeValue && props.hasBorderControls &&
				<ColorPaletteControl
					label={ __( 'Border Color', i18n ) }
					attribute={ getAttrName( 'borderColor' ) }
					hover="all"
					disableColorPicker={props.disableColorPicker}
				/>
			}
			{ props.hasBorderRadius &&
				<ConditionalControl
					options={BORDER_RADIUS}
					isEnabled={props.hasOptions}
					label={__('Border Radius', i18n)}
					attributeName={getAttrName( 'borderRadius2' )}
					saveAttr={getAttributes().generatedClasses}
					saveAttrName={'generatedClasses'}
				>
					<FourRangeControl
						label={ __( 'Border Radius', i18n ) }
						attribute={ getAttrName( 'borderRadius2' ) }
						responsive="all"
						hover={ props.hasBorderRadiusHover }
						helpTooltip={ {
							video: 'general-border-radius',
							description: __( 'Adjusts the radius of block corners to make them more rounded', i18n ),
						} }
						min={ 0 }
						isCorner={ true }
						sliderMax={ props.borderSliderMax }
						placeholder={ props.borderRadiusPlaceholder }
					/>
				</ConditionalControl>
			}
			<ShadowControl
				label={ __( 'Shadow / Outline', i18n ) }
				attribute={ getAttrName( 'shadow' ) }
				hover="all"
			/>
		</Fragment>
	)
}

BorderControls.defaultProps = {
	attrNameTemplate: '%s',
	borderTypeValue: '', // If not supplied, the value from the attribute will be used, otherwise: '' for none, 'solid', 'dashed', 'dotted'
	hasBorderType: true,
	hasBorderControls: true,
	hasBorderRadius: true,
	hasBorderRadiusHover: true,
	borderSelector: null,
	borderSliderMax: 50,
	disableColorPicker: false
}
