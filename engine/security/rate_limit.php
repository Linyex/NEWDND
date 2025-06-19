<?php
/**
 * Класс для ограничения частоты запросов
 */
class RateLimit {
    private $pdo;
    private $table = 'rate_limits';
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->createTable();
    }
    
    /**
     * Создание таблицы для хранения лимитов
     */
    private function createTable() {
        $sql = "CREATE TABLE IF NOT EXISTS {$this->table} (
            id INT AUTO_INCREMENT PRIMARY KEY,
            ip_address VARCHAR(45) NOT NULL,
            route VARCHAR(255) NOT NULL,
            hits INT DEFAULT 1,
            last_hit TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            blocked_until TIMESTAMP NULL,
            UNIQUE KEY idx_ip_route (ip_address, route)
        )";
        
        $this->pdo->exec($sql);
    }
    
    /**
     * Проверка и обновление лимитов
     */
    public function check($route, $max_hits = 60, $time_window = 60, $block_time = 3600) {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        // Очистка старых записей
        $this->cleanup();
        
        // Проверка блокировки
        $stmt = $this->pdo->prepare("SELECT blocked_until FROM {$this->table} 
                                    WHERE ip_address = ? AND route = ? AND blocked_until > NOW()");
        $stmt->execute([$ip, $route]);
        if ($stmt->fetch()) {
            return false;
        }
        
        // Получение текущих хитов
        $stmt = $this->pdo->prepare("SELECT hits, last_hit FROM {$this->table} 
                                    WHERE ip_address = ? AND route = ?");
        $stmt->execute([$ip, $route]);
        $record = $stmt->fetch();
        
        if ($record) {
            $time_passed = time() - strtotime($record['last_hit']);
            
            if ($time_passed < $time_window) {
                if ($record['hits'] >= $max_hits) {
                    // Блокировка при превышении лимита
                    $stmt = $this->pdo->prepare("UPDATE {$this->table} 
                                               SET blocked_until = DATE_ADD(NOW(), INTERVAL ? SECOND) 
                                               WHERE ip_address = ? AND route = ?");
                    $stmt->execute([$block_time, $ip, $route]);
                    return false;
                }
                
                // Увеличение счетчика
                $stmt = $this->pdo->prepare("UPDATE {$this->table} 
                                           SET hits = hits + 1, last_hit = NOW() 
                                           WHERE ip_address = ? AND route = ?");
                $stmt->execute([$ip, $route]);
            } else {
                // Сброс счетчика после окончания временного окна
                $stmt = $this->pdo->prepare("UPDATE {$this->table} 
                                           SET hits = 1, last_hit = NOW() 
                                           WHERE ip_address = ? AND route = ?");
                $stmt->execute([$ip, $route]);
            }
        } else {
            // Создание новой записи
            $stmt = $this->pdo->prepare("INSERT INTO {$this->table} 
                                       (ip_address, route, hits, last_hit) 
                                       VALUES (?, ?, 1, NOW())");
            $stmt->execute([$ip, $route]);
        }
        
        return true;
    }
    
    /**
     * Очистка старых записей
     */
    private function cleanup() {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} 
                                    WHERE last_hit < DATE_SUB(NOW(), INTERVAL 24 HOUR) 
                                    AND (blocked_until IS NULL OR blocked_until < NOW())");
        $stmt->execute();
    }
    
    /**
     * Получение оставшихся попыток
     */
    public function getRemainingAttempts($route, $max_hits = 60) {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $stmt = $this->pdo->prepare("SELECT hits FROM {$this->table} 
                                    WHERE ip_address = ? AND route = ?");
        $stmt->execute([$ip, $route]);
        $record = $stmt->fetch();
        
        return $record ? max(0, $max_hits - $record['hits']) : $max_hits;
    }
    
    /**
     * Получение времени до разблокировки
     */
    public function getBlockedTime($route) {
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $stmt = $this->pdo->prepare("SELECT blocked_until FROM {$this->table} 
                                    WHERE ip_address = ? AND route = ? AND blocked_until > NOW()");
        $stmt->execute([$ip, $route]);
        $record = $stmt->fetch();
        
        return $record ? strtotime($record['blocked_until']) - time() : 0;
    }
}

// Создаем глобальный экземпляр класса
global $rate_limit;
$rate_limit = new RateLimit($pdo);

/**
 * Функция для проверки лимита запросов
 */
function checkRateLimit($route = null, $max_hits = 60, $time_window = 60, $block_time = 3600) {
    global $rate_limit;
    
    if ($route === null) {
        $route = $_SERVER['REQUEST_URI'];
    }
    
    if (!$rate_limit->check($route, $max_hits, $time_window, $block_time)) {
        $blocked_time = $rate_limit->getBlockedTime($route);
        
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode([
                'error' => 'Too many requests',
                'blocked_for' => $blocked_time
            ]);
        } else {
            header('HTTP/1.1 429 Too Many Requests');
            echo '<h1>429 Too Many Requests</h1>';
            echo '<p>Пожалуйста, подождите ' . ceil($blocked_time / 60) . ' минут.</p>';
        }
        exit;
    }
    
    return true;
}

/**
 * Функция для получения оставшихся попыток
 */
function getRemainingAttempts($route = null, $max_hits = 60) {
    global $rate_limit;
    
    if ($route === null) {
        $route = $_SERVER['REQUEST_URI'];
    }
    
    return $rate_limit->getRemainingAttempts($route, $max_hits);
} 