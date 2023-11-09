<?php

use Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

function baseMigration(): void
{
    $currentYear = date('Y');
    $currentMonth = match (date('m')) {
        '1' => 'JANEIRO',
        '2' => 'FEVEREIRO',
        '3' => 'MARÇO',
        '4' => 'ABRIL',
        '5' => 'MAIO',
        '6' => 'JUNHO',
        '7' => 'JULHO',
        '8' => 'AGOSTO',
        '9' => 'SETEMBRO',
        '10' => 'OUTUBRO',
        '11' => 'NOVEMBRO',
        '12' => 'DEZEMBRO',
    };

    try {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};port={$_ENV['DB_PORT']}";
        $pdo = new \PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $insertHeader = "INSERT INTO payment (name, status, amount, month, image) VALUES ";
        $insertBody = [];

        foreach ([
            'ANDRÉ',
            'BENJAMIM',
            'CASSIANO',
            'CLEFERSON',
            'DANIEL',
            'DE GEA',
            'FÁBIO',
            'JULIO',
            'LEANDRO',
            'LIPSZERA',
            'LUCIANO',
            'PASTOR',
            'PAULINHO',
            'REGINALDO',
            'RENAN',
            'WALLACE',
            'WELL'
        ] as $value) {
            $date = $currentMonth . '/' . $currentYear;
            $image = 'https://www.wribeiiro.com/' . (in_array($value, ['CASSIANO', 'CLEFERSON', 'DE GEA'])
                ? 'cassio.jpg'
                : 'cr7.jpg');

            $insertBody[] = "('{$value}', 'NÃO PAGO', '40', '{$date}', '{$image}')";
        }

        $pdo->query($insertHeader . implode(',', $insertBody));

        echo json_encode(['status' => 200, 'data' => [], 'message' => '(BASE MIGRATION) DEU BEYBLADE']);
        die;
    } catch (\Exception $e) {
        die($e->getMessage() . PHP_EOL . '(BASE MIGRATION) Deu ruim chama o léo!');
    }
}

function fetchAll(string $month): array
{
    try {
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};port={$_ENV['DB_PORT']}";
        $pdo = new \PDO($dsn, $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $pdo->prepare("SELECT * FROM payment WHERE MONTH = :month ORDER BY NAME ASC");
        $statement->execute([':month' => $month]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception) {
        return [];
    }
}

header('Access-Control-Allow-Origin: https://www.wribeiiro.com');
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header('Content-Type: application/json; charset=utf-8');

$requestRange = filter_input(INPUT_GET, 'month', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$migrate = filter_input(INPUT_GET, 'migrate', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if ($migrate) {
    baseMigration();
}

if (empty($requestRange)) {
    echo json_encode(['status' => 403, 'data' => [], 'message' => 'FORBIDDEN']);
    die;
}

echo json_encode(['status' => 200, 'data' => fetchAll($requestRange) ?? [], 'message' => 'SUCCESS']);
