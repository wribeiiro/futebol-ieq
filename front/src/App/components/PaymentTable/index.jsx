import React, { useEffect, useState, useCallback } from "react";
import "./style.css";
import PlayerImageModal from "../PlayerImageModal";
import BalanceCard from "../BalanceCard";
import Utils from "../../Utils";

const padIndex = (str) => {
	str = str.toString();

	if (str.length === 2)
		return str;

	return str.padStart(2, '0');
}

const currentYear = new Date().getFullYear();
const currentMonth = padIndex(new Date().getMonth() + 1);

const apiUrl = process.env.REACT_APP_ENV === "development"
	? `${process.env.REACT_APP_ENDPOINT_API_LOCAL}`
	: `${process.env.REACT_APP_ENDPOINT_API}`;

const PaymentTable = () => {

	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [selectedMonth, setSelectedMonth] = useState(`${currentMonth}/${currentYear}`);
	const [inputValues, setInputValues] = useState({});

	const handleInputChange = (e) => {
		const { name, value } = e.target;

		setInputValues({
			...inputValues,
			[name]: value,
		});
	};

	const getPaymentData = useCallback(async (month) => {
		try {
			setLoading(true);

			const res = await fetch(`${apiUrl}/payment?month=${month ?? selectedMonth}`);
			const resData = await res.json();

			setData([]);

			if (resData) {
				setData(resData);

				let initialInputValues = {};

				resData.forEach(element => {
					initialInputValues['value-' + element.id] = element.value;
				});

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
				<th className="bg-success" style={{ width: "27.5%", textAlign: 'center' }}>VALOR</th>
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
			const { player: { name, path_image, active } } = element;
			const { id, status } = element;

			if (active !== 'Y') {
				return null;
			}

			return (
				<tr
					key={Utils.generateHash()}
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
							style={{ textAlign: 'center' }}
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
			);
		});
	}

	const renderFilters = () => {
		const months = ['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'];
		let monthYear = [];

		for (let year = currentYear; year >= 2023; year--) {
			months.forEach((month, index) => monthYear.push({'value': index, 'month': month, 'year': year}));
		}

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
					{
						monthYear.map((month) => {
							return <option value={padIndex(month.value + 1) + "/" + month.year}>{month.month + "/" + month.year}</option>
						})
					}
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

	return (
		<>
			<BalanceCard
				month={selectedMonth}
			/>

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
