<?php
/**
 * Класс для безопасной работы с базой данных
 */
class DBSecurity {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    /**
     * Безопасное выполнение SELECT-запроса
     */
    public function safeSelect($table, $columns = ['*'], $conditions = [], $order = '', $limit = '') {
        $columns_str = implode(', ', array_map([$this, 'escapeIdentifier'], $columns));
        $table = $this->escapeIdentifier($table);
        
        $sql = "SELECT $columns_str FROM $table";
        
        if (!empty($conditions)) {
            $where_parts = [];
            $params = [];
            
            foreach ($conditions as $column => $value) {
                if (is_array($value)) {
                    $placeholders = str_repeat('?,', count($value) - 1) . '?';
                    $where_parts[] = $this->escapeIdentifier($column) . " IN ($placeholders)";
                    $params = array_merge($params, $value);
                } else {
                    $where_parts[] = $this->escapeIdentifier($column) . ' = ?';
                    $params[] = $value;
                }
            }
            
            $sql .= ' WHERE ' . implode(' AND ', $where_parts);
        }
        
        if ($order) {
            $sql .= ' ORDER BY ' . $this->escapeIdentifier($order);
        }
        
        if ($limit) {
            $sql .= ' LIMIT ' . (int)$limit;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params ?? []);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Безопасная вставка данных
     */
    public function safeInsert($table, $data) {
        $columns = array_keys($data);
        $values = array_values($data);
        
        $columns_str = implode(', ', array_map([$this, 'escapeIdentifier'], $columns));
        $placeholders = str_repeat('?,', count($values) - 1) . '?';
        
        $table = $this->escapeIdentifier($table);
        $sql = "INSERT INTO $table ($columns_str) VALUES ($placeholders)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        
        return $this->pdo->lastInsertId();
    }
    
    /**
     * Безопасное обновление данных
     */
    public function safeUpdate($table, $data, $conditions): mixed {
        $set_parts = [];
        $params = [];
        
        foreach ($data as $column => $value) {
            $set_parts[] = $this->escapeIdentifier(identifier: $column) . ' = ?';
            $params[] = $value;
        }
        
        $where_parts = [];
        foreach ($conditions as $column => $value) {
            $where_parts[] = $this->escapeIdentifier(identifier: $column) . ' = ?';
            $params[] = $value;
        }
        
        $table = $this->escapeIdentifier(identifier: $table);
        $sql = "UPDATE $table SET " . implode(separator: ', ', array: $set_parts) . 
               " WHERE " . implode(separator: ' AND ', array: $where_parts);
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Безопасное удаление данных
     */
    public function safeDelete($table, $conditions) {
        $where_parts = [];
        $params = [];
        
        foreach ($conditions as $column => $value) {
            $where_parts[] = $this->escapeIdentifier($column) . ' = ?';
            $params[] = $value;
        }
        
        $table = $this->escapeIdentifier($table);
        $sql = "DELETE FROM $table WHERE " . implode(' AND ', $where_parts);
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
    
    /**
     * Экранирование идентификаторов
     */
    private function escapeIdentifier($identifier) {
        // Удаляем бэктики
        $identifier = str_replace('`', '', $identifier);
        
        // Экранируем спецсимволы
        $identifier = preg_replace('/[^a-zA-Z0-9_]/', '', $identifier);
        
        return "`$identifier`";
    }
    
    /**
     * Безопасное выполнение произвольного запроса
     */
    public function safeQuery($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
    
    /**
     * Получение одной записи
     */
    public function safeGetOne($table, $conditions = []) {
        $result = $this->safeSelect($table, ['*'], $conditions, '', '1');
        return $result ? $result[0] : null;
    }
    
    /**
     * Проверка существования записи
     */
    public function safeExists($table, $conditions = []) {
        $result = $this->safeSelect($table, ['1'], $conditions, '', '1');
        return !empty($result);
    }
    
    /**
     * Подсчет количества записей
     */
    public function safeCount($table, $conditions = []) {
        $result = $this->safeSelect($table, ['COUNT(*) as count'], $conditions);
        return (int)$result[0]['count'];
    }

    /**
     * Безопасная пагинация
     */
    public function safePaginate($table, $page = 1, $per_page = 10, $conditions = [], $order = '') {
        $total = $this->safeCount($table, $conditions);
        $total_pages = ceil($total / $per_page);
        $page = max(1, min($page, $total_pages));
        
        $offset = ($page - 1) * $per_page;
        $items = $this->safeSelect(
            $table, 
            ['*'], 
            $conditions, 
            $order, 
            "$offset, $per_page"
        );
        
        return [
            'items' => $items,
            'total' => $total,
            'per_page' => $per_page,
            'current_page' => $page,
            'total_pages' => $total_pages
        ];
    }
}

// Создаем глобальный экземпляр класса
global $db_security;
$db_security = new DBSecurity($pdo); 