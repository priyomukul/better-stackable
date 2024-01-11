<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\IconBox')){
	class IconBox extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-icon-box'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'imageSize' => 'large'
		];
		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  .$this->output['classes']['wrapper']; ?>>
				<div class="<?php echo $this->output['classes']['element']; ?>">
					<?php
						echo $this->content;
						echo $this->componentRenderer->render('blockLink', [])
					?>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array {
			return [
				'stk-block-icon-box__content',
				$this->blockRenderer->getClasses(['container','innerBlocks']),
				$this->blockRenderer->getGeneratedClasses('container')
			];
		}


	}
}

new IconBox($attributes, $content, $block);

?>
