<?php
    session_start();
    // checking if user is authorized - admin
    if ($_SESSION['user_role'] != 1) {
        die("unauthorized access");
    }
    require './functions.php';
    $parts = fetchInventory();

?>


<html>
    <head>
        <title>Remove Inventory</title>
        <link rel="stylesheet" href="../style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
    </head>
    <body>
        <div id="sidenav">
            <button onClick="document.location.href='./GetInventory.php'">Check Inventory</button>
            <button onClick="document.location.href='./updateInventoryView.php'">Update Inventory</button>
            <button onClick="document.location.href='./addInventoryView.php'">Add Inventory</button>
            <button onClick="document.location.href='./removeInventoryView.php'">Remove Inventory</button>
            <button onClick="document.location.href='./usersView.php'">Manage Users</button>
        </div>
        <div class="main">
            <h1>Remove Inventory | <a href="./homeView.php">Home</a></h1>
            <h4 id="inventoryFormMsg"><?php if(isset($_SESSION['form_msg'])){echo $_SESSION['form_msg']; unset($_SESSION['form_msg']);}?></h4>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for names..">
            <br>
            <br>
            <div id="inventoryTableDiv">
                <!-- https://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array -->
                <table  class="table" id="inventoryTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Stock</th>
                            <th>Low Stock</th>
                            <th>Unit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($parts as $row): array_map('htmlentities', $row); ?>
                            <tr>
                            <td><?php echo implode('</td><td>', $row); ?></td>
                            <form name="removeProduct" action="removeInventory.php" method="post">
                                <td>
                                    <input type="hidden" name="remove_product_id" value=<?php echo $row['productID']; ?> >
                                    <input type="submit" name="s" value="Remove" >
                                </td>
                            </form>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>
        
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
        td = tr[i].getElementsByTagName("td")[1];
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