<?php
require "../database/connection.php";

$connection = db_connect();

function fetchInventory(){
    $connection = db_connect();
    $query = "select product_id, product_name, stock, low_stock, unit from products;";
    $result = mysqli_query($connection, $query);
    $products = array();
    while($row = mysqli_fetch_assoc($result)) {
        $products[] = ['productID' => $row['product_id'],
                      'productName' => $row['product_name'],
                      'stock' => $row['stock'],
                      'lowStock' => $row['low_stock'],
                      'unit' => $row['unit']];
    }
    return $products;
}

function fetchUsersAdmin(){
    $connection = db_connect();
    $query = "select user_id, first_name, last_name, user_type from users;";
    $result = mysqli_query($connection, $query);
    $users = array();
    while($row = mysqli_fetch_assoc($result)) {
        $role = 0;
        if ($row['user_type'] == 1)
            $role = "Admin";
        else if ($row['user_type'] == 2)
            $role = "General User";
        else
            $role = $row['user_type'];
        $users[] = ['id' => $row['user_id'],
                    'fn' => $row['first_name'],
                    'ln' => $row['last_name'],
                    'role' => $role];
    }
    return $users;
}

function fetchUsers($Id){
    $connection = db_connect();
    $query = "select user_id, email, first_name, last_name, user_type, PASSWORD from users where user_id = $Id;";
    $result = mysqli_query($connection, $query);
    $users = array();
    while($row = mysqli_fetch_assoc($result)) {
        $users[] = ['id' => $row['user_id'],
                    'email' => $row['email'],
                    'fn' => $row['first_name'],
                    'ln' => $row['last_name'],
                    'role' => $row['user_type']];
    }
    return $users;
}

?>