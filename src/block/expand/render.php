<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\ExpandShowMore' ) ) {
	class ExpandShowMore extends BaseBlockRenderer {
		protected array $uniqueWrapperClasses = ['stk-block-expand'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'customAttributes' => [
				[ 'aria-expanded', 'false' ]
			]
		];

		protected function getElementClasses(): array {
			return [
				'stk-inner-blocks stk-block-content',
				$this->blockRenderer->getClasses(['text/alignment']),
			];
		}


		protected function render(): string {
			ob_start();
			echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']}>";
			echo "<div class='{$this->output['classes']['element']}'>";
			echo $this->content;
			echo "</div>";
			echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
		}
	}
}

/**
 * @var array $attributes
 * @var string $content
 * @var WP_Block $block
 */
new ExpandShowMore( $attributes, $content, $block );
