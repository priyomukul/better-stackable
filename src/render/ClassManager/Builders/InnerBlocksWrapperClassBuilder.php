<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class InnerBlocksWrapperClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		$classes[] = "stk-inner-blocks stk-block-content stk-{$attributes['uniqueId']}-inner-blocks";
	}
}
