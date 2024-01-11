<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

class LightboxClassBuilder implements ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void
	{
		if (!empty($attributes['blockLinkHasLightbox']) || !empty($attributes['linkHasLightbox'])) {
			$classes[] = 'stk--has-lightbox';
		}
	}
}
