<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Columns')){
	class Columns extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-columns'];

		protected array $wrapperStrategies = ['unique', 'text/alignment', 'background', 'lightbox', 'margin', 'responsive','separator'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'topSeparatorInverted' => false,
			'topSeparatorDesign' => 'wave-1',
			'bottomSeparatorDesign' => 'wave-1',
			'bottomSeparatorInverted' => false,
		];
		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['classes']['wrapper']; ?>>
				<?php if(!empty($this->attributes['topSeparatorShow'])): ?>
				<div class="stk-separator stk-separator__top">
					<div class="stk-separator__wrapper">
						<?php echo $this->blockRenderer->getSeparator('top'); ?>
					</div>
				</div>
				<?php endif; ?>
				<div class="<?php echo $this->output['classes']['element']; ?>">
					<?php echo $this->content; ?>
				</div>
				<?php if(!empty($this->attributes['bottomSeparatorShow'])): ?>
					<div class="stk-separator stk-separator__bottom">
						<div class="stk-separator__wrapper">
							<?php echo $this->blockRenderer->getSeparator('bottom'); ?>
						</div>
					</div>
				<?php endif; ?>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array {
			$classes = [
				$this->blockRenderer->getClasses(['rowInnerBlocks', 'content/alignment']),
				"stk-{$this->attributes['uniqueId']}-column",
			];
			if(!empty($this->attributes['contentAlign'])){
				$classes[] = "stk--block-align-{$this->attributes['uniqueId']}";
			}

			return $classes;
		}
	}
}

new Columns($attributes, $content, $block);

?>
