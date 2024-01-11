<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;


if ( is_admin() ) {
	return;
}
if ( ! class_exists( 'StellarBlocks\Blocks\TableOfContents' ) ) {
	class TableOfContents extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-table-of-contents'];

		protected array $defaultAttributes = [
			'htmlTag' => 'nav',
			'textTag' => 'p',
			'titleText' => 'Table of Contents',
			'titleShow' => true,
			'listType' => '',

			'includeH1' => false,
			'includeH2' => true,
			'includeH3' => true,
			'includeH4' => true,
			'includeH5' => true,
			'includeH6' => true,
		];

		protected array $wrapperStrategies = ['unique', 'blockWidth', 'text/alignment', 'background', 'responsive','separator'];

		protected function prepareOutput(): void
		{
			parent::prepareOutput();

			/**
			 * Prepare classes for the list.
			 */

			$this->output['classes']['list'] = implode( " ", [
				'stk-table-of-contents__table',
				$this->blockRenderer->getGeneratedClasses('list'),
				$this->blockRenderer->getClasses([ 'typography' ])
			] );

			/**
			 * Prepare classes for the title
			 */
			$this->output['classes']['title'] = implode( " ", [
				'stk-table-of-contents__title',
				$this->blockRenderer->getGeneratedClasses('title'),
				$this->blockRenderer->getClasses([ 'typography:title%s' ])
			] );
		}

		/**
		 * Returning empty as I needed to implement it. but no element is needed here.
		 *
		 * @return array
		 */
		protected function getElementClasses(): array
		{
			return [];
		}

		protected function render(): string
		{
			$filteredHeadingList = [];
			if( ! empty( $this->attributes['headings'] ) ) {
				$filteredHeadingList = array_filter( $this->attributes['headings'], function( $heading ){
					return (bool) $this->attributes[ 'includeH' . $heading['tag'] ] && ! $heading['isExcluded'];
				});
			}

			$tagName = 'ol';
			if( empty( $this->attributes['listType'] ) || $this->attributes['listType'] === 'unordered' || $this->attributes['listType'] === 'none') {
				$tagName = 'ul';
			}

			ob_start();

			echo "<{$this->attributes['htmlTag']} {$this->output['classes']['wrapper']}>";

			// Title
			if( $this->attributes['titleShow'] ) {
				echo "<{$this->attributes['textTag']} class='{$this->output['classes']['title']}}'>";
				echo $this->attributes['titleText'];
				echo "</{$this->attributes['textTag']}>";
			}

			// List
			if( ! empty( $filteredHeadingList ) ) {
				echo "<{$tagName} class='{$this->output['classes']['list']}'>";
				$this->liGenerator( $this->getHeadingsTree( $filteredHeadingList ), $tagName );
				echo "</{$tagName}>";
			}

			echo "</{$this->attributes['htmlTag']}>";

			return ob_get_clean();
		}

		private function getHeadingsTree( $filterHeadings, $depth = 0 ): array
		{
			$headings = [];

			while( count( $filterHeadings ) ) {
				$heading = array_shift( $filterHeadings );
				$children = [];

				while( count( $filterHeadings ) ) {
					if ( $filterHeadings[ 0 ]['level'] <= $heading['level'] ) {
						break;
					}

					$children[] = [...array_shift( $filterHeadings )];
				}

				$headings[] = [
					'heading' => $heading,
					"index" => $depth++,
					"children" => $this->getHeadingsTree( $children, $depth ),
				];
			}

			return $headings;
		}

		private function liGenerator( $lists, $tag = 'ul' ): void
		{
			if( ! empty( $lists ) ) {
				foreach( $lists as $content ) {
					$list = $content['heading'];

					echo "<li>";
					// Anchor
					echo "<a href='#{$list['anchor']}'>";
					echo ! empty( $list['customContent'] ) ? $list['customContent'] : $list['content'];
					echo "</a>";

					// Children's
					if( ! empty( $content['children'] ) && is_array( $content['children'] ) ) {
						echo "<$tag>";
						$this->liGenerator( $content['children'], $tag );
						echo "</$tag>";
					}
					echo "</li>";
				}
			}
		}
	}
}


/**
 * @var array $attributes
 * @var string $content
 * @var WP_Block $block
 */
new TableOfContents( $attributes, $content, $block );
