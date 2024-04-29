<?php
header('Content-Type: application/json');
require_once __DIR__.'/../_.php';

try {
    $user_id = $_GET['user_id'];
    $user_is_blocked = $_GET['user_is_blocked'] == 1 ? 1 : 0; 

    $db = _db();
    $q = $db->prepare("
        UPDATE users 
        SET user_is_blocked = CASE 
            WHEN user_is_blocked = 0 THEN 1 
            ELSE 0 
        END
        WHERE user_id = :user_id;
    ");

    $q->bindValue(':user_id', $user_id);
    $q->execute();

    echo json_encode(['success' => true, 'message' => 'User updated successfully']);

} catch (Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'Error - ' . $e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['success' => false, 'error' => $message]);
}
?>
