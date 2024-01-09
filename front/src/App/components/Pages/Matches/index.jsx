import React, { useCallback, useEffect, useState } from 'react';
import Container from '../../Atomic/Container';
import Breadcrumb, { Item } from '../../Atomic/Breadcrumb';
import Utils from "../../../Utils";
import GameTable from '../../GameTable';
import Modal from "react-bootstrap/Modal";
import Button from 'react-bootstrap/Button';
import { useTranslation } from 'react-i18next';
import DatePicker from '../../Atomic/DatePicker';
import CircularLoading from '../../Atomic/CircularLoading';
import EscalationPlayers from './EscalationPlayers';
import { FINISHED, SELECT_PLAYERS, SELECT_TEAMS } from './steps';
import SelectTeam from './SelectTeams';

const Matches = () => {
	const [showModal, setShowModal] = useState(false);
	const [data, setData] = useState([]);
	const [loading, setLoading] = useState(true);
	const [selectedDate, setSelectedDate] = useState("");
	const [step, setStep] = useState(FINISHED);
	const { t } = useTranslation();

	const getGamesData = useCallback(async () => {
		try {
			const res = await fetch(`${Utils.baseUrl()}/game`);
			const resData = await res.json();

			if (resData.filter(game => game.status == SELECT_PLAYERS).length > 0) {
				setStep(SELECT_PLAYERS);
			}

			if (resData.filter(game => game.status == SELECT_TEAMS).length > 0) {
				setStep(SELECT_TEAMS);
			}

			setData(resData);
			setLoading(false);
		} catch (err) {
			alert(err);
		}
	});

	const createMatch = useCallback(() => {
		setLoading(true);
		fetch(`${Utils.baseUrl()}/game`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({
				date_game: selectedDate
			})
		}).catch(error => {
			console.error(error);
		}).finally(() => {
			getGamesData();
			setShowModal(false);
		});
	}, [setShowModal, selectedDate, getGamesData]);

	useEffect(() => {
		getGamesData();
	}, []);

	if (loading) {
		return <CircularLoading />;
	}

	if (step === SELECT_PLAYERS) {
		const game = data.filter(game => game.status == SELECT_PLAYERS);

		return <EscalationPlayers game={game[0]} getGamesData={getGamesData} />;
	}

	if (step === SELECT_TEAMS) {
		const game = data.filter(game => game.status == SELECT_TEAMS);

		return <SelectTeam game={game[0]} getGamesData={getGamesData} />;
	}

	return (
		<Container>
			<Breadcrumb
				items={[
					<Item to={"/"} title={t(3)} key={Utils.generateHash()} />,
					<Item to={"/matches"} title={t(7)} active key={Utils.generateHash()} />
				]}
			/>
			<div className="d-grid gap-2">
				<Button
					variant="primary"
					onClick={() => setShowModal(true)}
				>
					{t(10)}
				</Button>

				<Modal show={showModal} onHide={() => setShowModal(false)}
					aria-labelledby="contained-modal-title-vcenter"
					centered>
					<Modal.Header closeButton>
						<Modal.Title>{t(10)}</Modal.Title>
					</Modal.Header>
					<Modal.Body>
						<div style={{ textAlign: 'center' }}>
							<DatePicker value={selectedDate} onChange={setSelectedDate} />
						</div>
					</Modal.Body>
					<Modal.Footer>
						<Button variant="primary" disabled={!selectedDate} onClick={createMatch}>
							{t(9)}
						</Button>
					</Modal.Footer>
				</Modal>
				<GameTable data={data} />
			</div>
		</Container>
	);
}

export default Matches;
