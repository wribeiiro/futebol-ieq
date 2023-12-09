import React from 'react';
import Container from './../../Atomic/Container';
import Breadcrumb, { Item } from './../../Atomic/Breadcrumb';
import { Token } from  "./../../../Utils/TokenManager";
import Utils from "./../../../Utils";

const SquadBuilder = () => {
	return (
		<Container>
			<Breadcrumb
				items={[
					<Item to={"/"} title={Token(3)} key={Utils.generateHash()} />,
					<Item to={"/squad-builder"} title={Token(6)} active key={Utils.generateHash()} />
				]}
			/>
			<div className="d-grid gap-2">
				<img
					src="https://www.wribeiiro.com/players/team-a.jpg"
					alt="squad"
					width="100%"
				/>

				<img
					src="https://www.wribeiiro.com/players/team-b.jpg"
					alt="squad"
					width="100%"
				/>
			</div>
		</Container>
	);
}

export default SquadBuilder;
