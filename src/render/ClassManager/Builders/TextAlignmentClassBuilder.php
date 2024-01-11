<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class TextAlignmentClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if (!empty($attributes['contentAlign'])) {
			$classes[] = "has-text-align-{$attributes['contentAlign']}";
		}
		if (!empty($attributes['contentAlignTablet'])) {
			$classes[] = "has-text-align-{$attributes['contentAlignTablet']}-tablet";
		}
		if (!empty($attributes['contentAlignMobile'])) {
			$classes[] = "has-text-align-{$attributes['contentAlignMobile']}-mobile";
		}


		/**
		 * @see ./src/block-components/alignment/use-alignment.js
		 * @see getAlignmentClasses
		 */
		if (!empty($attributes['innerBlockOrientation']) && $attributes['innerBlockOrientation'] === 'horizontal') {
			$classes[] = 'stk--block-horizontal-flex';
		}

		if (!empty($attributes['innerBlockJustify']) || !empty($attributes['innerBlockAlign'])) {
			$classes[] = 'stk--column-flex';
		}

		if( ! empty( $attributes['rowAlign'] ) || ! empty( $attributes['rowAlignTablet'] ) || ! empty( $attributes['rowAlignMobile'] ) ) {
			$classes[] = "stk--block-align-{$attributes['uniqueId']}";
		}
	}
}
