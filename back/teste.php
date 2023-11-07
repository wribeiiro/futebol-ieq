<?php

function randomizeTeams()
{
	$players = [
        'ANDRÉ' => 'https://www.wribeiiro.com/players/andre.png',
        'BENJAMIM' => 'https://www.wribeiiro.com/players/blank.png',
        'CASSIANO' => 'https://www.wribeiiro.com/players/cassiano.png',
        'CLEFERSON GK' => 'https://www.wribeiiro.com/players/blank.png',
        'DANIEL' => 'https://www.wribeiiro.com/players/blank.png',
        'DE GEA GK' => 'https://www.wribeiiro.com/players/blank.png',
        'FÁBIO' => 'https://www.wribeiiro.com/players/blank.png',
        'JULIO' => 'https://www.wribeiiro.com/players/blank.png',
        'LEANDRO' => 'https://www.wribeiiro.com/players/leo.png',
        'LIPSZERA' => 'https://www.wribeiiro.com/players/lipszera.png',
        'LUCIANO' => 'https://www.wribeiiro.com/players/blank.png',
        'PASTOR' => 'https://www.wribeiiro.com/players/blank.png',
        'PAULINHO' => 'https://www.wribeiiro.com/players/blank.png',
        'REGINALDO' => 'https://www.wribeiiro.com/players/blank.png',
        'RENAN' => 'https://www.wribeiiro.com/players/blank.png',
        'WALLACE' => 'https://www.wribeiiro.com/players/blank.png',
        'WELL' => 'https://www.wribeiiro.com/players/well.png',
    ];

    $playerKeys = array_keys($players);

	shuffle($playerKeys);

    $sortedPlayers = [];
    foreach ($playerKeys as $player) {
        $sortedPlayers[$player] = $players[$player];
    }

	$teams = array_chunk($sortedPlayers, ceil(count($sortedPlayers) / 2), true);
    $invalidGk = 0;

    foreach (array_keys($teams[0]) as $player) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>

    body {
        padding: 10px;
        background-image: url('https://www.wribeiiro.com/players/bg.jpg');
        background-repeat: no-repeat;
        background-size: cover;
        color: #fff;
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
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
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
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

    .head-team {
        display: flex;
        align-items:center;
        font-size: 22px;
        flex-direction: column;
    }

    .fa-star {
        color: #FDDC54 !important;
    }

    </style>
</head>
<body>
    <button type="button" onclick="window.location.reload()">Gerar equipes</button>
    <div class='wrapper'>
        <div class="row">
            <div class="col">
                <div class="head-team">
                    <img src="https://www.wribeiiro.com/players/logo192.png" width="60">
                    <span>TEAM A</span>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>

                    <small>
                    <?php foreach ($teams[0] as $k => $t) echo $k . '<br>';  ?>
                    </small>
                </div>
                <div class="field">
                    <table class="squad">

                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/well.png" alt="ata" width="100" height="100">
                                <br>
                                Well
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="rf" width="100" height="100">
                                <br>
                                Luciano
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/lipszera.png" alt="mid" width="100" height="100">
                                <br>
                                Lipszera
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="lf" width="100" height="100">
                                <br>
                                Paulinho
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/andre.png" alt="fix" width="100" height="100">
                                <br>
                                André
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="gk" width="100" height="100">
                                <br>
                                De Gea
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>BANCO A</h2>
                <div class="row-subs">
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/blank.png" alt="ata" width="100" height="100">
                            <p>Daniel</p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/blank.png" alt="ata" width="100" height="100">
                            <p>Fábio</p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/blank.png" alt="ata" width="100" height="100">
                            <p>Pastor</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="head-team">
                    <img src="https://www.wribeiiro.com/players/logo192.png" width="60">
                    <span>TEAM B</span>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                    </div>
                    <small>
                    <?php foreach ($teams[1] as $k => $t) echo $k . '<br>';  ?>
                    </small>
                </div>
                <div class="field">
                    <table class="squad">

                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/cassiano.png" alt="ata" width="100" height="100">
                                <br>
                                Cassiano
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="https://www.wribeiiro.com/players/leo.png" alt="rf" width="100" height="100">
                                <br>
                                Leo
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="mid" width="100" height="100">
                                <br>
                                Benjamim
                            </td>
                            <td>
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="lf" width="100" height="100">
                                <br>
                                Reginaldo
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="fix" width="100" height="100">
                                <br>
                                Wallace
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="https://www.wribeiiro.com/players/blank.png" alt="gk" width="100" height="100">
                                <br>
                                Cleferson
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>BANCO B</h2>
                <div class="row-subs">
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/blank.png" alt="ata" width="100" height="100">
                            <p>Renan</p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="https://www.wribeiiro.com/players/blank.png" alt="ata" width="100" height="100">
                            <p>Júlio</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
