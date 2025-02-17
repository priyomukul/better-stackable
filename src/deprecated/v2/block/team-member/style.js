/**
 * External dependencies
 */
import {
	appendImportantAll,
	createTypographyStyles,
	createImageStyleSet,
	marginLeftAlign,
	marginRightAlign,
	createImageMask,
	createResponsiveStyles,
	createSocialButtonStyleSet,
	whiteIfDarkBlackIfLight,
	appendImportant,
	createImageBackgroundStyleSet,
	createBorderStyleSet,
	__getValue,
} from '~stackable/util'
import {
	createBackgroundStyleSet,
} from '../../util'
import { range } from 'lodash'

/**
 * Internal dependencies
 */
import { showOptions } from './util'
import deepmerge from 'deepmerge'

/**
 * WordPress dependencies
 */
import { applyFilters } from '@wordpress/hooks'

export const createStyles = props => {
	const getValue = __getValue( props.attributes )

	const show = showOptions( props )

	const {
		columns = 3,
		columnBackgroundColor = '',
		showImage = true,
		contentAlign = '',
	} = props.attributes

	const styles = []

	if ( show.borderRadius ) {
		styles.push( {
			'.ugb-team-member__item': {
				borderRadius: getValue( 'borderRadius', '%spx !important' ),
			},
		} )
	}

	if ( show.border ) {
		styles.push( {
			...createBorderStyleSet( 'column%s', '.ugb-team-member__item', props.attributes ),
		} )
	}

	// Column Background.
	const columnBackgroundSelector = applyFilters( 'stackable.team-member.styles.column-background', 'ugb-team-member__item', props.attributes )
	styles.push( {
		...( show.columnBackground ? createBackgroundStyleSet( 'column%s', columnBackgroundSelector, props.attributes, {
			importantBackgroundColor: true,
		} ) : {} ),
	} )

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
				'> .ugb-inner-block > .ugb-block-content > .ugb-team-member__item': appendImportantAll( {
					paddingTop: getValue( 'columnPaddingTop', `%s${ columnPaddingUnit }` ),
					paddingBottom: getValue( 'columnPaddingBottom', `%s${ columnPaddingUnit }` ),
					paddingRight: getValue( 'columnPaddingRight', `%s${ columnPaddingUnit }` ),
					paddingLeft: getValue( 'columnPaddingLeft', `%s${ columnPaddingUnit }` ),
				} ),
			},
			tabletOnly: {
				'> .ugb-inner-block > .ugb-block-content > .ugb-team-member__item': appendImportantAll( {
					paddingTop: getValue( 'tabletColumnPaddingTop', `%s${ tabletColumnPaddingUnit }` ),
					paddingRight: getValue( 'tabletColumnPaddingRight', `%s${ tabletColumnPaddingUnit }` ),
					paddingBottom: getValue( 'tabletColumnPaddingBottom', `%s${ tabletColumnPaddingUnit }` ),
					paddingLeft: getValue( 'tabletColumnPaddingLeft', `%s${ tabletColumnPaddingUnit }` ),
				} ),
			},
			mobile: {
				'> .ugb-inner-block > .ugb-block-content > .ugb-team-member__item': appendImportantAll( {
					paddingTop: getValue( 'mobileColumnPaddingTop', `%s${ mobileColumnPaddingUnit }` ),
					paddingRight: getValue( 'mobileColumnPaddingRight', `%s${ mobileColumnPaddingUnit }` ),
					paddingBottom: getValue( 'mobileColumnPaddingBottom', `%s${ mobileColumnPaddingUnit }` ),
					paddingLeft: getValue( 'mobileColumnPaddingLeft', `%s${ mobileColumnPaddingUnit }` ),
				} ),
			},
		},
	} )

	// Image.
	const {
		imageAlign = '',
		imageTabletAlign = '',
		tabletContentAlign = '',
		imageMobileAlign = '',
		mobileContentAlign = '',
	} = props.attributes
	if ( ! show.imageAsBackground && showImage ) {
		styles.push( {
			...createImageStyleSet( 'image%s', 'ugb-img', props.attributes, { inherit: false } ),
		} )

		styles.push( ...createResponsiveStyles( '.ugb-team-member__image', 'image%sWidth', 'width', '%spx', props.attributes, { important: true, inherit: false } ) )

		styles.push( {
			'.ugb-img, .ugb-team-member__image': {
				marginLeft: imageAlign !== '' || contentAlign !== '' ? marginLeftAlign( imageAlign || contentAlign ) + ' !important' : undefined,
				marginRight: imageAlign !== '' || contentAlign !== '' ? marginRightAlign( imageAlign || contentAlign ) + ' !important' : undefined,
			},
			tablet: {
				'.ugb-img, .ugb-team-member__image': {
					marginLeft: imageTabletAlign !== '' || tabletContentAlign !== '' ? marginLeftAlign( imageTabletAlign || tabletContentAlign ) + ' !important' : undefined,
					marginRight: imageTabletAlign !== '' || tabletContentAlign !== '' ? marginRightAlign( imageTabletAlign || tabletContentAlign ) + ' !important' : undefined,
				},
			},
			mobile: {
				'.ugb-img, .ugb-team-member__image': {
					marginLeft: imageMobileAlign !== '' || mobileContentAlign !== '' ? marginLeftAlign( imageMobileAlign || mobileContentAlign ) + ' !important' : undefined,
					marginRight: imageMobileAlign !== '' || mobileContentAlign !== '' ? marginRightAlign( imageMobileAlign || mobileContentAlign ) + ' !important' : undefined,
				},
			},
		} )
	} else if ( showImage ) {
		styles.push( {
			...createImageBackgroundStyleSet( 'image%s', 'ugb-team-member__image', props.attributes ),
		} )

		range( 1, columns + 1 ).forEach( i => {
			styles.push( {
				[ `.ugb-team-member__item.ugb-team-member__item${ i } .ugb-team-member__image` ]: {
					backgroundImage: getValue( `image${ i }Url`, 'url(%s)' ),
				},
			} )
		} )
	}

	// Title.
	const {
		nameColor = '',
		showName = true,
	} = props.attributes
	if ( showName ) {
		styles.push( {
			'.ugb-team-member__name': {
				color: appendImportant( whiteIfDarkBlackIfLight( nameColor, show.columnBackground && columnBackgroundColor ) ),
			},
		} )

		styles.push( {
			'.ugb-team-member__name': {
				...createTypographyStyles( 'name%s', 'desktop', props.attributes ),
				textAlign: appendImportant( getValue( 'nameAlign' ) || getValue( 'contentAlign' ) ),
			},
			tablet: {
				'.ugb-team-member__name': {
					...createTypographyStyles( 'name%s', 'tablet', props.attributes ),
					textAlign: appendImportant( getValue( 'nameTabletAlign' ) || getValue( 'tabletContentAlign' ) ),
				},
			},
			mobile: {
				'.ugb-team-member__name': {
					...createTypographyStyles( 'name%s', 'mobile', props.attributes ),
					textAlign: appendImportant( getValue( 'nameMobileAlign' ) || getValue( 'mobileContentAlign' ) ),
				},
			},
		} )
	}

	// Position.
	const {
		positionColor = '',
		showPosition = true,
	} = props.attributes
	if ( showPosition ) {
		styles.push( {
			'.ugb-team-member__position': {
				color: appendImportant( whiteIfDarkBlackIfLight( positionColor, show.columnBackground && columnBackgroundColor ) ),
			},
		} )

		styles.push( {
			'.ugb-team-member__position': {
				...createTypographyStyles( 'position%s', 'desktop', props.attributes ),
				textAlign: appendImportant( getValue( 'positionAlign' ) || getValue( 'contentAlign' ) ),
			},
			tablet: {
				'.ugb-team-member__position': {
					...createTypographyStyles( 'position%s', 'tablet', props.attributes ),
					textAlign: appendImportant( getValue( 'positionTabletAlign' ) || getValue( 'tabletContentAlign' ) ),
				},
			},
			mobile: {
				'.ugb-team-member__position': {
					...createTypographyStyles( 'position%s', 'mobile', props.attributes ),
					textAlign: appendImportant( getValue( 'positionMobileAlign' ) || getValue( 'mobileContentAlign' ) ),
				},
			},
		} )
	}

	// Description.
	const {
		descriptionColor = '',
		showDescription = true,
	} = props.attributes
	if ( showDescription ) {
		styles.push( {
			'.ugb-team-member__description': {
				color: whiteIfDarkBlackIfLight( descriptionColor, show.columnBackground && columnBackgroundColor ),
			},
		} )

		styles.push( {
			'.ugb-team-member__description': {
				...createTypographyStyles( 'description%s', 'desktop', props.attributes ),
				textAlign: appendImportant( getValue( 'descriptionAlign' ) || getValue( 'contentAlign' ) ),
			},
			tablet: {
				'.ugb-team-member__description': {
					...createTypographyStyles( 'description%s', 'tablet', props.attributes ),
					textAlign: appendImportant( getValue( 'descriptionTabletAlign' ) || getValue( 'tabletContentAlign' ) ),
				},
			},
			mobile: {
				'.ugb-team-member__description': {
					...createTypographyStyles( 'description%s', 'mobile', props.attributes ),
					textAlign: appendImportant( getValue( 'descriptionMobileAlign' ) || getValue( 'mobileContentAlign' ) ),
				},
			},
		} )
	}

	// Button.
	const {
		showSocial = true,
		socialDesign = '',
	} = props.attributes
	if ( showSocial ) {
		styles.push( {
			...createSocialButtonStyleSet( `social%s`, `ugb-button`, {
				...props.attributes,
				buttonDesign: socialDesign,
			} ),
		} )
		styles.push( {
			'.ugb-team-member__buttons': {
				textAlign: appendImportant( getValue( 'socialAlign' ) || getValue( 'contentAlign' ) ),
			},
			tablet: {
				'.ugb-team-member__buttons': {
					textAlign: appendImportant( getValue( 'socialTabletAlign' ) || getValue( 'tabletContentAlign' ) ),
				},
			},
			mobile: {
				'.ugb-team-member__buttons': {
					textAlign: appendImportant( getValue( 'socialMobileAlign' ) || getValue( 'mobileContentAlign' ) ),
				},
			},
		} )
	}

	// Spacing.
	if ( show.imageSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-team-member__image', 'image%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.nameSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-team-member__name', 'name%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.positionSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-team-member__position', 'position%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.descriptionSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-team-member__description', 'description%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
	}
	if ( show.socialSpacing ) {
		styles.push( ...createResponsiveStyles( '.ugb-button-container', 'social%sBottomMargin', 'marginBottom', '%spx', props.attributes, { important: true } ) )
		styles.push( ...createResponsiveStyles( '.ugb-button', 'social%sGap', 'marginLeft', '%spx', props.attributes, { important: true } ) )
		styles.push( ...createResponsiveStyles( '.ugb-button', 'social%sGap', 'marginRight', '%spx', props.attributes, { important: true } ) )
	}

	// Advanced image.
	if ( showImage ) {
		range( 1, columns + 1 ).forEach( i => {
			if ( props.attributes[ `image${ i }Shape` ] ) {
				styles.push( {
					[ `.ugb-team-member__item${ i } .ugb-img` ]: createImageMask( `image${ i }%s`, props.attributes ),
				} )
			}
		} )
	}

	return deepmerge.all( styles )
}

export default createStyles
