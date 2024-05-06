<?php
session_start();

// Include necessary files
require_once __DIR__ . '/../_.php';

// Check if user is logged in
if (!isset($_SESSION['user_role'])) {
    header("Location: /company2/views/login.php");
    exit;
}

// Function to search orders
function searchOrders($query)
{
    // Database connection
    $db = _db();

    $sql = $db->prepare('SELECT * FROM orders WHERE order_id LIKE :query OR order_user_fk LIKE :query OR order_product_fk LIKE :query OR order_amount_paid LIKE :query OR order_status LIKE :query ORDER BY order_id ASC;');
    $sql->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
    $sql->execute();
    return $sql->fetchAll(PDO::FETCH_ASSOC);
}

// Check if search query is present
if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $orders = searchOrders($query);
    echo json_encode($orders);
    exit;
}

// Check if user is authorized to access this page
if ($_SESSION['user_role'] !== 'Partner' && $_SESSION['user_role'] !== 'Admin') {
    header("Location: /company2/views/index.php");
    exit;
}

// If no search query, fetch all orders
$sql = $db->prepare('SELECT * FROM orders ORDER BY order_id ASC;');
$sql->execute();
$orders = $sql->fetchAll(PDO::FETCH_ASSOC);

// Output orders as JSON
echo json_encode($orders);
