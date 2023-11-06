<?php

function randomizeTeams()
{
	$players = ['ANDRÉ', 'BENJAMIM', 'CASSIANO', 'CLEFERSON GK', 'DANIEL', 'DE GEA GK', 'FÁBIO', 'JULIO', 'LEANDRO', 'LIPSZERA', 'LUCIANO', 'PASTOR', 'PAULINHO', 'REGINALDO', 'RENAN', 'WALLACE', 'WELL'];

	shuffle($players);

	$teams = array_chunk($players, ceil(count($players) / 2));

    $invalidGk = 0;
    foreach ($teams[0] as $player) {
        if (str_contains($player, ' GK')) $invalidGk++;
    }

    if ($invalidGk == 0 || $invalidGk == 2) {
        $teams = randomizeTeams();
    }

    return $teams;
}

$teams = randomizeTeams();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Squad</title>
    <style>

    body {
        padding: 10px;
    }

    html {
        height: 100%;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-weight: bold;
        text-transform: uppercase;
    }

    .squad {
        text-align: left;
        border-collapse: collapse;
        border: 0;
        width: 100%;
    }

    .squad td {
        padding: 15px;
        text-align: center;
        color: #fff;
    }

    .field {
        background-image: url('https://www.wribeiiro.com/players/field.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        margin-top: 20px;
        height: 100%;
    }

    h2 {
        text-align: center;
        margin-bottom: 5px;
    }

    .wrapper {
        display: flex;
    }

    .row {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 100%;
        margin-top: 5px;
    }

    .col {
        display: flex;
        flex-direction: column;
        flex-basis: 100%;
        flex: 1;
    }

    .row-subs {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        width: 100%;
        margin-top: 5px;
    }

    .col-subs {
        display: flex;
    }

    .subs-player {
        margin-right: 12px;
        text-align: center;
    }

    </style>
</head>
<body>
    <div class='wrapper'>
        <div class="row">
            <div class="col">
                <h2>TEAM A</h2>
                <div class="field">
                    <table class="squad">
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/well.png" alt="ata" width="75" height="105">
                                <br>
                                Well
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.wribeiiro.com/players/evertonribeiro.png" alt="rf" width="75" height="105">
                                <br>
                                Luciano
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/lipszera.png" alt="mid" width="75" height="105">
                                <br>
                                Lipszera
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/ya9.jpg" alt="lf" width="75" height="105">
                                <br>
                                Paulinho
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/andre.png" alt="fix" width="75" height="105">
                                <br>
                                André
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/de-gea.jpg" alt="gk" width="75" height="105">
                                <br>
                                De Gea
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>RESERVAS</h2>
                <div class="row-subs">
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/luan.jpg" alt="ata" width="75" height="105">
                            <p>Daniel</p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/zeroberto.jpg" alt="ata" width="75" height="105">
                            <p>Fábio</p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/ancelotti.jpg" alt="ata" width="75" height="105">
                            <p>Pastor</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <h2 style="text-align: center;">TEAM B</h2>
                <div class="field">
                    <table class="squad">
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/cassiano.png" alt="ata" width="75" height="105">
                                <br>
                                Cassiano
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.wribeiiro.com/players/leandro.png" alt="rf" width="75" height="105">
                                <br>
                                Leo
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/cr7.jpg" alt="mid" width="75" height="105">
                                <br>
                                Benjamim
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/zeroberto.jpg" alt="lf" width="75" height="105">
                                <br>
                                Reginaldo
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/r10.jpg" alt="fix" width="75" height="105">
                                <br>
                                Wallace
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/cassio.jpg" alt="gk" width="75" height="105">
                                <br>
                                Cleferson
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>RESERVAS</h2>
                <div class="row-subs">
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/cr7.jpg" alt="ata" width="75" height="105">
                            <p>Renan</p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/cr7.jpg" alt="ata" width="75" height="105">
                            <p>Júlio</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
