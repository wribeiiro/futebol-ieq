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
					<Item to={"/payment"} title={Token(6)} active key={Utils.generateHash()} />
				]}
			/>
			<div className="d-grid gap-2">
				times
			</div>
		</Container>

	);
}

export default SquadBuilder;
