<?php

    namespace StellarBlocks\Blocks;

    use StellarBlocks\Renderer\BaseBlockRenderer;

    if ( ! class_exists( 'StellarBlocks\Blocks\Heading' ) ) {
        class Heading extends BaseBlockRenderer {
            protected array $uniqueWrapperClasses = ['stk-block-heading', 'stk-block-heading--v2'];

            protected array $defaultAttributes = [
                'textTag' => 'h2',
                'htmlTag' => 'div',
				'text' => '',
				'generatedClasses' => [
					'frontSize' => [
						'type' => 'element',
						'desktop' => [
							'value' =>  'xl',
							'class' => 'stl-text-xl'
						]
					]
				]
            ];

            protected function getElementClasses(): array {
				return [
					'stk-block-heading__text',
					$this->blockRenderer->getClasses( ['text/alignment', 'typography'] ),
					$this->blockRenderer->getGeneratedClasses( 'element' )
				];
            }

            protected function render(): string {
                ob_start();
            	?>
				<<?php echo $this->attributes['htmlTag'] . ' ' . $this->output['classes']['wrapper']; ?>>
					<?php if ( ! empty( $this->attributes['showTopLine'] ) ): ?>
					<div class="stk-block-heading__top-line"></div>
					<?php endif;?>
					<<?php echo $this->attributes['textTag']; ?> class="<?php echo $this->output['classes']['element'] ?>">
						<?php echo $this->attributes['text']; ?>
					</<?php echo $this->attributes['textTag']; ?>>
					<?php if ( ! empty( $this->attributes['showBottomLine'] ) ): ?>
					<div class="stk-block-heading__bottom-line"></div>
					<?php endif;?>
				</<?php echo $this->attributes['htmlTag'] ?>>
				<?php
				return ob_get_clean();
			}
		}
    }

    new Heading( $attributes, $content, $block );

?>
