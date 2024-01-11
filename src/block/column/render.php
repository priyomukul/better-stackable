<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Column')){
	class Column extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-column stk-column'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div'
		];
		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['classes']['wrapper']; ?>>
				<div class="<?php echo $this->output['classes']['element']; ?>">
					<div class="<?php echo $this->output['classes']['innerBlocksWrapper']; ?>">
						<?php echo $this->content; ?>
					</div>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array {
			$classes = [
				$this->blockRenderer->getClasses(['container']),
				"stk-column-wrapper stk-block-column__content"
			];

			return $classes;
		}

		protected function getInnerBlocksWrapperClasses() : array {
			$classes =  [
				"stk-block-content stk-inner-blocks",
				"stk-{$this->attributes['uniqueId']}-inner-blocks"
			];
			if(!empty($this->attributes['alignLastBlockToBottom'])){
				$classes[] = 'stk--align-last-block-to-bottom';
			}
			return $classes;
		}
	}
}

new Column($attributes, $content, $block);

?>
