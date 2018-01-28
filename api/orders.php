<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

require_once(__DIR__ . '/../dataAccess/orderDal.php');

$data = loadOrders();
header('Content-Type: application/json');
echo json_encode($data);
?>