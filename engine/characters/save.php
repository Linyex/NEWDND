<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Не авторизован']);
    exit;
}

require_once __DIR__ . '/../account/db.php';

try {
    $system = $_POST['system'] ?? '';
    $edition = $_POST['edition'] ?? '';
    $user_id = $_SESSION['user_id'];
    
    // Удаляем системные поля из данных
    $data = $_POST;
    unset($data['system'], $data['edition']);
    
    // Преобразуем данные в JSON
    $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    
    // Серверная валидация для VTM
    if ($system === 'vtm' && empty($data['no_limits'])) {
        // --- Атрибуты ---
        $attrGroups = [
            'physical' => ['strength','dexterity','stamina'],
            'social' => ['charisma','manipulation','appearance'],
            'mental' => ['perception','intelligence','wits']
        ];
        $attrLimits = [7,5,3];
        // Приоритеты (по умолчанию)
        $attrPriority = isset($data['attr_priority']) ? json_decode($data['attr_priority'], true) : ['physical','social','mental'];
        if (count(array_unique($attrPriority)) < 3) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Группы приоритетов атрибутов должны быть разными!']);
            exit;
        }
        foreach ($attrPriority as $idx => $group) {
            $fields = $attrGroups[$group];
            $sum = 0;
            foreach ($fields as $f) {
                $sum += isset($data[$f]) ? (int)$data[$f] : 0;
            }
            if ($sum > $attrLimits[$idx]) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Превышен лимит очков в группе атрибутов: ' . $group . ' (' . $sum . ' из ' . $attrLimits[$idx] . ')']);
                exit;
            }
        }
        // --- Способности ---
        $skillGroups = [
            'talent' => ['acting','alertness','athletics','brawl','dodge','empathy','intimidation','leadership','streetwise','subterfuge'],
            'skill' => ['animalken','drive','etiquette','firearms','melee','music','repair','security','stealth','survival'],
            'knowledge' => ['bureaucracy','computer','finance','investigation','law','linguistics','medicine','occult','politics','science']
        ];
        $skillLimits = [13,9,5];
        $skillPriority = isset($data['skill_priority']) ? json_decode($data['skill_priority'], true) : ['talent','skill','knowledge'];
        if (count(array_unique($skillPriority)) < 3) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Группы приоритетов способностей должны быть разными!']);
            exit;
        }
        foreach ($skillPriority as $idx => $group) {
            $fields = $skillGroups[$group];
            $sum = 0;
            foreach ($fields as $f) {
                $sum += isset($data[$f]) ? (int)$data[$f] : 0;
            }
            if ($sum > $skillLimits[$idx]) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Превышен лимит очков в группе способностей: ' . $group . ' (' . $sum . ' из ' . $skillLimits[$idx] . ')']);
                exit;
            }
        }
        // --- Дисциплины ---
        $discFields = ['discipline1_val','discipline2_val','discipline3_val'];
        $discSum = 0;
        foreach ($discFields as $f) { $discSum += isset($data[$f]) ? (int)$data[$f] : 0; }
        if ($discSum > 3) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Превышен лимит очков дисциплин ('.$discSum.' из 3)']);
            exit;
        }
        // --- Дополнения ---
        $bgFields = ['background1_val','background2_val','background3_val','background4_val','background5_val'];
        $bgSum = 0;
        foreach ($bgFields as $f) { $bgSum += isset($data[$f]) ? (int)$data[$f] : 0; }
        if ($bgSum > 5) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Превышен лимит очков дополнений ('.$bgSum.' из 5)']);
            exit;
        }
        // --- Добродетели ---
        $virtueFields = ['conscience','selfcontrol','courage'];
        $virtueSum = 0;
        foreach ($virtueFields as $f) { $virtueSum += isset($data[$f]) ? (int)$data[$f] : 0; }
        if ($virtueSum > 7) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Превышен лимит очков добродетелей ('.$virtueSum.' из 7)']);
            exit;
        }
        // --- Автоматический пересчёт Человечности и Силы Воли ---
        $humanity = (isset($data['conscience']) ? (int)$data['conscience'] : 0) + (isset($data['selfcontrol']) ? (int)$data['selfcontrol'] : 0);
        $willpower = isset($data['courage']) ? (int)$data['courage'] : 0;
        $data['humanity'] = $humanity;
        $data['willpower'] = $willpower;
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
    }
    
    // Сохраняем в базу
    $stmt = $pdo->prepare("INSERT INTO character_sheets (user_id, game_system, game_edition, data) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $system, $edition, $json]);
    
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'error' => 'Ошибка сохранения: ' . $e->getMessage()]);
} 