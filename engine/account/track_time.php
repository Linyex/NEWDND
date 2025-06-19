<?php
session_start();
require_once __DIR__ . '/../../engine/security/auth.php';
header('Content-Type: application/json');
updateTotalTime();
echo json_encode(['success' => true]); 