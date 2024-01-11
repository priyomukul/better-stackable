<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}

if ( ! class_exists( 'StellarBlocks\Blocks\Separator' ) ) {
	class Separator extends BaseBlockRenderer {

		protected array $uniqueWrapperClasses = ['stk-block-separator stk--no-padding'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'separatorFlipVertically' => false,
			'separatorDesign' => 'wave-1'
		];

		protected function getElementClasses(): array {
			return [
				'stk-block-separator__inner'
			];
		}

		protected function render(): string {
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['wrapper']; ?>>
			<div class="<?php echo $this->output['classes']['element']; ?>" role="presentation">
				<?php echo $this->blockRenderer->getSeparator(); ?>
			</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}
	}
}

/**
 * @var array $attributes;
 * @var string $content;
 * @var WP_Block $block;
 */
new Separator( $attributes, $content, $block );
