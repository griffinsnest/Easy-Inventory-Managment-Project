<?php
    session_start();
    require "../database/connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        addInventory();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./removeInventoryView.php");
    }
    

    function addInventory() {
        $addInventoryMsg = "";
        $productName = $_POST['productName'];
        $lowStock = $_POST['lowStock'];
        $stock = $_POST['stock'];
        $unit = $_POST['unit'];
        
        if(empty($form_msg)) {
            $connection = db_connect();
            $query = "insert into products (product_name, low_stock, stock, unit)
                        values ('$productName', '$lowStock', '$stock', '$unit');";
            if (mysqli_query($connection, $query)) {
                $form_msg = "$productName has been added";
            } else {
                $form_msg = "update failed" . mysqli_error($connection);
            }
            mysqli_close($connection);
        }

        $_SESSION['form_msg'] = $form_msg;
        header("Location: ./addInventoryView.php");

    }


?>