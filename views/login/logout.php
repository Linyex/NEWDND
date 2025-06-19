<?php
require_once __DIR__ . '/../../engine/security/auth.php';

// Выполняем выход
logout();

// Перенаправляем на главную страницу
header('Location: ../../index.php');
exit; 