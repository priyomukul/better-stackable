/**
 * WordPress dependencies
 */
import domReady from '@wordpress/dom-ready'

class StackableMap {
	init = () => {
		const apiKey = window.stackableMapVars && window.stackableMapVars.googleApiKey
		if ( apiKey ) {
			// eslint-disable-next-line no-undef
			if ( typeof window.google === 'object' && typeof window.google.maps === 'object' ) {
				this.initMap()
			} else {
				this.loadScriptAsync( apiKey ).then( this.initMap )
			}
		} else {
			// Display missing api key note if needed.
			[].forEach.call( document.querySelectorAll( '.stk--uses-api-key' ), el => {
				el.classList.add( 'stk--missing-api-key' )
				el.querySelector( '.stk-block-map__canvas' ).innerHTML = window.stackableMapVars.labelMissingMapApiKey
			} )
		}
	}

	loadScriptAsync = apiKey => {
		return new Promise( resolve => {
			const script = document.createElement( 'script' )
			script.id = 'stackable-google-map'
			// Add callback to prevent warnings.
			script.src = `https://maps.googleapis.com/maps/api/js?key=${ apiKey }&libraries=places&callback=Function.prototype`
			script.type = 'text/javascript'
			script.async = true
			script.onload = resolve
			document.body.appendChild( script )
		} )
	}

	initMap = () => {
		[].forEach.call( document.querySelectorAll( '.stk-block-map__canvas' ), mapCanvas => {
			const mapOptions = JSON.parse( mapCanvas.dataset.mapOptions || '{}' )
			const markerOptions = JSON.parse( mapCanvas.dataset.markerOptions || 'false' )
			const markerIconOptions = JSON.parse( mapCanvas.dataset.iconOptions || '{}' )

			// eslint-disable-next-line no-undef
			const map = new google.maps.Map( mapCanvas, mapOptions )
			if ( markerOptions ) {
				markerOptions.map = map
				markerOptions.clickable = false

				// eslint-disable-next-line no-undef
				const marker = new google.maps.Marker( markerOptions )
				marker.setIcon( markerIconOptions )
			}
		} )
	}
}

window.stackableMap = new StackableMap()
domReady( window.stackableMap.init )
