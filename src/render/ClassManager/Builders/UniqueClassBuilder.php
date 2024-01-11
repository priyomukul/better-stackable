<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class UniqueClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if (isset($attributes['uniqueId'])) {
			$classes[] = "stk-" . $attributes['uniqueId'];
		}
	}
}
