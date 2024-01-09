import React, { useEffect, useState } from "react";
import "./style.css";
import LogoImg from "../../assets/images/logo512x512.png";
import moment from 'moment'

const apiUrl = process.env.REACT_APP_ENV === "development"
	? `${process.env.REACT_APP_ENDPOINT_API_LOCAL}`
	: `${process.env.REACT_APP_ENDPOINT_API}`;

const GameTable = () => {
	const [data, setData] = useState([]);

	const getGamesData = async () => {
		try {
			const res = await fetch(`${apiUrl}/game`);
			const resData = await res.json();

			setData([]);

			if (resData) {
				setData(resData);
			}
		} catch (err) {
			alert(err);
		}
	};

	useEffect(() => {
		getGamesData();
	}, []);

	return (
		<>
			<table className='table table-sm'>
				<thead>
					<tr>
						<th>Data</th>
						<th style={{textAlign: 'right'}}>Mandante</th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'left'}}>Visitante</th>
					</tr>
				</thead>
				<tbody>
					{data.map((element) => {
						return (
							<tr>
								<td>{moment(element.date_game).format('DD/MM/YYYY')}</td>
								<td style={{textAlign: 'right'}}>
									<div>
										<span style={{verticalAlign: 'middle'}}> Time A</span>
										<img
											src={LogoImg}
											alt="Logo"
											width="20"
											height="20"
										/>
									</div>
								</td>
								<td style={{textAlign: 'center', verticalAlign: 'middle'}}>{element.goals_team_a}</td>
								<td style={{textAlign: 'center', verticalAlign: 'middle'}}>x</td>
								<td style={{textAlign: 'center', verticalAlign: 'middle'}}>{element.goals_team_b}</td>
								<td>
									<div>
										<img
											src={LogoImg}
											alt="Logo"
											width="20"
											height="20"
										/>
										<span style={{verticalAlign: 'middle'}}> Time B</span>
									</div>
								</td>
							</tr>
						)
					})}
				</tbody>
			</table>
		</>
	);
}

export default GameTable;
