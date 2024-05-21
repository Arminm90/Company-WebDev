<?php
    session_start();
    require_once __DIR__ . '/_header.php';
    require_once __DIR__ . '/../_.php';
?>
<link rel="stylesheet" href="/company2/css/signup.css">
<div id="signupForm">
<h4>Signup</h4>
<form action="/company2/api/api-signup.php" method="post">
  <div id="name">
  <label for="user_name">Name: (<?= USER_NAME_MIN ?> to <?= USER_NAME_MAX ?> characters)</label>
  <input type="text" id="user_name" name="user_name" required >
  </div>
  <div id="lastName">
  <label for="user_last_name">Last Name: (<?= USER_LAST_NAME_MIN ?> to <?= USER_LAST_NAME_MAX ?> characters)</label>
  <input type="text" id="user_last_name" name="user_last_name" required>
  </div>
  <div id="userName">
  <label for="user_username">Username: (<?= USER_USERNAME_MIN ?> to <?= USER_USERNAME_MAX ?> characters)</label>
  <input type="text" id="user_username" name="user_username" required>
  </div>
  <div id="email">
  <label for="user_email">Email:</label>
  <input type="email" id="user_email" name="user_email" required>
  </div>
  <div id="address">
  <label for="user_address">Address: (<?= USER_ADDRESS_MIN ?> to <?= USER_ADDRESS_MAX ?> characters)</label>
  <textarea id="user_address" name="user_address" required></textarea>
  </div>
  <div id="pwd">
  <label for="user_password">Password: (<?= USER_PASSWORD_MIN ?> to <?= USER_PASSWORD_MAX ?> characters)</label>
  <input type="password" id="user_password" name="user_password" required>
  </div>
  <div id="cpwd">
  <label for="user_confirm_password">Confirm Password:</label>
  <input type="password" id="user_confirm_password" name="user_confirm_password" required>
  </div>
  <div id="user_role">
  <label for="user_role">Choose Role:</label>
  <select id="user_role_select" name="user_role" required>
      <option value="user">User</option>
      <option value="admin">Admin</option>
      <option value="partner">Partner</option>
  </select>
  </div>
  <button id="signup-btn" type="submit">Signup</button>
</form>
</div>
<?php
    require_once __DIR__ . '/_footer.php';
?>