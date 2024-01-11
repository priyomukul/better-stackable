<?php

namespace StellarBlocks\Renderer\ClassManager;

interface ClassManagerInterface
{
	public function add($class);

	public function remove($class);

	public function getAll();
}
