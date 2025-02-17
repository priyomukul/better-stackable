import {
	useState, useEffect, useRef,
} from '@wordpress/element'
import { useVisualGuideContext } from '~stackable/higher-order/with-visual-guide'

// This updates the block visual guide.
export const VisualGuideer = props => {
	const [ isShow, setIsShow ] = useState( false )
	const leftAlready = useRef( false )

	const setHighlightStyles = useVisualGuideContext()

	useEffect( () => {
		if ( ! isShow && setHighlightStyles ) {
			setHighlightStyles( null )
		}
	}, [ isShow ] )

	if ( ! setHighlightStyles ) {
		return props.children
	}

	// Always update the block when this component is rerendered.
	// This makes sure that the highlighted block always has the latest styles.
	if ( isShow ) {
		setHighlightStyles( props )
	}

	return (
		<div
			className="stk-visual-guideer-trigger"
			onMouseEnter={ () => {
				leftAlready.current = false

				// Add a delay to make sure that the block visual guides are on.
				// Moving fast between options can cause the highlight to not
				// show.
				setTimeout( () => {
					// We do a check for leftAlready.current because sometimes
					// this triggers after the mouse leaves already.
					if ( ! leftAlready.current && setIsShow ) {
						setIsShow( true )
					}
				}, 10 )
				// setIsShow( true )

				// If a block is currently focused, then the outline will get in
				// the way. Unfocus the block.
				// eslint-disable-next-line @wordpress/no-global-active-element
				if ( document?.activeElement?.getAttribute( 'data-type' )?.startsWith( 'stackable/' ) ) { //
					// eslint-disable-next-line @wordpress/no-global-active-element
					document.activeElement?.blur()
				}
			} }
			onMouseLeave={ () => {
				leftAlready.current = true
				setIsShow( false )
			} }
		>
			{ props.children }
		</div>
	)
}
