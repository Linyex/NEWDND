<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('HTTP/1.1 403 Forbidden');
    exit('Не авторизован');
}

$system = $_GET['system'] ?? '';
$edition = $_GET['edition'] ?? '';

$map = [
    'dnd' => ['5e' => 'dnd_5e.php'],
    'vtm' => ['3e' => 'vtm_3e.php'],
    'cthulhu' => ['7e' => 'cthulhu_7e.php']
];

if (isset($map[$system][$edition])) {
    include __DIR__ . '/../../views/characters/forms/' . $map[$system][$edition];
} else {
    echo '<div class="error">Форма не найдена</div>';
} 