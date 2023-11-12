import axios from "axios";

const instance = axios.create({
	baseURL: 'http://127.0.0.1:8000/api/',
});

const Utils = {
	axios: instance,
	generateHash: () => {
		return Math.floor(Math.random() * (999999 - 1 + 1)) + 1;
	},

};

export default Utils;


