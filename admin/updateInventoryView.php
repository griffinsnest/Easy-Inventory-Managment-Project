<?php
   session_start();
   require "../database/connection.php";

    $connection = db_connect();
    
    $sql = "SELECT product_name, stock, low_stock, unit from products";
    
    $result = mysqli_query($connection, $sql);
    
    $x = "";
    if ($result != false) {
        $x .= '<div id="inventoryTableDiv">
        <table class="table">
        <thead>
        <tr>
        <th>Name</th>
        <th>Stock</th>
        <th>Low Stock</th>
        <th>Unit</th>
        <th>Update</th>
        </tr>
        </thead>
        ';
        while($row = mysqli_fetch_assoc($result)) {
            $x .= '<tr>';
            $x .= "<td>" . $row["product_name"] . "</td>";
            $x .= "<td>" . $row["stock"] . "</td>";
            $x .= "<td>" . $row["low_stock"] . "</td>";
            $x .= "<td>" . $row["unit"] . "</td>";
            $x .= '<form name="modifyProd" action="ModifyStock.php" method="post">
            <td> 
                <input type="hidden" name="modify_product_name" value="' . $row["product_name"] . '">
                <input type="number" name="stockChange">
                <input type="submit" name="add" value="Add" >
                <input type="submit" name="sub" value="Sub" >
            </td>
            </form>';
            $x .= "</tr>";
        }
        $x .= '</table>
        </div>';
    } else {
        $x .= "Something isn't working";
    }
    ?>    
    <HTML>
    <head>
        <title>Update Inventory</title>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <div id="sidenav">
            <button onClick="document.location.href='./GetInventory.php'">Check Inventory</button>
            <button onClick="document.location.href='./updateInventoryView.php'">Update Inventory</button>
            <button onClick="document.location.href='./addInventoryView.php'"<?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Add Inventory</button>
            <button onClick="document.location.href='./removeInventoryView.php'" <?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Remove Inventory</button>
            <button onClick="document.location.href='./usersView.php'"<?php if($_SESSION['user_role'] != 1) {?> style="display: none;" <?php } ?>>Manage Users</button>
        </div>
        <div class="main">
            <h1>Selected Inventory | <a href="./homeView.php">Home</a></h1>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for names..">
            <br>
            <br>
            <?php
              echo $x;
            ?>
        </div>
    </body>
 </HTML>
   


<!-- Based on code from https://www.w3schools.com/howto/howto_js_filter_table.asp-->
<script>
    function filterTable() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("inventoryTableDiv");
      tr = table.getElementsByTagName("tr");
    
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
</script>
