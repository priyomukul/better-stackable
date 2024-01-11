<?php

    namespace StellarBlocks\Blocks;

    use StellarBlocks\Renderer\BaseBlockRenderer;

    if ( ! class_exists( 'StellarBlocks\Blocks\IconLabel' ) ) {
        class IconLabel extends BaseBlockRenderer {
            protected array $uniqueWrapperClasses = ['stk-block-icon-label'];

            protected array $defaultAttributes = [
                'htmlTag' => 'div'
            ];

            protected function getElementClasses(): array {
                $classes = [
                    'stk-inner-blocks',
                    $this->blockRenderer->getClasses( ['text/alignment'] ),
                    $this->blockRenderer->getClasses( ['rowInnerBlocks'] ),
                    'stk-block-content'
                ];

                if ( isset( $this->attributes['textColorType'] ) && $this->attributes['textColorType'] === 'gradient' ) {
                    $classes[] = 'stk--is-gradient';
                }
                if ( isset( $this->attributes['textColor1'] ) ) {
                    $classes[] = 'has-text-color';
                }
                return $classes;
            }

            protected function render(): string {
                ob_start();
            ?>
				<<?php echo $this->attributes['htmlTag'] . ' ' . $this->output['classes']['wrapper']; ?>>
					<div class="<?php echo $this->output['classes']['element']; ?>">
						<?php echo $this->content; ?>
					</div>
				</<?php echo $this->attributes['htmlTag'] ?>>
				<?php
                    return ob_get_clean();
                            }
                        }
                    }
                    new IconLabel( $attributes, $content, $block );

                ?>
