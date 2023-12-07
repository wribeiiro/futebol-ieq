import React, { useEffect, useState, useCallback } from "react";
import "./style.css";

const padIndex = (str) => {
	str = str.toString();

	if (str.length === 2)
		return str;

	return str.padStart(2, '0');
}

const currentYear = new Date().getFullYear();
const currentMonth = padIndex(new Date().getMonth());
const gameCost = 450.00;
const apiUrl = process.env.REACT_APP_ENV === "development"
	? `${process.env.REACT_APP_ENDPOINT_API}/payment`
	: "https://www.wribeiiro.com/sheets-api/back/index.php";

const PaymentTable = () => {

	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [selectedMonth, setSelectedMonth] = useState(`${currentMonth}/${currentYear}`);
	const [totalPaid, setTotalPaid] = useState(0);

	const formatNumber = (value) => {
		return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
	};

	const getPaymentData = useCallback(async (month) => {
		try {
			setLoading(true);

			const res = await fetch(`${apiUrl}?month=${month ?? selectedMonth}`);
			const resData = await res.json();

			setData([]);

			if (resData) {
				setData(resData);

				let paid = 0;

				resData.forEach(element => {
					if (element.status === 'PAGO') paid = paid + Number(element.value);
				});

				setTotalPaid(paid);
			}

			setLoading(false);
		} catch (err) {
			alert(err);
			setLoading(false);
		}
	}, [selectedMonth]);

	useEffect(() => {
		getPaymentData();
	}, [getPaymentData]);

	const renderTableHeader = () => {
		return (
			<tr>
				<th style={{ width: "5%" }}></th>
				<th style={{ width: "40%" }}>NOME</th>
				<th style={{ width: "20%", textAlign: 'center'}}>VALOR</th>
				<th style={{ width: "25%" }}>SITUAÇÃO</th>
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
			const {player: { id, name, path_image }, status, value} = element;

			return (
				<tr
					key={key}
					className={status === "PAGO" ? "table-success" : "table-warning"}
				>
					<td className="align-middle">
						<img
							src={path_image}
							alt={name}
							width="60"
							height="60"
						/>
					</td>
					<td className="align-middle"><b>{name}</b></td>
					<td className="align-middle">
						<input style={{ textAlign: 'center'}} className="form-control" type="number" value={value} id={'input-' + id}/>
					</td>
					<td className="align-middle">
						<select
							className="form-control"
							onChange={(e) => onChangeStatus(e)}
							data-player-id={id}
							data-player-name={name}
						>
							<option value={"PAGO"} selected={status === "PAGO"}>PAGO</option>
							<option value={"NÃO PAGO"} selected={status === "NÃO PAGO"}>NÃO PAGO</option>
						</select>
					</td>
				</tr>
			);
		});
	}

	const renderFilters = () => {
		const months = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];

		return (
			<>
				<label className="form-label" htmlFor="month"><b>SELECIONE MÊS/ANO: </b></label>
				<select
					className="form-control"
					name="month"
					id="month"
					onChange={(e) => onChangeFilter(e)}
					value={selectedMonth}
				>
					{months.map((month, index) => {
						return <option value={padIndex(index + 1) + "/" + currentYear}>{month}/{currentYear}</option>
					})}
				</select>
			</>
		);
	}

	const onChangeFilter = (event) => {
		setSelectedMonth(event.target.value);
		getPaymentData(event.target.value);
	}

	const onChangeStatus = (event) => {
		alert('Atualizar status do: ' + event.target.getAttribute('data-player-id') + ' - ' + event.target.getAttribute('data-player-name'));
	}

	return (
		<>
			<div>
				<table className="table">
					<tbody>
						<tr>
							<td className="table-info text-center"><b>HORÁRIO: {formatNumber(gameCost)}</b></td>
							<td className="table-success text-center"><b>PAGO: {formatNumber(totalPaid)}</b></td>
							<td className="table-warning text-center"><b>FALTA PAGAR: {formatNumber(gameCost - totalPaid)}</b></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div className="filters">
				{renderFilters()}
			</div>

			<div className="content mt-3">
				<table className="table-sm table table-striped table-hover" id="players">
					<thead>
						{renderTableHeader()}
					</thead>
					<tbody>
						{renderTableData()}
					</tbody>
				</table>
			</div>
		</>
	);
}

export default PaymentTable;
