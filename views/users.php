<?php
session_start();

require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';

$db = _db();

// Fetch list of users from the database
$sql = "SELECT user_id, user_name, user_last_name, user_username, user_email, user_address, user_role FROM users";
$q = $db->query($sql);
$users = $q->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="/company2/css/users.css">
<div id="userList">
    <h4>User List</h4>
    <ul>
        <?php foreach ($users as $user): ?>
            <div>
                <div>
                    <label for="user_id" name="User ID">User ID: </label>
                </div>
                <?= $user['user_id']; ?>
                <div>
                    <label for="user_name" name="User Name">User Name: </label>
                </div>
                <?= $user['user_name']; ?>
                <div>
                    <label for="user_last_name" name="User Last Name">User Last Name: </label>
                </div>
                <?= $user['user_last_name']; ?>
                <div>
                    <label for="user_username" name="User Username">User Username: </label>
                    </div>
                <?= $user['user_username']; ?>
                <div>
                    <label for="user_email" name="User Email">User Email: </label>
                </div>
                <?= $user['user_email']; ?>
                <div>
                    <label for="user_address" name="User Address">User Address: </label>
                </div>
                <?= $user['user_address']; ?>
                <div>
                    <label for="user_role" name="User Role">User Role: </label>
                </div>
                <?= $user['user_role']; ?>
                <div>
                    <label for="view_user" name="View User">View User: </label>
                </div>  
                <a href="/views/view_user.php?user_id=<?= $user['user_id']; ?>">
                    <?= $user['user_name']; ?> 👁️ <!-- Eye icon or any other indicator -->
                </a>
            </div>
        <?php endforeach; ?>
    </ul>
</div>

<?php
require_once __DIR__ . '/_footer.php';
?>
