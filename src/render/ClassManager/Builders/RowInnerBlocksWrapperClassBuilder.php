<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class RowInnerBlocksWrapperClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		$classes[] = "stk-row stk-inner-blocks stk-block-content stk-{$attributes['uniqueId']}-inner-blocks";
	}
}
