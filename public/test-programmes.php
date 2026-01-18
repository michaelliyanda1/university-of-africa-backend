<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=newuoa1', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query('SELECT * FROM programmes WHERE is_active = 1 ORDER BY `order`, title');
    $programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($programmes as &$prog) {
        $prog['specializations'] = json_decode($prog['specializations'], true);
        $prog['careers'] = json_decode($prog['careers'], true);
        $prog['learning_outcomes'] = json_decode($prog['learning_outcomes'], true);
        $prog['is_active'] = (bool)$prog['is_active'];
        $prog['is_featured'] = (bool)$prog['is_featured'];
    }
    
    echo json_encode($programmes);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
