<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class BackgroundClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if (!empty($attributes['hasBackground'])) {
			$classes[] = 'stk-block-background';
		}

		if (!empty($attributes['hasBackground']) && (
				(isset($attributes['blockBackgroundColorType']) && $attributes['blockBackgroundColorType'] === 'gradient') ||
				!empty($attributes['blockBackgroundMediaUrl']) ||
				!empty($attributes['blockBackgroundMediaUrlTablet']) ||
				!empty($attributes['blockBackgroundMediaUrlMobile'])
			)) {

			$classes[] = 'stk--has-background-overlay';
		}
	}
}
