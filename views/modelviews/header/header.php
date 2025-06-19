<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D&D World - Мир настольных игр </title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/animation.css">
    <style>
        .video-background {
            position: fixed;
            right: 0;
            bottom: 0;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: -1;
            object-fit: cover;
        }
        .main-content {
            position: relative;
            z-index: 1;
            background: rgba(0, 0, 0, 0.7);
            color: white;
        }
        .main-nav {
            position: relative;
            z-index: 2;
            background: rgba(0, 0, 0, 0.8);
        }
        .main-footer {
            position: relative;
            z-index: 2;
            background: rgba(0, 0, 0, 0.8);
            color: white;
        }
    </style>
</head>
<body>
    <nav class="main-nav">
        <div class="nav-container">
            <a href="../../index.php" class="nav-brand">D&D World</a>
            <button class="nav-toggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="nav-menu">
                <a href="../../index.php" class="nav-link active">Главная</a>
                <div class="nav-link nav-dropdown">
                    Игровые миры
                    <div class="dropdown-content">
                        <a href="../../views/worlds/dnd/index.php">Dungeons & Dragons</a>
                        <a href="../../views/worlds/vtm/index.php">Vampire: The Masquerade</a>
                        <a href="../../views/worlds/coc/index.php">Call of Cthulhu</a>
                    </div>
                </div>
                <a href="/views/characters/create.php" class="nav-link">Создание персонажей</a>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="/views/login/profile.php" class="nav-link"><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                    <a href="/views/login/logout.php" class="nav-link">Выйти</a>
                <?php else: ?>
                    <a href="/views/login/login.php" class="nav-link">Войти</a>
                    <a href="/views/login/register.php" class="nav-link">Регистрация</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <script src="/engine/js/track_time.js"></script>
</body>
</html> 