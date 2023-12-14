import React from 'react';
import Container from './../../Atomic/Container';
import Breadcrumb, { Item } from './../../Atomic/Breadcrumb';
import { Token } from  "./../../../Utils/TokenManager";
import Utils from "./../../../Utils";

const SquadBuilder = () => {
	return (
		<Container style={{ overflow: 'hidden !important' }}>
			<Breadcrumb
				items={[
					<Item to={"/"} title={Token(3)} key={Utils.generateHash()} />,
					<Item to={"/squad-builder"} title={Token(6)} active key={Utils.generateHash()} />
				]}
			/>
			<div className="d-grid gap-2">
				<iframe
					src="https://www.wribeiiro.com/sheets-api/back/teste.php"
					frameborder="0"
					width={"100%"}
					height={"auto"}
					title={"teams"}
					style={{
						height: "100vh",
						overflow: "hidden"
					}}
				>
				</iframe>
			</div>
		</Container>
	);
}

export default SquadBuilder;
