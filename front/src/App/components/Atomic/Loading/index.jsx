import React from "react";

const style = {width: '3rem', height: '3rem'};

const Loading = () => {
	return (
		<div className="d-flex justify-content-center">
			<div className="spinner-border" style={style} role="status">
				<span className="visually-hidden"></span>
			</div>
		</div>
	);
};

export default Loading;