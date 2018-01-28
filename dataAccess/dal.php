<?php
$user = "root";
$pass = "root";

$ordersDbHost = "172.17.0.3";
$ordersDbHostSlave = "172.20.0.2";
$ordersDb = "Orders";

$customersDbHost = "172.18.0.3";
$customersDb = "Customers";

$contractorsDbHost = "172.17.0.2";
$contractorsDb = "Contractors";

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
        $customer = $customers[$order['customerId']];

        $orderView = array();
        $orderView['id'] = $order['id'];
        $orderView['title'] = $order['title'];
        $orderView['customer'] = $customer['name'];

        $orderViews[] = $orderView;
    }
    return $orderViews;
}

function getOrders()
{
    global $ordersDbHost;
    global $ordersDb;
    $conn = getConnection($ordersDbHost, $ordersDb);
    $query = "select top 100 * from Orders";
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
    global $ordersDbHost;
    global $ordersDbHostSlave;
    global $ordersDb;
    global $customersDbHost;
    global $customersDb;

    $foundCustomerId = getCustomerIdByName($customerName);
    if ($foundCustomerId == null)
    {
        //insert new customer
        $foundCustomerId = insertCustomer($customerName);
    }
    $conn = getConnection($ordersDbHost, $ordersDb);
    $query = $conn->prepare("INSERT INTO 'Order'('Name') VALUES (?)");
    $query->bind_param('s', $name);
    $query.execute();
    $newCustId = mysqli_insert_id($conn);
    mysqli_close($conn);



    $conn = getConnection($ordersDbHost, $ordersDb);
    $query = "select top 100 * from Orders";
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

function insertCustomer($name)
{
    global $customersDbHost;
    global $customersDb;
    $conn = getConnection($customersDbHost, $customersDb);
    $query = $conn->prepare("INSERT INTO 'Customer'('Name') VALUES (?)");
    $query->bind_param('s', $name);
    $query.execute();
    $newCustId = mysqli_insert_id($conn);
    mysqli_close($conn);

    return $newCustId;
}

function getCustomerIdByName($name)
{
    global $customersDbHost;
    global $customersDb;
    $conn = getConnection($customersDbHost, $customersDb);
    $query = $conn->prepare("select id from Customer where Name = ?");
    $query->bind_param('s', $name);
    $query.execute();
    $customerIds = $query->get_result();
    $foundCustomer = null;
    if ($cust = $customerIds->fetch_assoc()) {
        $foundCustomer = $cust["id"];
    }

    mysqli_close($conn);

    return $foundCustomer;
}

function getCustomers($customerIds)
{
    global $customersDbHost;
    global $customersDb;
    $conn = getConnection($customersDbHost, $customersDb);
    $query = "select id, name from Customer where Id in (" . implode(",", $customerIds) . ")";
    $rows = mysqli_query($conn, $query);

    $customers = array();
    if (mysqli_num_rows($rows) > 0) {
        while ($row = mysqli_fetch_assoc($rows)) {
            $customer['id'] = $row['Id'];
            $customer['name'] = $row['Name'];

            $customers[$customer['id']] = $customer;
        }
    }

    mysqli_close($conn);

    return $customers;
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