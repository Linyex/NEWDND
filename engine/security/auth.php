<?php
require_once __DIR__ . '/../account/db.php';
require_once __DIR__ . '/security.php';
require_once __DIR__ . '/rate_limit.php';

define('MAX_LOGIN_ATTEMPTS', 5); 
define('LOGIN_TIMEOUT', 900); 
define('PASSWORD_MIN_LENGTH', 8); 
define('TOKEN_LIFETIME', 3600); 
define('SESSION_LIFETIME', 1800); 

function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

function generateImageCaptcha() {
    $code = substr(str_shuffle('23456789ABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 6);
    $_SESSION['captcha_code'] = $code;
    
    $image = imagecreatetruecolor(150, 50);
    $bg = imagecolorallocate($image, 255, 255, 255);
    imagefill($image, 0, 0, $bg);
    
    for($i = 0; $i < 5; $i++) {
        $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imageline($image, rand(0, 150), rand(0, 50), rand(0, 150), rand(0, 50), $color);
    }
    
    for($i = 0; $i < 50; $i++) {
        $color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
        imagesetpixel($image, rand(0, 150), rand(0, 50), $color);
    }
    
    $color = imagecolorallocate($image, 0, 0, 0);
    $font = realpath(__DIR__ . '/../assets/fonts/arial.ttf');
    imagettftext($image, 20, rand(-10, 10), 20, 35, $color, $font, $code);
    
    ob_start();
    imagepng($image);
    $captcha_image = ob_get_clean();
    imagedestroy($image);
    
    return base64_encode($captcha_image);
}

function checkCaptcha($input) {
    return isset($_SESSION['captcha_code']) && 
           strtoupper($input) === $_SESSION['captcha_code'];
}

function checkLoginAttempts($username) {
    global $pdo;
    
    $stmt = $pdo->prepare('SELECT attempts, last_attempt FROM login_attempts WHERE username = ?');
    $stmt->execute([$username]);
    $attempts = $stmt->fetch();
    
    if (!$attempts) {
        return true;
    }
    
    if ($attempts['attempts'] >= MAX_LOGIN_ATTEMPTS && 
        time() - strtotime($attempts['last_attempt']) < LOGIN_TIMEOUT) {
        return false;
    }
    
    if (time() - strtotime($attempts['last_attempt']) > LOGIN_TIMEOUT) {
        $stmt = $pdo->prepare('DELETE FROM login_attempts WHERE username = ?');
        $stmt->execute([$username]);
        return true;
    }
    
    return true;
}

function updateLoginAttempts($username, $success = false) {
    global $pdo;
    
    if ($success) {
        $stmt = $pdo->prepare('DELETE FROM login_attempts WHERE username = ?');
        $stmt->execute([$username]);
        return;
    }
    
    $stmt = $pdo->prepare('INSERT INTO login_attempts (username, attempts, last_attempt) 
                          VALUES (?, 1, NOW()) 
                          ON DUPLICATE KEY UPDATE 
                          attempts = attempts + 1, 
                          last_attempt = NOW()');
    $stmt->execute([$username]);
}

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function checkPasswordStrength($password) {
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        return ['valid' => false, 'message' => 'Пароль должен быть не менее ' . PASSWORD_MIN_LENGTH . ' символов'];
    }
    
    if (!preg_match('/[A-Z]/', $password)) {
        return ['valid' => false, 'message' => 'Пароль должен содержать заглавные буквы'];
    }
    
    if (!preg_match('/[a-z]/', $password)) {
        return ['valid' => false, 'message' => 'Пароль должен содержать строчные буквы'];
    }
    
    if (!preg_match('/[0-9]/', $password)) {
        return ['valid' => false, 'message' => 'Пароль должен содержать цифры'];
    }
    
    if (!preg_match('/[^A-Za-z0-9]/', $password)) {
        return ['valid' => false, 'message' => 'Пароль должен содержать специальные символы'];
    }
    
    return ['valid' => true, 'message' => ''];
}

function generate2FACode() {
    return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
}

function send2FACode($email, $code) {
    $subject = "Код подтверждения D&D World";
    $message = "Ваш код подтверждения: $code\n\nКод действителен в течение 15 минут.";
    $headers = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8";
    return mail($email, $subject, $message, $headers);
}

function verify2FACode($user_id, $code) {
    global $pdo;
    
    $stmt = $pdo->prepare('SELECT code, created_at FROM two_factor_codes 
                          WHERE user_id = ? AND code = ? AND used = 0 
                          ORDER BY created_at DESC LIMIT 1');
    $stmt->execute([$user_id, $code]);
    $stored_code = $stmt->fetch();
    
    if (!$stored_code) {
        return false;
    }
    
    if (time() - strtotime($stored_code['created_at']) > 900) { // 15 минут
        return false;
    }
    
    $stmt = $pdo->prepare('UPDATE two_factor_codes SET used = 1 
                          WHERE user_id = ? AND code = ?');
    $stmt->execute([$user_id, $code]);
    
    return true;
}

function createUserSession($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['last_activity'] = time();
    $_SESSION['login_time'] = time();
    
    session_regenerate_id(true);
    
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO login_history (user_id, ip_address, user_agent) 
                          VALUES (?, ?, ?)');
    $stmt->execute([
        $user['id'],
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    ]);
    
    $stmt = $pdo->prepare('INSERT INTO user_sessions 
                          (user_id, session_id, ip_address, user_agent) 
                          VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $user['id'],
        session_id(),
        $_SERVER['REMOTE_ADDR'],
        $_SERVER['HTTP_USER_AGENT']
    ]);
}

function checkSession() {
    if (!isset($_SESSION['last_activity'])) {
        return false;
    }
    
    if (time() - $_SESSION['last_activity'] > SESSION_LIFETIME) {
        session_unset();
        session_destroy();
        return false;
    }
    
    global $pdo;
    $stmt = $pdo->prepare('SELECT id FROM user_sessions 
                          WHERE user_id = ? AND session_id = ? AND is_active = 1');
    $stmt->execute([
        $_SESSION['user_id'] ?? 0,
        session_id()
    ]);
    
    if (!$stmt->fetch()) {
        session_unset();
        session_destroy();
        return false;
    }
    
    $_SESSION['last_activity'] = time();
    return true;
}

function cleanupLoginAttempts() {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM login_attempts 
                          WHERE last_attempt < DATE_SUB(NOW(), INTERVAL ? SECOND)');
    $stmt->execute([LOGIN_TIMEOUT]);
}

function cleanup2FACodes() {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM two_factor_codes 
                          WHERE created_at < DATE_SUB(NOW(), INTERVAL 15 MINUTE) 
                          OR used = 1');
    $stmt->execute();
}

function logout() {
    global $pdo;
    
    if (isset($_SESSION['user_id'])) {
        $stmt = $pdo->prepare('UPDATE user_sessions SET is_active = 0 
                              WHERE user_id = ? AND session_id = ?');
        $stmt->execute([$_SESSION['user_id'], session_id()]);
    }
    
    updateTotalTime();
    
    $_SESSION = array();
    
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 3600, '/');
    }
    
    session_destroy();
}

function isConfirmed($user) {
    return isset($user['is_confirmed']) && $user['is_confirmed'] == 1;
}

cleanupLoginAttempts();
cleanup2FACodes();

if (isset($_SESSION['user_id']) && !checkSession()) {
    logout();
    safeRedirect('login.php');
}

setSecurityHeaders();

$critical_routes = [
    '/login.php' => ['max_hits' => 10, 'time_window' => 300], 
    '/register.php' => ['max_hits' => 5, 'time_window' => 3600], 
    '/forgot_password.php' => ['max_hits' => 3, 'time_window' => 3600], 
];

$current_route = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (isset($critical_routes[$current_route])) {
    $limits = $critical_routes[$current_route];
    checkRateLimit($current_route, $limits['max_hits'], $limits['time_window']);
}

function updateTotalTime() {
    global $pdo;
    if (isset($_SESSION['user_id'], $_SESSION['login_time'])) {
        $session_time = time() - $_SESSION['login_time'];
        $minutes = round($session_time / 60);
        if ($minutes > 0) {
            $stmt = $pdo->prepare('UPDATE users SET total_time = total_time + ? WHERE id = ?');
            $stmt->execute([$minutes, $_SESSION['user_id']]);
            $_SESSION['login_time'] = time(); 
        }
    }
} 