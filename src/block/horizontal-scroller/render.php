<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;


if ( is_admin() ) {
	return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\HorizontalScroller' ) ) {
	class HorizontalScroller extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-horizontal-scroller'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'columnSpacing' => '',
			'horizontalScrollerColumnWidth' => '',
			'horizontalScrollerHeight' => '',
			'horizontalScrollerColumnGap' => '',
			'horizontalScrollerSnap' => '',
			'horizontalScrollerLeftOffset' => '',
			'templateLock' => '',
			'columnArrangement' => '',
			'scrollbarHeight' => '',
			'scrollbarTrackColor' => '',
			'scrollbarThumbColor' => '',
			'scrollbarThumbRadius' => '',
			'showScrollbar' => false,
		];

		/**
		 * Returning empty as I needed to implement it. but no element is needed here.
		 *
		 * @return array
		 */
		protected function getElementClasses(): array
		{
			$classes = [
				'stk-inner-blocks',
				'stk-block-content',
				$this->blockRenderer->getClasses([ 'row', 'text/alignment', 'content/alignment' ])
			];

			if ( $this->attributes['showScrollbar'] ?? false ) {
				$classes[] = 'stk--with-scrollbar';
			}

			return $classes;
		}

		protected function render(): string
		{
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
new HorizontalScroller( $attributes, $content, $block );
