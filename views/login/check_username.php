<?php
require_once __DIR__ . '/../../engine/account/check_username_functions.php';

header('Content-Type: application/json');
echo json_encode(checkUsernameAvailability()); 