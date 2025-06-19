<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

$errors = [];
$success = false;
$token = $_GET['token'] ?? '';

// Проверяем токен
if (empty($token)) {
    header('Location: login.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE reset_token = ? AND reset_token_expires > NOW() AND is_blocked = 0');
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    $errors[] = 'Недействительная или устаревшая ссылка для сброса пароля.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $captcha = $_POST['captcha'] ?? '';
    
    // Проверка капчи
    if (!checkCaptcha($captcha)) {
        $errors[] = 'Неверно введена капча.';
    }
    
    // Проверка паролей
    if ($password !== $password_confirm) {
        $errors[] = 'Пароли не совпадают.';
    }
    
    // Проверка сложности пароля
    $password_check = checkPasswordStrength($password);
    if (!$password_check['valid']) {
        $errors[] = $password_check['message'];
    }
    
    if (empty($errors)) {
        // Хэшируем новый пароль
        $password_hash = hashPassword($password);
        
        // Обновляем пароль и очищаем токен
        $stmt = $pdo->prepare('UPDATE users SET 
            password_hash = ?, 
            reset_token = NULL, 
            reset_token_expires = NULL 
            WHERE id = ?');
        $stmt->execute([$password_hash, $user['id']]);
        
        // Очищаем все сессии пользователя
        $stmt = $pdo->prepare('DELETE FROM user_sessions WHERE user_id = ?');
        $stmt->execute([$user['id']]);
        
        $success = true;
    }
}

// Генерируем новую капчу
$captcha_image = generateImageCaptcha();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Сброс пароля — D&D World</title>
    <link rel="stylesheet" href="assets/css/dnd-fantasy.css">
    <style>
        .reset-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 2rem;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 5px;
            border: 1px solid #ffd700;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-control {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.25rem;
            border: 1px solid #ccc;
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.9);
        }
        .btn-reset {
            width: 100%;
            padding: 0.75rem;
            background: #ffd700;
            color: #000;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-reset:hover {
            background: #fff;
        }
        .error-message {
            color: #ff0000;
            margin-bottom: 1rem;
        }
        .success-message {
            color: #00ff00;
            margin-bottom: 1rem;
            text-align: center;
        }
        .password-requirements {
            color: #ffd700;
            font-size: 0.9em;
            margin-top: 0.5rem;
        }
        .captcha-container {
            margin: 1rem 0;
        }
        .captcha-image {
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
<div class="dnd-fantasy-container">
    <h1 class="dnd-fantasy-title">Сброс пароля</h1>
    
    <?php if ($success): ?>
        <div class="reset-form">
            <div class="success-message">
                <p>Пароль успешно изменен!</p>
                <p>Теперь вы можете войти в систему, используя новый пароль.</p>
            </div>
            <p style="text-align: center;">
                <a href="login.php" style="color: #ffd700;">Перейти к входу</a>
            </p>
        </div>
    <?php elseif ($errors && !isset($errors[0])): ?>
        <div class="reset-form">
            <div class="error-message">
                <p><?= htmlspecialchars($errors[0]) ?></p>
            </div>
            <p style="text-align: center;">
                <a href="forgot_password.php" style="color: #ffd700;">Запросить новую ссылку</a>
            </p>
        </div>
    <?php else: ?>
        <?php if ($errors): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="post" class="reset-form">
            <div class="form-group">
                <label for="password">Новый пароль:</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="password-requirements">
                    Пароль должен содержать:<br>
                    - Минимум 8 символов<br>
                    - Заглавные и строчные буквы<br>
                    - Цифры<br>
                    - Специальные символы
                </div>
            </div>
            
            <div class="form-group">
                <label for="password_confirm">Подтвердите пароль:</label>
                <input type="password" id="password_confirm" name="password_confirm" 
                       class="form-control" required>
            </div>
            
            <div class="captcha-container">
                <label>Капча:</label>
                <div class="captcha-image">
                    <img src="data:image/png;base64,<?= $captcha_image ?>" alt="Капча">
                </div>
                <input type="text" name="captcha" class="form-control" required 
                       placeholder="Введите символы с картинки">
            </div>
            
            <button type="submit" class="btn-reset">Сохранить новый пароль</button>
        </form>
    <?php endif; ?>
</div>

<script>
// Проверка совпадения паролей в реальном времени
document.getElementById('password_confirm').addEventListener('input', function() {
    var password = document.getElementById('password').value;
    var confirm = this.value;
    
    if (password !== confirm) {
        this.setCustomValidity('Пароли не совпадают');
    } else {
        this.setCustomValidity('');
    }
});
</script>
</body>
</html> 