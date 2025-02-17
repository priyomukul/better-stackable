/**
 * External dependencies
 */
import {
	appendImportantAll,
	createResponsiveStyles,
	createTypographyStyles,
	appendImportant,
	createBorderStyleSet,
	clampInheritedStyle,
	__getValue,
} from '~stackable/util'
import {
	createBackgroundStyles,
	createBackgroundOverlayStyles,
} from '../../util'
import deepmerge from 'deepmerge'

/**
 * Internal dependencies
 */
import { showOptions } from './util'

export const createStyles = props => {
	const getValue = __getValue( props.attributes )

	const show = showOptions( props )

	const styles = []

	if ( show.borderRadius ) {
		styles.push( {
			'.ugb-image-box__box': {
				borderRadius: appendImportant( getValue( 'borderRadius', '%spx !important' ) ),
			},
		} )
	}

	if ( show.border ) {
		styles.push( {
			...createBorderStyleSet( 'column%s', '.ugb-image-box__item', props.attributes ),
		} )
	}

	const clampedImageHeight = clampInheritedStyle( getValue( 'columnHeight' ), { max: 300 } )

	// Container
	const {
		columnPaddingUnit = 'px',
		tabletColumnPaddingUnit = 'px',
		mobileColumnPaddingUnit = 'px',
	} = props.attributes
	styles.push( {
		saveOnly: {
			desktopTablet: {
				'> .ugb-inner-block > .ugb-block-content > *': appendImportantAll( {
					paddingTop: getValue( 'columnPaddingTop', `%s${ columnPaddingUnit }` ),
					paddingBottom: getValue( 'columnPaddingBottom', `%s${ columnPaddingUnit }` ),
					paddingRight: getValue( 'columnPaddingRight', `%s${ columnPaddingUnit }` ),
					paddingLeft: getValue( 'columnPaddingLeft', `%s${ columnPaddingUnit }` ),
				} ),
			},
			tabletOnly: {
				'> .ugb-inner-block > .ugb-block-content > *': appendImportantAll( {
					paddingTop: getValue( 'tabletColumnPaddingTop', `%s${ tabletColumnPaddingUnit }` ),
					paddingRight: getValue( 'tabletColumnPaddingRight', `%s${ tabletColumnPaddingUnit }` ),
					paddingBottom: getValue( 'tabletColumnPaddingBottom', `%s${ tabletColumnPaddingUnit }` ),
					paddingLeft: getValue( 'tabletColumnPaddingLeft', `%s${ tabletColumnPaddingUnit }` ),
				} ),
			},
			mobile: {
				'> .ugb-inner-block > .ugb-block-content > *': appendImportantAll( {
					paddingTop: getValue( 'mobileColumnPaddingTop', `%s${ mobileColumnPaddingUnit }` ),
					paddingRight: getValue( 'mobileColumnPaddingRight', `%s${ mobileColumnPaddingUnit }` ),
					paddingBottom: getValue( 'mobileColumnPaddingBottom', `%s${ mobileColumnPaddingUnit }` ),
					paddingLeft: getValue( 'mobileColumnPaddingLeft', `%s${ mobileColumnPaddingUnit }` ),
				} ),
			},
		},
		editor: {
			desktopTablet: {
				'> .ugb-inner-block > .ugb-block-content > .ugb-image-box__item': appendImportantAll( {
					paddingTop: getValue( 'columnPaddingTop', `%s${ columnPaddingUnit }` ),
					paddingBottom: getValue( 'columnPaddingBottom', `%s${ columnPaddingUnit }` ),
					paddingRight: getValue( 'columnPaddingRight', `%s${ columnPaddingUnit }` ),
					paddingLeft: getValue( 'columnPaddingLeft', `%s${ columnPaddingUnit }` ),
				} ),
			},
			tabletOnly: {
				'> .ugb-inner-block > .ugb-block-content > .ugb-image-box__item': appendImportantAll( {
					paddingTop: getValue( 'tabletColumnPaddingTop', `%s${ tabletColumnPaddingUnit }` ),
					paddingRight: getValue( 'tabletColumnPaddingRight', `%s${ tabletColumnPaddingUnit }` ),
					paddingBottom: getValue( 'tabletColumnPaddingBottom', `%s${ tabletColumnPaddingUnit }` ),
					paddingLeft: getValue( 'tabletColumnPaddingLeft', `%s${ tabletColumnPaddingUnit }` ),
				} ),
			},
			mobile: {
				'> .ugb-inner-block > .ugb-block-content > .ugb-image-box__item': appendImportantAll( {
					paddingTop: getValue( 'mobileColumnPaddingTop', `%s${ mobileColumnPaddingUnit }` ),
					paddingRight: getValue( 'mobileColumnPaddingRight', `%s${ mobileColumnPaddingUnit }` ),
					paddingBottom: getValue( 'mobileColumnPaddingBottom', `%s${ mobileColumnPaddingUnit }` ),
					paddingLeft: getValue( 'mobileColumnPaddingLeft', `%s${ mobileColumnPaddingUnit }` ),
				} ),
			},
		},
	} )

	// Height.
	styles.push( {
		'.ugb-image-box__item': {
			height: appendImportant( getValue( 'columnHeight', '%spx' ) ),
		},
		tabletOnly: {
			'.ugb-image-box__item': {
				height: appendImportant( getValue( 'tabletColumnHeight', '%spx' ) || ( clampedImageHeight && `${ clampedImageHeight }px` ) ),
			},
		},
		mobile: {
			'.ugb-image-box__item': {
				height: appendImportant( getValue( 'mobileColumnHeight', '%spx' ) || ( clampedImageHeight && `${ clampedImageHeight }px` ) ),
			},
		},
	} )

	// Vertical align.
	styles.push( {
		'.ugb-image-box__item': {
			justifyContent: appendImportant( getValue( 'columnContentVerticalAlign' ) ),
		},
		tablet: {
			'.ugb-image-box__item': {
				justifyContent: appendImportant( getValue( 'columnContentTabletVerticalAlign' ) ),
			},
		},
		mobile: {
			'.ugb-image-box__item': {
				justifyContent: appendImportant( getValue( 'columnContentMobileVerticalAlign' ) ),
			},
		},
	} )

	// Image.
	styles.push( {
		'.ugb-image-box__item1 .ugb-image-box__image': {
			backgroundImage: getValue( 'image1Url', `url(%s)` ),
		},
		'.ugb-image-box__item2 .ugb-image-box__image': {
			backgroundImage: getValue( 'image2Url', `url(%s)` ),
		},
		'.ugb-image-box__item3 .ugb-image-box__image': {
			backgroundImage: getValue( 'image3Url', `url(%s)` ),
		},
		'.ugb-image-box__item4 .ugb-image-box__image': {
			backgroundImage: getValue( 'image4Url', `url(%s)` ),
		},
		'.ugb-image-box__image': {
			backgroundPosition: appendImportant( getValue( 'imageBackgroundPosition' ) ),
			backgroundRepeat: appendImportant( getValue( 'imageBackgroundRepeat' ) ),
			backgroundSize: appendImportant( getValue( 'imageBackgroundSize' ) === 'custom'
				? getValue( 'imageBackgroundCustomSize', `%s${ getValue( 'imageBackgroundCustomSizeUnit' ) || 'px' }` )
				: getValue( 'imageBackgroundSize' ) ),
		},
	} )

	// Overlay.
	const {
		showOverlay = false,
	} = props.attributes
	if ( showOverlay ) {
		styles.push( {
			'.ugb-image-box__overlay': {
				...createBackgroundStyles( 'overlay%s', 'desktop', props.attributes, { importantBackgroundColor: true } ),
				...createBackgroundOverlayStyles( 'overlay%s', 'desktop', props.attributes, { importantBackgroundColor: true } ),
			},
			'.ugb-image-box__item:not(:hover) .ugb-image-box__overlay': {
				opacity: appendImportant( getValue( 'overlayOpacity' ) ),
			},
		} )
	}

	// Overlay Hover.
	const {
		showOverlayHover = false,
	} = props.attributes
	if ( showOverlayHover ) {
		styles.push( {
			'.ugb-image-box__overlay-hover': {
				...createBackgroundStyles( 'overlayHover%s', 'desktop', props.attributes, { importantBackgroundColor: true } ),
				...createBackgroundOverlayStyles( 'overlayHover%s', 'desktop', props.attributes, { importantBackgroundColor: true } ),
			},
			'.ugb-image-box__item:hover .ugb-image-box__overlay-hover': {
				opacity: appendImportant( getValue( 'overlayHoverOpacity' ) ),
			},
		} )
	}

	// Subtitle.
	const {
		showSubtitle = true,
	} = props.attributes
	if ( showSubtitle ) {
		styles.push( {
			'.ugb-image-box__subtitle': {
				...createTypographyStyles( 'subtitle%s', 'desktop', props.attributes, { importantSize: true } ),
				color: appendImportant( getValue( 'subtitleColor' ) ),
				textAlign: getValue( 'subtitleAlign', '%s !important' ),
			},
			tablet: {
				'.ugb-image-box__subtitle': {
					...createTypographyStyles( 'subtitle%s', 'tablet', props.attributes, { importantSize: true } ),
					textAlign: getValue( 'subtitleTabletAlign', '%s !important' ),
				},
			},
			mobile: {
				'.ugb-image-box__subtitle': {
					...createTypographyStyles( 'subtitle%s', 'mobile', props.attributes, { importantSize: true } ),
					textAlign: getValue( 'subtitleMobileAlign', '%s !important' ),
				},
			},
		} )
	}

	// Title.
	const {
		showTitle = true,
	} = props.attributes
	if ( showTitle ) {
		styles.push( {
			'.ugb-image-box__title': {
				...createTypographyStyles( 'title%s', 'desktop', props.attributes, { importantSize: true } ),
				color: appendImportant( getValue( 'titleColor' ) ),
				textAlign: getValue( 'titleAlign', '%s !important' ),
			},
			tablet: {
				'.ugb-image-box__title': {
					...createTypographyStyles( 'title%s', 'tablet', props.attributes, { importantSize: true } ),
					textAlign: getValue( 'titleTabletAlign', '%s !important' ),
				},
			},
			mobile: {
				'.ugb-image-box__title': {
					...createTypographyStyles( 'title%s', 'mobile', props.attributes, { importantSize: true } ),
					textAlign: getValue( 'titleMobileAlign', '%s !important' ),
				},
			},
		} )
	}

	// Description.
	const {
		showDescription = true,
	} = props.attributes
	if ( showDescription ) {
		styles.push( {
			'.ugb-image-box__description': {
				...createTypographyStyles( 'description%s', 'desktop', props.attributes, { importantSize: true } ),
				color: appendImportant( getValue( 'descriptionColor' ) ),
				textAlign: getValue( 'descriptionAlign', '%s !important' ),
			},
			tablet: {
				'.ugb-image-box__description': {
					...createTypographyStyles( 'description%s', 'tablet', props.attributes, { importantSize: true } ),
					textAlign: getValue( 'descriptionTabletAlign', '%s !important' ),
				},
			},
			mobile: {
				'.ugb-image-box__description': {
					...createTypographyStyles( 'description%s', 'mobile', props.attributes, { importantSize: true } ),
					textAlign: getValue( 'descriptionMobileAlign', '%s !important' ),
				},
			},
		} )
	}

	// Arrow.
	const {
		showArrow = false,
	} = props.attributes
	if ( showArrow ) {
		styles.push( {
			'.ugb-image-box__arrow svg': {
				fill: appendImportant( getValue( 'arrowColor' ) ),
			},
		} )
		styles.push( ...createResponsiveStyles( '.ugb-image-box__arrow svg', 'arrow%sSize', 'width', '%spx', props.attributes, { important: true, inherit: false } ) )
		styles.push( ...createResponsiveStyles( '.ugb-image-box__arrow', 'arrow%sAlign', 'textAlign', '%s', props.attributes, { important: true } ) )
	}

	// Spacing.
	if ( show.subtitleSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-image-box__subtitle', 'subtitle%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.titleSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-image-box__title', 'title%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.descriptionSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-image-box__description', 'description%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.arrowSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-image-box__arrow', 'arrow%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}

	return deepmerge.all( styles )
}

export default createStyles
