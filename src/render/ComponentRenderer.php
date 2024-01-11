<?php

namespace StellarBlocks\Renderer;

use StellarBlocks\Renderer\Components\BaseComponent;
use StellarBlocks\Renderer\Components\BlockLink;
use StellarBlocks\Renderer\Components\Icon;
use StellarBlocks\Renderer\Components\LinearGradient;
use StellarBlocks\Renderer\Components\Link;
use StellarBlocks\Renderer\Components\LinkComponent;
use StellarBlocks\Renderer\Components\SVGContent;

class ComponentRenderer {
	protected array $attributes;
	protected BaseBlockRenderer $block;

	/**
	 * @var BaseComponent[]
	 */
	private array $components = [
		'link' => Link::class,
		'linkComponent' => LinkComponent::class,
		'blockLink' => BlockLink::class,
		'icon' => Icon::class,
		'svgContent' => SVGContent::class,
		'linearGradient' => LinearGradient::class
	];

	public function __construct( $block ) {
		$this->block = $block;
		$this->attributes = $block->attributes;
	}

	public function resolve( string $componentName, $props ): BaseComponent {
		if( ! str_contains( $componentName, ':' ) ) {
			return ($this->components[ $componentName ]::make( $this, $props ));
		}

		/**
		 * Passing Options For Strategy with Colon in Name.
		 * i.e: link:link%s
		 */
		$attribute_with_options = explode( ':', $componentName );
		$componentName = $attribute_with_options[0];
		$attributeTemplate = $attribute_with_options[1];

		return ($this->components[ $componentName ]::make( $this, $props, $attributeTemplate ));
	}

	public function render( string $componentName, $props = [], callable $children = null ): string {
		return $this->resolve( $componentName, $props )->renderAsHtml( $children );
	}

	public function getAttributes(): array {
		return $this->attributes;
	}
}
