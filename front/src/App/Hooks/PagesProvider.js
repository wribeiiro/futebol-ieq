import React, { useContext, useState } from "react";

const PagesContext = React.createContext(false);

export const PagesContextProvider = ({ children }) => {
	const [loading, setLoading] = useState(false);

	const props = {
		loading,
		setLoading
	}

	return (
		<PagesContext.Provider value={props}>
			{children}
		</PagesContext.Provider>
	);
};

export default function usePagesContext() {
	return useContext(PagesContext);
};