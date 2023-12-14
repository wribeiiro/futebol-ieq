import React from 'react';
import Container from '../../Atomic/Container';
import Breadcrumb, { Item } from '../../Atomic/Breadcrumb';
import { Token } from  "../../../Utils/TokenManager";
import Utils from "../../../Utils";
import GameTable from '../../GameTable';

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

				<GameTable/>
			</div>
		</Container>

	);
}

export default Matches;
