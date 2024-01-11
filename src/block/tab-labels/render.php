<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\TabLabels' ) ) {
	class TabLabels extends BaseBlockRenderer {
		protected array $uniqueWrapperClasses = ['stk-block-tab-labels'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'showIcon' => false,
			'icon' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" class="svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>',
			'columnGap' => 12,
			'fullWidth' => false,
			'scrollableOnMobile' => true,
		];

		public function __construct(array $attributes, string $content, WP_Block $block)
		{
			if( ! empty( $attributes[ 'scrollableOnMobile'] ) ) {
				$this->uniqueWrapperClasses[] = 'stk-block-tab-labels--wrap-mobile';
			}

			parent::__construct($attributes, $content, $block);
		}

		protected function getElementClasses(): array {
			return [
				'stk-block-tab-labels__text',
				$this->blockRenderer->getClasses(['text/alignment', 'typography']),
			];
		}


		protected function render(): string {
			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']}>";

			echo "<div class='stk-block-tab-labels__wrapper' role='tablist'>";

			if( ! empty( $this->attributes['tabLabels'] ) ) {
				foreach( $this->attributes['tabLabels'] as $tabLabel ) {
					echo "<button class='stk-block-tabs__tab {$this->blockRenderer->getGeneratedClasses('button')}' role='tab'>";

					$this->blockRenderer->getIconHTML(
						$this->attributes['icon'],
						$this->attributes['showIcon']
					);

					echo "<div class='{$this->output['classes']['element']}'>";
					echo "<span>{$tabLabel['label']}</span>";
					echo "</div>";

					echo "</button>";
				}
			}

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
new TabLabels( $attributes, $content, $block );

?>
