<?php

namespace StellarBlocks\Renderer;

class Helper {
	/**
	 * This method converts array of attributes into a string.
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public static function getNormalizeAttributes( array $attributes = [] ): string {
		if( empty( $attributes ) ) {
			return '';
		}

		$normalized_attributes = array();
		foreach ( $attributes as $key => $value ) {
			$normalized_attributes[] = $key . '="' . esc_attr( $value ) . '"';
		}

		return implode( ' ', $normalized_attributes );
	}


	public static function getAttributeName( $attrNameTemplate, $name = '', $name2 = '' ): string {
		return lcfirst(sprintf( $attrNameTemplate, ucfirst( $name ), ucfirst( $name2 ) ));
	}
}
