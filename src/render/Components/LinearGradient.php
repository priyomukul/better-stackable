<?php

namespace StellarBlocks\Renderer\Components;

class LinearGradient extends BaseComponent {

	/**
	 * @inheritDoc
	 */
	public function shouldRender(): bool {
		return $this->props['hasLinearGradient'] ?? false;
	}

	public function render( callable $children = null ): string {
		$id = $this->props['id'];

		return <<<SVG
<svg style="height: 0; width: 0">
	<defs>
		<linearGradient
			id="$id"
			x1="0"
			x2="100%"
			y1="0"
			y2="0"
		>
			<stop offset="0%" style="stop-opacity: 1; stop-color: var(--{$id}-color-1)"></stop>
			<stop offset="0%" style="stop-opacity: 1; stop-color: var(--{$id}-color-2)"></stop>
		</linearGradient>
	</defs>
</svg>
SVG;
	}
}
