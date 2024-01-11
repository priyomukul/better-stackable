<?php
namespace StellarBlocks\Renderer;

use WP_Block;

/**
 * @property-read bool $applyCustomAttributes
 * @property-read bool $applyAdvancedAttributes
 * @property-read array $hasWrapperAttributes
 * @property-read array $attributes
 */
abstract class BaseBlockRenderer {
	/**
	 * Default block attributes and provided attributes by user
	 * @var array
	 */
    protected array $attributes;

	/**
	 * This indicates whether there are any needs to generate custom attributes for wrapper div.
	 *
	 * Default is true, as every wrapper div needs custom attributes except few blocks.
	 * @var bool
	 */
	protected bool $applyCustomAttributes = true;

	/**
	 * This indicates whether there are any needs to generate ID as attributes for wrapper div.
	 *
	 * Default is true, as every wrapper div needs ID as attributes except few blocks.
	 * @var bool
	 */
	protected bool $applyAdvancedAttributes = true;

	/**
	 * A list of default attributes with value in it.
	 * @var array|string[]
	 */
    protected array $defaultAttributes = [
        'htmlTag' => 'div'
    ];

	/**
	 * A list of unique wrapper classes a block must have.
	 * @var array|string[]
	 */
    protected array $uniqueWrapperClasses = [''];

	/**
	 * A list of HTML Attributes without 'data-' in it. And the name of key for value from the attributes.
	 * @ref VideoPopup
	 * @var array
	 */
    protected array $hasWrapperAttributes = [];

    protected array $output;

    protected BlockRendererInterface $blockRenderer;
    protected ComponentRenderer $componentRenderer;

    protected WP_Block $block;

    protected string $content;

	protected array $wrapperStrategies = ['unique', 'blockWidth', 'background', 'lightbox', 'margin', 'responsive','separator'];

    /**
     * Base block renderer construct
     * @param array $attributes
     * @param string $content
     * @param WP_Block $block
     */
    public function __construct( array $attributes, string $content, WP_Block $block ) {
        // Check for admin mode
        if ( is_admin() ) {
            return;
        }
        // merge with default attributes
        $this->attributes = wp_parse_args( $attributes, $this->defaultAttributes );

		/**
	     * Setting up the content and block into properties.
	     */
        $this->content = $content;
        $this->block   = $block;

        // initialize block renderer helper
        $this->blockRenderer = new BlockRenderer( $this );
        $this->componentRenderer = new ComponentRenderer( $this );

        // prepare output classes
        $this->prepareOutput();
        // render output
        echo $this->render();
    }

	public function __get( string $name ) : mixed {
		if( property_exists( $this, $name ) ) {
			return $this->$name;
		}

		return null;
	}

	public function __isset( string $name ): bool {
		return isset( $this->$name );
	}

    /**
     * Prepare out classes
     * @return void
     */
    protected function prepareOutput(): void {
	    /**
	     * Generate Wrapper Attributes
	     */
		$this->output['wrapper'] = $this->blockRenderer->getWrapperAttributes( $this->combineClasses( $this->uniqueWrapperClasses ), $this->wrapperStrategies );
        $this->output['classes']['element'] = $this->combineClasses( $this->getElementClasses() );

	    /**
	     * Fallback, as this is used in most block. Maybe we can remove this in the future.
	     */
        $this->output['classes']['wrapper'] = $this->output['wrapper'];

        // For inner block implement getInnerBlocksWrapperClasses in child
        if ( method_exists( $this, 'getInnerBlocksWrapperClasses' ) ) {
            $this->output['classes']['innerBlocksWrapper'] = $this->combineClasses( [ ...$this->getInnerBlocksWrapperClasses(),  $this->blockRenderer->getGeneratedClasses('innerBlocks')] );
        }
    }

    /**
     * Combine classes from array to string
     * @param array $classes
     *
     * @return string
     */
    public function combineClasses( array $classes ): string {
        return trim( implode( ' ', $classes ) );
    }

    /**
     * Get child element classes
     * Made this required for avoiding errors
     * @return array
     */
    abstract protected function getElementClasses(): array;

    /**
     * Render view
     * @return string
     */
    abstract protected function render(): string;
}
