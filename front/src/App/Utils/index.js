const Utils = {
	generateHash: () => {
		return Math.floor(Math.random() * (999999 - 1 + 1)) + 1;
	}
};

export default Utils;