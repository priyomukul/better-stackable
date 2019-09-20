/**
 * A Control for selecting designs.
 */
/**
 * External dependencies
 */
import { DesignPanelItem } from '~stackable/components'
import { omit } from 'lodash'

/**
 * WordPress dependencies
 */
import { RadioControl } from '@wordpress/components'

function DesignControl( props ) {
	const {
		selected, options, onChange,
	} = props

	// Convert the options.
	const fixedOptions = options.map( option => {
		return {
			...option,
			label: <DesignPanelItem imageFile={ option.image } imageHoverFile={ option.hoverImage } isPro={ option.isPro } label={ option.label } />,
			title: option.label,
			value: option.value,
		}
	} )

	return (
		<div className="ugb-design-control-wrapper components-base-control">
			<div className="components-base-control__label">{ props.label }</div>
			<RadioControl
				{ ...omit( props, [ 'label' ] ) }
				className="ugb-design-control"
				selected={ selected }
				options={ fixedOptions }
				onChange={ onChange }
			/>
		</div>
	)
}

export default DesignControl
