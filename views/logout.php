<?php
session_start();
session_destroy();
header('Location: /company2/views/index.php');
exit();
