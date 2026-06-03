<?php

$host = 'localhost';
$dbname = 'cinema_booking';
$username = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
// ВРЕМЕННЫЙ КОД ДЛЯ ПРОВЕРКИ
echo "<h3>Подключение к базе данных успешно!</h3>";
echo "<p>Хост: " . $host . "</p>";
echo "<p>База данных: " . $dbname . "</p>";
echo "<p>Пользователь: " . $username . "</p>";
