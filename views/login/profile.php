<?php
require_once __DIR__ . '/../../engine/account/db.php';

// Проверяем, авторизован ли пользователь
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// Получаем данные пользователя
$stmt = $pdo->prepare("SELECT username, email, total_time FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Если пользователь не найден, перенаправляем на главную
if (!$user) {
    header('Location: /');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/../../views/modelviews/header/header.php'; ?>
    
    <main class="container">
        <h1>Профиль пользователя</h1>
        <div class="profile-info">
            <p><strong>Логин:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p><strong>Почта:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p><strong>Время на сайте:</strong> <span id="realtime-total-time" data-total-time="<?= (int)$user['total_time'] ?>"></span></p>
        </div>
    </main>
    
    <?php include __DIR__ . '/../../views/modelviews/footer/footer.php'; ?>
    <script src="/engine/js/profile_time.js"></script>

<script>
// Получаем начальное значение времени из data-атрибута
let totalMinutes = parseInt(document.getElementById('realtime-total-time').dataset.totalTime) || 0;
let seconds = totalMinutes * 60;
function formatTime(sec) {
    const h = Math.floor(sec / 3600);
    const m = Math.floor((sec % 3600) / 60);
    const s = sec % 60;
    let res = '';
    if (h > 0) res += h + ' ч ';
    if (m > 0 || h > 0) res += m + ' мин ';
    res += s + ' сек';
    return res;
}
function updateTime() {
    seconds++;
    document.getElementById('realtime-total-time').textContent = formatTime(seconds);
}
document.getElementById('realtime-total-time').textContent = formatTime(seconds);
setInterval(updateTime, 1000);
</script>
</body>
</html> 