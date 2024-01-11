<?php

namespace StellarBlocks\Renderer\Components;

class BlockLink extends LinkComponent {
	public function shouldRender(): bool {
		return isset( $this->attributes[ $this->getAttrName( 'url' ) ] );
	}

	public function defaultProps(): array {
		$defaults = parent::defaultProps();

		return wp_parse_args([
			'isHidden' => true
		], $defaults);
	}

	public function prepare(): void {
		parent::prepare();

		if ( $this->attrTemplate === '%s' ) {
			$this->attrTemplate     = 'blockLink%s';
			$this->attrTemplateName = ':blockLink%s';
		}
	}

	public function eligibleAttributes(): array {
		$attributes = parent::eligibleAttributes();

		unset( $attributes['isHidden'] );

		$component = $this->componentRenderer->resolve( "linkComponent{$this->attrTemplateName}", [
			'class' => 'stk-block-link stk--transparent-overlay',
			'href'  => $this->props['href'] ?? $this->attributes[ $this->getAttrName( 'url' ) ] ?? null,
			'target'  => ( ($this->attributes[ $this->getAttrName( 'newTab' ) ] ?? false) ? '_blank' : null ),
			'rel'  => ( $this->attributes[ $this->getAttrName( 'rel' ) ] ?? null ),
			'title'  => ( $this->attributes[ $this->getAttrName( 'title' ) ] ?? null ),
			'aria-hidden'  => $this->props['isHidden'] == 'true' ? "true" : null,
			'tabindex'  => $this->props['isHidden'] == 'true' ? "-1" : null,
		] );

		return array_merge( $attributes, $component->eligibleAttributes() );
	}
}
