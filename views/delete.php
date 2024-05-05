<?php
session_start();

require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /company2/views/login.php');
    die();
}
?>
<link rel="stylesheet" href="/company2/css/delete.css">
<h2>Delete Profile</h2>
<p>Are you sure you want to delete your account?</p>
<form action="/company2/api/api-delete.php" method="post">
    <div id="button-container">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <button id="delete-btn" type="submit">Yes, Delete My Account</button>
        <button><a href="/company2/views/user.php">Cancel</a></button>
    </div>
</form>

<?php
require_once __DIR__ . '/_footer.php';
?>