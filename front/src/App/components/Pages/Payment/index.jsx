import React from 'react';
import Button from 'App/components/Atomic/Button';
import Container from 'App/components/Atomic/Container';
import Breadcrumb, { Item } from 'App/components/Atomic/Breadcrumb';
import { Token } from 'App/Utils/TokenManager';
import Utils from 'App/Utils';

const Payment = () => {
	return (
		<Container>
			<Breadcrumb
				items={[
					<Item to={"/"} title={Token(3)} key={Utils.generateHash()}/>,
					<Item to={"/payment"} title={Token(2)} active key={Utils.generateHash()}/>
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