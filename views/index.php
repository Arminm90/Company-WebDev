<?php
session_start();
require_once __DIR__ . '/_header.php';
require_once __DIR__ . '/../_.php';
?>
<article>
    <h2>Welcome</h2>
    <p>I am thankful for your visit.</p>
    <p>I hope you will find the food you are looking for</p>
    <div id="button">
        <div id="newuser">
            <label for="newuser">New user</label>
            <button id="sign-btn" onclick="window.location.href='/company2/views/signup.php'">Signup</button>
        </div>
        <div id="login">
            <label for="login">Already user</label>
            <button id="login-btn" onclick="window.location.href='/company2/views/login.php'">Login</button>
        </div>
    </div>
</article>

<?php
require_once __DIR__ . '/_footer.php';
?>
