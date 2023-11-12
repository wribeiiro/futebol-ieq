import React, { Fragment } from "react";
import Loading from "../Atomic/Loading";
import usePagesContext, { PagesContextProvider } from "../../Hooks/PagesProvider";

const style = {
	height: '90vh',
	display: 'flex',
	alignItems: 'center',
	justifyContent: 'center'
}

const Item = ({ children }) => {
	const { loading } = usePagesContext();

	if (loading) {
		return (
			<div style={style}>
				<Loading />
			</div>
		);
	}

	return <Fragment>
		{children}
	</Fragment>;
}

const Pages = ({ children }) => {


	return (
		<PagesContextProvider>
			<Item>
				{children}
			</Item>
		</PagesContextProvider>
	);
};

export default Pages;