<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ##############################
function _db()
{
  try {
    $user_name = "root"; // Update with your XAMPP MySQL username
    $user_password = ""; // No password set for MySQL in XAMPP
    $db_connection = "mysql:host=localhost; dbname=company1; charset=utf8mb4";

    $db_options = array(
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );
    return new PDO($db_connection, $user_name, $user_password, $db_options);
  } catch (PDOException $e) {
    throw new Exception('ups... system under maintenance', 500);
    exit();
  }
}

// function _db(){
// 	try{
//     $user_name = "root";
//     $user_password = "";
// 	  $db_connection = "mysql:host=localhost; dbname=company1; charset=utf8mb4";

// 	  $db_options = array(
// 		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
// 		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // [['id'=>1, 'name'=>'A'],[]]  $user['id']
// 	  );
// 	  return new PDO( $db_connection, $user_name, $user_password, $db_options );
// 	}catch( PDOException $e){
// 	  throw new Exception('ups... system under maintainance', 500);
// 	  exit();
// 	}	
// }


// ##############################
define('USER_NAME_MIN', 2);
define('USER_NAME_MAX', 20);
function _validate_user_name()
{

  $error = 'user_name min ' . USER_NAME_MIN . ' max ' . USER_NAME_MAX;

  if (!isset($_POST['user_name'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_name'] = trim($_POST['user_name']);

  if (strlen($_POST['user_name']) < USER_NAME_MIN) {
    throw new Exception($error, 400);
  }

  if (strlen($_POST['user_name']) > USER_NAME_MAX) {
    throw new Exception($error, 400);
  }
}

// ##############################
define('USER_LAST_NAME_MIN', 2);
define('USER_LAST_NAME_MAX', 20);
function _validate_user_last_name()
{

  $error = 'user_last_name min ' . USER_LAST_NAME_MIN . ' max ' . USER_LAST_NAME_MAX;

  if (!isset($_POST['user_last_name'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_last_name'] = trim($_POST['user_last_name']);

  if (strlen($_POST['user_last_name']) < USER_LAST_NAME_MIN) {
    throw new Exception($error, 400);
  }

  if (strlen($_POST['user_last_name']) > USER_LAST_NAME_MAX) {
    throw new Exception($error, 400);
  }
}
define('USER_USERNAME_MIN', 6);
define('USER_USERNAME_MAX', 50);
function _validate_user_username()
{

  $error = 'user_username min ' . USER_USERNAME_MIN . ' max ' . USER_USERNAME_MAX;

  if (!isset($_POST['user_username'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_username'] = trim($_POST['user_username']);

  if (strlen($_POST['user_username']) < USER_USERNAME_MIN) {
    throw new Exception($error, 400);
  }

  if (strlen($_POST['user_username']) > USER_USERNAME_MAX) {
    throw new Exception($error, 400);
  }
}
define('USER_ADDRESS_MIN', 6);
define('USER_ADDRESS_MAX', 50);
function _validate_user_address()
{

  $error = 'user_address min ' . USER_ADDRESS_MIN . ' max ' . USER_ADDRESS_MAX;

  if (!isset($_POST['user_address'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_address'] = trim($_POST['user_address']);

  if (strlen($_POST['user_address']) < USER_ADDRESS_MIN) {
    throw new Exception($error, 400);
  }

  if (strlen($_POST['user_address']) > USER_ADDRESS_MAX) {
    throw new Exception($error, 400);
  }
}

// ##############################
function _validate_user_email()
{
  $error = 'user_email invalid';
  if (!isset($_POST['user_email'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_email'] = trim($_POST['user_email']);
  if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
    throw new Exception($error, 400);
  }
}

// ##############################
define('USER_PASSWORD_MIN', 6);
define('USER_PASSWORD_MAX', 50);
function _validate_user_password()
{

  $error = 'user_password min ' . USER_PASSWORD_MIN . ' max ' . USER_PASSWORD_MAX;

  if (!isset($_POST['user_password'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_password'] = trim($_POST['user_password']);

  if (strlen($_POST['user_password']) < USER_PASSWORD_MIN) {
    throw new Exception($error, 400);
  }

  if (strlen($_POST['user_password']) > USER_PASSWORD_MAX) {
    throw new Exception($error, 400);
  }
}

// ##############################
function _validate_user_confirm_password()
{
  $error = 'user_confirm_password must match the user_password';
  if (!isset($_POST['user_confirm_password'])) {
    throw new Exception($error, 400);
  }
  $_POST['user_confirm_password'] = trim($_POST['user_confirm_password']);
  if ($_POST['user_password'] != $_POST['user_confirm_password']) {
    throw new Exception($error, 400);
  }
}

// ##############################
function _is_admin()
{
  return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// ##############################
function _is_partner()
{
  return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'partner';
}
