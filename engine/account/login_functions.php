<?php
require_once __DIR__ . '/../security/auth.php';
require_once __DIR__ . '/db.php';

function handleLogin() {
    global $pdo;
    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Проверка попыток входа
        if (!checkLoginAttempts($username)) {
            $errors[] = 'Слишком много попыток входа. Попробуйте позже.';
        }
        
        if (empty($errors)) {
            $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND is_blocked = 0');
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password_hash'])) {
                // Закомментирована проверка подтверждения email
                /*if (!isConfirmed($user)) {
                    $errors[] = 'Пожалуйста, подтвердите ваш email перед входом.';
                } else {*/
                    // Создаем сессию пользователя
                    createUserSession($user);
                    
                    // Генерируем код 2FA
                    $code = generate2FACode();
                    $stmt = $pdo->prepare('INSERT INTO two_factor_codes (user_id, code) VALUES (?, ?)');
                    $stmt->execute([$user['id'], $code]);
                    
                    /* Отправляем код на email
                    if (send2FACode($user['email'], $code)) {
                        $_SESSION['2fa_user_id'] = $user['id'];
                        $_SESSION['2fa_username'] = $user['username'];
                        header('Location: verify_2fa.php');
                        exit;
                    } else {
                        $errors[] = 'Ошибка отправки кода подтверждения.';
                    } */
                //}
                /* Очищаем попытки входа при успешной аутентификации
                updateLoginAttempts($username, true);*/
            } else {
                // Увеличиваем счетчик попыток
                updateLoginAttempts($username);
                $errors[] = 'Неверное имя пользователя или пароль.';
            }
        }
    }

    return [
        'errors' => $errors,
        'success' => $success,
    ];
} 