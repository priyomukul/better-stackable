<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if ( ! class_exists( 'StellarBlocks\Blocks\IconList' ) ) {
    class IconList extends BaseBlockRenderer {
        protected array $uniqueWrapperClasses = ['stk-block-icon-list'];

        protected array $defaultAttributes = [
            'textTag' => 'ul',
            'htmlTag' => 'div'
        ];

        protected function getElementClasses(): array {
            $classes = [
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
            // error_log( print_r( $this->attributes, 1 ) );
            ob_start();
            printf( "<%s %s>", $this->attributes['htmlTag'], $this->output['classes']['wrapper'] );
            $elementclass = "";
            if ( isset( $this->output['classes']['element'] ) && ! empty( $this->output['classes']['element'] ) ) {
                $elementclass = "class=\"" . $this->output['classes']['element'] . "\"";
            }
            printf( "<%s %s>", $this->attributes['textTag'], $elementclass );
            echo $this->attributes['text'];
            printf( "</%s>", $this->attributes['textTag'] );
            printf( "</%s>", $this->attributes['htmlTag'] );

            return ob_get_clean();
        }
    }
}
new IconList( $attributes, $content, $block );

?>
