<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../database/_.php';

try {
    $db = _db();
    $searchTerm = isset($_GET['query']) ? $_GET['query'] : '';
    $q = $db->prepare('SELECT * FROM users WHERE user_firstname LIKE :searchTerm OR user_lastname LIKE :searchTerm OR user_id = :searchId');
    $q->bindValue(':searchTerm', "%{$searchTerm}%");
    $q->bindValue(':searchId', $searchTerm, PDO::PARAM_INT);
    $q->execute();
    $users = $q->fetchAll();

    echo json_encode($users);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['info' => $e->getMessage()]);
}
