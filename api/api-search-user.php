<?php
session_start();
require_once __DIR__ . '/../_.php';
header('Content-Type: application/json');

try {
    $db = _db();

    if (!_is_partner()) {
        throw new Exception("Unauthorized", 401);
    }

    if (!isset($_GET['query'])) {
        throw new Exception("Query parameter is missing", 400);
    }

    $searchTerm = "%" . $_GET['query'] . "%";

    $q = $db->prepare('
        SELECT user_id, user_name, user_last_name, user_username, user_email, user_address
        FROM users
        WHERE user_name LIKE :searchTerm OR user_email LIKE :searchTerm
    ');
    $q->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);

    $q->execute();
    $users = $q->fetchAll(PDO::FETCH_ASSOC);

    // Include user name and email in the response
    foreach ($users as &$user) {
        $user['user_name'] = htmlspecialchars($user['user_name']);
        $user['user_email'] = htmlspecialchars($user['user_email']);
    }

    echo json_encode($users);
} catch (Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - ' . $e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
