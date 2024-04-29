<?php
session_start();
require_once __DIR__ . '/../_.php';
header('Content-Type: application/json');

try {
    _validate_user_name();
    _validate_user_last_name();
    _validate_user_username();
    _validate_user_email();
    _validate_user_address();
    _validate_user_password();
    _validate_user_confirm_password();

    $db = _db();

    // Role Validation
    $allowed_roles = ['user', 'admin', 'partner'];
    if (!isset($_POST['user_role']) || !in_array($_POST['user_role'], $allowed_roles)) {
        throw new Exception("Invalid role selected", 400);
    }

    $hashed_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users 
            (user_name, user_last_name, user_username, user_email, user_address, user_password, user_role, user_created_at, user_updated_at, user_deleted_at, user_is_blocked) 
            VALUES 
            (:user_name, :user_last_name, :user_username, :user_email, :user_address, :user_password, :user_role, :user_created_at, :user_updated_at, :user_deleted_at, :user_is_blocked)";

    $q = $db->prepare($sql);

    $q->bindParam(':user_name', $_POST['user_name']);
    $q->bindParam(':user_last_name', $_POST['user_last_name']);
    $q->bindParam(':user_username', $_POST['user_username']);
    $q->bindParam(':user_email', $_POST['user_email']);
    $q->bindParam(':user_address', $_POST['user_address']);
    $q->bindParam(':user_password', $hashed_password);
    $q->bindParam(':user_role', $_POST['user_role']);
    $q->bindValue(':user_created_at', time());
    $q->bindValue(':user_updated_at', 0);
    $q->bindValue(':user_deleted_at', 0);
    $q->bindValue(':user_is_blocked', 0);

    if ($q->execute()) {
        // Debugging line
        error_log("Redirecting to login.php");
        // Redirect to login.php after successful registration
        header('Location: /company2/views/login.php');
        exit; // Ensure no further output after the header redirect
    } else {
        throw new Exception('Failed to insert user', 500);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500); // Use 500 if the code is not set
    echo json_encode(['info' => $e->getMessage()]);
}
?>