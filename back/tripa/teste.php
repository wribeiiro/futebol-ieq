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

function randomizeTeams(array $resultPlayers = [])
{
    $players = [];
    foreach ($resultPlayers as $play) {
        $players[$play['name']] = $play['image'];
    }

    $playerKeys = array_keys($players);

	shuffle($playerKeys);

    $sortedPlayers = [];
    $gks = [];
    foreach ($playerKeys as $player) {
    	if (str_contains($player, ' GK')) {
    		$gks[] = ['name' => $player, 'image' => $players[$player]];
    		continue;
    	}

        $sortedPlayers[] = ['name' => $player, 'image' => $players[$player]];
    }

	$teams = array_chunk($sortedPlayers, ceil(count($sortedPlayers) / 3));

	array_unshift($teams[0], $gks[0]);
	array_unshift($teams[1], $gks[1]);
	array_unshift($teams[2], $gks[random_int(0, 1)]);

    return $teams;
}

$connection = Database::getInstance();
$resultPlayers = $connection->query("SELECT name, image FROM players ORDER BY name ASC")->fetchAll(\PDO::FETCH_ASSOC);
$teams = randomizeTeams($resultPlayers);

[$gkTeamA, $player2TeamA, $player3TeamA, $player4TeamA, $player5TeamA, $player6TeamA] = $teams[0];
[$gkTeamB, $player2TeamB, $player3TeamB, $player4TeamB, $player5TeamB, $player6TeamB] = $teams[1];
[$gkTeamC, $player2TeamC, $player3TeamC, $player4TeamC, $player5TeamC, $player6TeamC] = $teams[2];

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
        /*transform: scale(0.9);*/
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

    .head-team {
        display: flex;
        align-items:center;
        font-size: 22px;
        flex-direction: column;
    }

    .fa-star {
        color: #FDDC54 !important;
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
                                <img src="<?= $player2TeamA['image'] ?>" alt="ata" width="100" height="100">
                                <br>
                                <?= $player2TeamA['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="<?= $player3TeamA['image'] ?>" alt="rf" width="100" height="100">
                                <br>
                                <?= $player3TeamA['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player4TeamA['image'] ?>" alt="mid" width="100" height="100">
                                <br>
                                <?= $player4TeamA['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player5TeamA['image'] ?>" alt="lf" width="100" height="100">
                                <br>
                                <?= $player5TeamA['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player6TeamA['image'] ?>" alt="fix" width="100" height="100">
                                <br>
                                <?= $player6TeamA['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $gkTeamA['image'] ?>" alt="gk" width="100" height="100">
                                <br>
                                <?= $gkTeamA['name'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--
                <h2>BANCO A</h2>
                <div class="subs">
                    <ul>
                        <li>
                            <img src="<?= $player7TeamA['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player7TeamA['name'] ?></p>
                        </li>
                        <li>
                            <img src="<?= $player8TeamA['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player8TeamA['name'] ?></p>
                        </li>
                    </ul>
                </div>
                -->
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
                                <img src="<?= $player2TeamB['image'] ?>" alt="ata" width="100" height="100">
                                <br>
                                <?= $player2TeamB['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player3TeamB['image'] ?>" alt="rf" width="100" height="100">
                                <br>
                                <?= $player3TeamB['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player4TeamB['image'] ?>" alt="mid" width="100" height="100">
                                <br>
                                <?= $player4TeamB['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="<?= $player5TeamB['image'] ?>" alt="lf" width="100" height="100">
                                <br>
                                <?= $player5TeamB['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player6TeamB['image'] ?>" alt="fix" width="100" height="100">
                                <br>
                                <?= $player6TeamB['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $gkTeamB['image'] ?>" alt="gk" width="100" height="100">
                                <br>
                                <?= $gkTeamB['name'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <!--
                <h2>BANCO B</h2>
                <div class="subs">
                    <ul>
                        <li>
                            <img src="<?= $player7TeamB['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player7TeamB['name'] ?></p>
                        </li>
                        <li>
                            <img src="<?= $player8TeamB['image'] ?>" alt="ata" width="100" height="100">
                            <p><?= $player8TeamB['name'] ?></p>
                        </li>
                    </ul>
                </div>
                -->
            </div>

            <div class="col">
                <div class="head-team">
                    <img src="https://www.wribeiiro.com/players/logo192.png" width="60">
                    <span>TEAM C</span>
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
                                <img src="<?= $player2TeamC['image'] ?>" alt="ata" width="100" height="100">
                                <br>
                                <?= $player2TeamC['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player3TeamC['image'] ?>" alt="rf" width="100" height="100">
                                <br>
                                <?= $player3TeamC['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <img src="<?= $player4TeamC['image'] ?>" alt="mid" width="100" height="100">
                                <br>
                                <?= $player4TeamC['name'] ?>
                            </td>
                            <td>
                                <img src="<?= $player5TeamC['image'] ?>" alt="lf" width="100" height="100">
                                <br>
                                <?= $player5TeamC['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $player6TeamC['image'] ?>" alt="fix" width="100" height="100">
                                <br>
                                <?= $player6TeamC['name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <img src="<?= $gkTeamC['image'] ?>" alt="gk" width="100" height="100">
                                <br>
                                <?= $gkTeamC['name'] ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
