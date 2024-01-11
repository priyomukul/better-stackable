<?php

namespace StellarBlocks\Renderer\Components;

class SVGContent extends BaseComponent {
	protected string $tagName = 'div';

	public function defaultProps(): array {
		$class = [ 'stk--inner-svg' ];

		if( ! empty( $this->attributes[ $this->getAttrName('icon2') ] ) ) {
			$class[] = 'stk--icon-2';
		}

		return [
			'prependRenderString' => '',
			'class' => implode( ' ', $class )
		];
	}

	public function eligibleAttributes(): array {
		return $this->omit( [ 'prependRenderString', 'value', $this->getAttrName('icon2'), $this->getAttrName('icon') ] );
	}

	public function shouldRender(): bool {
		return true;
	}

	public function render( callable $children = null ): string {
		return $this->props['prependRenderString'] . $this->props['value'];
	}
}
