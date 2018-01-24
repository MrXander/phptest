<?php
$user = "root";
$pass = "root";

$ordersDbHost = "172.17.0.2";
$ordersDb = "Orders";

$customersDbHost = "172.18.0.2";
$customersDb = "Customers";

$contractorsDbHost = "172.17.0.3";
$contractorsDb = "Contractors";
?>

<html>
<head>
    <title>Vk test</title>
</head>
<body>
<ul>
    <?php
            $ordersData = loadOrders();
            for($i = 0; $i < count($ordersData); $i++){
                $order = $ordersData[$i];
                print "<li>" . "#" . $order['id'] . " " . $order['title'] . " Customer:" . $order['customer'] . "</li>";
            }
        ?>
</ul>
</body>
</html>

<?php
function loadOrders()
{
    $orders = getOrders();
    for ($i = 0; $i < count($orders); $i++) {
        $order = $orders[$i];
        //echo $order['id'] . ": " . $order['title'];
    }

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
    $query = "select * from Orders";
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

function getCustomers($customerIds)
{
    global $customersDbHost;
    global $customersDb;
    $conn = getConnection($customersDbHost, $customersDb);
    $query = "select * from Customer where Id in (" . implode(",", $customerIds) . ")";
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
