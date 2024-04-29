<?php
session_start(); // Start the session

require_once __DIR__ . '/../_.php'; // Include necessary files for database connection or other functionalities

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: /views/index.php'); // Redirect to index.php if the user is not logged in
    exit();
}

try {
    $db = _db(); // Establish database connection

    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Delete user from the database
    $sql = "DELETE FROM users WHERE user_id = :user_id";
    $q = $db->prepare($sql);
    $q->bindParam(':user_id', $userId);

    if ($q->execute()) {
        // Logout user and redirect to index.php after successful deletion
        session_destroy(); // Destroy the session to logout the user
        header('Location: /company2/views/index.php'); // Redirect to index.php
        exit();
    } else {
        throw new Exception('Failed to delete user');
    }
} catch (Exception $e) {
    // Handle exceptions and errors
    // You can customize error handling based on your requirements (e.g., log errors, display error messages)
    header('Location: /company2/views/index.php'); // Redirect to index.php in case of errors
    exit();
}
?>