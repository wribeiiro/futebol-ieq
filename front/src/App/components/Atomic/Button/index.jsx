const Button = ({ type, children, onClick }) => {
	return (
		<button
			className={`btn btn-${type}`}
			type="button"
			onClick={onClick}
		>
			{children}
		</button>
	);
};

export default Button;