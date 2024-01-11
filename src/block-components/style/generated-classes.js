export const getGeneratedClasses = (attributes, type, combineWith = '') => {
	let classes = '';
	if (combineWith.length) {
		classes += combineWith;
	}
	const deviceTypeClass = (property, deviceName) => {
		return attributes.generatedClasses[property][deviceName] && attributes.generatedClasses[property][deviceName].class ? attributes.generatedClasses[property][deviceName].class : ''
	}

	attributes.generatedClasses && Object.keys(attributes.generatedClasses).forEach(function (key) {
		if (attributes.generatedClasses[key].type === type) {
			const all = ` ${deviceTypeClass(key, 'desktop')} ${deviceTypeClass(key, 'tablet')} ${deviceTypeClass(key, 'mobile')}`.trim();
			if(all.length){
				classes += ` ${all}`;
			}
		}
	});
	return classes.trim();
}

