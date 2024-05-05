<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../database/_.php';

try {
    $db = _db();
    $q = $db->prepare('
   SELECT orders.order_id, orders.partner_id, orders.user_id, orders.order_date, orders.order_status, orders.order_total, partners.partner_name
   FROM orders
   JOIN products ON orders.partner_id = products.partner_id
   JOIN partners ON products.partner_id = partners.partner_id
   WHERE orders.user_id = :user_id
   AND (products.product_name LIKE :searchTerm OR partners.partner_name LIKE :searchTerm)
');
    $q->bindValue(':user_id', 10, PDO::PARAM_INT);
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
