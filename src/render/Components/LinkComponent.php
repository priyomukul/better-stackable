<?php

namespace StellarBlocks\Renderer\Components;

class LinkComponent extends BaseComponent {
	public string $tagName = 'a';

	public function shouldRender(): bool {
		return true;
	}

	public function eligibleAttributes(): array {
		$attrs = [];

		$attrs['class'] = 'stk-link ' . ( $this->props['class'] ?? '');

		$propsToPass = $this->omit( [ 'target', 'rel', 'tagName' ] );

		if ( isset( $this->props['target'] ) ) {
			$propsToPass['target'] = esc_attr( $this->props['target'] );
		}

		$rel = array_filter( explode( ' ', $this->props['rel'] ?? '' ), fn( $s ) => ! ! $s );

		if ( ($this->props['target'] ?? '') === '_blank' ) {
			if ( ! in_array( 'noreferrer', $rel ) ) {
				$rel[] = 'noreferrer';
			}

			if ( ! in_array( 'noopener', $rel ) ) {
				$rel[] = 'noopener';
			}
		}

		if ( ! empty( $rel ) ) {
			$propsToPass['rel'] = implode( ' ', $rel );
		}

		return array_merge( $propsToPass, $attrs );
	}
}
