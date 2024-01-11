<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\TeamMember')){
	class TeamMember extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-team-member'];

		protected array $wrapperStrategies = ['unique', 'background', 'margin', 'responsive', 'content/alignment'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
            'contentAlign' => 'center',
            'hasContainer' => true,
			'generatedClasses' => [
				'containerPadding' => [
					'type' => 'container',
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
				$this->blockRenderer->getClasses(['innerBlocks', 'text/alignment']),
			];
		}

		protected function getElementClasses( ): array {
            $classes = [
                'stk-content-align',
				$this->blockRenderer->getClasses(['container']),
				$this->blockRenderer->getGeneratedClasses('container')
			];
            if(!empty($this->attributes['innerBlockContentAlign'])){
                $classes[] = 'align'.$this->attributes['innerBlockContentAlign'];
            }
            return $classes;
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

new TeamMember($attributes, $content, $block);

?>
