<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class ResponsiveClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if (isset($attributes['hideDesktop']) && $attributes['hideDesktop']) {
			$classes[] = 'stk--hide-desktop';
		}
		if (isset($attributes['hideTablet']) && $attributes['hideTablet']) {
			$classes[] = 'stk--hide-tablet';
		}
		if (isset($attributes['hideMobile']) && $attributes['hideMobile']) {
			$classes[] = 'stk--hide-mobile';
		}
	}
}
