<?php

namespace StellarBlocks\Renderer\Components;

use StellarBlocks\Renderer\ComponentRenderer;
use StellarBlocks\Renderer\Helper;

abstract class BaseComponent {
	protected array  $attributes;
	protected array  $props;
	protected string $attrTemplate     = '%s';
	protected string $attrTemplateName = ':%s';
	protected string $tagName          = '';

	public function __construct( protected ComponentRenderer $componentRenderer, array $props = [], string $attrTemplate = '' ) {
		$this->attributes       = $componentRenderer->getAttributes();
		$this->props            = $props;

		if( ! empty( $attrTemplate ) ) {
			$this->attrTemplate     = $attrTemplate;
			$this->attrTemplateName = ":$attrTemplate";
		}

		$this->props = wp_parse_args( $this->props, $this->defaultProps() );

		$this->prepare();
	}

	public function defaultProps() : array {
		return [];
	}

	public function prepare() : void {

	}

	public static function make( ComponentRenderer $componentRenderer, array $props, string $attrTemplate = '' ): static {
		return new static( $componentRenderer, $props, $attrTemplate );
	}

	/**
	 * This method is overridable.
	 * Please make sure to implement it if needed in any case.
	 *
	 * @param callable|null $children
	 *
	 * @return string
	 */
	public function render( callable $children = null ): string {
		return is_callable( $children ) ? $children() : '';
	}

	/**
	 * This method decides whether we should display the HTML or only children should be displayed if any.
	 * @return bool
	 */
	abstract public function shouldRender(): bool;

	final public function renderAsHtml( callable $children = null ): string {
		if ( ! $this->shouldRender() ) {
			return is_callable( $children ) ? $children() : '';
		}

		$this->openTag();

		echo $this->render( $children );

		return $this->closeTag();
	}

	protected function omit( $omitThis ): array {
		return array_diff_key( $this->props, array_flip( $omitThis ) );
	}

	/**
	 * This method decides which HTML attributes will be rendered.
	 * Please override this if needed.
	 * @return array
	 */
	public function eligibleAttributes(): array {
		return $this->props;
	}

	private function htmlAttributes(): string {
		return Helper::getNormalizeAttributes( array_filter( $this->eligibleAttributes(), fn( $p ) => ! is_null( $p ) ) );
	}

	protected function openTag(): void {
		ob_start();
		echo "<{$this->tagName} {$this->htmlAttributes()}>";
	}

	protected function closeTag(): string {
		echo "</$this->tagName>";

		return ob_get_clean();
	}

	protected function getAttrName( $param1 = '', $param2 = '' ): string {
		return Helper::getAttributeName( $this->attrTemplate, $param1, $param2 );
	}
}
