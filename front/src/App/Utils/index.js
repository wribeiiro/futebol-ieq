const Utils = {
	generateHash: () => {
		return Math.floor(Math.random() * (999999 - 1 + 1)) + 1;
	},
	baseUrl: () => {
		const apiUrl = process.env.REACT_APP_ENV === "development"
			? `${process.env.REACT_APP_ENDPOINT_API_LOCAL}`
			: `${process.env.REACT_APP_ENDPOINT_API}`;

		return apiUrl;
	},
	formatDate: date => {
		const [year, month, day] = date.split('-');
		return `${day}/${month}/${year}`;
	}
};

export default Utils;