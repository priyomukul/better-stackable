<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if ( is_admin() ) {
    return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\Hero' ) ) {
    class Hero extends BaseBlockRenderer {
        protected array $uniqueWrapperClasses = ['stk-block-hero'];

        protected array $defaultAttributes = [
            'textTag' => 'p',
            'htmlTag' => 'div',
			'contentAlign' => 'center',
			'hasContainer' => true,
			'blockBackgroundColorType' => 'single',
			'containerVerticalAlign' => 'center',
			'containerHeight' => 500,

			'topSeparatorInverted' => false,
			'topSeparatorDesign' => 'wave-1',
			'bottomSeparatorDesign' => 'wave-1',
			'bottomSeparatorInverted' => false,
        ];

        protected function getElementClasses(): array {
            return [
				'stk-block-hero__content',
				$this->blockRenderer->getGeneratedClasses('container'),
				$this->blockRenderer->getClasses(['container', 'content/alignment', 'background', 'text/alignment']),
            ];
        }

		protected function getInnerBlocksWrapperClasses(): array
		{
			return [
				$this->blockRenderer->getClasses([ 'text/alignment', 'innerBlocks' ]),
			];
		}

        protected function render(): string {
            ob_start();

            echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']}>";

			/**
			 * TOP SEPARATOR
			 */
			if(!empty($this->attributes['topSeparatorShow'])) {
				echo '<div class="stk-separator stk-separator__top">';
					echo '<div class="stk-separator__wrapper">';
						echo $this->blockRenderer->getSeparator('top');
					echo "</div>";
				echo "</div>";
			}

			echo "<div class='{$this->output['classes']['element']}'>";
				echo "<div class='{$this->output['classes']['innerBlocksWrapper']}'>";
					echo $this->content;
				echo "</div>";
			echo "</div>";

			/**
			 * BOTTOM SEPARATOR
			 */
			if(!empty($this->attributes['bottomSeparatorShow'])) {
				echo '<div class="stk-separator stk-separator__bottom">';
					echo '<div class="stk-separator__wrapper">';
						echo $this->blockRenderer->getSeparator('bottom');
					echo "</div>";
				echo "</div>";
			}

            echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
        }
    }
}

new Hero( $attributes, $content, $block );

?>
