<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Button')){
	class Button extends BaseBlockRenderer
	{
		/**
		 * This indicates whether there are any needs to generate custom attributes for wrapper div.
		 * @var bool
		 */
		protected bool $applyCustomAttributes = false;

		/**
		 * This indicates whether there are any needs to generate ID as attributes for wrapper div.
		 * @var bool
		 */
		protected bool $applyAdvancedAttributes = false;

		protected array $uniqueWrapperClasses = ['stk-block-button'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'buttonHoverEffect' => 'darken',
			'iconPosition' => 'left',
			'linkUrl' => '#'
		];
		protected function render(): string
		{
			/**
			 * This portion of code generates custom attributes as we need this in Anchor tag
			 */
			$link_attributes = $this->blockRenderer->getCustomAttributes();
			$link_attributes += $this->blockRenderer->getAdvancedAttributes();

			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  .$this->output['classes']['wrapper']; ?>>
				<a href="<?php echo $this->attributes['linkUrl']?>" class="<?php echo $this->output['classes']['element']; ?>" <?php echo $this->blockRenderer->getNormalizeAttributes( $link_attributes ); ?>>
					<?php if(!empty($this->attributes['icon']) && $this->attributes['iconPosition'] == 'left'): ?>
						<span class="stk--svg-wrapper">
						<div class="stk--inner-svg">
							<?php echo $this->attributes['icon']; ?>
						</div>
					</span>
					<?php endif; ?>
					<span class="stk-button__inner-text"><?php echo $this->attributes['text'] ?? ''; ?></span>
					<?php if(!empty($this->attributes['icon']) && $this->attributes['iconPosition'] == 'right'): ?>
					<span class="stk--svg-wrapper">
						<div class="stk--inner-svg">
							<?php echo $this->attributes['icon']; ?>
						</div>
					</span>
					<?php endif; ?>
				</a>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array {
			return  [
				'stk-link',
				'stk-button',
				'stk--hover-effect-' . $this->attributes['buttonHoverEffect'],
				$this->blockRenderer->getGeneratedClasses('element')
			];
		}
	}
}

new Button($attributes, $content, $block);

?>
