import React from "react";
import LogoImg from "./../../assets/images/logo512x512.png";
import { NavLink } from "react-router-dom";
import { useTranslation } from 'react-i18next';

const Menu = () => {
	const { t } = useTranslation();

	return (
		<nav className="navbar navbar-expand-lg navbar-dark bg-primary">
			<div className="container-fluid">
				<NavLink className="navbar-brand" to="/">
					<img src={LogoImg} alt="Logo" width="30" height="30" className="d-inline-block align-text-top" />
					{t(1)}
				</NavLink>
				<button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
					<span className="navbar-toggler-icon"></span>
				</button>
				<div className="collapse navbar-collapse" id="navbarText">
					<ul className="navbar-nav me-auto mb-2 mb-lg-0">
						<li className="nav-item">
							<NavLink className="nav-link" activeclassname="active" to="/payment">{t(2)}</NavLink>
						</li>

						<li className="nav-item">
							<NavLink className="nav-link" to="/squad-builder">{t(6)}</NavLink>
						</li>

						<li className="nav-item">
							<NavLink className="nav-link" to="/matches">{t(7)}</NavLink>
						</li>
					</ul>
					<span className="navbar-text">
						<NavLink className="nav-link" to="/profile"><i className="fas fa-user"></i> {t(8)}</NavLink>
					</span>
				</div>
			</div>
		</nav>
	);
};

export default Menu;
