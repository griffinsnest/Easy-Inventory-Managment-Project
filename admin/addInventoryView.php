<?php
    session_start();
    // checking if user is authorized - admin only
    if ($_SESSION['user_role'] != 1) {
        die("unauthorized access");
    }
    require './functions.php';
    $users = fetchInventory();

?>

<html>
    <head>
        <title>Add Inventory</title>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <div id="sidenav">
            <button onClick="document.location.href='./GetInventory.php'">Check Inventory</button>
            <button onClick="document.location.href='./updateInventoryView.php'">Update Inventory</button>
            <button onClick="document.location.href='./addInventoryView.php'"<?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Add Inventory</button>
            <button onClick="document.location.href='./removeInventoryView.php'"<?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Remove Inventory</button>
            <button onClick="document.location.href='./usersView.php'"<?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Manage Users</button>
        </div>
        <div class="main">
            <h1>Add Inventory | <a href="./homeView.php">Home</a></h1>
            <h4 id="inventoryFormMsg"><?php if(isset($_SESSION['form_msg'])){echo $_SESSION['form_msg']; unset($_SESSION['form_msg']);}?></h4>
            <div id="addInventoryDiv">
                <table>
                    <form name="add_inventory" action="addInventory.php" method="post">
                        <tr>
                            <th>Product Name: </th>
                            <th><input type="text" name="productName" required></th>
                        </tr>
                        <tr>
                            <th>Stock: </th>
                            <th><input type="text" name="stock" required></th>
                        </tr>
                        </tr>
                        <tr>
                            <th>Low Stock: </th>
                            <th><input type="text" name="lowStock" required></th>
                        </tr>
                        <tr>
                            <th>Unit: </th>
                            <th><input type="text" name="unit"></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th><input type="submit" name="s" value="Add Inventory"></th>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
        
        