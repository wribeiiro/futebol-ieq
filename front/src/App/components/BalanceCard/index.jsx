import React, { useEffect, useState, useCallback } from "react";
import "./style.css";

const apiUrl = process.env.REACT_APP_ENV === "development"
	? `${process.env.REACT_APP_ENDPOINT_API_LOCAL}`
	: `${process.env.REACT_APP_ENDPOINT_API}`;

const gameCost = 450.00;
const shouldRenderBalance = false;

const BalanceCard = ({ month }) => {
	const [balance, setBalance] = useState(0);
	const [totalPaid, setTotalPaid] = useState({total: 0, thisMonth: 0});

	const formatNumber = (value) => {
		return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
	};

	const getBalanceData = useCallback(async () => {
		try {
			setBalance(0);

			setTotalPaid({
				total: 0,
				thisMonth: 0
			});

			const res = await fetch(`${apiUrl}/balance?month=${month}`);
			const resData = await res.json();

			if (resData) {
				setBalance(resData.balance);
				setTotalPaid({
					total: resData.total_paid,
					thisMonth: resData.total_this_month
				});
			}

		} catch (err) {
			alert(err);
		}
	}, [month]);

	const renderTotalBalance = () => {
		return (
			<div className="row row-cols-md-2 g-4">
				<div className="col">
					<div className="card text-white text-center bg-success mb-3">
						<div className="card-body">
							<p className="card-text font-weight-bold">TOTAL PAGO <br></br> {formatNumber(totalPaid.total)}</p>
						</div>
					</div>
				</div>

				<div className="col">
					<div className={"card text-white text-center mb-3 " + (balance > 0 ? "bg-info" : "bg-warning")}>
						<div className="card-body">
							<p className="card-text font-weight-bold">
								{ balance > 0 ? '+ SALDO' : 'A PAGAR'} <br></br>
								{formatNumber(balance)}
							</p>
						</div>
					</div>
				</div>
			</div>
		);
	}

	useEffect(() => {
		getBalanceData();
	}, [getBalanceData]);

	return (
		<>
			<div className="row row-cols-md-2 g-4">
				<div className="col">
					<div className="card text-white text-center bg-primary mb-3">
						<div className="card-body">
							<p className="card-text font-weight-bold">HORÁRIO <br></br> {formatNumber(gameCost)}</p>
						</div>
					</div>
				</div>

				<div className="col">
					<div className="card text-white text-center bg-secondary mb-3">
						<div className="card-body">
							<p className="card-text font-weight-bold">PAGO NO MÊS <br></br> {formatNumber(totalPaid.thisMonth)}</p>
						</div>
					</div>
				</div>
			</div>

			{shouldRenderBalance ? renderTotalBalance() : null}
		</>
	);
}

export default BalanceCard;
