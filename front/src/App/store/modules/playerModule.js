import Utils from "../../Utils";

const axios = Utils.axios;

const PlayerModule = {
	actions: {
		async fetchPlayers() {
			return axios.get(`/players`)
		}
	}
}
export default PlayerModule;