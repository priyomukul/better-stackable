<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;
use WP_Block;

if(!class_exists('StellarBlocks\Blocks\Notification')){
	class Notification extends BaseBlockRenderer
	{
		protected array $uniqueWrapperClasses = ['stk-block-notification'];

		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'text' => '',
			'isDismissible' => true,
			'dismissibleSize' => 16,
			'notificationType' => 'success',
			'hasContainer' => true
		];

		public function __construct( array $attributes, string $content, WP_Block $block ) {
			$this->attributes = wp_parse_args($attributes, $this->defaultAttributes);
			$this->uniqueWrapperClasses = $this->getWrapperClasses();
			parent::__construct( $attributes, $content, $block );
		}

		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  . $this->output['wrapper']; ?>>
				<div class="<?php echo $this->output['classes']['element']; ?>">
					<div class="<?php echo $this->output['classes']['innerBlocksWrapper']?>">
						<?php echo $this->content; ?>
					</div>
					<?php echo $this->componentRenderer->render( 'blockLink' );  ?>
					<?php if($this->attributes['isDismissible']): ?>
						<button class="stk-block-notification__close-button">
							<svg viewBox="0 0 28.3 28.3" width="<?php echo $this->attributes['dismissibleSize']; ?>" height="<?php echo $this->attributes['dismissibleSize']; ?>">
								<path d="M52.4-166.2c3.2,0,3.2-5,0-5C49.2-171.2,49.2-166.2,52.4-166.2L52.4-166.2z" />
								<path d="M16.8,13.9L26.9,3.8c0.6-0.6,0.6-1.5,0-2.1s-1.5-0.6-2.1,0L14.7,11.8L4.6,1.7C4,1.1,3.1,1.1,2.5,1.7s-0.6,1.5,0,2.1l10.1,10.1L2.5,24c-0.6,0.6-0.6,1.5,0,2.1c0.3,0.3,0.7,0.4,1.1,0.4s0.8-0.1,1.1-0.4L14.7,16l10.1,10.1c0.3,0.3,0.7,0.4,1.1,0.4s0.8-0.1,1.1-0.4c0.6-0.6,0.6-1.5,0-2.1L16.8,13.9z" />
							</svg>
						</button>
					<?php endif; ?>
				</div>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		protected function getElementClasses( ): array
		{
			return [
				"stk-block-notification__content",
				$this->blockRenderer->getClasses(['container', 'content/alignment']),
				$this->blockRenderer->getGeneratedClasses('container')
			];
		}

		protected function getWrapperClasses(  ) :array
		{
			$classes = [
				'stk-block-notification',
				'stk--is-' . $this->attributes['notificationType']
			];
			if($this->attributes['isDismissible']){
				$classes[] = 'stk--is-dismissible';
			}

			return $classes;
		}

		protected function getInnerBlocksWrapperClasses(  ) {
			return [
				$this->blockRenderer->getClasses(['innerBlocks', 'text/alignment'])
			];
		}
	}
}

new Notification($attributes, $content, $block);

?>
