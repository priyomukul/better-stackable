<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\NumberBox')){
	class NumberBox extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-number-box', 'stk--has-shape'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'text' => '',
			'hasShape' => true
		];
		protected function render(): string
		{
			$wrapperAttributes = $this->output['classes']['wrapper'];
			if(empty($this->attributes['hasShape'])){
				$wrapperAttributes = str_replace('stk--has-shape', '', $wrapperAttributes);
			}
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $wrapperAttributes; ?>>
				<div class="<?php echo $this->output['classes']['element']; ?>" role="presentation">
					<?php echo $this->attributes['text']; ?>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array {
			$classes =  [
				'stk-block-number-box__text',
				$this->blockRenderer->getClasses(['typography']),
				$this->blockRenderer->getGeneratedClasses('element')
			];
			if(!empty($this->attributes['hasShape'])){
				$classes[] = $this->blockRenderer->getGeneratedClasses('shape');
			}
			return $classes;
		}
	}
}

new NumberBox($attributes, $content, $block);

?>
