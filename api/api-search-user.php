<?php
session_start();
require_once __DIR__ . '/../_.php';
header('Content-Type: application/json');

try {
    $db = _db();

    // Check if the user is authorized (partner or admin)
    if (!_is_partner() && !_is_admin()) {
        throw new Exception("Unauthorized", 401);
    }

    // Check if the query parameter exists
    if (!isset($_GET['query'])) {
        throw new Exception("Query parameter is missing", 400);
    }

    // Sanitize and prepare the search term
    $searchTerm = "%" . htmlspecialchars($_GET['query']) . "%";

    // Prepare and execute the SQL query
    $q = $db->prepare('
        SELECT user_id, user_name, user_last_name, user_username, user_email, user_address, user_role
        FROM users
        WHERE user_name LIKE :searchTerm 
            OR user_email LIKE :searchTerm 
            OR user_role LIKE :searchTermRole
    ');
    $q->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $q->bindValue(':searchTermRole', $searchTerm, PDO::PARAM_STR);
    $q->execute();
    $users = $q->fetchAll(PDO::FETCH_ASSOC);

    // Encode the response data as JSON
    foreach ($users as &$user) {
        $user['user_name'] = htmlspecialchars($user['user_name']);
        $user['user_email'] = htmlspecialchars($user['user_email']);
    }

    // Set the HTTP response code and content type header
    http_response_code(200);
    header('Content-Type: application/json');
    echo json_encode($users);
} catch (Exception $e) {
    // Handle exceptions
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - ' . $e->getLine() : $e->getMessage();
    http_response_code($status_code);
    header('Content-Type: application/json');
    echo json_encode(['info' => $message]);
}
?>
