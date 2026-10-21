<?php
header("Content-Type: application/json");

$host = 'localhost'; // Изменено с 'MySQL-5.7' на 'localhost' для универсальности
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

if (isset($data['username']) && isset($data['password'])) {
    $username = $data['username'];
    $password = $data['password'];

    // Безопасное хеширование пароля перед записью в БД
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Запись в базу данных
    $stmt = $pdo->prepare("INSERT INTO logins (username, password) VALUES (:username, :password)");
    $stmt->execute(['username' => $username, 'password' => $hashedPassword]);

    echo json_encode(["success" => true, "message" => "Данные успешно сохранены."]);
} else {
    http_response_code(400);
    echo json_encode(["error" => "Некорректные данные."]);
}
?>