<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

use StellarBlocks\Renderer\ClassManager\Builders\ClassBuilderStrategyInterface;

/**
 * @see ./src/block-components/row/use-row.js
 * @see getRowClasses
 */
class RowClassBuilder implements ClassBuilderStrategyInterface
{

    public function addClasses(array &$classes, array $attributes): void
    {
        $classes[] = 'stk-row';

		if( ! empty( $attributes['numInnerBlocks'] ) && $attributes['numInnerBlocks'] > 1 ) {
			$classes[] = "stk-columns-{$attributes['numInnerBlocks']}";
		}
    }
}
