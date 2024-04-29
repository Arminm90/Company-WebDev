<?php
session_start();
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';

$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

try {
    $db = _db();
} catch (PDOException $e) {
    exit('Database connection error: ' . $e->getMessage());
}

$user_id = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;
if ($user_id <= 0) {
    exit('Invalid user ID');
}

$userData = fetchUserById($user_id, $db);
if (!$userData) {
    exit('User not found');
}

function fetchUserById($userId, $db) {
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $q = $db->prepare($sql);
    $q->bindParam(':user_id', $userId, PDO::PARAM_INT);
    $q->execute();
    return $q->fetch(PDO::FETCH_ASSOC);
}
?>
<?php if (!empty($message)): ?>
  <div class="<?php echo (strpos($message, 'success') !== false) ? 'success-message' : 'error-message'; ?>">
    <?php echo $message; ?>
  </div>
<?php endif; ?>
<link rel="stylesheet" href="/company2/css/update.css">
<div id="updateForm">
  <h4>User Update</h4>
  <p>Make necessary changes and click "Update" to save.</p>
<form id="updateFormUser" action="/company2/api/api-update.php" method="post">

<input type="hidden" id="user_id" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_id']); ?>">
  
  <div id="name">
  <label for="user_name">User Name:</label>
  <input type="text" id="user_name" name="user_name" value="<?php echo htmlspecialchars($userData['user_name']); ?>" required>
  </div>
  <div id="lastName">
  <label for="user_last_name">Last Name:</label>
  <input type="text" id="user_last_name" name="user_last_name" value="<?php echo htmlspecialchars($userData['user_last_name']); ?>" required>
  </div>
  <div id="userName">
  <label for="user_username">Username:</label>
  <input type="text" id="user_username" name="user_username" value="<?php echo htmlspecialchars($userData['user_username']); ?>" required>
  </div>
  <div id="email">
  <label for="user_email">Email:</label>
  <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($userData['user_email']); ?>" required>
  </div>
  <div id="address">
  <label for="user_address">Address:</label>
  <textarea id="user_address" name="user_address" required><?php echo htmlspecialchars($userData['user_address']); ?></textarea>
  </div>
  <div id="nPwd">
  <label for="user_password">New Password (Optional):</label>
  <input type="password" id="user_password" name="user_password">
  </div>
  <div id="CnPwd">
  <label for="user_confirm_password">Confirm New Password</label>
    <input type="password" id="user_confirm_password" name="user_confirm_password">
  </div>
 <button id="update-btn" type="submit">Update</button>
 <button><a href="/company2/views/user.php">Back to Profile</a></button>
</form>
</div>
<?php
require_once __DIR__ . '/_footer.php';
?>
