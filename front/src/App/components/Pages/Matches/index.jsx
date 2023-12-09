import React from 'react';
import Container from '../../Atomic/Container';
import Breadcrumb, { Item } from '../../Atomic/Breadcrumb';
import { Token } from  "../../../Utils/TokenManager";
import Utils from "../../../Utils";
import LogoImg from "../../../assets/images/logo512x512.png";

const Matches = () => {
	return (
		<Container>
			<Breadcrumb
				items={[
					<Item to={"/"} title={Token(3)} key={Utils.generateHash()} />,
					<Item to={"/matches"} title={Token(7)} active key={Utils.generateHash()} />
				]}
			/>
			<div className="d-grid gap-2">
				<button
					type="button"
					className={"btn btn-primary mt-2 mb-2"}
					onClick={() => alert('Será criado uma partida!')}
				>
					Criar partida
				</button>

				<table className='table table-hover table-striped table-bordered table-sm'>
					<thead>
						<th>Jogo</th>
						<th>Data</th>
						<th style={{textAlign: 'right'}}>Mandante</th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'center'}}></th>
						<th style={{textAlign: 'left'}}>Visitante</th>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>00/00/0000</td>
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
							<td style={{textAlign: 'center'}}>3</td>
							<td style={{textAlign: 'center'}}>9</td>
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
						<tr>
							<td>2</td>
							<td>00/00/0000</td>
							<td style={{textAlign: 'right'}}>
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
							<td style={{textAlign: 'center'}}>5</td>
							<td style={{textAlign: 'center'}}>5</td>
							<td>
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
						</tr>
						<tr>
							<td>3</td>
							<td>00/00/0000</td>
							<td style={{textAlign: 'right'}}>
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
							<td style={{textAlign: 'center'}}>3</td>
							<td style={{textAlign: 'center'}}>3</td>
							<td>
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
						</tr>
						<tr>
							<td>4</td>
							<td>00/00/0000</td>
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
							<td style={{textAlign: 'center'}}>7</td>
							<td style={{textAlign: 'center'}}>7</td>
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
					</tbody>
				</table>
			</div>
		</Container>

	);
}

export default Matches;
