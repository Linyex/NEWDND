<?php
session_start();
require_once __DIR__ . '/../../engine/security/auth.php';

$errors = [];

// Проверяем, что пользователь прошел первый этап аутентификации
if (!isset($_SESSION['2fa_user_id']) || !isset($_SESSION['2fa_username'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = trim($_POST['code'] ?? '');
    
    if (strlen($code) !== 6 || !ctype_digit($code)) {
        $errors[] = 'Код должен состоять из 6 цифр.';
    } else {
        if (verify2FACode($_SESSION['2fa_user_id'], $code)) {
            // Получаем данные пользователя
            $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
            $stmt->execute([$_SESSION['2fa_user_id']]);
            $user = $stmt->fetch();
            
            if ($user) {
                // Создаем сессию
                createUserSession($user);
                
                // Очищаем временные данные 2FA
                unset($_SESSION['2fa_user_id']);
                unset($_SESSION['2fa_username']);
                
                // Обновляем время последнего входа
                $stmt = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
                $stmt->execute([$user['id']]);
                
                header('Location: index.php');
                exit;
            }
        } else {
            $errors[] = 'Неверный код подтверждения.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Подтверждение входа — D&D World</title>
    <link rel="stylesheet" href="assets/css/dnd-fantasy.css">
    <style>
        .verify-form {
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
            font-size: 1.2em;
            text-align: center;
            letter-spacing: 0.2em;
        }
        .btn-verify {
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
        .btn-verify:hover {
            background: #fff;
        }
        .error-message {
            color: #ff0000;
            margin-bottom: 1rem;
        }
        .info-text {
            color: #ffd700;
            margin-bottom: 1rem;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="dnd-fantasy-container">
    <h1 class="dnd-fantasy-title">Подтверждение входа</h1>
    
    <?php if ($errors): ?>
        <div class="error-message">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <div class="verify-form">
        <p class="info-text">
            Код подтверждения отправлен на ваш email.<br>
            Пожалуйста, введите его ниже.
        </p>
        
        <form method="post">
            <div class="form-group">
                <label for="code">Код подтверждения:</label>
                <input type="text" id="code" name="code" class="form-control" 
                       required maxlength="6" pattern="\d{6}" 
                       placeholder="000000" autocomplete="off">
            </div>
            
            <button type="submit" class="btn-verify">Подтвердить</button>
        </form>
        
        <p style="text-align: center; margin-top: 1rem;">
            <a href="login.php" style="color: #ffd700;">Вернуться к входу</a>
        </p>
    </div>
</div>

<script>
// Автоматический переход к следующему полю при вводе
document.getElementById('code').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '').substr(0, 6);
});
</script>
</body>
</html> 