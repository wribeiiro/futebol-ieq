import React, { useCallback, useEffect, useState } from 'react';

const DatePicker = ({value, onChange}) => {
	const [selectedDate, setSelectedDate] = useState('');
	const handleDateChange = useCallback((event) => {
		setSelectedDate(event.target.value);
		onChange(event.target.value);
	}, [onChange]);

	useEffect(() => {
		setSelectedDate(value);
	}, [value]);

	return (
		<div>
			<input
				type="date"
				value={selectedDate}
				onChange={handleDateChange}
			/>
		</div>
	);
};

export default DatePicker;
