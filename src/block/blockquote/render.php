<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if(!class_exists('StellarBlocks\Blocks\BlockQuote')){
	class BlockQuote extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-blockquote'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'hasContainer' => true
		];

		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['wrapper']; ?>>
				<div class="<?php echo $this->output['classes']['element']; ?>">
					<div class="<?php echo $this->output['classes']['innerBlocksWrapper']?>">
						<?php echo $this->content; ?>
					</div>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array
		{
			return [
				"stk-block-blockquote__content",
				$this->blockRenderer->getClasses(['container', 'content/alignment']),
				$this->blockRenderer->getGeneratedClasses('container')
			];
		}

		protected function getInnerBlocksWrapperClasses(  ) {
			return [
				$this->blockRenderer->getClasses(['innerBlocks', 'text/alignment'])
			];
		}
	}
}

new BlockQuote($attributes, $content, $block);

?>
