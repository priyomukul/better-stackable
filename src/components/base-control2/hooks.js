/**
 * Internal dependencies
 */
import { useAttributeName, useBlockAttributes } from '~stackable/hooks'

/**
 * WordPress dependencies
 */
import { useCallback } from '@wordpress/element'
import { useBlockEditContext } from '@wordpress/block-editor'
import { dispatch } from '@wordpress/data'

export const useControlHandlers = ( attribute, responsive = false, hover = false, valueCallback = null, onChangeCallback = null ) => {
	const { clientId } = useBlockEditContext()

	const attributes = useBlockAttributes( clientId )
	const attrName = useAttributeName( attribute, responsive, hover )

	let value = attributes[ attrName ]
	if ( valueCallback ) {
		value = valueCallback( value )
	}

	const onChange = useCallback( _value => {
		const value = onChangeCallback ? onChangeCallback( _value ) : _value
		dispatch( 'core/block-editor' ).updateBlockAttributes( clientId, { [ attrName ]: value } )
	}, [ clientId, attrName, onChangeCallback ] )

	return [ value, onChange ]
}
