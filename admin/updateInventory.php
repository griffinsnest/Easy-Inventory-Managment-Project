<?php
    session_start();
    require "../database/connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        updateInventory();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./updateInventoryView.php");
    }
    

    function updateInventory() {
        $addInventoryMsg = "";
        $productName = $_POST['productName'];
       

        //validate info?
        
        if(empty($form_msg)) {
            $connection = db_connect();
            $query = "SELECT product_name, stock, unit from products where product_name = '$productName'";;
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