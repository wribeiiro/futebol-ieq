import React, { useEffect, useState } from "react";
import "./App.css";

const App = () => {
	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [selectedMonth, setSelectedMonth] = useState(`NOVEMBRO/2023`);
	const [totalPaid, setTotalPaid] = useState(0);

	const currentYear = new Date().getFullYear();
	const gameCost = 450.00;
	const costPerPlayer = 40.00;
	const apiUrl = process.env.REACT_APP_ENV === "development"
		? "http://localhost:8000"
		: "https://www.wribeiiro.com/sheets-api/back/index.php";

	const formatNumber = (value) => {
		return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
	};

	const getSheetData = async (month) => {
		try {
			setLoading(true);

			const res = await fetch(`${apiUrl}?month=${month ?? selectedMonth}`);
			const resData = await res.json();

			if (resData.status === 200) {
				setData(resData.data);

				let paid = 0;

				resData.data.forEach(element => {
					if (element.status === 'PAGO') paid = paid + Number(element.amount);
				});

				setTotalPaid(paid);

			} else {
				setData([]);
			}

			setLoading(false);
		} catch (err) {
			alert(err);
			setLoading(false);
		}
	}

	useEffect(() => {
		getSheetData();
	}, []);

	const renderTableHeader = () => {
		return (
			<tr>
				<th style={{width: "5%"}}></th>
				<th>NOME</th>
				<th>SITUAÇÃO</th>
				<th>VALOR</th>
			</tr>
		);
	}

	const renderTableData = () => {
		if (loading) {
			return (
				<tr>
					<td></td>
					<td>Carregando dados...</td>
					<td></td>
					<td></td>
				</tr>
			);
		}

		if (data.length <= 0 && !loading) {
			return (
				<tr>
					<td></td>
					<td>Nenhum registro encontrado para esse período...</td>
					<td></td>
					<td></td>
				</tr>
			);
		}

		return data.map((element, key) => {
			const {name, status, image, amount} = element;

			return (
				<tr
					key={key}
				>
					<td>
						<img
							src={image}
							alt={name}
							width="75"
						/>
					</td>
					<td><b>{name}</b></td>
					<td className={status === 'PAGO' ? 'text-success' : 'text-danger'}>
						<b>{status}</b>
					</td>
					<td><b>{formatNumber(amount)}</b></td>
				</tr>
			);
		});
	}

	const renderFilters = () => {
		const months = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];

		return (
			<select
				name="month"
				id="month"
				onChange={(e) => onChangeFilter(e)}
				value={selectedMonth}
			>
				{months.map((month) => {
					return <option value={month + "/" + currentYear}>{month}/{currentYear}</option>
				})}
			</select>
		);
	}

	const onChangeFilter = (event) => {
		setSelectedMonth(event.target.value);
		getSheetData(event.target.value);
	}

	return (
		<div>
			<div>
				<h1 id='title'>FUTEBOL IEQ ⚽✝️</h1>
				<table id='players'>
					<tbody>
						<tr>
							<td style={{ background: '#886CE4' }}><b>POR PESSOA: {formatNumber(costPerPlayer)}</b></td>
							<td style={{ background: '#C9DAF8', color: '#303030' }}><b>HORÁRIO: {formatNumber(gameCost)}</b></td>
							<td style={{ background: '#B6D7A8', color: '#303030' }}><b>TOTAL PAGO: {formatNumber(totalPaid)}</b></td>
							<td style={{ background: '#EA9999', color: '#303030' }}><b>TOTAL FALTA PAGAR: {formatNumber(gameCost - totalPaid)}</b></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div className="filters" style={{ padding: '15px' }}>
				<label htmlFor="month"><b>SELECIONE MÊS/ANO: </b></label>
				{renderFilters()}
				<br/>
			</div>

			<div className="content">
				<table id='players'>
					<thead>
						{renderTableHeader()}
					</thead>
					<tbody>
						{renderTableData()}
					</tbody>
				</table>
			</div>
		</div>
	);
}

export default App;
