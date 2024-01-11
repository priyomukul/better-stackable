<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

use StellarBlocks\Renderer\ClassManager\Builders\ClassBuilderStrategyInterface;

/**
 * @see ./src/block-components/typography/get-typography-classes.js
 * @see getTypographyClasses
 */
class TypographyClassBuilder implements ClassBuilderStrategyInterface
{
	private string $attrNameTemplate = '%s';

	public function __construct( $attrNameTemplate = '%s' )
	{
		$this->attrNameTemplate = $attrNameTemplate;
	}

	private function getAttributeName( $name = '', $name2 = '' ): string
	{
		return lcfirst(sprintf( $this->attrNameTemplate, ucfirst( $name ), ucfirst( $name2 ) ));
	}

	public function addClasses(array &$classes, array $attributes): void
    {
		if( isset( $attributes[ $this->getAttributeName( 'textColorType' ) ] ) && $attributes[ $this->getAttributeName( 'textColorType' ) ] === 'gradient' ) {
			$classes[] = 'stk--is-gradient';
		}

		if( ! empty( $attributes[ $this->getAttributeName( 'textAlign' ) ] ) ) {
			$classes[] = 'has-text-align-' . $attributes[ $this->getAttributeName( 'textAlign' ) ];
		}

		if( ! empty( $attributes[ $this->getAttributeName( 'textAlignTablet' ) ] ) ) {
			$classes[] = 'has-text-align-' . $attributes[ $this->getAttributeName( 'textAlignTablet' ) ];
		}

		if( ! empty( $attributes[ $this->getAttributeName( 'textAlignMobile' ) ] ) ) {
			$classes[] = 'has-text-align-' . $attributes[ $this->getAttributeName( 'textAlignMobile' ) ];
		}

		if( ! empty( $attributes[ $this->getAttributeName( 'textColor1' ) ] ) ) {
			$classes[] = 'has-text-color';
		}

		if( ! empty( $attributes[ $this->getAttributeName( 'textColorClass' ) ] ) ) {
			$classes[] = $attributes[ $this->getAttributeName( 'textColorClass' ) ];
		}
    }
}
