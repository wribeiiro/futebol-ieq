import React from 'react';
import Button from './../../Atomic/Button';
import Container from './../../Atomic/Container';
import Breadcrumb, { Item } from './../../Atomic/Breadcrumb';
import { Token } from  "./../../../Utils/TokenManager";
import Utils from "./../../../Utils";

const Payment = () => {
	return (
		<Container>
			<Breadcrumb
				items={[
					<Item to={"/"} title={Token(3)} key={Utils.generateHash()} />,
					<Item to={"/payment"} title={Token(2)} active key={Utils.generateHash()} />
				]}
			/>
			<div className="d-grid gap-2">
				<Button
					type={'primary'}
					onClick={() => console.log(1)}
				>
					{Token(4)}
				</Button>
				<Button
					type={'primary'}
					onClick={() => console.log(1)}
				>
					{Token(5)}
				</Button>
			</div>
		</Container>

	);
}

export default Payment;