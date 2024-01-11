<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Button_Group')){
	class Button_Group extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-button-group'];

		protected function getElementClasses(): array
		{
			return  ['stk-button-group', $this->blockRenderer->getClasses(['rowInnerBlocks'])];
		}

		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  .$this->output['classes']['wrapper']; ?>>
				<div class="<?php echo $this->output['classes']['element'];?>">
					<?php echo $this->content;?>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}
	}
}

new Button_Group($attributes, $content, $block);

?>
