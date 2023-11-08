import React from 'react';

const Card = ({ children }) => {
	return (
		<div className="card" style={{ width: "18rem" }}>
			<div className="card-body">
				{children}
			</div>
		</div>
	);
};

export default Card;
