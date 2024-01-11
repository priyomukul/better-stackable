<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if ( is_admin() ) {
    return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\Testimonial' ) ) {
    class Testimonial extends BaseBlockRenderer {
        protected array $uniqueWrapperClasses = ['stk-block-testimonial'];

        protected array $defaultAttributes = [
            'textTag' => 'p',
            'htmlTag' => 'div',
			'contentAlign' => 'center',
			'innerBlockContentAlign' => 'center',
			'hasContainer' => true,
			'blockBackgroundColorType' => 'single'
        ];

        protected function getElementClasses(): array {
            return [
				'stk-block-testimonial__content',
				$this->blockRenderer->getGeneratedClasses('container'),
				$this->blockRenderer->getClasses(['content/alignment', 'container', 'background']),
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
				echo "<div class='{$this->output['classes']['element']}'>";
					echo "<div class='{$this->output['classes']['innerBlocksWrapper']}'>";
						echo $this->content;
					echo "</div>";
				echo "</div>";
            echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
        }
    }
}

new Testimonial( $attributes, $content, $block );

?>
