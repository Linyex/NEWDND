<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../views/modelviews/header/header.php';
require_once __DIR__ . '/../../engine/account/login_functions.php';

$result = handleLogin();
$errors = $result['errors'];
$success = $result['success'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | D&D World</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Вход в мир D&D</h1>
            
            <?php if ($success): ?>
                <div class="success-message">
                    Вы успешно вошли в систему!
                </div>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $error): ?>
                            <p><?= htmlspecialchars($error) ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">Логин:</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="auth-button">Войти</button>
                </form>

                <div class="auth-links">
                    <a href="/views/login/register.php">Регистрация</a>
                    <a href="/views/login/forgot_password.php">Забыли пароль?</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="/assets/js/auth.js"></script>
</body>
</html> 