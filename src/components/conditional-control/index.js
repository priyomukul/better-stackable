import { useEffect, useRef, useState } from "@wordpress/element";
import { Button, ButtonGroup, SelectControl } from "@wordpress/components";
import AdvancedControl from '../base-control2'
import { useAttributeEditHandlers, useDeviceType } from "~stackable/hooks";

const ConditionalControl = ({
	type,
	options,
	label,
	saveAttr,
	saveAttrName,
	attributeName,
	hasResponsive = "all",
	isEnabled,
	...props
}) => {
	const deviceType = useDeviceType();
	const [currentValue, setCurrentValue] = useState('');
	const [currentOptions, setCurrentOptions] = useState([]);
	const prevValue = useRef('');
	const prevGeneratedValue = useRef(null);
	const {
		updateAttribute,
		updateAttributes,
		getAttrName,
		getAttribute
	} = useAttributeEditHandlers();

	useEffect(() => {
		if (isEnabled) {
			setCurrentOptions([...options, { label: 'Custom', value: 'custom' }]);
			if (deviceType) {
				saveAttr && saveAttr[attributeName] && saveAttr[attributeName][deviceTypeName()] && setCurrentValue(saveAttr[attributeName][deviceTypeName()].value);
			}
		}
	}, []);

	useEffect(() => {
		if (isEnabled) {
			saveAttr && saveAttr[attributeName] && saveAttr[attributeName][deviceTypeName()] && setCurrentValue(saveAttr[attributeName][deviceTypeName()]?.value)
		}
	}, [deviceType]);

	const onChangeValue = (selected) => {
		let selectedClass = '';
		if (selected.value !== 'custom') {
			selectedClass = selected.class[deviceTypeName()]
			prevGeneratedValue.current = selected;
		} else {
			prevValue.current = saveAttr[attributeName] && saveAttr[attributeName][deviceTypeName()] ? saveAttr[attributeName][deviceTypeName()] : { value: '' };
		}
		updateAttributes({
			[getAttrName(attributeName, deviceType)]: '',
			[saveAttrName]: {
				...saveAttr, [attributeName]: {
					...saveAttr[attributeName], [deviceTypeName()]: {
						value: selected.value, class: selectedClass
					}
				}
			}
		});
		setCurrentValue(selected.value);
	}
	const revertBack = () => {
		const name = getAttrName(attributeName, deviceType);
		const value = getAttribute(name, deviceType);
		let newValue;
		switch (typeof value) {
			case "object":
				newValue = { top: 0, right: 0, bottom: 0, left: 0 };
				break;
			case "number":
				newValue = 0;
				break;
			default:
				newValue = '';
		}

		updateAttribute(name, newValue);
		updateAttribute(saveAttrName, {...saveAttr, [attributeName]: { ...saveAttr[attributeName], [deviceTypeName()]: prevValue.current } });
		setCurrentValue(prevValue.current.value);

		/**
		 * Revert to selected predefined size if have
		 */
		if (prevGeneratedValue.current !== null) {
			let selected = prevGeneratedValue.current;
			let selectedClass = selected.class[deviceTypeName()]

			updateAttributes({
				[getAttrName(attributeName, deviceType)]: '',
				[saveAttrName]: {
					...saveAttr, [attributeName]: {
						...saveAttr[attributeName], [deviceTypeName()]: {
							value: selected.value, class: selectedClass
						}
					}
				}
			});

			setCurrentValue(prevGeneratedValue.current.value);
		}
	}



	const resetOptions = () => {
		updateAttribute(saveAttrName, { ...saveAttr, [attributeName]: { ...saveAttr[attributeName], [deviceTypeName()]: '' } });
		setCurrentValue('');
	}

	const deviceTypeName = () => hasResponsive === false ? 'desktop' : deviceType.toLowerCase();

	return !isEnabled ? props.children : (
		<div className="stl-conditional-control" style={{ marginBottom: 10 }}>
			{currentValue === 'custom' ? (
				<div className="wrapper">
					{props.children}
					<Button onClick={revertBack} size="small" variant="primary">Use options</Button>
				</div>
			) : type === 'select' ? (
				<AdvancedControl responsive={hasResponsive} label={label}>
					<SelectControl
						options={currentOptions}
						onChange={onChangeValue}
						value={currentValue}
					/>
					{
						currentValue?.length && (
							<button className="stl-reset-options" onClick={resetOptions}><i className="dashicons dashicons-undo"></i></button>
						) || ''
					}
				</AdvancedControl>
			) : (
				<AdvancedControl responsive={hasResponsive} label={label}>
					<ButtonGroup className={"stl-flex"}>
						{currentOptions.map((option, index) => (
							<Button
								label={option.label}
								key={index}
								onClick={e => onChangeValue(option)}
								variant={currentValue === option.value ? 'primary' : 'secondary'}
							>
								{option.value === 'custom' ? (
									<i className="dashicons dashicons-edit"></i>
								) : option.label}
							</Button>
						))}
					</ButtonGroup>
					{
						currentValue && currentValue.length && (
							<button className="stl-reset-options" onClick={resetOptions}><i className="dashicons dashicons-undo"></i></button>
						) || ''
					}

				</AdvancedControl>
			)}
		</div>
	);
}

export default ConditionalControl;
