<?php
$customersDbHost = "172.18.0.2";
$customersDb = "Customers";

function insertCustomer($name)
{
    global $customersDbHost;
    global $customersDb;
    $conn = getConnection($customersDbHost, $customersDb);
    $query = $conn->prepare("INSERT INTO Customer('Name') VALUES (?)");
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
    $query = "select Id, Name from Customer where Id in (" . implode(",", $customerIds) . ")";
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
?>