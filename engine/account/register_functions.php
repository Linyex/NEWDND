<?php
require_once __DIR__ . '/../security/auth.php';
require_once __DIR__ . '/db.php';

function handleRegistration() {
    global $pdo;
    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        // Валидация
        if (mb_strlen($username) < 3 || mb_strlen($username) > 32) {
            $errors[] = 'Логин должен быть от 3 до 32 символов.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Некорректный email.';
        }
        
        // Упрощенная проверка пароля
        if (mb_strlen($password) < 6) {
            $errors[] = 'Пароль должен быть не менее 6 символов.';
        }
        
        // Проверка совпадения паролей
        if ($password !== $password_confirm) {
            $errors[] = 'Пароли не совпадают.';
        }

        // Проверка уникальности
        if (empty($errors)) {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ? OR email = ?');
            $stmt->execute([$username, $email]);
            if ($stmt->fetch()) {
                $errors[] = 'Пользователь с таким логином или email уже существует.';
            }
        }

        // Регистрация
        if (empty($errors)) {
            $password_hash = hashPassword($password);
            $token = generateToken();
            
            // Закомментирована отправка письма подтверждения
            /*$stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, is_confirmed, confirm_token) 
                                  VALUES (?, ?, ?, 0, ?)');
            
            if ($stmt->execute([$username, $email, $password_hash, $token])) {
                // Отправка письма
                $confirm_link = "http://" . $_SERVER['HTTP_HOST'] . "/views/login/activate.php?token=$token";
                $subject = "Подтверждение регистрации на D&D World";
                $message = "Здравствуйте!\n\n";
                $message .= "Благодарим за регистрацию на сайте D&D World.\n\n";
                $message .= "Для подтверждения регистрации перейдите по ссылке:\n$confirm_link\n\n";
                $message .= "Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.\n\n";
                $message .= "С уважением,\nКоманда D&D World";
                
                $headers = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8";
                
                if (mail($email, $subject, $message, $headers)) {
                    $success = true;
                } else {
                    $errors[] = 'Ошибка отправки письма. Пожалуйста, попробуйте позже.';
                }
            } else {
                $errors[] = 'Ошибка при регистрации. Пожалуйста, попробуйте позже.';
            }*/

            // Новая версия без подтверждения email
            $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash, is_confirmed) 
                                  VALUES (?, ?, ?, 1)');
            
            if ($stmt->execute([$username, $email, $password_hash])) {
                $success = true;
            } else {
                $errors[] = 'Ошибка при регистрации. Пожалуйста, попробуйте позже.';
            }
        }
    }

    return [
        'errors' => $errors,
        'success' => $success,
    ];
} 