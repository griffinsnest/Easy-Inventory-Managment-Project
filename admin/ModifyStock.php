<?php
    session_start();
    require "../database/connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        modStock();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./updateInventoryView.php");
    }
    

    function modStock() {
        $modifyInventoryMsg = "";
        $productName = $_POST['modify_product_name'];
        $change = $_POST['stockChange'];
        if(!is_numeric($change))
            $change = 1;

        if(empty($form_msg)) {
            $connection = db_connect();
            $query = "SELECT stock from products where product_name = '$productName'";
            $result = mysqli_query($connection, $query);
            $row=$result->fetch_assoc();
            $stock = intval($row['stock']);
            if(isset($_POST["add"]))
                $newStock = $stock + $change;
            if(isset($_POST["sub"]))
                $newStock = $stock - $change;
            $query2 = "update products set stock = '$newStock' where product_name = '$productName'";
            if (mysqli_query($connection, $query2)) {
                $form_msg = "Update successful. Stock changed from $stock to $newStock.";
            } else {
                $form_msg = "update failed" . mysqli_error($connection);
            }
            mysqli_close($connection);
        }

        $_SESSION['form_msg'] = $form_msg;
        header("Location: ./updateInventoryView.php");

    }

