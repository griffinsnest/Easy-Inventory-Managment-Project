<?php 
    session_start();
    //checking if user is authorized
    /* if ($_SESSION['user_role'] != 1) {
        $style = "style='display:none;'";
    } */
    if(isset($_SESSION['form_msg'])){$_SESSION['form_msg'] = "";}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Inventory Management System</title>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <div id="sidenav">
            <button onClick="document.location.href='./GetInventory.php'">Check Inventory</button>
            <button onClick="document.location.href='./updateInventoryView.php'">Update Inventory</button>
            <button onClick="document.location.href='./addInventoryView.php'"<?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Add Inventory</button>
            <button onClick="document.location.href='./removeInventoryView.php'" <?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Remove Inventory</button>
            <button onClick="document.location.href='./usersView.php'" <?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Manage Users</button>
        </div>
        <div class="main">
            <h1>Welcome  <?php echo $_SESSION['fn'] ?></h1>
            <p>Please Select An Action</p>
        </div>
    </body>