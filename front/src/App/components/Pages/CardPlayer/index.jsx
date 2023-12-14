import './style.css';
import LogoImg from "../../../assets/images/logo512x512.png";

const CardPlayer = (playerData) => {
    const cardHeader = () => {
		return (
			<>
				<div className="player-card-top">
					<div className="player-master-info">
						<div className="player-rating">
							<span>97</span>
						</div>
						<div className="player-position">
							<span>LW</span>
						</div>
						<div className="player-nation">
							<img src="https://www.wribeiiro.com/players/brazil.png" alt="Brazil" draggable="false" width={200}/>
						</div>
						<div className="player-club">
							<img src={LogoImg} alt="Valentes FC" draggable="false" width={200}/>
						</div>
					</div>
					<div className="player-picture">
						<img src="https://www.wribeiiro.com/players/card/well-teste.png" alt="Well" draggable="false"/>
					</div>
				</div>
			</>
		)
	}

	const cardBottom = () => {
		return (
			<>
				<div className="player-card-bottom">
					<div className="player-info">
						<div className="player-name">
							<span>WELL</span>
						</div>
						<div className="player-features">
							<div className="player-features-col">
								<span>
									<div className="player-feature-value">97</div>
									<div className="player-feature-title">PAC</div>
								</span>
								<span>
									<div className="player-feature-value">95</div>
									<div className="player-feature-title">SHO</div>
								</span>
								<span>
									<div className="player-feature-value">94</div>
									<div className="player-feature-title">PAS</div>
								</span>
							</div>
							<div className="player-features-col">
								<span>
									<div className="player-feature-value">99</div>
									<div className="player-feature-title">DRI</div>
								</span>
								<span>
									<div className="player-feature-value">35</div>
									<div className="player-feature-title">DEF</div>
								</span>
								<span>
									<div className="player-feature-value">68</div>
									<div className="player-feature-title">PHY</div>
								</span>
							</div>
						</div>
					</div>
				</div>
			</>
		)
	}

	return (
		<>
			<div className="fut-player-card">
				{cardHeader()}
				{cardBottom()}
			</div>
		</>
	);
}

export default CardPlayer;
