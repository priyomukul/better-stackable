<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;


if ( is_admin() ) {
	return;
}

if ( ! class_exists( 'StellarBlocks\Blocks\Map' ) ) {
	class Map extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-map'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'usesApiKey' => false,
			'showMarker' => false,
			'showZoomButtons' => true,
			'showMapTypeButtons' => true,
			'showStreetViewButton' => true,
			'showFullScreenButton' => true,
			'isDraggable' => true,
			'mapStyle' => '',
			'customMapStyle' => '',
			'icon' => '',

			'location' => [
				'lat' => 14.680936247180512,
				'lng' => 121.04845461073226
			],

			'height' => 350,
			'zoom' => 12,
		];

		public function __construct(array $attributes, string $content, WP_Block $block)
		{
			/**
			 * Wrapper Classes
			 */
			$classes = [];
			if( ! empty( $attributes['usesApiKey'] ) ) {
				$classes[] = 'stk--uses-api-key';
			}

			$this->uniqueWrapperClasses = array_merge( $this->uniqueWrapperClasses, $classes );

			parent::__construct($attributes, $content, $block);
		}

		protected function getElementClasses(): array
		{
			return [ 'stk-block-map__canvas' ];
		}

		protected function render(): string
		{
			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']}>";

			if( $this->attributes['usesApiKey'] ) {
				$styles = '';
				if( $this->attributes['mapStyle'] ) {
					$styles = $this->getDefaultMapStyles( $this->attributes['mapStyle'] );
				}

				if( ! empty( $this->attributes['customMapStyle'] ) ) {
					$styles = json_decode($this->attributes['customMapStyle'], true);
				}


				$mapOptions = json_encode([
					'center' => $this->attributes['location'],
					'zoom' => $this->attributes['zoom'],
					'styles' => $styles,
					'gestureHandling' => $this->attributes['isDraggable'] ? 'undefined' : 'none',
					'fullscreenControl' => $this->attributes['showFullScreenButton'],
					'mapTypeControl' => $this->attributes['showMapTypeButtons'],
					'streetViewControl' => $this->attributes['showStreetViewButton'],
					'zoomControl' => $this->attributes['showZoomButtons'],
				]);

				$markerOptions = false;
				if( $this->attributes['showMarker'] ) {
					$markerOptions = json_encode([
						'position' => $this->attributes['location'],
						'title' => $this->attributes['address'] ?? 'undefined'
					]);
				}

				$iconOptions = $this->getIconOptions();

				echo "<div
					data-map-options='$mapOptions'
					data-marker-options='$markerOptions'
					data-icon-options='$iconOptions'
					class='{$this->output['classes']['element']}'
				/>";
			} else {
				$title = __( 'Embedded content from Google Maps Platform.', '' );
				$address = $this->attributes['address'] ?? 'Quezon City';
				$zoom = $this->attributes['zoom'] ?? 12;

				echo "<iframe title='$title' src='https://maps.google.com/maps?q=$address&t=&z=$zoom&ie=UTF8&output=embed' style='border:0;width:100%;max-width:none;max-height:none;height:100%;' aria-hidden='false' tabIndex='0' allowfullscreen loading='lazy' frameBorder='0'></iframe>";
			}

			echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
		}

		private function getIconOptions(): bool|string {
			$iconOptions = [
				'iconColor1' => $this->attributes['iconColor1'] ?? '#000000',
				'iconSize' => ! empty( $this->attributes['iconSize'] ) ? intval($this->attributes['iconSize']) : 40,
				'iconOpacity' => ! empty( $this->attributes['iconOpacity'] ) ? floatval($this->attributes['iconOpacity']) : 1.0,
				'iconRotation' => ! empty( $this->attributes['iconRotation'] ) ? intval($this->attributes['iconRotation']) : 0,
				'iconAnchorPositionX' => ! empty( $this->attributes['iconAnchorPositionX'] ) ? intval($this->attributes['iconAnchorPositionX']) : 0,
				'iconAnchorPositionY' => ! empty( $this->attributes['iconAnchorPositionY'] ) ? intval($this->attributes['iconAnchorPositionY']) : 0,
			];

			$return_value = [
				'anchor' => [
					'x' => $iconOptions['iconAnchorPositionX'] + ( $iconOptions['iconSize'] / 2 ),
					'y' => $iconOptions['iconAnchorPositionY'] + $iconOptions['iconSize'],
				]
			];

			/**
			 * This portion of code is needed to add attributes in SVG.
			 * we need to parse it first then add attributes.
			 */
			try {
				$svgElement = new \SimpleXMLElement( $this->attributes['icon'] );
				$svgElement->addAttribute( 'width', $iconOptions['iconSize'] );
				$svgElement->addAttribute( 'height', $iconOptions['iconSize'] );
				$svgElement->addAttribute( 'style', "color: {$iconOptions['iconColor1']}; opacity: {$iconOptions['iconOpacity']}; transform: rotate({$iconOptions['iconRotation']}deg)" );

				$hasFill = $svgElement->path->attributes();

				if( $hasFill ) {
					$fill = false;
					foreach( $hasFill as $attr ) {
						if( $attr->getName() === 'fill' ) {
							$fill = true;
							break;
						}
					}

					if( ! $fill ) {
						$svgElement->path->addAttribute( 'fill', 'currentColor' );
					}
				}

				$return_value['url'] = "data:image/svg+xml;base64," . base64_encode( $svgElement->saveXML() );
			} catch ( \Exception $e ) {
				unset( $e );
			}

			return json_encode($return_value);
		}

		private function getDefaultMapStyles( string $mapStyle ): array {
			switch ( $mapStyle ) {
				case 'silver':
					return json_decode( '[{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]', true );
				case 'retro':
					return json_decode( '[{"elementType":"geometry","stylers":[{"color":"#ebe3cd"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#523735"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f1e6"}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#c9b2a6"}]},{"featureType":"administrative.land_parcel","elementType":"geometry.stroke","stylers":[{"color":"#dcd2be"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#ae9e90"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#93817c"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#a5b076"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#447530"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#f5f1e6"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#fdfcf8"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#f8c967"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#e9bc62"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#e98d58"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry.stroke","stylers":[{"color":"#db8555"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#806b63"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"transit.line","elementType":"labels.text.fill","stylers":[{"color":"#8f7d77"}]},{"featureType":"transit.line","elementType":"labels.text.stroke","stylers":[{"color":"#ebe3cd"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#dfd2ae"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#b9d3c2"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#92998d"}]}]', true );
				case 'dark':
					return json_decode( '[{"elementType":"geometry","stylers":[{"color":"#212121"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#212121"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#757575"}]},{"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"administrative.land_parcel","stylers":[{"visibility":"off"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#181818"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#1b1b1b"}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#2c2c2c"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8a8a8a"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#373737"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3c3c3c"}]},{"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#4e4e4e"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#3d3d3d"}]}]', true );
				case 'night':
					return json_decode( '[{"elementType":"geometry","stylers":[{"color":"#242f3e"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#746855"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#242f3e"}]},{"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#263c3f"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#6b9a76"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#38414e"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"color":"#212a37"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#9ca5b3"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#746855"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#1f2835"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#f3d19c"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#2f3948"}]},{"featureType":"transit.station","elementType":"labels.text.fill","stylers":[{"color":"#d59563"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#17263c"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#515c6d"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#17263c"}]}]', true );
				case 'aubergine':
					return json_decode( '[{"elementType":"geometry","stylers":[{"color":"#1d2c4d"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#8ec3b9"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#1a3646"}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#64779e"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"color":"#4b6878"}]},{"featureType":"landscape.man_made","elementType":"geometry.stroke","stylers":[{"color":"#334e87"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#023e58"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#283d6a"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#6f9ba5"}]},{"featureType":"poi","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#023e58"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#3C7680"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#304a7d"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#2c6675"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#255763"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#b0d5ce"}]},{"featureType":"road.highway","elementType":"labels.text.stroke","stylers":[{"color":"#023e58"}]},{"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#98a5be"}]},{"featureType":"transit","elementType":"labels.text.stroke","stylers":[{"color":"#1d2c4d"}]},{"featureType":"transit.line","elementType":"geometry.fill","stylers":[{"color":"#283d6a"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#3a4762"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#0e1626"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#4e6d70"}]}]', true );
				default:
					return [];
			}
		}
	}
}

/**
 * @var array $attributes
 * @var string $content
 * @var WP_Block $block
 */
new Map( $attributes, $content, $block );

