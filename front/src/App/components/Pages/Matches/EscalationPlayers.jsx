import React, { useCallback, useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import Utils from "../../../Utils";
import Container from '../../Atomic/Container';
import Breadcrumb, { Item } from '../../Atomic/Breadcrumb';
import CircularLoading from '../../Atomic/CircularLoading';
import Table from 'react-bootstrap/Table';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { SELECT_TEAMS } from "./steps";

const EscalationPlayers = ({ game, getGamesData }) => {
    const { t } = useTranslation();
    const [players, setPlayers] = useState([]);
    const [loading, setLoading] = useState(true);

    const fetchPlayers = useCallback(() => {
        setLoading(true);
        fetch(`${Utils.baseUrl()}/game/players?id_game=${game.id}`, {
            method: 'GET',
        }).catch(error => {
            console.error(error);
        }).then(response => {
            response.json().then(data => setPlayers(data));
        }).finally(() => {
            setLoading(false);
        });
    }, [game]);

    const selectPlayer = useCallback((option, player_id, id_players_game) => {
        setLoading(true);
        fetch(`${Utils.baseUrl()}/playersgame/selector`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                game_id: game.id,
                player_id,
                id_players_game,
                option
            })
        }).catch(error => {
            console.error(error);
        }).then(response => {
            console.log(response);
        }).finally(() => {
            setLoading(false);
            fetchPlayers();
        });
    }, [game]);

    const finishStep = useCallback(() => {
        setLoading(true);
        fetch(`${Utils.baseUrl()}/game/finish/selector`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id_game: game.id
            })
        }).finally(() => {
            getGamesData();
        });
    }, []);

    useEffect(() => {
        fetchPlayers();
    }, []);

    if (loading) {
        return <CircularLoading />;
    }

    return (
        <Container>
            <Breadcrumb
                items={[
                    <Item to={"/"} title={t(3)} key={Utils.generateHash()} />,
                    <Item to={"/matches"} title={t(7)} active key={Utils.generateHash()} />
                ]}
            />
            <div className="d-grid gap-2" style={{marginBottom: '10px'}}>
                <Button variant="primary" size="sm" onClick={finishStep}>
                    Finalizar escalação
                </Button>
            </div>

            <Form.Label><strong>Data: </strong></Form.Label> {Utils.formatDate(game.date_game)}
            <Table striped="columns">
                <thead>
                    <tr>
                        <th>Jogador</th>
                        <th>Vai jogar?</th>
                    </tr>
                </thead>
                <tbody>
                    {players.map(player => (
                        <tr key={player.id}>
                            <td>{player.name}</td>
                            <td style={{ textAlign: 'center' }}>
                                <Form.Select
                                    size="sm"
                                    value={player.id_players_game === null ? 2 : 1}
                                    onChange={e => selectPlayer(e.target.value, player.id, player.id_players_game)}
                                >
                                    <option value={2}>Não</option>
                                    <option value={1}>Sim</option>
                                </Form.Select>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </Table>
        </Container >
    );
};

export default EscalationPlayers;