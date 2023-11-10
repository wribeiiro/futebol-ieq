<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Database
{
    /**
     * @var \PDO
     */
    protected \PDO $connection;

    private static $instance = null;

    private function __clone()
    {}

    private function __construct() {}

    public static function getInstance()
    {
        if (self::$instance === null) {
            try {
                self::$instance = new PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('ERROR CATCH'. $e->getmessage());
            }
        }

        return self::$instance;
    }
}

function randomizeTeams(array $resultPlayers)
{
    $players = [];

    foreach ($resultPlayers as $player) {
        $players[$player['id']] = $player;
    }

    $playerKeys = array_keys($players);

	shuffle($playerKeys);

    $sortedPlayers = [];
    $gks = [];
    foreach ($playerKeys as $player) {
    	if ($players[$player]['is_goalkeeper'] == 'Y') {
    		$gks[] = $players[$player];
    		continue;
    	}

        $sortedPlayers[] = $players[$player];
    }

	$teams = array_chunk($sortedPlayers, ceil(count($sortedPlayers) / 2));

	array_unshift($teams[0], $gks[0]);
	array_unshift($teams[1], $gks[1]);

    $overallTeamA = round(array_sum(array_column($teams[0], 'overall')) / count($teams[0]));
    $overallTeamB = round(array_sum(array_column($teams[1], 'overall')) / count($teams[1]));
    $diffOverall = $overallTeamA - $overallTeamB;

    if (abs($diffOverall) >= 5) {
        randomizeTeams($resultPlayers);
    }

    return [
        'teamA' => [
            'players' => $teams[0],
            'overall' => $overallTeamA
        ],
        'teamB' => [
            'players' => $teams[1],
            'overall' => $overallTeamB
        ]
    ];
}

$connection = Database::getInstance();
$resultPlayers = $connection->query("SELECT * FROM players ORDER BY name ASC")->fetchAll(\PDO::FETCH_ASSOC);
$teams = randomizeTeams($resultPlayers);

[$gkTeamA, $player1TeamA, $player2TeamA, $player3TeamA, $player4TeamA, $player5TeamA, $player6TeamA, $player7TeamA, $player8TeamA] = $teams['teamA']['players'];
[$gkTeamB, $player1TeamB, $player2TeamB, $player3TeamB, $player4TeamB, $player5TeamB, $player6TeamB, $player7TeamB, $player8TeamB] = $teams['teamB']['players'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Squad Builder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>

    body {
        padding: 10px;
        background: linear-gradient(0deg, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('https://www.wribeiiro.com/players/bg.jpg') no-repeat center center fixed;
        background-size: 100% 100%;
        color: #fff;
        text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black;
    }

    html {
        height: 100%;
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        font-weight: bold;
    }

    .squad {
        border: 0;
        width: 100%;
    }

    .squad td {
        text-align: center;
        color: #fff;
    }

    .field {
        background-image: url('https://www.wribeiiro.com/players/field.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        margin-top: 10px;
    }

    h2 {
        text-align: center;
        margin-bottom: 5px;
    }

    .flex-container {
        display: flex;
        align-items: center;
        justify-content: space-around;
        align-content: center;
        flex-wrap: wrap;
    }

    .flex-item {
        width: 100%;
        flex: 1;
        margin-left: 5px;
        margin-right: 5px;
    }

    .head-team {
        display: flex;
        flex-direction: column;
        align-items: center;
        font-size: 28px;
    }

    .team-name, .team-overall {
        font-size: 40px;
    }

    .fa-star {
        color: #FDDC54 !important;
        font-size: 20px;
    }

    ul {
        list-style-type: none;
        position: relative;
        margin: 0 auto;
    }

    li {
        display: inline-block;
        text-align: center;
    }

    li img {
        vertical-align: middle;
    }

    .badge {
        background-color: #23292C;
        color: white;
        padding: 2px 4px;
        text-align: center;
        border-radius: 5px;

    }

    .subs {
        background: rgba(0, 0, 0, 0.6);
        width: 100%;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        padding-top: 20px;
    }

    .player-img {
        margin-bottom: -2px;
    }

    .mt-4 {
        margin-top: 4px;
    }

    .cf, .lwf, .rwf {
        color: #DA4970;
        margin-right: 25px;
    }

    .lm {
        color: #479833;
        margin-right: 25px;
    }

    .cm {
        color: #479833;
        margin-right: 25px;
    }

    .rm {
        color: #479833;
        margin-right: 25px;
    }

    .cb {
        color: #127FA7;
        margin-right: 25px;
    }

    .gk {
        color: #BD9F41;
        margin-right: 25px;
    }

    </style>
</head>
<body>
    <button type="button" onclick="window.location.reload()">Gerar equipes</button>

    <div class="flex-container">
        <div class="flex-item">
            <div class="head-team">
                <span class="team-name">Team A</span>
                <img src="https://www.wribeiiro.com/players/logo192.png" width="60">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <span class="team-overall"><?= $teams['teamA']['overall'] ?></span>
            </div>
            <div class="field">
                <table class="squad">
                    <tr>
                        <td colspan="3">
                            <img class="player-img" src="<?= $player1TeamA['image'] ?>" alt="<?= $player1TeamA['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="cf">CF</span> <?= $player1TeamA['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player1TeamA['name'] ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="player-img" src="<?= $player2TeamA['image'] ?>" alt="<?= $player2TeamA['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="lm">LM</span> <?= $player2TeamA['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player2TeamA['name'] ?>
                            </div>
                        </td>
                        <td>
                            <img class="player-img" src="<?= $player3TeamA['image'] ?>" alt="<?= $player3TeamA['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="cm">CM</span> <?= $player3TeamA['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player3TeamA['name'] ?>
                            </div>
                        </td>
                        <td>
                            <img class="player-img" src="<?= $player4TeamA['image'] ?>" alt="<?= $player4TeamA['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="rm">RM</span> <?= $player4TeamA['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player4TeamA['name'] ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img class="player-img" src="<?= $player5TeamA['image'] ?>" alt="<?= $player5TeamA['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="cb">CB</span> <?= $player5TeamA['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player5TeamA['name'] ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img class="player-img" src="<?= $gkTeamA['image'] ?>" alt="<?= $gkTeamA['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="gk">GK</span> <?= $gkTeamA['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $gkTeamA['name'] ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <h2>Banco A</h2>
            <div class="subs">
                <ul>
                    <li>
                        <img src="<?= $player6TeamA['image'] ?>" alt="<?= $player6TeamA['id'] ?>" width="100" height="100">
                        <div>
                            <span class="badge">
                                <span class="cm">CM</span> <?= $player6TeamA['overall'] ?>
                            </span>
                        </div>
                        <div>
                            <?= $player6TeamA['name'] ?>
                        </div>
                    </li>
                    <li>
                        <img src="<?= $player7TeamA['image'] ?>" alt="<?= $player7TeamA['id'] ?>" width="100" height="100">
                        <div>
                            <span class="badge">
                                <span class="cf">CF</span> <?= $player7TeamA['overall'] ?>
                            </span>
                        </div>
                        <div>
                            <?= $player7TeamA['name'] ?>
                        </div>
                    </li>
                    <li>
                        <img src="<?= $player8TeamA['image'] ?>" alt="<?= $player8TeamA['id'] ?>" width="100" height="100">
                        <div>
                            <span class="badge">
                                <span class="cb">CB</span> <?= $player8TeamA['overall'] ?>
                            </span>
                        </div>
                        <div>
                            <?= $player8TeamA['name'] ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="flex-item">
            <div class="head-team">
                <span class="team-name">Team B</span>
                <img src="https://www.wribeiiro.com/players/logo192.png" width="60">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </div>
                <span class="team-overall"><?= $teams['teamB']['overall'] ?></span>
            </div>
            <div class="field">
                <table class="squad">
                    <tr>
                        <td>
                            <img class="player-img" src="<?= $player1TeamB['image'] ?>" alt="<?= $player1TeamB['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="lwf">LWF</span> <?= $player1TeamB['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player1TeamB['name'] ?>
                            </div>
                        </td>
                        <td>
                            <img class="player-img" src="<?= $player2TeamB['image'] ?>" alt="<?= $player2TeamB['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="rwf">RWF</span> <?= $player2TeamB['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player2TeamB['name'] ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img class="player-img" src="<?= $player3TeamB['image'] ?>" alt="<?= $player3TeamB['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="cm">CM</span> <?= $player3TeamB['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player3TeamB['name'] ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img class="player-img" src="<?= $player4TeamB['image'] ?>" alt="<?= $player4TeamB['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="cb">CB</span> <?= $player4TeamB['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player4TeamB['name'] ?>
                            </div>
                        </td>
                        <td>
                            <img class="player-img" src="<?= $player5TeamB['image'] ?>" alt="<?= $player5TeamB['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="cb">CB</span> <?= $player5TeamB['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $player5TeamB['name'] ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img class="player-img" src="<?= $gkTeamB['image'] ?>" alt="<?= $gkTeamB['id'] ?>" width="100" height="100">
                            <div>
                                <span class="badge">
                                    <span class="gk">GK</span> <?= $gkTeamB['overall'] ?>
                                </span>
                            </div>
                            <div>
                                <?= $gkTeamB['name'] ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <h2>Banco B</h2>
            <div class="subs">
                <ul>
                    <li>
                        <img src="<?= $player6TeamB['image'] ?>" alt="<?= $player6TeamB['id'] ?>" width="100" height="100">
                        <div>
                            <span class="badge">
                                <span class="cf">CF</span> <?= $player6TeamB['overall'] ?>
                            </span>
                        </div>
                        <div>
                            <?= $player6TeamB['name'] ?>
                        </div>
                    </li>
                    <li>
                        <img src="<?= $player7TeamB['image'] ?>" alt="<?= $player7TeamB['id'] ?>" width="100" height="100">
                        <div>
                            <span class="badge">
                                <span class="cb">CB</span> <?= $player7TeamB['overall'] ?>
                            </span>
                        </div>
                        <div>
                            <?= $player7TeamB['name'] ?>
                        </div>
                    </li>
                    <li>
                        <img src="<?= $player8TeamB['image'] ?>" alt="<?= $player8TeamB['id'] ?>" width="100" height="100">
                        <div>
                            <span class="badge">
                                <span class="cm">CM</span> <?= $player8TeamB['overall'] ?>
                            </span>
                        </div>
                        <div>
                            <?= $player8TeamB['name'] ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
