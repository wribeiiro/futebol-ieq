import React from "react";
import "./style.css";
import LogoImg from "../../assets/images/logo512x512.png";

const GameTable = ({data}) => {
	return (
		<>
			<table className='table table-hover table-striped table-bordered table-sm'>
				<thead>
					<tr>
						<th>Data</th>
						<th style={{textAlign: 'right'}}>Mandante</th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'left'}}>Visitante</th>
					</tr>
				</thead>
				<tbody>
					{data.map((element) => {
						return (
							<tr key={element.date_game}>
								<td>{element.date_game}</td>
								<td style={{textAlign: 'right'}}>
									<div>
										<img
											src={LogoImg}
											alt="Logo"
											width="30"
											height="30"
										/>
										<span style={{verticalAlign: 'middle'}}> Time A</span>
									</div>
								</td>
								<td style={{textAlign: 'center', verticalAlign: 'middle'}}>{element.goals_team_a}</td>
								<td style={{textAlign: 'center', verticalAlign: 'middle'}}>{element.goals_team_b}</td>
								<td>
									<div>
										<img
											src={LogoImg}
											alt="Logo"
											width="30"
											height="30"
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
