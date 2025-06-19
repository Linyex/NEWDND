<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /views/login/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создать лист персонажа</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/views/characters/assets/character.css">
    <style>
        body {
            position: relative;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        #background-video {
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
        
        .container {
            position: relative;
            z-index: 1;
            background: none !important;
            border-radius: 0 !important;
            padding: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            color: #fff;
        }
        
        h1, label, select, input, option {
            color: #fff !important;
            text-shadow: 1px 1px 4px #000;
        }
        
        .character-form {
            background: none !important;
            border-radius: 0 !important;
            padding: 2rem;
            box-shadow: none !important;
            backdrop-filter: none !important;
        }
        
        select, input {
            background: rgba(0,0,0,0.3) !important;
            border: 1px solid #fff;
        }
        
        .form-group {
            background: none !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>
</head>
<body>
    <video id="background-video" autoplay muted loop>
        <source src="/assets/mp4/night_netural.mp4" type="video/mp4">
    </video>
    
    <?php include __DIR__ . '/../modelviews/header/header.php'; ?>
    
    <main class="container">
        <h1>Создать лист персонажа</h1>
        <form id="system-form" class="character-form">
            <div class="form-group">
                <label for="system-select">Система:</label>
                <select id="system-select" required>
                    <option value="">Выберите...</option>
                    <option value="dnd">Dungeons & Dragons</option>
                    <option value="vtm">Vampire: The Masquerade</option>
                    <option value="cthulhu">Call of Cthulhu</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="edition-select">Редакция:</label>
                <select id="edition-select" required disabled>
                    <option value="">Сначала выберите систему</option>
                </select>
            </div>
        </form>
        
        <div id="character-form-container"></div>
    </main>

    <script src="/views/characters/assets/character.js"></script>
</body>
</html> 