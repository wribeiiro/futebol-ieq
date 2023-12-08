import React from 'react';
import { NavLink } from "react-router-dom";

export const Item = ({ to, title, active }) => {
	let classActive = "";

	if (active) {
		classActive = "active";
	}

	return (
		<li className="breadcrumb-item">
			<NavLink
				activeclassname={classActive}
				className="breadcrumb-item"
				to={to}
			>
				{title}
			</NavLink>
		</li>
	);
}

const Breadcrumb = ({ items }) => {
	return (
		<nav className="mt-3" aria-label="breadcrumb">
			<ol className="breadcrumb">
				{items.map(item => item)}
			</ol>
		</nav>
	);
};

export default Breadcrumb;
