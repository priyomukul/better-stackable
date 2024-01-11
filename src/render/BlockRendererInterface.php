<?php

namespace StellarBlocks\Renderer;

interface BlockRendererInterface
{
	public function getWrapperAttributes(string $uniqueWrapperClasses, $strategies = []): string;

	public function getClasses(array $types = []): string;

	public function getGeneratedClasses($class_type): string;
}
