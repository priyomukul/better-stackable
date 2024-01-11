<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Accordion')){
	class Accordion extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-accordion'];

		protected array $defaultAttributes = [
			'htmlTag' => 'details'
		];

		protected array $wrapperStrategies = ['unique', 'content/alignment', 'text/alignment', 'background', 'innerBlocks', 'margin', 'responsive'];

		protected function getElementClasses(): array
		{
			return  [];
		}

		protected function prepareOutput() : void
		{
			$attrs = [
				'data-block-id' => $this->attributes['uniqueId']
			];
			$classes = [ ...$this->uniqueWrapperClasses];
			if(!empty($this->attributes['startOpen'])){
				$classes[] = 'stk--is-open';
				$attrs['open'] = true;
			}
			if(!empty($this->attributes['onlyOnePanelOpen'])){
				$classes[] = 'stk--single-open';
			}
			$classes[] = $this->blockRenderer->getClasses($this->wrapperStrategies);
			$classes[] = $this->blockRenderer->getGeneratedClasses('blockDiv');

			$this->output['classes']['wrapper'] = get_block_wrapper_attributes([
				'class' => $this->combineClasses($classes),
				...$attrs
			]);
			$this->output['classes']['element'] = $this->combineClasses( $this->getElementClasses() );
		}

		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['classes']['wrapper']; ?>>
				<?php echo $this->content;?>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}
	}
}

new Accordion($attributes, $content, $block);

?>
