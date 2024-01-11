<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use StellarBlocks\Renderer\BlockRenderer;
use StellarBlocks\Renderer\BlockRendererInterface;
use WP_Block;

if(!class_exists('StellarBlocks\Blocks\Icon')){
		class Icon extends BaseBlockRenderer
		{
			protected array $uniqueWrapperClasses = ['stk-block-icon'];

			protected array $defaultAttributes = [
				'htmlTag' => 'div',
				'buttonHoverEffect' => 'darken',
				'icon' => '<svg data-prefix="fa" data-icon="star" class="svg-inline--fa fa-star fa-w-18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" aria-hidden="true"><path fill="currentColor" d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"></path></svg>',
				'linkUrl' => '#'
			];
			protected function render(): string
			{
				ob_start();
				?>
				<<?php echo $this->attributes['htmlTag'] . ' '  .$this->output['classes']['wrapper']; ?>>
				<?php
					echo $this->componentRenderer->render('link', [], function() {
						return $this->componentRenderer->render( 'icon', [] );
					});
				?>
				</<?php echo $this->attributes['htmlTag']?>>
				<?php

				return ob_get_clean();
			}

			protected function getElementClasses(): array {
				return ['stk--svg-wrapper'];
			}
		}
}

/**
 * @var array $attributes;
 * @var string $content;
 * @var WP_Block $block;
 */
new Icon($attributes, $content, $block);
