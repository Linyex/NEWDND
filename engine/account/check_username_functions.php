<?php
require_once __DIR__ . '/../security/auth.php';
require_once __DIR__ . '/db.php';

function checkUsernameAvailability() {
    global $pdo;
    $response = ['available' => false, 'error' => null];
    
    if (!isset($_GET['username'])) {
        $response['error'] = 'Не указано имя пользователя';
        return $response;
    }
    
    $username = trim($_GET['username']);
    
    if (mb_strlen($username) < 3 || mb_strlen($username) > 32) {
        $response['error'] = 'Имя пользователя должно быть от 3 до 32 символов';
        return $response;
    }
    
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute([$username]);
    
    $response['available'] = !$stmt->fetch();
    return $response;
} 