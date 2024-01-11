<?php

namespace StellarBlocks\Renderer\Components;

class Icon extends BaseComponent {
	protected string $tagName = 'span';

	public function defaultProps(): array {
		$class = [ 'stk--svg-wrapper' ];

		if( ! empty( $this->attributes[ $this->getAttrName('icon2') ] ) ) {
			$class[] = 'stk--has-icon2';
		}

		return [
			'value' => '',
			'hasLinearGradient' => true,
			'class' => implode( ' ', $class )
		];
	}

	public function eligibleAttributes(): array {
		return $this->omit( [ 'hasLinearGradient', 'value' ] );
	}

	public function shouldRender(): bool {
		return ! empty( $this->props['value'] ) || ! empty( $this->attributes[$this->getAttrName( 'icon' )] );
	}

	public function render( callable $children = null ): string {
		$linearGradient = $this->props[ 'hasLinearGradient' ] ? $this->componentRenderer->resolve( 'linearGradient', [
			'id' => 'linear-gradient-' . $this->attributes['uniqueId']
		] )->render() : '';

		$icon = ( ! empty( $this->props['value'] ) ? $this->props['value'] : null ) ?? $this->attributes[$this->getAttrName( 'icon' )] ?? false;

		ob_start();

		if( $icon ) {
			echo $this->componentRenderer->resolve( 'svgContent', [
				'value' => $icon,
				'prependRenderString' => $linearGradient,
				'aria-label' => $this->attributes[ $this->getAttrName('ariaLabel') ] ?? null
			] )->renderAsHtml( $children );
		}

		if( $this->attributes[$this->getAttrName( 'icon2' )] ?? false ) {
			echo $this->componentRenderer->resolve( 'svgContent', [
				'value' => $this->attributes[$this->getAttrName( 'icon2' )],
				'prependRenderString' => $linearGradient,
				'aria-label' => $this->attributes[ $this->getAttrName('ariaLabel') ] ?? null,
				'style' => [ 'display: none' ]
			] )->renderAsHtml( $children );
		}

		echo parent::render( $children );

		return ob_get_clean();
	}
}
