<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

$errors = [];
$success = false;
$token = $_GET['token'] ?? '';

if (empty($token)) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE confirm_token = ? AND is_confirmed = 0 AND is_blocked = 0');
$stmt->execute([$token]);
$user = $stmt->fetch();

if ($user) {
    // Активируем аккаунт
    $stmt = $pdo->prepare('UPDATE users SET is_confirmed = 1, confirm_token = NULL WHERE id = ?');
    if ($stmt->execute([$user['id']])) {
        $success = true;
    } else {
        $errors[] = 'Произошла ошибка при активации аккаунта.';
    }
} else {
    $errors[] = 'Недействительная или устаревшая ссылка для активации.';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Активация аккаунта — D&D World</title>
    <link rel="stylesheet" href="assets/css/dnd-fantasy.css">
    <style>
        .activation-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 5px;
            border: 1px solid #ffd700;
            text-align: center;
        }
        .success-message {
            color: #00ff00;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #ff0000;
            margin-bottom: 1rem;
        }
        .activation-link {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            background: #ffd700;
            color: #000;
            text-decoration: none;
            border-radius: 3px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .activation-link:hover {
            background: #fff;
        }
    </style>
</head>
<body>
<div class="dnd-fantasy-container">
    <h1 class="dnd-fantasy-title">Активация аккаунта</h1>
    
    <div class="activation-container">
        <?php if ($success): ?>
            <div class="success-message">
                <p>Ваш аккаунт успешно активирован!</p>
                <p>Теперь вы можете войти в систему.</p>
            </div>
            <a href="login.php" class="activation-link">Перейти к входу</a>
        <?php else: ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
            <a href="register.php" class="activation-link">Вернуться к регистрации</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html> 