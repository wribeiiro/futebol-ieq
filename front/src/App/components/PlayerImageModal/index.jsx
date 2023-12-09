import { useState } from "react";
import Button from "react-bootstrap/Button";
import Modal from "react-bootstrap/Modal";

const PlayerImageModal = ({ pathImage, name }) => {
	const [show, setShow] = useState(false);

	const handleClose = () => setShow(false);
	const handleShow = () => setShow(true);

	return (
		<>
			<img
				src={pathImage}
				alt={name}
				width="60"
				height="60"
				onClick={handleShow}
			/>

			<Modal
				show={show}
				onHide={handleClose}
			>
				<Modal.Header closeButton>
					<Modal.Title>{name}</Modal.Title>
				</Modal.Header>
				<Modal.Body>
					<img
						src={pathImage}
						alt={name}
						width="100%"
						height="100%"
					/>
				</Modal.Body>
				<Modal.Footer>
					<Button variant="secondary" onClick={handleClose}>
						Fechar
					</Button>
				</Modal.Footer>
			</Modal>
		</>
	);
};

export default PlayerImageModal;
