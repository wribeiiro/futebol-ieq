<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function randomizeTeams()
{
    $resultPlayers = [];

    try {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};port={$_ENV['DB_PORT']}";
        $pdo = new \PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT name, image FROM players ORDER BY name ASC");
        $statement->execute();

        $resultPlayers = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
        die($e);
    }

    $players = [];
    foreach ($resultPlayers as $play) {
        $players[$play['name']] = $play['image'];
    }

    $playerKeys = array_keys($players);

	shuffle($playerKeys);

    $sortedPlayers = [];
    foreach ($playerKeys as $player) {
        $sortedPlayers[] = ['name' => $player, 'image' => $players[$player]];
    }

	$teams = array_chunk($sortedPlayers, ceil(count($sortedPlayers) / 2));
    $invalidGk = 0;

    foreach ($teams[0] as $player) {
        if (str_contains($player['name'], ' GK')) $invalidGk++;
    }

    if ($invalidGk == 0 || $invalidGk == 2) {
        $teams = randomizeTeams();
    }

    return $teams;
}

$teams = randomizeTeams();

[$player1TeamA, $player2TeamA, $player3TeamA, $player4TeamA, $player5TeamA, $player6TeamA, $player7TeamA, $player8TeamA] = $teams[0];
[$player1TeamB, $player2TeamB, $player3TeamB, $player4TeamB, $player5TeamB, $player6TeamB, $player7TeamB, $player8TeamB] = $teams[1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Squad Builder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>

    html, body {
        height: 100%;
    }

    body {
        padding: 10px;
        background-image: url('https://www.wribeiiro.com/players/bg.jpg');
        background-size: cover;
        background-repeat: repeat;
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
                </div>
                <div class="field">
                    <table class="squad">

                        <tr>
                            <td colspan="3">
                                <img src="<?= $player1TeamA['image'] ?>" alt="ata" width="100" height="100">
                                <br>
                                <?= $player1TeamA['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="<?= $player2TeamA['image'] ?>" alt="rf" width="100" height="100">
                                <br>
                                <?= $player2TeamA['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player3TeamA['image'] ?>" alt="mid" width="100" height="100">
                                <br>
                                <?= $player3TeamA['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player4TeamA['image'] ?>" alt="lf" width="100" height="100">
                                <br>
                                <?= $player4TeamA['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player5TeamA['image'] ?>" alt="fix" width="100" height="100">
                                <br>
                                <?= $player5TeamA['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player6TeamA['image'] ?>" alt="gk" width="100" height="100">
                                <br>
                                <?= $player6TeamA['name'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>BANCO A</h2>
                <div class="row-subs">
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="<?= $player7TeamA['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player1TeamA['name'] ?></p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="<?= $player8TeamA['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player8TeamA['name'] ?></p>
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
                </div>
                <div class="field">
                    <table class="squad">
                        <tr>
                            <td>
                                <img src="<?= $player1TeamB['image'] ?>" alt="ata" width="100" height="100">
                                <br>
                                <?= $player1TeamB['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player2TeamB['image'] ?>" alt="rf" width="100" height="100">
                                <br>
                                <?= $player2TeamB['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player3TeamB['image'] ?>" alt="mid" width="100" height="100">
                                <br>
                                <?= $player3TeamB['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="<?= $player4TeamB['image'] ?>" alt="lf" width="100" height="100">
                                <br>
                                <?= $player4TeamB['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player5TeamB['image'] ?>" alt="fix" width="100" height="100">
                                <br>
                                <?= $player5TeamB['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player6TeamB['image'] ?>" alt="gk" width="100" height="100">
                                <br>
                                <?= $player6TeamB['name'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <h2>BANCO B</h2>
                <div class="row-subs">
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="<?= $player7TeamB['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player7TeamB['name'] ?></p>
                        </div>
                    </div>
                    <div class="col-subs">
                        <div class="subs-player">
                            <img src="<?= $player8TeamB['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player8TeamB['name'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
