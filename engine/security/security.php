<?php
/**
 * Безопасный вывод текста (защита от XSS)
 */
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Очистка входных данных
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Установка безопасных заголовков
 */
function setSecurityHeaders() {
    // Защита от кликджекинга
    header('X-Frame-Options: DENY');
    
    // Защита от XSS в старых браузерах
    header('X-XSS-Protection: 1; mode=block');
    
    // Запрет определения MIME-типа
    header('X-Content-Type-Options: nosniff');
    
    // Content Security Policy
    header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:;");
    
    // Referrer Policy
    header('Referrer-Policy: strict-origin-when-cross-origin');
    
    // HSTS (включать только при наличии HTTPS)
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
    }
}

/**
 * Проверка безопасности пароля
 */
function isPasswordSecure($password) {
    // Минимальная длина
    if (strlen($password) < 8) {
        return false;
    }
    
    // Проверка на наличие различных типов символов
    $containsLetter = preg_match('/[a-zA-Z]/', $password);
    $containsDigit = preg_match('/\d/', $password);
    $containsSpecial = preg_match('/[^a-zA-Z\d]/', $password);
    
    return $containsLetter && $containsDigit && $containsSpecial;
}

/**
 * Генерация случайной строки
 */
function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Безопасное сравнение строк
 */
function safeStringCompare($string1, $string2) {
    return hash_equals($string1, $string2);
}

/**
 * Проверка валидности email
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Очистка имени файла
 */
function sanitizeFileName($filename) {
    // Удаляем специальные символы
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    
    // Защита от null byte injection
    $filename = str_replace(chr(0), '', $filename);
    
    return $filename;
}

/**
 * Проверка разрешенных типов файлов
 */
function isAllowedFileType($filename, $allowed_types = ['jpg', 'jpeg', 'png', 'gif']) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($ext, $allowed_types);
}

/**
 * Безопасное перенаправление
 */
function safeRedirect($url) {
    // Проверяем, является ли URL локальным
    if (!preg_match('/^https?:\/\//', $url)) {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . ltrim($url, '/');
    }
    
    // Проверяем домен
    $parsedUrl = parse_url($url);
    if ($parsedUrl === false || !isset($parsedUrl['host']) || 
        $parsedUrl['host'] !== $_SERVER['HTTP_HOST']) {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/';
    }
    
    header('Location: ' . $url);
    exit;
}

/**
 * Защита от SQL-инъекций для динамических запросов
 */
function buildSafeQuery($base_query, $conditions = [], $params = []) {
    $where_clauses = [];
    $safe_params = [];
    
    foreach ($conditions as $field => $value) {
        $where_clauses[] = "$field = ?";
        $safe_params[] = $value;
    }
    
    $where_string = empty($where_clauses) ? '' : ' WHERE ' . implode(' AND ', $where_clauses);
    
    return [
        'query' => $base_query . $where_string,
        'params' => array_merge($params, $safe_params)
    ];
}

/**
 * Логирование попыток взлома
 */
function logSecurityEvent($event_type, $details = []) {
    $log_data = [
        'timestamp' => date('Y-m-d H:i:s'),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'event_type' => $event_type,
        'details' => json_encode($details)
    ];
    
    // Здесь можно реализовать сохранение в базу данных или файл
    error_log(implode('|', $log_data));
}

// Устанавливаем безопасные заголовки по умолчанию
setSecurityHeaders(); 