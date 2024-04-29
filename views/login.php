<?php
  session_start();
    require_once __DIR__ . '/_header.php';
    require_once __DIR__ . '/../_.php';
?>
<link rel="stylesheet" href="/company2/css/login.css">
<div id="loginForm">
<h4>Login</h4>
<form action="/company2/api/api-login.php" method="post">
  <div id="email">
  <label for="user_email">Email:</label>
  <input type="email" id="user_email" name="user_email" required>
  </div>
  <div id="pwd">
  <label for="user_password">Password:</label>
  <input type="password" id="user_password" name="user_password" required>
  </div>
  <button id="login-btn" type="submit" value="Login">login</button>
</form>
</div>
<?php
    require_once __DIR__ . '/_footer.php';
?>
