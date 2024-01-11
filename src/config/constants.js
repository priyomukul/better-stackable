import { __ } from '@wordpress/i18n'
import { i18n } from 'stackable'

export const GROUP_SIZES = [
	{
		value: 'sm',
		label: __('S', i18n),
		class: {
			desktop: 'stl-text-sm',
			tablet: 'md:stl-text-sm',
			mobile: 'sm:stl-text-sm',
		}
	},
	{
		value: 'md',
		label: __('N', i18n),
		class: {
			desktop: 'stl-text-base',
			tablet: 'md:stl-text-base',
			mobile: 'sm:stl-text-base',
		}
	},
	{
		value: 'lg',
		label: __('L', i18n),
		class: {
			desktop: 'stl-text-lg',
			tablet: 'md:stl-text-lg',
			mobile: 'sm:stl-text-lg',
		},
	},
	{
		value: 'xl',
		label: __('XL', i18n),
		class: {
			desktop: 'stl-text-xl',
			tablet: 'md:stl-text-xl',
			mobile: 'sm:stl-text-xl'
		}
	},
	{
		value: '2xl',
		label: __('2XL', i18n),
		class: {
			desktop: 'stl-text-2xl',
			tablet: 'md:stl-text-2xl',
			mobile: 'sm:stl-text-2xl',
		}
	},
]
export const BORDER_RADIUS = [
	{
		value: 'md',
		label: __('N', i18n),
		class: {
			desktop: 'stl-rounded',
			tablet: 'md:stl-rounded',
			mobile: 'sm:stl-rounded',
		}
	},
	{
		value: 'lg',
		label: __('L', i18n),
		class: {
			desktop: 'stl-rounded-lg',
			tablet: 'md:stl-rounded-lg',
			mobile: 'sm:stl-rounded-lg',
		},
	},
	{
		value: 'xl',
		label: __('XL', i18n),
		class: {
			desktop: 'stl-rounded-xl',
			tablet: 'md:stl-rounded-xl',
			mobile: 'sm:stl-rounded-xl',
		}
	},
	{
		value: '2xl',
		label: __('2XL', i18n),
		class: {
			desktop: 'stl-rounded-2xl',
			tablet: 'md:stl-rounded-2xl',
			mobile: 'sm:stl-rounded-2xl',
		}
	},
	{
		value: 'full',
		label: __('Full', i18n),
		class: {
			desktop: 'stl-rounded-full',
			tablet: 'md:stl-rounded-full',
			mobile: 'sm:stl-rounded-full',
		}
	},
]

export const PADDINGS = [
	{
		value: 'sm',
		label: __('S', i18n),
		class: {
			desktop: 'stl-p-1',
			tablet: 'md:stl-p-1',
			mobile: 'sm:stl-p-1',
		}
	},
	{
		value: 'md',
		label: __('N', i18n),
		class: {
			desktop: 'stl-p-2.5',
			tablet: 'md:stl-p-2.5',
			mobile: 'sm:stl-p-2.5',
		}
	},
	{
		value: 'lg',
		label: __('L', i18n),
		class: {
			desktop: 'stl-p-4',
			tablet: 'md:stl-p-4',
			mobile: 'sm:stl-p-4',
		},
	},
	{
		value: 'xl',
		label: __('XL', i18n),
		class: {
			desktop: 'stl-p-6',
			tablet: 'md:stl-p-6',
			mobile: 'sm:stl-p-6',
		}
	},
	{
		value: '2xl',
		label: __('2XL', i18n),
		class: {
			desktop: 'stl-p-10',
			tablet: 'md:stl-p-10',
			mobile: 'sm:stl-p-10',
		}
	},
]

export const MARGINS = [
	{
		value: 'sm',
		label: __('S', i18n),
		class: {
			desktop: 'stl-m-1',
			tablet: 'md:stl-my-1',
			mobile: 'sm:stl-my-1',
		}
	},
	{
		value: 'md',
		label: __('N', i18n),
		class: {
			desktop: 'stl-my-2.5',
			tablet: 'md:stl-my-2.5',
			mobile: 'sm:stl-my-2.5',
		}
	},
	{
		value: 'lg',
		label: __('L', i18n),
		class: {
			desktop: 'stl-my-4',
			tablet: 'md:stl-my-4',
			mobile: 'sm:stl-my-4',
		},
	},
	{
		value: 'xl',
		label: __('XL', i18n),
		class: {
			desktop: 'stl-my-6',
			tablet: 'md:stl-my-6',
			mobile: 'sm:stl-my-6',
		}
	},
	{
		value: '2xl',
		label: __('2XL', i18n),
		class: {
			desktop: 'stl-my-10',
			tablet: 'md:stl-my-10',
			mobile: 'sm:stl-my-10',
		}
	},
]

export const DEFAULT_COLORS = [
	{
		name: 'Primary',
		slug: 'primary',
		color: '#c15454',
		rgb: '193, 84, 84'
	},
	{
		name: 'Secondary',
		slug: 'secondary',
		color: '#2091e1',
		rgb: '32, 145, 225'
	}
];

export const SPACINGS = [
	{
		value: 'sm',
		label: __('S', i18n),
		class: {
			desktop: 'stl-mb-3',
			tablet: 'md:stl-mb-3',
			mobile: 'sm:stl-mb-3',
		}
	},
	{
		value: 'md',
		label: __('N', i18n),
		class: {
			desktop: 'stl-mb-4',
			tablet: 'md:stl-mb-4',
			mobile: 'sm:stl-mb-4',
		}
	},
	{
		value: 'lg',
		label: __('L', i18n),
		class: {
			desktop: 'stl-mb-6',
			tablet: 'md:stl-mb-6',
			mobile: 'sm:stl-mb-6',
		},
	},
	{
		value: 'xl',
		label: __('XL', i18n),
		class: {
			desktop: 'stl-mb-8',
			tablet: 'md:stl-mb-8',
			mobile: 'sm:stl-mb-8',
		}
	},
	{
		value: '2xl',
		label: __('2XL', i18n),
		class: {
			desktop: 'stl-mb-10',
			tablet: 'md:stl-mb-10',
			mobile: 'sm:stl-mb-10',
		}
	},
]

