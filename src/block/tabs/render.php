<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\Tabs' ) ) {
	class Tabs extends BaseBlockRenderer {
		protected array $uniqueWrapperClasses = ['stk-block-tabs'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'initialTabOpen' => '1',
			'tabOrientation' => 'horizontal',
			'tabPanelEffect' => 'fade',
			'tabPanelOffset' => 16,
		];

		protected function getElementClasses(): array {
			$classes = [
				'stk-inner-blocks stk-block-content',
				$this->blockRenderer->getClasses(['row', 'content/alignment', 'text/alignment']),
			];

			if( ! empty( $this->attributes['tabOrientation'] ) ) {
				if( $this->attributes['tabOrientation'] === 'vertical' ) {
					$classes[] = 'stk-block-tabs--vertical';
				} else {
					$classes[] = 'stk-block-tabs--horizontal';
				}
			}

			if( ! empty( $this->attributes['tabPanelEffect'] ) ) {
				if( $this->attributes['tabPanelEffect'] !== 'immediate' ) {
					$classes[] = 'stk-block-tabs--fade';
				} else {
					$classes[] = 'stk-block-tabs--immediate';
				}
			}

			return $classes;
		}

		protected function render(): string {
			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']} data-initial-tab='{$this->attributes['initialTabOpen']}'>";

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
new Tabs( $attributes, $content, $block );

?>
