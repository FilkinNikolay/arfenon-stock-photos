<?php
header("Content-Type: application/json");

$host = 'localhost'; 
$db   = 'lab4'; 
$user = 'root'; 
$pass = ''; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Ошибка подключения к базе данных"]);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['suggestion'])) {
    $suggestion = $data['suggestion'];

    $stmt = $pdo->prepare("INSERT INTO suggestions (suggestion) VALUES (:suggestion)");
    $stmt->execute(['suggestion' => $suggestion]);

    echo json_encode(["success" => true, "message" => "Спасибо за ваше предложение!"]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Некорректные данные."]);
}
?>