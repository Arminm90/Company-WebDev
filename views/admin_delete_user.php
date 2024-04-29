<?php
// session_start();

require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';
// require_once __DIR__ . '/admin_header.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: /company2/views/login.php');
    die();
}

// Handle form submission
if (isset($_POST['user_id'])) {
    $_user_id = $_POST['user_id'];

    header('Location: /company2/views/admin/users_list.php?deleted=true');
    die();
}
?>

<h4>Delete User</h4>

<form action="/views/admin_delete_user.php" method="POST">
    <label for="user_id">Select User ID:</label>
    <select name="user_id" id="user_id">
        <option value="1">1</option>
        <option value="2">2</option>
        <!-- Add more options based on your users' list -->
    </select>
    
    <!-- Submit Button -->
    <button type="submit">Delete User</button>
</form>
