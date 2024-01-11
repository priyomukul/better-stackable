<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Card')){
	class Card extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-card'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'imageSize' => 'large',
			'generatedClasses' => [
				'containerPadding' => [
					'type' => 'innerBlocks',
					'desktop' => [
						'value' =>  'xl',
						'class' => 'stl-p-6'
					],
					'tablet' => [
						'value' =>  'xl',
						'class' => 'md:stl-p-6'
					],
					'mobile' => [
						'value' =>  'xl',
						'class' => 'sm:stl-p-6'
					]
				]
			]
		];
		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  .$this->output['classes']['wrapper']; ?>>
				<div class="<?php echo $this->output['classes']['element']; ?>">
					<?php if(!empty($this->attributes['imageId'])): ?>
					<figure class="<?php echo $this->getImageClasses();?>">
						<?php if(!empty($this->attributes['imageId'])): ?>
							<?php echo wp_get_attachment_image($this->attributes['imageId'], $this->attributes['imageSize'], false, [
								'stk-img wp-image-'.$this->attributes['imageId']
							]); ?>
						<?php endif;?>
					</figure>
					<?php endif;?>
					<div class="<?php echo $this->output['classes']['innerBlocksWrapper']?>">
						<?php echo $this->content; ?>
					</div>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getInnerBlocksWrapperClasses(){
			return [
				$this->blockRenderer->getClasses(['innerBlocks'])
			];
		}

		protected function getElementClasses( ): array {
			return [
				$this->blockRenderer->getClasses(['container']),
				$this->blockRenderer->getGeneratedClasses('container')
			];
		}

		private function getImageClasses() {
			$classes = [
				'stk-block-card__image stk-img-wrapper'
			];
			if(!empty($this->attributes['imageShapeStretch'])){
				$classes[] = 'stk-image--shape-stretch';
			}
			return $this->combineClasses($classes);
		}


	}
}

new Card($attributes, $content, $block);

?>
