<?php

    namespace StellarBlocks\Blocks;

    use StellarBlocks\Renderer\BaseBlockRenderer;

    if ( ! class_exists( 'StellarBlocks\Blocks\Image' ) ) {
        class Image extends BaseBlockRenderer {
            protected array $uniqueWrapperClasses = ['stk-block-image'];

            protected array $defaultAttributes = [
                'htmlTag' => 'div',
				'imageSize' => 'full'
            ];

            protected function getElementClasses(): array {
                $classes = [
                    'stk-img-wrapper'
                ];
                if ( !empty( $this->attributes['imageShape'] ) ) {
                    $classes[] = 'stk-img--shape';
                }
				if(!empty($this->attributes['imageShapeStretch'])){
					$classes[] = 'stk-image--shape-stretch';
				}
				if(!empty($this->attributes['imageHasLightbox'])){
					$classes[] = 'stk--has-lightbox';
				}
                return $classes;
            }

            protected function render(): string {
				ob_start();

            	?>
					<<?php echo $this->attributes['htmlTag'] . ' ' . $this->output['classes']['wrapper']; ?>>
						<?php if(!empty($this->attributes['imageId'])): ?>
							<figure class="<?php echo $this->output['classes']['element'] ?>">
								<?php echo wp_get_attachment_image($this->attributes['imageId'], $this->attributes['imageSize'], false, [
									'stk-img wp-image-'.$this->attributes['imageId']
								]); ?>
							</figure>
						<?php endif;?>
					</<?php echo $this->attributes['htmlTag'] ?>>
					<?php
				return ob_get_clean();
            }
        }
    }
    new Image( $attributes, $content, $block );

?>
