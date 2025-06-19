<?php
require_once __DIR__ . '/../../engine/account/register_functions.php';

$result = handleRegistration();
$errors = $result['errors'];
$success = $result['success'];
$captcha_image = $result['captcha_image'];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | D&D World</title>
    <link rel="stylesheet" href="/assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Регистрация в мире D&D</h1>
            
            <?php if ($success): ?>
                <div class="success-message">
                    Регистрация успешна! Теперь вы можете войти в систему.
                </div>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $error): ?>
                            <p><?php echo htmlspecialchars($error); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="auth-form">
                    <div class="form-group">
                        <label for="username">Логин:</label>
                        <input type="text" id="username" name="username" required>
                        <div id="username-status"></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Пароль:</label>
                        <input type="password" id="password" name="password" required>
                        <div class="password-requirements">
                            Пароль должен быть не менее 6 символов
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Подтверждение пароля:</label>
                        <input type="password" id="password_confirm" name="password_confirm" required>
                    </div>

                    <button type="submit" class="auth-button">Зарегистрироваться</button>
                </form>

                <div class="auth-links">
                    <a href="login.php">Уже есть аккаунт? Войти</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.getElementById('username').addEventListener('input', function() {
        const username = this.value.trim();
        const statusDiv = document.getElementById('username-status');
        
        if (username.length < 3) {
            statusDiv.textContent = 'Логин должен быть не менее 3 символов';
            statusDiv.className = 'error';
            return;
        }
        
        fetch('check_username.php?username=' + encodeURIComponent(username))
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    statusDiv.textContent = data.error;
                    statusDiv.className = 'error';
                } else if (data.available) {
                    statusDiv.textContent = 'Логин доступен';
                    statusDiv.className = 'success';
                } else {
                    statusDiv.textContent = 'Логин уже занят';
                    statusDiv.className = 'error';
                }
            })
            .catch(error => {
                statusDiv.textContent = 'Ошибка проверки логина';
                statusDiv.className = 'error';
            });
    });
    </script>
    <script src="/assets/js/auth.js"></script>
</body>
</html> 