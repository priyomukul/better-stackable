<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class MarginClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if (isset($attributes['blockMargin']['top']) && $attributes['blockMargin']['top'] === 'auto') {
			$classes[] = 'stk--block-margin-top-auto';
		}
		if (isset($attributes['blockMargin']['bottom']) && $attributes['blockMargin']['bottom'] === 'auto') {
			$classes[] = 'stk--block-margin-bottom-auto';
		}
	}
}
