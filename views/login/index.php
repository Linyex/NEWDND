<?php
session_start();
require_once __DIR__ . '/../../engine/security/auth.php';

$errors = [];
$success = false;

// Если пользователь уже авторизован, перенаправляем на главную
if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

// Генерация капчи
//$captcha_image = generateCaptcha();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $captcha = $_POST['captcha'] ?? '';

    // Проверка капчи
    if (!checkCaptcha($captcha)) {
        $errors[] = 'Неверно введена капча.';
    }

    // Проверка попыток входа
    if (!checkLoginAttempts($username)) {
        $errors[] = 'Слишком много попыток входа. Попробуйте позже.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            if ($user['is_blocked']) {
                $errors[] = 'Аккаунт заблокирован.';
            } elseif (!$user['is_confirmed']) {
                $errors[] = 'Аккаунт не подтвержден. Проверьте email.';
            } else {
                // Успешный вход
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                
                // Обновление времени последнего входа
                $stmt = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
                $stmt->execute([$user['id']]);
                
                // Запись в историю входов
                $stmt = $pdo->prepare('INSERT INTO login_history (user_id, ip_address, user_agent) VALUES (?, ?, ?)');
                $stmt->execute([$user['id'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']]);
                
                // Сброс попыток входа
                updateLoginAttempts($username, true);
                
                header('Location: /index.php');
                exit;
            }
        } else {
            $errors[] = 'Неверное имя пользователя или пароль.';
            updateLoginAttempts($username);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход в D&D World</title>
    <link rel="stylesheet" href="assets/css/auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Форма входа -->
                <form action="index.php" method="POST" class="sign-in-form">
                    <h2 class="title">Вход</h2>
                    <?php if ($errors): ?>
                        <div class="error-message">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Имя пользователя" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Пароль" required />
                    </div>
                    <div class="captcha-container">
                        <div class="captcha-image">
                            <img src="data:image/png;base64,<?= $captcha_image ?>" alt="Капча">
                        </div>
                        <div class="input-field">
                            <i class="fas fa-shield-alt"></i>
                            <input type="text" name="captcha" placeholder="Введите символы с картинки" required />
                        </div>
                    </div>
                    <input type="submit" value="Войти" class="btn solid" />
                    
                    <div class="links">
                        <a href="register.php">Регистрация</a> |
                        <a href="forgot_password.php">Забыли пароль?</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Новичок в D&D World?</h3>
                    <p>Присоединяйтесь к нашему сообществу и откройте для себя удивительный мир D&D!</p>
                    <a href="register.php" class="btn transparent">Регистрация</a>
                </div>
                <img src="assets/images/login.png" class="image" alt="Вход" />
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html> 