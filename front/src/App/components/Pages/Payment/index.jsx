import React from 'react';
import Container from './../../Atomic/Container';
import Breadcrumb, { Item } from './../../Atomic/Breadcrumb';
import { Token } from  "./../../../Utils/TokenManager";
import Utils from "./../../../Utils";
import PaymentTable from '../../PaymentTable';

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
				<PaymentTable />
			</div>
		</Container>

	);
}

export default Payment;
