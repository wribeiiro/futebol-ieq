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

	$teams = array_chunk($sortedPlayers, ceil(count($sortedPlayers) / 2));

	array_unshift($teams[0], $gks[0]);
	array_unshift($teams[1], $gks[1]);

    return $teams;
}

$connection = Database::getInstance();
$resultPlayers = $connection->query("SELECT name, image FROM players ORDER BY name ASC")->fetchAll(\PDO::FETCH_ASSOC);
$teams = randomizeTeams($resultPlayers);

[$gkTeamA, $player2TeamA, $player3TeamA, $player4TeamA, $player5TeamA, $player6TeamA, $player7TeamA, $player8TeamA, $player9TeamA] = $teams[0];
[$gkTeamB, $player2TeamB, $player3TeamB, $player4TeamB, $player5TeamB, $player6TeamB, $player7TeamB, $player8TeamB] = $teams[1];
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
    }

    h2 {
        text-align: center;
        margin-bottom: 5px;
    }

    .container {
        display: flex;
        align-items: center;
        justify-content: space-around;
        align-content: center;
        flex-wrap: wrap;
    }

    .item {
        width: 100%;
        flex: 1;
        margin-left: 5px;
        margin-right: 5px;
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

    .badge {
        background-color: #29AE54;
        color: white;
        padding: 4px 8px;
        text-align: center;
        border-radius: 5px;
        text-shadow: none !important;
    }

    .subs {
        background: rgba(0, 0, 0, 0.6);
        width: 100%;
        border-top-left-radius: 20px;
        border-top-right-radius: 20px;
        padding-top: 20px;
    }

    .mt-4 {
        margin-top: 4px;
    }
    </style>
</head>
<body>
    <button type="button" onclick="window.location.reload()">Gerar equipes</button>

    <div class="container">
        <div class="item">
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
                            <div><span class="badge"><?= $player2TeamA['name'] ?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?= $player3TeamA['image'] ?>" alt="rf" width="100" height="100">
                            <div><span class="badge"><?= $player3TeamA['name'] ?></span></div>
                        </td>
                        <td>
                            <img src="<?= $player4TeamA['image'] ?>" alt="mid" width="100" height="100">
                            <div><span class="badge"><?= $player4TeamA['name'] ?></span></div>
                        </td>
                        <td>
                            <img src="<?= $player5TeamA['image'] ?>" alt="lf" width="100" height="100">
                            <div><span class="badge"><?= $player5TeamA['name'] ?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img src="<?= $player6TeamA['image'] ?>" alt="fix" width="100" height="100">
                            <div><span class="badge"><?= $player6TeamA['name'] ?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img src="<?= $gkTeamA['image'] ?>" alt="gk" width="100" height="100">
                            <div><span class="badge"><?= $gkTeamA['name'] ?></span></div>
                        </td>
                    </tr>
                </table>
            </div>

            <h2>BANCO A</h2>
            <div class="subs">
                <ul>
                    <li>
                        <img src="<?= $player7TeamA['image'] ?>" alt="ata" width="100" height="100">
                        <div class="mt-4"><span class="badge"><?= $player7TeamA['name'] ?></span></div>
                    </li>
                    <li>
                        <img src="<?= $player8TeamA['image'] ?>" alt="ata" width="100" height="100">
                        <div class="mt-4"><span class="badge"><?= $player8TeamA['name'] ?></span></div>
                    </li>
                    <li>
                        <img src="<?= $player9TeamA['image'] ?>" alt="ata" width="100" height="100">
                        <div class="mt-4"><span class="badge"><?= $player9TeamA['name'] ?></span></div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="item">
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
                            <div><span class="badge"><?= $player9TeamA['name'] ?></span></div>
                        </td>
                        <td>
                            <img src="<?= $player3TeamB['image'] ?>" alt="rf" width="100" height="100">
                            <div><span class="badge"><?= $player3TeamB['name'] ?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img src="<?= $player4TeamB['image'] ?>" alt="mid" width="100" height="100">
                            <div><span class="badge"><?= $player4TeamB['name'] ?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <img src="<?= $player5TeamB['image'] ?>" alt="lf" width="100" height="100">
                            <div><span class="badge"><?= $player5TeamB['name'] ?></span></div>
                        </td>
                        <td>
                            <img src="<?= $player6TeamB['image'] ?>" alt="fix" width="100" height="100">
                            <div><span class="badge"><?= $player6TeamB['name'] ?></span></div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <img src="<?= $gkTeamB['image'] ?>" alt="gk" width="100" height="100">
                            <div><span class="badge"><?= $gkTeamB['name'] ?></span></div>
                        </td>
                    </tr>
                </table>
            </div>
            <h2>BANCO B</h2>
            <div class="subs">
                <ul>
                    <li>
                        <img src="<?= $player7TeamB['image'] ?>" alt="ata" width="100" height="100">
                        <div class="mt-4"><span class="badge"><?= $player7TeamB['name'] ?></span></div>
                    </li>
                    <li>
                        <img src="<?= $player8TeamB['image'] ?>" alt="ata" width="100" height="100">
                        <div class="mt-4"><span class="badge"><?= $player8TeamB['name'] ?></span></div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
