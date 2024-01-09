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
    	if ($players[$player]['goalkeeper'] == 'Y') {
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
$resultPlayers = $connection->query("SELECT *, path_image FROM players ORDER BY name ASC")->fetchAll(\PDO::FETCH_ASSOC);
$teams = randomizeTeams($resultPlayers);

[$gkTeamA, $player1TeamA, $player2TeamA, $player3TeamA, $player4TeamA, $player5TeamA, $player6TeamA, $player7TeamA, $player8TeamA] = $teams['teamA']['players'];
[$gkTeamB, $player1TeamB, $player2TeamB, $player3TeamB, $player4TeamB, $player5TeamB, $player6TeamB, $player7TeamB] = $teams['teamB']['players'];
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
        padding: 0;
        margin: 0;
        border: 0;
    }
    * { box-sizing: border-box; }

    .squad {
        border: 0;
        width: 100%;
    }

    .squad td {
        text-align: center;
        color: #fff;
    }

    .field {
        background-image: url('https://www.wribeiiro.com/players/field5.png');
        background-size: 100% 100%;
        margin-top: 10px;
        max-height: 530px;
        display: flex;
        flex-direction: column;
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
        justify-content: center;
        align-items: center;
        font-size: 28px;
    }

    .team-name {
        font-size: 30px;
    }

    .team-overall {
        font-size: 24px;
    }

    .fa-star, .fa-star-half {
        color: #FDDC54 !important;
        font-size: 18px;
    }

    .fa-ambulance {
        font-size: 14px;
        color: #DA4970;
        vertical-align: middle;
    }

    .fa-plus, .fa-bandage, .fa-bandage {
        font-size: 14px;
        color: #DA4970;
        transform: rotate(-35deg);
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

    .row {
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    .container {
        text-align: center;
    }

    .hidden {
        visibility: hidden;
    }

    .red {
        color: #DA4970;
    }

    .green {
        color: #479833;
    }

    </style>
</head>
<body>
    <div class="flex-container">
        <div class="flex-item">
            <div class="head-team">
                <img src="https://www.wribeiiro.com/players/logo192.png" width="120">
                <div class="head-content">
                    <span class="team-name">Team A</span>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                    </div>
                    <span class="team-overall">Rating <?= $teams['teamA']['overall'] ?></span>
                </div>
            </div>

            <div class="field">
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $player1TeamA['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player1TeamA['path_image'] ?>" alt="<?= $player1TeamA['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="cf">CF</span>
                                    <?= $player1TeamA['overall'] ?>
                                    <?= $player1TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player1TeamA['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $player2TeamA['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player2TeamA['path_image'] ?>" alt="<?= $player2TeamA['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="lm">LM</span>
                                    <?= $player2TeamA['overall'] ?>
                                    <?= $player2TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player2TeamA['name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div id="drag<?= $player3TeamA['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player3TeamA['path_image'] ?>" alt="<?= $player3TeamA['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="cm">CM</span> <?= $player3TeamA['overall'] ?>
                                    <?= $player3TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player3TeamA['name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div id="drag<?= $player4TeamA['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player4TeamA['path_image'] ?>" alt="<?= $player4TeamA['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="rm">RM</span> <?= $player4TeamA['overall'] ?>
                                    <?= $player4TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player4TeamA['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $player5TeamA['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player5TeamA['path_image'] ?>" alt="<?= $player5TeamA['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="cb">CB</span> <?= $player5TeamA['overall'] ?>
                                    <?= $player5TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player5TeamA['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $gkTeamA['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $gkTeamA['path_image'] ?>" alt="<?= $gkTeamA['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="gk">GK</span> <?= $gkTeamA['overall'] ?>
                                    <?= $gkTeamA['injured_type'] == 'Y' ? '<i class="fa-solid fa-bandage "></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $gkTeamA['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Banco A <button type="button" onclick="window.location.reload()">Gerar equipes</button></h2>
            <div class="subs">
                <ul>
                    <li>
                        <div class="container">
                            <div id="drag<?= $player6TeamA['id'] ?>" draggable="true" class="player-card">
                                <img src="<?= $player6TeamA['path_image'] ?>" alt="<?= $player6TeamA['id'] ?>" width="90" height="90">
                                <div>
                                    <span class="badge">
                                        <span class="cm">CM</span> <?= $player6TeamA['overall'] ?>
                                        <?= $player6TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                    </span>
                                </div>
                                <div>
                                    <?= $player6TeamA['name'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="container">
                            <div id="drag<?= $player7TeamA['id'] ?>" draggable="true" class="player-card">
                                <img src="<?= $player7TeamA['path_image'] ?>" alt="<?= $player7TeamA['id'] ?>" width="90" height="90">
                                <div>
                                    <span class="badge">
                                        <span class="cf">CF</span> <?= $player7TeamA['overall'] ?>
                                        <?= $player7TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                    </span>
                                </div>
                                <div>
                                    <?= $player7TeamA['name'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="container">
                            <div id="drag<?= $player8TeamA['id'] ?>" draggable="true" class="player-card">
                                <img src="<?= $player8TeamA['path_image'] ?>" alt="<?= $player8TeamA['id'] ?>" width="90" height="90">
                                <div>
                                    <span class="badge">
                                        <span class="cb">CB</span> <?= $player8TeamA['overall'] ?>
                                        <?= $player8TeamA['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                    </span>
                                </div>
                                <div>
                                    <?= $player8TeamA['name'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="flex-container" style="margin-top: 60px;">
        <div class="flex-item">
            <div class="head-team">
                <img src="https://www.wribeiiro.com/players/logo192.png" width="120">
                <div class="head-content">
                    <span class="team-name">Team B</span>
                    <div class="stars">
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star-half"></i>
                    </div>
                    <span class="team-overall">Rating <?= $teams['teamB']['overall'] ?></span>
                </div>
            </div>

            <div class="field">
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $player1TeamB['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player1TeamB['path_image'] ?>" alt="<?= $player1TeamB['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="lwf">LWF</span> <?= $player1TeamB['overall'] ?>
                                    <?= $player1TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player1TeamB['name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div id="drag<?= $player2TeamB['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player2TeamB['path_image'] ?>" alt="<?= $player2TeamB['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="rwf">RWF</span> <?= $player2TeamB['overall'] ?>
                                    <?= $player2TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player2TeamB['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $player3TeamB['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player3TeamB['path_image'] ?>" alt="<?= $player3TeamB['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="cm">CM</span> <?= $player3TeamB['overall'] ?>
                                    <?= $player3TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player3TeamB['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $player4TeamB['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player4TeamB['path_image'] ?>" alt="<?= $player4TeamB['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="cb">CB</span> <?= $player4TeamB['overall'] ?>
                                    <?= $player4TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player4TeamB['name'] ?>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div id="drag<?= $player5TeamB['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $player5TeamB['path_image'] ?>" alt="<?= $player5TeamB['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="cb">CB</span> <?= $player5TeamB['overall'] ?>
                                    <?= $player5TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $player5TeamB['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="container">
                        <div id="drag<?= $gkTeamB['id'] ?>" draggable="true" class="player-card">
                            <img class="player-img" src="<?= $gkTeamB['path_image'] ?>" alt="<?= $gkTeamB['id'] ?>" width="90" height="90">
                            <div>
                                <span class="badge">
                                    <span class="gk">GK</span> <?= $gkTeamB['overall'] ?>
                                    <?= $gkTeamB['injured_type'] == 'Y' ? '<i class="fa-solid fa-bandage "></i>' : ''?>
                                </span>
                            </div>
                            <div>
                                <?= $gkTeamB['name'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h2>Banco B</h2>
            <div class="subs">
                <ul>
                    <li>
                        <div class="container">
                            <div id="drag<?= $player6TeamB['id'] ?>" draggable="true" class="player-card">
                                <img src="<?= $player6TeamB['path_image'] ?>" alt="<?= $player6TeamB['id'] ?>" width="90" height="90">
                                <div>
                                    <span class="badge">
                                        <span class="cf">CF</span> <?= $player6TeamB['overall'] ?>
                                        <?= $player6TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                    </span>
                                </div>
                                <div>
                                    <?= $player6TeamB['name'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="container">
                            <div id="drag<?= $player7TeamB['id'] ?>" draggable="true" class="player-card">
                                <img src="<?= $player7TeamB['path_image'] ?>" alt="<?= $player7TeamB['id'] ?>" width="90" height="90">
                                <div>
                                    <span class="badge">
                                        <span class="cb">CB</span> <?= $player7TeamB['overall'] ?>
                                        <?= $player7TeamB['injured_type'] == 'Y' ? '<i class="fas fa-ambulance"></i>' : ''?>
                                    </span>
                                </div>
                                <div>
                                    <?= $player7TeamB['name'] ?>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<script>
    const images = document.querySelectorAll("img");
    const cards = document.querySelectorAll(".player-card");
    const containers = document.querySelectorAll(".container");

    images.forEach((image) => {
        image.setAttribute("draggable", "false")
    });

    cards.forEach((card) => {
        console.log(card)
        card.addEventListener("dragstart", dragStart);
        card.addEventListener("dragend", dragEnd);
    });

    containers.forEach((container) => {
        container.addEventListener("dragover", dragOver);
        container.addEventListener("drop", drop);
    });

    function dragStart(event) {
        event.dataTransfer.setData("draggedCardId", event.target.id);
        setTimeout(() => event.target.classList.toggle("hidden"));
    }

    function dragEnd(event) {
        event.target.classList.toggle("hidden");
    }

    function dragOver(event) {
        event.preventDefault();
    }

    function drop(event) {
        const draggedCardId = event.dataTransfer.getData("draggedCardId");
        const draggedCard = document.getElementById(draggedCardId);
        const fromContainer = draggedCard.parentNode;
        const toContainer = event.currentTarget;

        if (toContainer !== fromContainer) {
            fromContainer.appendChild(toContainer.firstElementChild);
            toContainer.appendChild(draggedCard);
        }
    }
</script>
</body>
</html>
