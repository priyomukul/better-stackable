<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if ( is_admin() ) {
    return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\Subtitle' ) ) {
    class Subtitle extends BaseBlockRenderer {
        protected array $uniqueWrapperClasses = ['stk-block-subtitle'];

        protected array $defaultAttributes = [
            'textTag' => 'p',
            'htmlTag' => 'div'
        ];

        protected function getElementClasses(): array {
            $classes = [
                'stk-block-subtitle__text',
                $this->blockRenderer->getClasses( ['text/alignment'] ),
                $this->blockRenderer->getGeneratedClasses( 'element' )
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
            echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']}>";
            echo "<{$this->attributes['textTag']} class='{$this->output['classes']['element']}'>";
            echo $this->attributes['text'];
            echo "</{$this->attributes['textTag']}>";
            echo "</{$this->attributes['htmlTag']}>";

            return ob_get_clean();
        }
    }
}
new Subtitle( $attributes, $content, $block );

?>
