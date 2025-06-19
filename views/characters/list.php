<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /views/login/login.php');
    exit;
}

require_once __DIR__ . '/../../engine/account/db.php';

// Получаем список персонажей пользователя
$stmt = $pdo->prepare("SELECT * FROM character_sheets WHERE user_id = ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['user_id']]);
$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои персонажи</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/views/characters/assets/character.css">
</head>
<body>
    <?php include __DIR__ . '/../modelviews/header/header.php'; ?>
    
    <main class="container">
        <h1>Мои персонажи</h1>
        
        <a href="/views/characters/create.php" class="btn btn-primary">Создать нового персонажа</a>
        
        <div class="character-list">
            <?php if (empty($characters)): ?>
                <p>У вас пока нет созданных персонажей.</p>
            <?php else: ?>
                <?php foreach ($characters as $char): ?>
                    <?php $data = json_decode($char['data'], true); ?>
                    <div class="character-card">
                        <h3><?= htmlspecialchars($data['name'] ?? 'Без имени') ?></h3>
                        <p class="system-info">
                            <?= htmlspecialchars(ucfirst($char['game_system'])) ?> 
                            <?= htmlspecialchars($char['game_edition']) ?>
                        </p>
                        <div class="character-details">
                            <?php if ($char['game_system'] === 'dnd'): ?>
                                <p>Класс: <?= htmlspecialchars($data['class'] ?? 'Не указан') ?></p>
                                <p>Раса: <?= htmlspecialchars($data['race'] ?? 'Не указана') ?></p>
                            <?php elseif ($char['game_system'] === 'vtm'): ?>
                                <p>Клан: <?= htmlspecialchars($data['clan'] ?? 'Не указан') ?></p>
                                <p>Поколение: <?= htmlspecialchars($data['generation'] ?? 'Не указано') ?></p>
                            <?php elseif ($char['game_system'] === 'cthulhu'): ?>
                                <p>Профессия: <?= htmlspecialchars($data['occupation'] ?? 'Не указана') ?></p>
                                <p>Рассудок: <?= htmlspecialchars($data['sanity'] ?? 'Не указан') ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="character-actions">
                            <a href="/views/characters/edit.php?id=<?= $char['id'] ?>" class="btn btn-secondary">Редактировать</a>
                            <button onclick="deleteCharacter(<?= $char['id'] ?>)" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

    <script>
    function deleteCharacter(id) {
        if (confirm('Вы уверены, что хотите удалить этого персонажа?')) {
            fetch('/engine/characters/delete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ id: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Ошибка: ' + (data.error || 'Неизвестная ошибка'));
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при удалении персонажа');
            });
        }
    }
    </script>
</body>
</html> 