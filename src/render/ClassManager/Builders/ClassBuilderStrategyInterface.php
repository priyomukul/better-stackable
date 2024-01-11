<?php

namespace StellarBlocks\Renderer\ClassManager\Builders;

interface ClassBuilderStrategyInterface
{
	public function addClasses(array &$classes, array $attributes): void;
}
