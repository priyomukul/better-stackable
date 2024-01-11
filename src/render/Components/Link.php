<?php

namespace StellarBlocks\Renderer\Components;

class Link extends LinkComponent {
	public function shouldRender(): bool {
		return isset( $this->attributes[ $this->getAttrName( 'hasLink' ) ] );
	}

	public function prepare(): void {
		parent::prepare();

		if ( $this->attrTemplate === '%s' ) {
			$this->attrTemplate     = 'link%s';
			$this->attrTemplateName = ':link%s';
		}
	}

	public function eligibleAttributes(): array {
		$attributes = parent::eligibleAttributes();

		$component = $this->componentRenderer->resolve( "linkComponent{$this->attrTemplateName}", [
			'href'   => $this->attributes[ $this->getAttrName( 'url' ) ] ?? null,
			'target' => ( ( $this->attributes[ $this->getAttrName( 'newTab' ) ] ?? false ) ? '_blank' : null ),
			'rel'    => ( $this->attributes[ $this->getAttrName( 'rel' ) ] ?? null ),
			'title'  => ( $this->attributes[ $this->getAttrName( 'title' ) ] ?? null ),
		] );

		return array_merge( $attributes, $component->eligibleAttributes() );
	}
}
