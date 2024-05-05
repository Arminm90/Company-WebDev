<?php
session_start();
$partner_id = $_SESSION['partner']['id'];

header('Content-Type: application/json');
require_once __DIR__ . '/../database/_.php';

try {
    $db = _db();
    $q = $db->prepare('
   SELECT o.*, u.user_firstname, u.user_lastname, p.product_name, p.product_price, pt.partner_name
   FROM orders o
   JOIN users u ON o.user_id = u.user_id
   JOIN order_details od ON o.order_id = od.order_id
   JOIN products p ON od.product_id = p.product_id
   JOIN partners pt ON o.partner_id = pt.partner_id
   WHERE o.partner_id = :partner_id
   AND (o.order_id LIKE :searchTerm OR u.user_firstname LIKE :searchTerm OR u.user_lastname LIKE :searchTerm OR u.user_id LIKE :searchTerm OR p.product_name LIKE :searchTerm)
');
    $q->bindValue(':partner_id', $partner_id);
    $q->bindValue(':searchTerm', "%{$_GET['query']}%", PDO::PARAM_STR);

    $q->execute();
    $orders = $q->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($orders);
} catch (Exception $e) {
    $status_code = !ctype_digit($e->getCode()) ? 500 : $e->getCode();
    $message = strlen($e->getMessage()) == 0 ? 'error - ' . $e->getLine() : $e->getMessage();
    http_response_code($status_code);
    echo json_encode(['info' => $message]);
}
