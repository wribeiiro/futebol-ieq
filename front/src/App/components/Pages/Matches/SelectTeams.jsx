import React, { useCallback, useEffect, useState } from "react";
import CircularLoading from '../../Atomic/CircularLoading';
import Utils from "../../../Utils";

const SelectTeam = ({ game }) => {
    const [players, setPlayers] = useState([]);
    const [loading, setLoading] = useState(true);

    const fetchPlayers = useCallback(() => {
        setLoading(true);
        fetch(`${Utils.baseUrl()}/playersgame/team?id_game=${game.id}`, {
            method: 'GET',
        }).catch(error => {
            console.error(error);
        }).then(response => {
            response.json().then(data => setPlayers(data));
        }).finally(() => {
            setLoading(false);
        });
    }, [game]);

    useEffect(() => {
        fetchPlayers();
    }, []);

    if (loading) {
        return <CircularLoading />;
    }

    return (
        <div>
            Usar frame tripa para montar os time e enviar jogo para a proxima etapa que entao vai colocar o resultado do jogo
            {players.map(player => {
                return <li key={player.id}>{player.name}</li>;
            })}
        </div>
    );
};

export default SelectTeam;