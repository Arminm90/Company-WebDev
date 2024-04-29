<?php
session_start();  // Start the session
require_once __DIR__ . '/../_.php';

try {

    if(!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
        throw new Exception("Invalid email format", 400);
    }

    if(strlen($_POST['user_password']) < 8){
        throw new Exception("Password must be at least 8 characters long", 400);
    }

    if (!isset($_POST['user_email']) || !isset($_POST['user_password'])) {
        throw new Exception("Both email and password are required", 400);
    }

    $db = _db();

    $email = $_POST['user_email'];
    $password = $_POST['user_password'];

    // Fetch user by email
    $sql = "SELECT * FROM users WHERE user_email = :email";
    $q = $db->prepare($sql);
    $q->bindParam(':email', $email);
    $q->execute();

    $user = $q->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['user_password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_email'] = $user['user_email'];
        $_SESSION['user_role'] = $user['user_role'];

        // Redirect to user.php upon successful login
        $redirect_url = '';
        switch ($_SESSION['user_role']) {
            case 'admin':
                $redirect_url = '/company2/views/admin.php';
                break;
            case 'partner':
                $redirect_url = '/company2/views/partner.php';
                break;
            case 'user':
                $redirect_url = '/company2/views/user.php';
                break;
            default:
                $redirect_url = '/company2/views/index.php';
                break;
        }
        header('Location: ' . $redirect_url);
        
        exit();
    } else {
        throw new Exception("Invalid email or password", 401);
    }

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500); // Use 500 if the code is not set
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
