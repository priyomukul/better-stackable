<?php

namespace StellarBlocks\Renderer\ClassManager;

use StellarBlocks\Renderer\ClassManager\Builders\BlockWidthClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\ClassBuilderStrategyInterface;
use StellarBlocks\Renderer\ClassManager\Builders\ContainerClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\ContentAlignmentClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\InnerBlocksWrapperClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\RowClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\RowInnerBlocksWrapperClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\SeparatorClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\TextAlignmentClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\BackgroundClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\LightboxClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\MarginClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\ResponsiveClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\TypographyClassBuilder;
use StellarBlocks\Renderer\ClassManager\Builders\UniqueClassBuilder;

class ClassManager
{
	private array $attributes;

	/**
	 * Typography class builder has an option to pass. as attribute name template.
	 * i.e: typography:digit%s
	 */
	private array $builders = [
		'unique' => UniqueClassBuilder::class,
		'text/alignment' => TextAlignmentClassBuilder::class,
		'content/alignment' => ContentAlignmentClassBuilder::class,
		'blockWidth' => BlockWidthClassBuilder::class,
		'row' => RowClassBuilder::class,
		'typography' => TypographyClassBuilder::class,
		'background' => BackgroundClassBuilder::class,
		'lightbox' => LightboxClassBuilder::class,
		'margin' => MarginClassBuilder::class,
		'responsive' => ResponsiveClassBuilder::class,
		'innerBlocks' => InnerBlocksWrapperClassBuilder::class,
		'rowInnerBlocks' => RowInnerBlocksWrapperClassBuilder::class,
		'container' => ContainerClassBuilder::class,
		'separator' => SeparatorClassBuilder::class,
	];

	private array $strategies = [];

	public function __construct(array $attributes) {
		$this->attributes = $attributes;
	}

	/**
	 * @param string $attribute
	 * @return ClassBuilderStrategyInterface
	 */
	private function initializeStrategy(string $attribute): ClassBuilderStrategyInterface
	{
		if( ! str_contains( $attribute, ':' ) ) {
			return new $this->builders[$attribute];
		}

		/**
		 * Passing Options For Strategy with Colon in Name.
		 * i.e: typography:digit%s
		 *
		 * here digit%s is attribute name template for Typography controls.
		 */
		$attribute_with_options = explode( ':', $attribute );
		$attribute = $attribute_with_options[0];

		unset( $attribute_with_options[0] );
		return new $this->builders[ $attribute ]( current( $attribute_with_options ) );
	}

	/**
	 * @param string $attribute
	 * @return ClassBuilderStrategyInterface|null
	 */
	private function getStrategy(string $attribute): ?ClassBuilderStrategyInterface
	{
		return $this->strategies[$attribute] ?? $this->initializeStrategy($attribute);
	}

	/**
	 * @param $classes
	 * @return string
	 */
	public function getClassMarkup($classes): string
	{
		$result = [];
		foreach ($classes as $key => $class) {
			if (is_array($class)) {
				// Recursively handle nested arrays
				$result[] = $this->getClassMarkup($class);
			} elseif (is_string($class) && !empty($class)) {
				$result[] = $class;
			} elseif ($class === true) {
				$result[] = $key;
			}
		}

		return implode(' ', $result);
	}

	/**
	 * @param array $strategies
	 * @return string
	 */
	public function getClasses(array $strategies = []): string
	{
		$classes = [];
		// Get all strategies if none specified
		$strategies = empty($strategies) ? array_keys($this->builders) : $strategies;
		foreach ($strategies as $name) {
			$strategy = $this->getStrategy($name);
			$strategy->addClasses($classes, $this->attributes);
		}
		return $this->getClassMarkup(array_unique($classes));
	}

	/**
	 * @param $class_type
	 * @return string
	 */
	public function getGeneratedClasses($class_type): string
	{
		$classes = [];
		if (isset($this->attributes['generatedClasses'])) {
			foreach ($this->attributes['generatedClasses'] as $property) {
				$type = '';
				foreach ($property as $key => $property_values) {
					if ($key === 'type') {
						$type = $property_values;
						continue;
					}
					if (!empty($type) && $type === $class_type && !empty($property_values) && $property_values['value'] !== 'custom') {
						$classes[] = $property_values['class'];
					}
				}
			}
		}
		return trim($this->getClassMarkup($classes));
	}


	// TODO: Shouldn't every block have a unique class? Inserting no unique class is a bug.
	/**
	 * @return string
	 */
	public function getUniqueClass(): string
	{
		return isset( $this->attributes['uniqueId'] ) ? "stk-" . $this->attributes['uniqueId'] : '';
	}
}
