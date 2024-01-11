<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}


if ( ! class_exists( 'StellarBlocks\Blocks\TabContent' ) ) {
	class TabContent extends BaseBlockRenderer {
		protected array $uniqueWrapperClasses = ['stk-block-tab-content'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'templateLock' => '',
		];

		protected function getElementClasses(): array {
			return [
				'stk-inner-blocks stk-block-content',
				$this->blockRenderer->getClasses(['row', 'text/alignment', 'content/alignment']),
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
new TabContent( $attributes, $content, $block );

?>
