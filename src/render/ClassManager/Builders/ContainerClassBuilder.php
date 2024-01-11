<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class ContainerClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		$classes[] = 'stk-container';
		$classes[] = "stk-{$attributes['uniqueId']}-container";

		if( empty( $attributes['hasContainer'] ) ) {
			$classes[] = 'stk--no-background stk--no-padding';
		} else {
			if(!empty($attributes['triggerHoverState'])){
				$classes[] = 'stk-hover-parent';
			}
		}
	}
}
