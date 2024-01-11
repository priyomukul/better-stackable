<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class SeparatorClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if ( !empty($attributes['topSeparatorShow']) ){
			$classes[] = 'stk-has-top-separator';
		}
		if (!empty($attributes['bottomSeparatorShow'])) {
			$classes[] = 'stk-has-bottom-separator';
		}
	}
}
