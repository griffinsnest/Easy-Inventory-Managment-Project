<?php
    session_start();
    require "../database/connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        removeInventory();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./removeInventoryView.php");
    }
    

    function removeInventory() {
        $connection = db_connect();
        $deleteProductPartMsg = "";
        $deleteProductId = $_POST["remove_product_id"];
        $query = "delete from products where product_id = '$deleteProductId';";
        if (mysqli_query($connection, $query)) {
            $deleteProductMsg = "Product $deleteProductId has been removed";
        } else {
            $deleteProductMsg = "update failed" . mysqli_error($connection);
        }
        mysqli_close($connection);
        
        $_SESSION['form_msg'] = $deleteProductMsg;
        header("Location: ./removeInventoryView.php");
    }


?>