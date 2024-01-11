<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class BlockWidthClassBuilder implements ClassBuilderStrategyInterface
{
    public function addClasses(array &$classes, array $attributes): void
    {
		if( ! empty( $attributes['align'] ) ) {
			$classes[] = "align{$attributes['align']}";
		}
    }
}
