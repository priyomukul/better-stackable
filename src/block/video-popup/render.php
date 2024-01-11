<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;


if ( is_admin() ) {
	return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\VideoPopup' ) ) {
	class VideoPopup extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-video-popup'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'videoLink' => '',
			'videoFullscreen' => true,
			'videoDownload' => true,
			'videoLoop' => false,
		];

		protected array $hasWrapperAttributes = [
			'video' => 'videoLink',
			'nofullscreen' => 'videoFullscreen',
			'nodownload' => 'videoDownload',
			'loop' => 'videoLoop',
		];

		/**
		 * Returning empty as I needed to implement it. but no element is needed here.
		 *
		 * @return array
		 */
		protected function getElementClasses(): array
		{
			return [
				'stk-block-video-popup__overlay',
				'stk-inner-blocks stk-block-content stk-hover-parent',
				$this->blockRenderer->getClasses( [ 'row', 'text/alignment' ] )
			];
		}

		protected function render(): string
		{
			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['wrapper']}>";
			echo "<button class='{$this->output['classes']['element']}' aria-label='".  ( $this->attributes['ariaLabel'] ?? __( 'Play Video', STACKABLE_I18N ) ) ."'>";
			echo $this->content;
			echo "</button>";

			echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
		}
	}
}


/**
 * @var array $attributes
 * @var string $content
 * @var WP_Block $block
 */
new VideoPopup( $attributes, $content, $block );
