<?php
require_once(__DIR__ . '/dal.php');

$data = loadOrders();
header('Content-Type: application/json');
echo json_encode($data);
?>