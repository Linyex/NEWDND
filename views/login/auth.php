<?php
require_once __DIR__ . '/../../engine/security/auth.php';

// Если пользователь не авторизован, перенаправляем на страницу входа
if (!isset($_SESSION['user_id'])) {
    header('Location: /views/login/login.php');
    exit;
}

// Проверка активности сессии
if (!checkSession()) {
    logout();
    header('Location: /views/login/login.php');
    exit;
}

// Обновление времени последней активности
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&D World - Вход</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <!-- Форма входа -->
                <form action="login.php" method="POST" class="sign-in-form">
                    <h2 class="title">Вход</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Имя пользователя" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Пароль" required />
                    </div>
                    <input type="submit" value="Войти" class="btn solid" />
                    <a href="forgot_password.php" class="forgot-password">Забыли пароль?</a>
                </form>

                <!-- Форма регистрации -->
                <form action="register.php" method="POST" class="sign-up-form">
                    <h2 class="title">Регистрация</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" name="username" placeholder="Имя пользователя" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Пароль" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" placeholder="Подтвердите пароль" required />
                    </div>
                    <input type="submit" value="Зарегистрироваться" class="btn solid" />
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Новичок в D&D World?</h3>
                    <p>Присоединяйтесь к нашему сообществу и откройте для себя удивительный мир D&D!</p>
                    <button class="btn transparent" id="sign-up-btn">Регистрация</button>
                </div>
                <img src="assets/images/login/reg.png" class="image" alt="Регистрация" />
            </div>

            <div class="panel right-panel">
                <div class="content">
                    <h3>Уже с нами?</h3>
                    <p>Войдите в свой аккаунт и продолжите приключение!</p>
                    <button class="btn transparent" id="sign-in-btn">Вход</button>
                </div>
                <img src="assets/images/login/aut.png" class="image" alt="Авторизация" />
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <script src="assets/js/auth.js"></script>
</body>
</html> 