<?php

namespace StellarBlocks\Renderer;

use StellarBlocks\Renderer\ClassManager\ClassManager;

class BlockRenderer implements BlockRendererInterface {
	public array              $output;
	private ClassManager      $classManager;
	private array             $attributes;
	private BaseBlockRenderer $stellarBlock;

	public function __construct( $block ) {
		$this->stellarBlock = $block;
		$this->attributes   = $this->stellarBlock->attributes;
		$this->classManager = new ClassManager( $this->attributes );
	}

	public function getWrapperAttributes( string $uniqueWrapperClasses, $strategies = [] ): string {
		$classes = "stk-block";
		$classes .= " " . $uniqueWrapperClasses;
		$classes .= " " . $this->classManager->getClasses( $strategies );
		$classes .= " " . $this->classManager->getGeneratedClasses( 'blockDiv' );

		$_custom_attributes = $this->getCustomAttributes( $this->stellarBlock->applyCustomAttributes );
		$_custom_attributes += $this->getAdvancedAttributes( $this->stellarBlock->applyAdvancedAttributes );

		/**
		 * If blockDiv has custom attributes.
		 */
		if ( ! empty( $this->stellarBlock->hasWrapperAttributes ) ) {
			foreach ( $this->stellarBlock->hasWrapperAttributes as $key => $value ) {
				$_custom_attributes["data-$key"] = $this->attributes[ $value ] ?? null;
			}
		}

		/**
		 * Generates a string of attributes by applying to the current block being rendered all the features
		 * that the block supports.
		 * https://developer.wordpress.org/reference/functions/get_block_wrapper_attributes/
		 */
		return get_block_wrapper_attributes( array_merge( [
			'class'         => $classes,
			'data-block-id' => $this->attributes['uniqueId'] ?? false,
		], $_custom_attributes ) );
	}

	/**
	 * This method generates custom attributes array in a key->value manner.
	 *
	 * @param bool $shouldApply
	 *
	 * @return array
	 */
	public function getCustomAttributes( bool $shouldApply = true ): array {
		$_custom_attributes = [];
		if ( $shouldApply && ! empty( $this->attributes['customAttributes'] ) ) {
			foreach ( $this->attributes['customAttributes'] as $attribute ) {
				$_custom_attributes[ esc_attr( $attribute[0] ) ] = esc_attr( $attribute[1] );
			}
		}

		return $_custom_attributes;
	}

	/**
	 * This method generates ID as attributes
	 *
	 * @param bool $shouldApply
	 *
	 * @return array
	 */
	public function getAdvancedAttributes( bool $shouldApply = true ): array {
		$_custom_attributes = [];
		if ( $shouldApply && ! empty( $this->attributes['anchor'] ) ) {
			$_custom_attributes['id'] = $this->attributes['anchor'];
		}

		return $_custom_attributes;
	}

	/**
	 * This method converts array of attributes into a string.
	 *
	 * @param array $attributes
	 *
	 * @return string
	 */
	public function getNormalizeAttributes( array $attributes = [] ): string {
		return Helper::getNormalizeAttributes( $attributes );
	}

	public function getClasses( array $types = [] ): string {
		return $this->classManager->getClasses( $types );
	}

	public function getGeneratedClasses( $class_type ): string {
		return $this->classManager->getGeneratedClasses( $class_type );
	}

	public function getSeparator( string $type = '' ): string {
		$attrName      = empty( $type ) ? 'separator' : $type . 'Separator';
		$separatorPath = plugin_dir_path( STACKABLE_FILE ) . 'assets/images/svg/';

		if ( ! empty( $this->attributes[ $attrName . 'Design' ] ) ) {
			$separatorPath .= $this->attributes[ $attrName . 'Design' ];
			if ( isset( $this->attributes[ $attrName . 'Inverted' ] ) && $this->attributes[ $attrName . 'Inverted' ] ) {
				$separatorPath .= '-inverted';
			}
			$separatorPath .= '.svg';
			if ( file_exists( $separatorPath ) ) {
				return file_get_contents( $separatorPath );
			}
		}

		return '';
	}

	public function getIconHTML( $icon, $showIcon = true ): void {
		if ( empty( $icon ) || ! $showIcon ) {
			return;
		}

		echo '<span class="stk--svg-wrapper">';
		echo '<div class="stk--inner-svg">';
		echo $icon;
		echo '</div>';
		echo '</span>';
	}

	/**
	 * This method can be improved. As for now its just echo's the icon it gets.
	 *
	 * @param $icon
	 *
	 * @return void
	 */
	public function getFontAwesomeHtml( $icon ): void {
		echo $icon;
	}
}

