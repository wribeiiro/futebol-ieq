import React, { useEffect, useState, useCallback } from "react";
import "./style.css";
import PlayerImageModal from "../PlayerImageModal";

const padIndex = (str) => {
	str = str.toString();

	if (str.length === 2)
		return str;

	return str.padStart(2, '0');
}

const currentYear = new Date().getFullYear();
const currentMonth = padIndex(new Date().getMonth() + 1);
const gameCost = 450.00;

const apiUrl = process.env.REACT_APP_ENV === "development"
	? `${process.env.REACT_APP_ENDPOINT_API_LOCAL}`
	: `${process.env.REACT_APP_ENDPOINT_API}`;

const PaymentTable = () => {

	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [selectedMonth, setSelectedMonth] = useState(`${currentMonth}/${currentYear}`);
	const [totalPaid, setTotalPaid] = useState(0);
	const [inputValues, setInputValues] = useState({});

	const handleInputChange = (e) => {
		const { name, value } = e.target;

		setInputValues({
			...inputValues,
			[name]: value,
		});
	};

	const formatNumber = (value) => {
		return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
	};

	const getPaymentData = useCallback(async (month) => {
		try {
			setLoading(true);

			const res = await fetch(`${apiUrl}/payment?month=${month ?? selectedMonth}`);
			const resData = await res.json();

			setData([]);

			if (resData) {
				setData(resData);

				let paid = 0;
				let initialInputValues = {};

				resData.forEach(element => {
					if (element.status === 'PAGO') paid = paid + Number(element.value);

					initialInputValues['value-' + element.id] = element.value;
				});

				setTotalPaid(paid);
				setInputValues(initialInputValues)
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
				<th className="bg-success" style={{ width: "5%" }}></th>
				<th className="bg-success" style={{ width: "25%" }}>NOME</th>
				<th className="bg-success" style={{ width: "27.5%", textAlign: 'center'}}>VALOR</th>
				<th className="bg-success" style={{ width: "32.5%" }}>SITUAÇÃO</th>
			</tr>
		);
	}

	const renderTableData = () => {
		if (loading) {
			return (
				<tr>
					<td></td>
					<td>Carregando...</td>
					<td></td>
					<td></td>
				</tr>
			);
		}

		if (data.length <= 0 && !loading) {
			return (
				<tr>
					<td></td>
					<td>Nenhum registro encontrado.</td>
					<td></td>
					<td></td>
				</tr>
			);
		}

		return data.map((element, key) => {
			const { player: { name, path_image } } = element;
			const { id, status } = element;

			return (
				<>
					<tr
						key={key}
						className={status === "PAGO" ? "table-success" : ""}
					>
						<td className="align-middle">
							<PlayerImageModal
								pathImage={path_image}
								name={name}
								id={id}
							/>
						</td>
						<td className="align-middle font-uppercase"><b>{name}</b></td>
						<td className="align-middle">
							<input
								style={{ textAlign: 'center'}}
								className="form-control font-weight-bold"
								type="number"
								value={inputValues['value-' + id]}
								id={'value-' + id}
								name={'value-' + id}
								onChange={handleInputChange}
							/>
						</td>
						<td className="align-middle">
							<select
								className="form-control font-weight-bold"
								onChange={(e) => onChangeStatus(e)}
								data-payment-id={id}
							>
								<option value={"PAGO"} selected={status === "PAGO"}>PAGO</option>
								<option value={"NÃO PAGO"} selected={status === "NÃO PAGO"}>NÃO PAGO</option>
							</select>
						</td>
					</tr>
				</>
			);
		});
	}

	const renderFilters = () => {
		const months = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];

		return (
			<>
				<label className="form-label font-weight-bold" htmlFor="month">SELECIONE MÊS/ANO: </label>
				<select
					className="form-control font-weight-bold"
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

	const changeStatusApi = async ({ id, value, status }) => {
		const options = {
			method: 'PUT',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				value,
				status
			})
		};

		await fetch(apiUrl + '/payment/' + id, options)
			.then(response => response.json())
			.then(data => {
				console.log(data)
			})
			.catch(error => {
				console.error('Error updating data:', error);
			});
	}

	const onChangeStatus = async (event) => {
		const data = {
			id: event.target.getAttribute('data-payment-id'),
			value: document.getElementById('value-' + event.target.getAttribute('data-payment-id')).value,
			status: event.target.value
		}

		await changeStatusApi(data);
		await getPaymentData();
	}

	const toPay = gameCost - totalPaid;

	return (
		<>
			<div className="row row-cols-md-3 g-4">
				<div className="col">
					<div className="card text-white text-center bg-primary mb-3">
						<div className="card-body">
							<p className="card-text font-weight-bold">HORÁRIO <br></br> {formatNumber(gameCost)}</p>
						</div>
					</div>
				</div>

				<div className="col">
					<div className="card text-white text-center bg-success mb-3">
						<div className="card-body">
							<p className="card-text font-weight-bold">PAGO <br></br> {formatNumber(totalPaid)}</p>
						</div>
					</div>
				</div>
				<div className="col">
					<div className={"card text-white text-center mb-3 " + (toPay < 0 ? "bg-info" : "bg-warning")}>
						<div className="card-body">
							<p className="card-text font-weight-bold">
								{ toPay < 0 ? '+ SALDO' : 'A PAGAR'} <br></br>
								{formatNumber(toPay < 0 ? -toPay : toPay)}
							</p>
						</div>
					</div>
				</div>
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
