<?php
require_once(__DIR__.'/customerDal.php');
require_once(__DIR__.'/contractorDal.php');

$user = "root";
$pass = "root";

$ordersDbHost = "172.17.0.3";
$ordersDbHostSlave = "172.20.0.2";
$ordersDb = "Orders";

function loadOrders()
{
    $orders = getOrders();
    $customerIds = array();
    foreach ($orders as $order) {
        $customerIds[] = $order['customerId'];
    }

    $customers = getCustomers($customerIds);

    $orderViews = array();
    for ($i = 0; $i < count($orders); $i++) {
        $order = $orders[$i];
        $customer = $order['customerId'] == null
                        ? null
                        : $customers[$order['customerId']];

        $orderView = array();
        $orderView['id'] = $order['id'];
        $orderView['title'] = $order['title'];
        $orderView['customer'] = $customer == null
                                    ? null
                                    : $customer['name'];

        $orderViews[] = $orderView;
    }
    return $orderViews;
}

function getOrders()
{
    global $ordersDbHost;
    global $ordersDb;
    $conn = getConnection($ordersDbHost, $ordersDb);
    $query = "SELECT Id, Title, Description, Price, Status, CustomerId, ContractorId FROM Orders"; //TODO paging
    $rows = mysqli_query($conn, $query);

    $orders = array();
    if (mysqli_num_rows($rows) > 0) {
        while ($row = mysqli_fetch_assoc($rows)) {
            $order['id'] = $row['Id'];
            $order['title'] = $row['Title'];
            $order['description'] = $row['Description'];
            $order['status'] = $row['Status'];
            $order['price'] = $row['Price'];
            $order['customerId'] = $row['CustomerId'];
            $order['contractorId'] = $row['ContractorId'];

            $orders[] = $order;
        }
    }

    mysqli_close($conn);

    return $orders;
}

function insertOrder($title, $descr, $price, $customerName)
{
    $foundCustomerId = getCustomerIdByName($customerName);
    if ($foundCustomerId == null) {
        //insert new customer
        $foundCustomerId = insertCustomer($customerName);
    }
    insertOrderWithReplication($title, $descr, $price, $foundCustomerId);
}

function insertOrderWithReplication($title, $descr, $price, $customerId)
{
    global $ordersDbHost;
    global $ordersDbHostSlave;

    $query = "INSERT INTO Orders('Title', 'Description', 'Price', 'CustomerId') VALUES (?, ?, ?, ?)";
    $params = array($title, $descr, $price, $customerId);
    insertOrderToDb($ordersDbHost, $query, $params);
    insertOrderToDb($ordersDbHostSlave, $query, $params);
}

function insertOrderToDb($dbHost, $query, $params)
{
    global $ordersDb;

    $conn = getConnection($dbHost, $ordersDb);
    $query = $conn->prepare($query);
    $query->bind_param('ssdi', ...$params);
    $query . execute();
    mysqli_close($conn);
}

function getConnection($host, $db)
{
    global $user;
    global $pass;

    $conn = mysqli_connect($host, $user, $pass, $db);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}
?>