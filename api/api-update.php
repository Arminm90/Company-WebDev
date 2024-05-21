<?php
session_start();
require_once __DIR__ . '/../_.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

try {
    $db = _db();
} catch (PDOException $e) {
    $response['message'] = 'Database connection error: ' . $e->getMessage();
    echo json_encode($response);
    exit();
}

$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

if ($user_id <= 0) {
    $response['message'] = 'Invalid user ID';
    echo json_encode($response);
    exit();
}

$userData = fetchUserById($user_id, $db);

if (!$userData) {
    $response['message'] = 'User not found';
    echo json_encode($response);
    exit();
}
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $user_name = isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : '';
    $user_last_name = isset($_POST['user_last_name']) ? htmlspecialchars($_POST['user_last_name']) : '';
    $user_username = isset($_POST['user_username']) ? htmlspecialchars($_POST['user_username']) : '';
    $user_email = isset($_POST['user_email']) ? htmlspecialchars($_POST['user_email']) : '';
    $user_address = isset($_POST['user_address']) ? htmlspecialchars($_POST['user_address']) : '';
    $user_password = isset($_POST['user_password']) ? $_POST['user_password'] : '';
    $user_confirm_password = isset($_POST['user_confirm_password']) ? $_POST['user_confirm_password'] : '';


    // Update user data in the database
    $sql = "UPDATE users SET user_name = :user_name, user_last_name = :user_last_name, user_username = :user_username, user_email = :user_email, user_address = :user_address";
    
    if (!empty($user_password) && $user_password === $user_confirm_password) {
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $sql .= ", user_password = :user_password";
    }

    $sql .= " WHERE user_id = :user_id";
    
    $q = $db->prepare($sql);
    $q->bindParam(':user_name', $user_name);
    $q->bindParam(':user_last_name', $user_last_name);
    $q->bindParam(':user_username', $user_username);
    $q->bindParam(':user_email', $user_email);
    $q->bindParam(':user_address', $user_address);
    $q->bindParam(':user_id', $user_id);

    if ($q->execute()) {
        $response['success'] = true;
        $response['message'] = 'User updated successfully';
    } else {
        $response['message'] = 'Failed to update user';
    }

    echo json_encode($response);
}

function fetchUserById($userId, $db) {
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $q = $db->prepare($sql);
    $q->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $q->execute();
    return $q->fetch(PDO::FETCH_ASSOC);
}
?>
