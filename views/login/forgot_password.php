<?php
session_start();
require_once __DIR__ . '/includes/auth.php';

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $captcha = $_POST['captcha'] ?? '';
    
    // Проверка капчи
    if (!checkCaptcha($captcha)) {
        $errors[] = 'Неверно введена капча.';
    }
    
    // Проверка email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Некорректный email.';
    }
    
    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT id, username FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Генерируем токен для сброса пароля
            $token = generateToken();
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $stmt = $pdo->prepare('UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE id = ?');
            $stmt->execute([$token, $expires, $user['id']]);
            
            // Отправляем письмо
            $reset_link = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/reset_password.php?token=$token";
            $subject = "Восстановление пароля на D&D World";
            $message = "Здравствуйте!\n\n";
            $message .= "Вы запросили восстановление пароля на сайте D&D World.\n\n";
            $message .= "Для сброса пароля перейдите по ссылке: $reset_link\n\n";
            $message .= "Ссылка действительна в течение 1 часа.\n\n";
            $message .= "Если вы не запрашивали восстановление пароля, просто проигнорируйте это письмо.";
            $headers = "From: no-reply@" . $_SERVER['HTTP_HOST'];
            
            if (mail($email, $subject, $message, $headers)) {
                $success = true;
            } else {
                $errors[] = 'Ошибка отправки письма. Пожалуйста, попробуйте позже.';
            }
        } else {
            // Для безопасности не сообщаем, что email не найден
            $success = true;
        }
    }
}

// Генерируем новую капчу
$captcha_image = generateImageCaptcha();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Восстановление пароля — D&D World</title>
    <link rel="stylesheet" href="assets/css/dnd-fantasy.css">
    <style>
        .recovery-form {
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
        .btn-recovery {
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
        .btn-recovery:hover {
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
    <h1 class="dnd-fantasy-title">Восстановление пароля</h1>
    
    <?php if ($success): ?>
        <div class="recovery-form">
            <div class="success-message">
                <p>Инструкции по восстановлению пароля отправлены на указанный email.</p>
                <p>Пожалуйста, проверьте вашу почту.</p>
            </div>
            <p style="text-align: center;">
                <a href="login.php" style="color: #ffd700;">Вернуться к входу</a>
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
        
        <form method="post" class="recovery-form">
            <p style="color: #ffd700; margin-bottom: 1rem; text-align: center;">
                Введите email, указанный при регистрации.<br>
                Мы отправим вам инструкции по восстановлению пароля.
            </p>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" 
                       required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
            
            <div class="captcha-container">
                <label>Капча:</label>
                <div class="captcha-image">
                    <img src="data:image/png;base64,<?= $captcha_image ?>" alt="Капча">
                </div>
                <input type="text" name="captcha" class="form-control" required 
                       placeholder="Введите символы с картинки">
            </div>
            
            <button type="submit" class="btn-recovery">Восстановить пароль</button>
            
            <p style="text-align: center; margin-top: 1rem;">
                <a href="login.php" style="color: #ffd700;">Вернуться к входу</a>
            </p>
        </form>
    <?php endif; ?>
</div>
</body>
</html> 