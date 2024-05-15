<?php
session_start();
require_once __DIR__ . '/../_.php';
header('Content-Type: application/json');

try {
    $db = _db();

    // Check if the user is authorized as an admin or partner
    if (!_is_partner() && !_is_admin()) {
        throw new Exception("Unauthorized", 401);
    }

    // Check if the query parameter exists
    if (!isset($_GET['query'])) {
        throw new Exception("Query parameter is missing", 400);
    }

    // Sanitize and prepare the search term
    $searchTerm = "%" . htmlspecialchars($_GET['query']) . "%";

    // Prepare and execute the SQL query to search orders
    $q = $db->prepare('
    SELECT * FROM orders
    WHERE order_id LIKE :searchTerm OR order_user_fk LIKE :searchTerm OR order_product_fk LIKE :searchTerm OR order_amount_paid LIKE :searchTerm OR order_status LIKE :searchTerm
    ORDER BY order_id ASC;
');

    $q->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $q->execute();
    $orders = $q->fetchAll(PDO::FETCH_ASSOC);

    // Encode the response data as JSON
    echo json_encode($orders);
} catch (Exception $e) {
    // Handle exceptions
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - ' . $e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
