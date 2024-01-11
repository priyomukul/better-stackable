<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;


if ( is_admin() ) {
	return;
}

if ( ! class_exists( 'StellarBlocks\Blocks\Carousel' ) ) {
	class Carousel extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-carousel'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'autoplay' => true,
			'autoplaySpeed' => 4000,

			'slidesToShow' => 1,

			'showArrows' => true,
			'showArrowsOnMobile' => true,
			'showDotsOnMobile' => true,

			'ariaLabelSlideOf' => 'Slide %%d of %%d',
			'ariaLabelSlide' => 'Slide %%d',
			'ariaLabelPrev' => 'Previous slide',
			'ariaLabelNext' => 'Next slide',

			'showDots' => true,

			'arrowIconPrev' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" class="svg-inline--fa fa-chevron-left" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="32" height="32"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z"></path></svg>',
			'arrowIconNext' => '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" class="svg-inline--fa fa-chevron-right" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="32" height="32"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z"></path></svg>',

			'topSeparatorInverted' => false,
			'topSeparatorDesign' => 'wave-1',
			'bottomSeparatorDesign' => 'wave-1',
			'bottomSeparatorInverted' => false,

			'generatedClasses' => [
				'arrowBorderRadius' => [
					'type' => 'arrows',
					'desktop' => [
						'value' =>  'full',
						'class' => 'stl-rounded-full'
					]
				],
				'dotsBorderRadius' => [
					'type' => 'dots',
					'desktop' => [
						'value' =>  'full',
						'class' => 'stl-rounded-full'
					]
				]
			]
		];

		public function __construct(array $attributes, string $content, WP_Block $block)
		{
			/**
			 * Slider Based Classes
			 */
			$classes = [];
			if( empty( $attributes['carouselType'] ) ) {
				$classes[] = 'stk--is-slide';
			}

			if( ! empty( $attributes['carouselType'] ) && $attributes['carouselType'] === 'fade' ) {
				$classes[] = 'stk--is-fade';
			}

			if( ! empty( $attributes['showArrowsOnMobile'] ) && (bool) $attributes['showArrowsOnMobile'] === false ) {
				$classes[] = 'stk--hide-mobile-arrows';
			}

			if( ! empty( $attributes['showDotsOnMobile'] ) && (bool) $attributes['showDotsOnMobile'] === false ) {
				$classes[] = 'stk--hide-mobile-dots';
			}

			if( ! empty( $attributes['arrowPosition'] ) && $attributes['arrowPosition'] === 'outside' ) {
				$classes[] = 'stk--arrows-outside';
			}

			if( ! empty( $attributes['dotsStyle'] ) && $attributes['dotsStyle'] === 'outline' ) {
				$classes[] = 'stk--dots-outline';
			}

			$classes[] = 'stk--arrows-justify-space-between';
			if( ! empty( $attributes['arrowJustify'] ) ) {
				$classes[] = 'stk--arrows-justify-' . $attributes['arrowJustify'];
			}

			$classes[] = 'stk--arrows-align-center';
			if( ! empty( $attributes['arrowAlign'] ) ) {
				$classes[] = 'stk--arrows-align-' . $attributes['arrowAlign'];
			}

			$this->uniqueWrapperClasses = array_merge( $this->uniqueWrapperClasses, $classes );

			parent::__construct($attributes, $content, $block);
		}

		protected function getElementClasses(): array
		{
			return [
				'stk-block-carousel__slider-wrapper',
				'stk-inner-blocks',
				'stk-block-content',
				$this->blockRenderer->getClasses([ 'row', 'text/alignment', 'content/alignment' ])
			];
		}

		protected function render(): string
		{
			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']} data-slides-to-show='{$this->attributes['slidesToShow']}'>";

			/**
			 * TOP SEPARATOR
			 */
			if(!empty($this->attributes['topSeparatorShow'])) {
				echo '<div class="stk-separator stk-separator__top">';
				echo '<div class="stk-separator__wrapper">';
				echo $this->blockRenderer->getSeparator('top');
				echo "</div>";
				echo "</div>";
			}

			echo '<div class="stk-block-carousel__content-wrapper">';


			$autoPlaySpeed = false;
			if( $this->attributes['autoplay'] ) {
				$autoPlaySpeed = $this->attributes['autoplaySpeed'];
			}

			echo "<div class='{$this->output['classes']['element']}'>"; // Slider Wrapper Started

			echo "<div class='stk-block-carousel__slider' role='list' data-autoplay='$autoPlaySpeed' data-label-slide-of='{$this->attributes['ariaLabelSlideOf']}'>";
			echo $this->content; // Inner Blocks Content Here
			echo "</div>";

			$this->renderArrows();

			echo "</div>"; // Slider Wrapper Ended

			$this->renderDots();

			echo '</div>';

			/**
			 * BOTTOM SEPARATOR
			 */
			if(!empty($this->attributes['bottomSeparatorShow'])) {
				echo '<div class="stk-separator stk-separator__bottom">';
				echo '<div class="stk-separator__wrapper">';
				echo $this->blockRenderer->getSeparator('bottom');
				echo "</div>";
				echo "</div>";
			}

			echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
		}

		private function renderArrows(): void {
			if( $this->attributes['showArrows'] ) {
				$prevLabel = $this->attributes['ariaLabelPrev'] ?? 'Previous slide';
				$nextLabel = $this->attributes['ariaLabelNext'] ?? 'Next slide';

				$buttonClasses = $this->blockRenderer->getGeneratedClasses( 'arrows' );

				echo "<div class='stk-block-carousel__buttons'>";
					echo "<button class='stk-block-carousel__button stk-block-carousel__button__prev $buttonClasses' aria-label='$prevLabel'>";
					$this->blockRenderer->getFontAwesomeHtml( $this->attributes['arrowIconPrev'] );
					echo "</button>";
					echo "<button class='stk-block-carousel__button stk-block-carousel__button__next $buttonClasses' aria-label='$nextLabel'>";
					$this->blockRenderer->getFontAwesomeHtml( $this->attributes['arrowIconNext'] );
					echo "</button>";
				echo "</div>";
			}
		}

		private function renderDots(): void {
			if( $this->attributes['showDots'] ) {
				$buttonClasses = $this->blockRenderer->getGeneratedClasses( 'dots' );
				$label = $this->attributes['ariaLabelSlide'] ?? 'Slide %%d';
				echo "<div class='stk-block-carousel__dots $buttonClasses' role='list' data-label='$label'></div>";
			}
		}
	}
}

/**
 * @var array $attributes
 * @var string $content
 * @var WP_Block $block
 */
new Carousel( $attributes, $content, $block );

