import React from "react";
import LogoImg from "./../../assets/images/logo512x512.png";
import { NavLink } from "react-router-dom";
import { Token } from "./../../Utils/TokenManager";

const Menu = () => {
	return (
		<nav className="navbar navbar-expand-lg navbar-dark bg-primary">
			<div className="container-fluid">
				<NavLink className="navbar-brand" to="/">
					<img src={LogoImg} alt="Logo" width="30" height="30" className="d-inline-block align-text-top" />
					{Token(1)}
				</NavLink>
				<button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span className="navbar-toggler-icon"></span>
				</button>
				<div className="collapse navbar-collapse" id="navbarText">
					<ul className="navbar-nav me-auto mb-2 mb-lg-0">
						<li className="nav-item">
							<NavLink className="nav-link" activeclassname="active" to="/payment">{Token(2)}</NavLink>
						</li>

						<li className="nav-item">
							<NavLink className="nav-link" to="/squad-builder">{Token(6)}</NavLink>
						</li>

						<li className="nav-item">
							<NavLink className="nav-link" to="/matches">{Token(7)}</NavLink>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	);
};

export default Menu;
