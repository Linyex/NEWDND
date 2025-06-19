<?php
// Подключение к базе данных DND через PDO
$host = 'localhost';
$db   = 'DND';
$user = 'root'; // замените на своего пользователя, если не root
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
} catch (PDOException $e) {
    exit('Ошибка подключения к базе данных: ' . $e->getMessage());
} 