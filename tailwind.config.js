module.exports = {
	mode: 'jit',
	important: true,
  content: ["./src/**/*.{html,js}"],
	prefix: 'stl-',
  theme: {
		fontSize: {
			sm: 'var(--font-sm)',
			base: 'var(--font-base)',
			lg: 'var(--font-lg)',
			xl: 'var(--font-xl)',
			'2xl': 'var(--font-2xl)',
		},
    screens: {
			'md': {'max': '1023px'},
			'sm': {'max': '767px'},
		},
  },
  plugins: [],
}
