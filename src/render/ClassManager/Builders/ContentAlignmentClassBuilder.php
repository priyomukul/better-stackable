<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;


/**
 * @see ./src/block-components/content-align/use-content-align.js
 * @see getContentAlignmentClasses
 */
class ContentAlignmentClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		$classes[] = 'stk-content-align';

		// FIXME: column should be dynamic (horizontal-scroller)
		if( isset( $attributes['showScrollbar'] ) ) {
			$classes[] = "stk-{$attributes['uniqueId']}-horizontal-scroller";
		} else {
			$classes[] = "stk-{$attributes['uniqueId']}-column";
		}
		
		if( ! empty( $attributes['columnJustify'] ) ) {
			$classes[] = 'stk--flex';
		}

		if( ! empty( $attributes['innerBlockContentAlign'] ) ) {
			if( $attributes['innerBlockContentAlign'] !== 'center' ) {
				$classes[] = $attributes['innerBlockContentAlign'];
			}
		}
	}
}
