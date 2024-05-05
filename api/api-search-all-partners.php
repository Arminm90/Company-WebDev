<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../database/_.php';

try {
    $db = _db();
    $searchTerm = isset($_GET['query']) ? $_GET['query'] : '';
    $q = $db->prepare('SELECT * FROM partners WHERE partner_name LIKE :searchTerm OR partner_id = :searchId');
    $q->bindValue(':searchTerm', "%{$searchTerm}%");
    $q->bindValue(':searchId', $searchTerm, PDO::PARAM_INT);
    $q->execute();
    $partners = $q->fetchAll();

    foreach ($partners as $key => $partner) {
        $q = $db->prepare('SELECT * FROM partner_address WHERE partner_id = :partner_id');
        $q->bindValue(':partner_id', $partner['partner_id'], PDO::PARAM_INT);
        $q->execute();
        $address = $q->fetch();

        if ($address) {
            $partners[$key]['address'] = $address;
        }
    }

    echo json_encode($partners);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['info' => $e->getMessage()]);
}
