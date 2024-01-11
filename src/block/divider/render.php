<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if ( is_admin() ) {
	return;
}

if ( ! class_exists( 'StellarBlocks\Blocks\Divider' ) ) {
	class Divider extends BaseBlockRenderer {

		protected array $uniqueWrapperClasses = ['stk-block-divider'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
		];

		protected function getElementClasses(): array {
			return [];
		}

		protected function render(): string {
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['wrapper']; ?>>
			<?php if(in_array($this->getStyle(), ['dots', 'asterisks'])): ?>
				<div class="stk-block-divider__dots" aria-hidden="true">
					<div class="stk-block-divider__dot"></div>
					<div class="stk-block-divider__dot"></div>
					<div class="stk-block-divider__dot"></div>
				</div>
			<?php else: ?>
				<hr class="stk-block-divider__hr" />
			<?php endif; ?>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		public function getStyle(  ) {
			preg_match('(is-style-\w+)',$this->attributes['className'], $matches);
			if(!empty($matches)){
				return str_replace('is-style-','', $matches[0]);
			}
		}
	}
}

/**
 * @var array $attributes;
 * @var string $content;
 * @var WP_Block $block;
 */
new Divider( $attributes, $content, $block );
