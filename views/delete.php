<?php
session_start();

    require_once __DIR__ . '/_header.php';
    require_once __DIR__ . '/../_.php';

    if(!isset($_SESSION['user_id'])) {
        header('Location: /company2/views/login.php');
        die();
    }
?>
<link rel="stylesheet" href="/company2/css/delete.css">
<h2>Delete Profile</h2>
<p>Are you sure you want to delete your account?</p>


<form action="/company2/api/api-delete.php" method="post"> 
    <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
    <input id="delete-btn" type="submit" value="Yes, Delete My Account">

    <a href="/company2/views/profile.php">Cancel</a></form> 

<?php
require_once __DIR__ . '/_footer.php';
?>