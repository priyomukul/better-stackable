/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready'

const ANIM_OPTS = {
	duration: 400,
	easing: 'cubic-bezier(0.2, 0.6, 0.4, 1)',
}

class StackableAccordion {
	init = () => {
		// If reduce motion is on, don't use smooth resizing.
		const reduceMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches
		const isAnimationDisabled = ( ! ( 'ResizeObserver' in window ) || reduceMotion )

		// This observer is called whenever the size element is changed.
		const RO = new ResizeObserver( entries => { // eslint-disable-line compat/compat
			return entries.forEach( entry => {
				const height = entry.borderBoxSize[ 0 ].blockSize
				const el = entry.target

				// Take note of the current height of the element, this is
				// referenced in different points of the accordion.
				el.dataset.height = height

				// If the accordion is opened/closed this will trigger an
				// animation.
				if ( el.doAnimate ) {
					el.doAnimate = false
					const preHeight = el.dataset.preHeight

					// When inside columns, flex prevents the accordion closing animation, this hack fixes it.
					const doWrapHack = !! el.closest( '.stk-block-columns' )
					let wrapper = null

					if ( doWrapHack ) {
						wrapper = addWrapperHack( el )
					}

					// Animate the accordion height.
					el.anim = el.animate( {
						height: [ `${ preHeight }px`, `${ height }px` ],
					}, ANIM_OPTS )

					// We need to animate the content as well since it will
					// overflow out the accordion.
					if ( height - preHeight >= 0 ) {
						el.contentEl.anim = el.contentEl.animate( {
							maxHeight: [ `0px`, `${ height - preHeight }px` ],
						}, ANIM_OPTS )
					}

					if ( doWrapHack ) {
						removeWrapperHack( el, wrapper )
					}
				}
			} )
		} )

		// This observer is called whenever the accordion's `open` attribute is
		// changed.
		const MO = new MutationObserver( function( mutations ) {
			mutations.forEach( function( mutation ) {
				const el = mutation.target

				// Cancel any animations if there are any.
				if ( el.anim ) {
					el.anim.cancel()
				}
				if ( el.contentEl.anim ) {
					el.contentEl.anim.cancel()
				}

				el.classList[
					! Array.from( el.classList ).includes( 'stk--is-open' ) ? 'add' : 'remove'
				]( 'stk--is-open' )

				// When the accordion is triggered to open/close, we animate
				// from this current height.
				el.dataset.preHeight = el.dataset.height

				if ( ! isAnimationDisabled ) {
					// Trigger the animation when the accordion is opened/closed.
					el.doAnimate = true
				}

				// Close other adjacent accordions if needed.
				if ( el.open && el.classList.contains( 'stk--single-open' ) ) {
					let adjacent = el.nextElementSibling
					while ( adjacent && adjacent.classList.contains( 'stk-block-accordion' ) ) {
						if ( adjacent.open ) {
							adjacent.open = false
						}
						adjacent = adjacent.nextElementSibling
					}
					adjacent = el.previousElementSibling
					while ( adjacent && adjacent.classList.contains( 'stk-block-accordion' ) ) {
						if ( adjacent.open ) {
							adjacent.open = false
						}
						adjacent = adjacent.previousElementSibling
					}
				}

				// If an accordion with large content is closed while opening
				// another accordion, it scrolls downwards.
				// This is to instantly scroll to the opening accordion.
				if ( el.open ) {
					const isAboveView = el.getBoundingClientRect().top < 0
					if ( isAboveView ) {
						el.scrollIntoView( {
							inline: 'start',
							block: 'start',
							behavior: 'instant',
						} )
					}
				}
			} )
		} )

		const els = document.querySelectorAll( '.stk-block-accordion' )
		els.forEach( el => {
			if ( ! el._StackableHasInitAccordion ) {
				el.contentEl = el.querySelector( '.stk-block-accordion__content' )
				if ( ! isAnimationDisabled ) {
					RO.observe( el )
				}
				MO.observe( el, {
					attributeFilter: [ 'open' ],
					attributeOldValue: true,
				} )
				el._StackableHasInitAccordion = true
			}
		} )

		const addWrapperHack = el => {
			// wrap el with div if it is inside a columns block
			const wrapper = document.createElement( 'div' )
			wrapper.classList.add( 'stk-block-accordion__wrapper' )
			el.parentNode.insertBefore( wrapper, el )
			wrapper.appendChild( el )
			const svg = el.querySelector( '.stk--svg-wrapper:not(.stk--has-icon2)' )
			if ( svg ) {
				const rotate = el.open ? { from: 0, to: 180 } : { from: 180, to: 0 }
				svg.anim = svg.animate( {
					transform: [ `rotate(${ rotate.from }deg)`, `rotate(${ rotate.to }deg)` ],
				}, {
					duration: 700,
					easing: 'cubic-bezier(0.2, 0.6, 0.4, 1)',
				} )
			}
			return wrapper
		}

		const removeWrapperHack = ( el, wrapper ) => {
			el.anim.onfinish = el.anim.oncancel = () => {
				// Unwrap el from the div
				wrapper.parentNode?.insertBefore( el, wrapper )
				wrapper?.remove()
			}
		}
	}
}

window.stackableAccordion = new StackableAccordion()
domReady( window.stackableAccordion.init )
