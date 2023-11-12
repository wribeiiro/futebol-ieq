import React, { useCallback, useEffect, useState } from 'react';
import Container from './../../Atomic/Container';
import Breadcrumb, { Item } from './../../Atomic/Breadcrumb';
import { Token } from "./../../../Utils/TokenManager";
import Utils from "./../../../Utils";
import Select from "react-select";
import PlayerModule from '../../../store/modules/playerModule';
import usePagesContext from '../../../Hooks/PagesProvider';

const Payment = () => {
	const { setLoading } = usePagesContext();
	const { actions } = PlayerModule;
	const [playerSelected, setPlayerSelected] = useState(null);
	const [players, setPlayers] = useState([]);

	const setLoadingCallback = useCallback(value => {
		setLoading(value);
	}, [setLoading])

	useEffect(() => {
		actions.fetchPlayers()
			.then(({ data }) => {
				setLoadingCallback(false);

				setPlayers(data.map(item => {
					item.label = item.name;

					return item;
				}))
			});
	}, [setPlayers, actions, setLoadingCallback]);

	return (
		<Container>
			<Breadcrumb
				items={[
					<Item to={"/"} title={Token(3)} key={Utils.generateHash()} />,
					<Item to={"/payment"} title={Token(2)} active key={Utils.generateHash()} />
				]}
			/>
			<Select options={players} onChange={setPlayerSelected} />
		</Container>
	);
}

export default Payment;