<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}

if ( ! class_exists( 'StellarBlocks\Blocks\ImageBox' ) ) {
	class ImageBox extends BaseBlockRenderer {
		protected array $uniqueWrapperClasses = ['stk-block-image-box stk-hover-parent'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'contentAlign' => 'center',
			'blockLinkNewTab' => false,
		];

		protected function getElementClasses(): array {
			return [
				'stk-block-content stk-inner-blocks stk-block-image-box__content',
				$this->blockRenderer->getClasses(['row', 'text/alignment']),
			];
		}

		protected function render(): string {
			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['wrapper']}>";

			echo "<div class='{$this->output['classes']['element']}'>";
			echo $this->content;
			echo "</div>";

			// we need to render link here
			echo $this->componentRenderer->render( 'blockLink', [
				'isHidden' => false,
			] );

			echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
		}
	}
}

/**
 * @var array $attributes;
 * @var string $content;
 * @var WP_Block $block;
 */
new ImageBox( $attributes, $content, $block );
