<?php

namespace StellarBlocks\Blocks;

use StellarBlocks\Renderer\BaseBlockRenderer;

if(!class_exists('StellarBlocks\Blocks\Post')){
	class Post extends BaseBlockRenderer
	{
		/**
		 * @var array
		 */
		protected array $uniqueWrapperClasses = ['stk-block-posts'];

		/**
		 * @var array
		 */
		protected array $defaultAttributes = [
			'htmlTag' => 'div',
			'generatedClasses' => [],
			'type' => 'post',
			'numberOfItems' => 6,
			'orderBy' => 'date',
			'order' => 'desc',
			'taxonomyType' => 'category',
			'taxonomy' => '',
			'taxonomyFilterType' => '__in',
			'postOffset' => 0,
			'postExclude' => '',
			'postInclude' => '',
			'imageSize' => 'full',
			'excerptLength' => 55,
			'readmoreText' => 'Continue Reading',
			'metaSeparator' => 'dot',
			'categoryHighlighted' => false,
			'excludeCurrentPost' => true,
			'titleTextTag' => 'h2',
			'imageHasLink' => true,
			'contentOrder' => [
				'title',
				'featured-image',
				'meta',
				'category',
				'excerpt',
				'readmore'
			]
		];

		private array $metaSeparators = [
			'dot' => '·',
			'space' => ' ',
			'comma' => ',',
			'dash' => '—',
			'pipe' => '|',
		];
		/**
		 * @return string
		 */
		protected function render(): string
		{
			ob_start();
			?>
			<<?php echo $this->attributes['htmlTag'] . ' '  .$this->output['classes']['wrapper']; ?>>
				<div class="stk-block-posts__items">
					<?php foreach ($this->getPosts() as $post):?>
						<div class="stk-block-posts__item">
							<div class="<?php echo $this->output['classes']['element']; ?>">
								<?php if($this->isListStyle()): ?>
								<?php echo $this->image($post); ?>
								<?php endif; ?>
								<article <?php echo $this->isListStyle() ? "class='stk-container-padding'" : ''; ?>>
									<?php echo $this->postMarkup($post); ?>
								</article>
							</div>
						</div>
					<?php endforeach;?>
				</div>
				<?php if(!empty($this->content)): ?>
				<div class="<?php echo $this->output['classes']['innerBlocksWrapper']?>">
					<?php echo $this->content; ?>
				</div>
				<?php endif; ?>
			</<?php echo $this->attributes['htmlTag']?>>
			<?php
			return ob_get_clean();
		}

		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function postMarkup( \WP_Post $post ) : string
		{
			$contents = [
				'title' => $this->title($post),
				'featured-image' => $this->image($post),
				'meta' => $this->meta($post),
				'category' => $this->category($post),
				'excerpt' => $this->excerpt($post),
				'readmore' => $this->readmore($post)
			];
			$markup = '';
			foreach ($this->attributes['contentOrder'] as $content){
				if(!empty($contents[$content])){
					$markup .= $contents[$content];
				}
			}
			return $markup;

		}
		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function title($post) : string
		{
			$classes = [
				'stk-block-posts__title',
				$this->blockRenderer->getClasses(['typography']),
				$this->blockRenderer->getGeneratedClasses('title')
			];
			ob_start();
			?>
			<<?php echo $this->attributes['titleTextTag']?> class='<?php echo $this->combineClasses($classes); ?>'>
				<a href="<?php echo get_permalink($post)?>"><?php echo $post->post_title; ?></a>
			</<?php echo $this->attributes['titleTextTag']?>>
			<?php
			return ob_get_clean();
		}

		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function image( $post ) : string
		{
			$classes = [
				'stk-img-wrapper stk-image--shape-stretch',
				$this->blockRenderer->getGeneratedClasses('image')
			];
			$thumbnail = get_the_post_thumbnail($post, $this->attributes['imageSize']);
			if(!$this->isListStyle()){
				if(!empty($this->attributes['imageHeight'])){
					$thumbnail = preg_replace('/height=\"[0-9]+\"/', 'height="'.$this->attributes['imageHeight'].'"', $thumbnail);
				}
				if(!empty($this->attributes['imageWidth'])){
					$thumbnail = preg_replace('/width=\"[0-9]+\"/', 'width="'.$this->attributes['imageWidth'].'"', $thumbnail);
				}
			}

			ob_start();
			?>
			<?php if($this->attributes['imageHasLink']): ?>
			<a href="<?php echo get_permalink($post)?>" class="stk-block-posts__image-link">
			<?php endif; ?>
			<figure class="<?php echo $this->combineClasses($classes);?>">
				<?php echo $thumbnail; ?>
			</figure>

			<?php
			if($this->attributes['imageHasLink']){
				echo "</a>";
			}
			return ob_get_clean();
		}

		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function excerpt( $post ) : string
		{
			$classes = $this->combineClasses([
				'stk-block-posts__excerpt',
				$this->blockRenderer->getGeneratedClasses('excerpt')
			]);
			ob_start();
			?>
			<div class="<?php echo $classes;?>">
				<p>
					<?php echo wp_trim_words(get_the_excerpt($post),$this->attributes['excerptLength'], '...'); ?>
				</p>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function readmore($post) : string
		{
			$classes = $this->combineClasses([
				'stk-block-posts__readmore',
				$this->blockRenderer->getGeneratedClasses('readmore')
			]);
			return "<a href='".get_the_permalink($post->ID)."' class='{$classes}'>". __($this->attributes['readmoreText'], 'stellar-blocks') ."</a>";
		}

		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function category( $post ) : string
		{
			$classes = $this->combineClasses([
				'stk-block-posts__category stk-subtitle',
				$this->blockRenderer->getClasses(['typography']),
				$this->blockRenderer->getGeneratedClasses(['category']),
			]);
			$categories = get_categories(['include' => $post->post_category]);
			$total = count($categories);
			ob_start();
			?>
				<div class="<?php echo $classes;?>">
					<?php foreach ($categories as $key => $category): ?>
					<a href="<?php echo get_term_link($category->term_id); ?>" <?php echo $this->attributes['categoryHighlighted'] ? 'class="stk-button"' : ''?>>
						<?php if($this->attributes['categoryHighlighted']): ?>
						<span class="stk-button__inner-text"><?php echo $category->name; ?></span>
						<?php else: ?>
						<?php echo $category->name; ?>
						<?php endif; ?>
					</a>
					<?php if($key < ($total - 1) && !$this->attributes['categoryHighlighted']){ echo ','; } ?>
					<?php endforeach; ?>
				</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @param \WP_Post $post
		 *
		 * @return string
		 */
		private function meta($post) : string
		{
			$commentsCount = get_comments_number($post);
			ob_start();
			?>
				<div class="stk-block-posts__meta stk-subtitle">
					<span><?php echo get_the_author_meta('display_name', $post->post_author); ?></span>
					<span class="stk-block-posts__meta-sep"><?php echo $this->metaSeparators[$this->attributes['metaSeparator']]; ?></span>
					<time datetime="<?php echo get_the_date('c',$post)?>"><?php echo get_the_date('', $post); ?></time>
					<span class="stk-block-posts__meta-sep"><?php echo $this->metaSeparators[$this->attributes['metaSeparator']]; ?></span>
					<span><?php echo $commentsCount;?> <?php echo __($commentsCount !== 1 ? 'Comments':'Comment', 'stellar-blocks');?></span>
				</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @return array
		 */
		protected function getInnerBlocksWrapperClasses() : array
		{
			return [
				$this->blockRenderer->getClasses(['innerBlocks'])
			];
		}

		/**
		 * @return array
		 */
		protected function getElementClasses( ) : array
		{
			return [
				$this->blockRenderer->getClasses(['container']),
				$this->blockRenderer->getGeneratedClasses('container')
			];
		}

		/**
		 * @param $queryString
		 *
		 * @return int[]|\WP_Post[]
		 */
		private function getPosts( $queryString = '' )
		{
			return get_posts($this->generateQuery($queryString));
		}

		/**
		 * @param $queryString
		 *
		 * @return array
		 */
		private function generateQuery( $queryString ) : array
		{
			$post_query = array(
				'post_type' => $this->attributes['type'],
				'post_status' => 'publish',
				'order' => $this->attributes['order'],
				'orderby' => $this->attributes['orderBy'],
				'numberposts' => $this->attributes['numberOfItems'],
				'post__not_in' => [get_the_ID()],
				'suppress_filters' => false
			);

			if ( ! empty( $this->attributes['taxonomy'] ) && ! empty( $this->attributes['taxonomyType'] ) ) {
				// Categories.
				if ( $this->attributes['taxonomyType'] === 'category' ) {
					$post_query[ 'category' . $this->attributes['taxonomyFilterType'] ] = explode( ',', $this->attributes['taxonomy'] );
					// Tags.
				} else if ( $this->attributes['taxonomyType'] === 'post_tag' ) { $post_query[ 'tag' . $this->attributes['taxonomyFilterType'] ] = explode( ',', $this->attributes['taxonomy'] );
					// Custom taxonomies.
				} else {
					$post_query['tax_query'] = array(
						array(
							'taxonomy' => $this->attributes['taxonomyType'],
							'field' => 'term_id',
							'terms' => explode( ',', $this->attributes['taxonomy'] ),
							'operator' => $this->attributes['taxonomyFilterType'] === '__in' ? 'IN' : 'NOT IN',
						),
					);
				}
			}

			return apply_filters( 'stackable/posts/post_query',
				$post_query,
				$this->attributes,
				$queryString
			);
		}

		/**
		 * @return bool
		 */
		private function isListStyle() : bool
		{
			return str_contains($this->attributes['className'], 'is-style-list');
		}

	}
}

new Post($attributes, $content, $block);

?>
