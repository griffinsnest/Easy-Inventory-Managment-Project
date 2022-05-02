<?php
   require "../database/connection.php";
   session_start();
   error_reporting(0);

    $connection = db_connect();
    
    $sql = "SELECT product_name, stock, low_stock, unit from products";
    
    $result = mysqli_query($connection, $sql);

    //https://stackoverflow.com/questions/6574927/exporting-mysql-table-to-txt-or-doc-file-using-php
    function generateReport() {
        $dataNow = array();
        $dataPast = array();
        $connection = db_connect();

        $sql = "SELECT * FROM products ORDER BY product_id";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result)) {          
            $last = end($row);
            $num = mysqli_num_fields($result);   
            $nextLine = "";
            for($i = 0; $i < $num; $i++) {            
                $nextLine .= $row[$i];
                if ($row[$i] != $last)
                   $nextLine .= ",";
            }                                                                 
            array_push($dataNow, $nextLine);
        }

        $sql = "SELECT * FROM past_products ORDER BY product_id";
        $result = mysqli_query($connection, $sql);
        while ($row = mysqli_fetch_array($result)) {          
            $last = end($row);          
            $num = mysqli_num_fields($result);   
            $nextLine = ""; 
            for($i = 0; $i < $num; $i++) {            
                $nextLine .= $row[$i];
                if ($row[$i] != $last)
                   $nextLine .= ",";
            }
            array_push($dataPast, $nextLine);
        }

        $past = array();
        $now = array();
        $pastkeys = array();
        $nowkeys = array();
        $report = array();

        foreach($dataPast as $line) {
            $temp = explode(",", $line, 2);
            $key = $temp[0];
            $value = $temp[0].",".$temp[1];
            $past[$key] = $value;
            array_push($pastkeys, $key);
        }

        foreach($dataNow as $line) {
            $temp = explode(",", $line, 2);
            $key = $temp[0];
            $value = $temp[0].",".$temp[1];
            $now[$key] = $value;
            array_push($nowkeys, $key);
        }

        $nowcounter = 0;

        array_push($report, "ID,Item Name,Count,Low Stock,Unit\n");
        while($nowcounter < count($now)) {
            $currentkey = $nowkeys[$nowcounter];
            $str = str_replace("\n", '', $now[$currentkey]);
            if ($now[$currentkey] != "" && $past[$currentkey] != "") {
                $nowcontent = explode(",", $now[$currentkey]);
                $pastcontent = explode(",", $past[$currentkey]);
                if ($nowcontent[2] != $pastcontent[2]) {
                    $str = $nowcontent[0].",".$nowcontent[1].",".$pastcontent[2]." -> ".$nowcontent[2].",".$nowcontent[3].",".$nowcontent[4];
                }
                if ($nowcontent[2] <= $nowcontent[3]) {
                    $str .= ",(Low Stock)";
                }
                $str .= "\n";
                array_push($report, $str);
            }
            elseif ($now[$currentkey] != "" && $past[$currentkey] == "") {
                $str = str_replace("\n", '', $now[$currentkey]);
                $str .= ",(Added)";
                $nowcontent = explode(",", $now[$currentkey]);
                if ($nowcontent[2] <= $nowcontent[3])
                    $str .= ",(Low Stock)";
                $str .= "\n";
                array_push($report, $str);
            }
            $nowcounter++;
        }


        $removeditemexists = false;

        foreach($pastkeys as $key) {
            if ($now[$key] == "")
                $removeditemexists = true;
        }

        $pastcounter = 0;

        if ($removeditemexists) {
            array_push($report, ",,Removed Items,,\n");
            while($pastcounter < count($past)) {
                $currentkey = $pastkeys[$pastcounter];
                if ($now[$currentkey] == "") {
                    $str = str_replace("\n", '', $past[$currentkey]);
                    $str .= ",(Removed)";
                    $str .= "\n";
                    array_push($report, $str);
                }
                $pastcounter++;
            }
        }
        
        unset($_POST['generateReport']);

        $date = date('d-m-Y');
        header("Content-Type: application/octet-stream");
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"$date Report.csv\""); 
        foreach($report as $line) {
            echo $line;
        }

        mysqli_query($connection, "DELETE FROM past_products;");
        foreach($dataNow as $entry) {
            $temp = explode(",", $entry);
            $query = "INSERT into past_products (product_id, product_name, stock)
                    VALUES ('$temp[0]', '$temp[1]', '$temp[2]');";
            mysqli_query($connection, $query);
        }

        die();
    }

    if(isset($_POST['generateReport'])) {
        generateReport();
    }
    
    $tableContent = "";
    if ($result != false) {
        $savedTableContent = "";
        $tableContent .= '<div id="inventoryTableDiv">
        <table class="table">
        <thead>
        <tr>
        <th>Name</th>
        <th>Stock</th>
        <th>Low Stock</th>
        <th>Unit</sth>
        </tr>
        </thead>
        ';
        while($row = mysqli_fetch_assoc($result)) {
            if ($row["stock"] <= $row["low_stock"]) {
                $tableContent .= '<tr>';
                $tableContent .= "<td>" . $row["product_name"] . "</td>";
                $tableContent .= "<td>" . $row["stock"] . "</td>";
                $tableContent .= "<td>" . $row["low_stock"] . "</td>";
                $tableContent .= "<td>" . $row["unit"] . "</td>";
                $tableContent .= "</tr>";
            }
            else {
                $savedTableContent .= '<tr>';
                $savedTableContent .= "<td>" . $row["product_name"] . "</td>";
                $savedTableContent .= "<td>" . $row["stock"] . "</td>";
                $savedTableContent .= "<td>" . $row["low_stock"] . "</td>";
                $savedTableContent .= "<td>" . $row["unit"] . "</td>";
                $savedTableContent .= "</tr>";
            }
        }
        $tableContent .= $savedTableContent;
        $tableContent .= '</table>
        </div>';
    } else {
        $tableContent .= "Something isn't working";
    }
?>
    <HTML>
    <head>
        <title>Check Inventory</title>
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
            <h1>Selected Inventory | <a href="./homeView.php">Home</a></h1>
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for names..">
            <br>
            <br>
            <?php
                echo $tableContent;
            ?>
            <br>
            <form method="post">
                <input type="submit" name="generateReport" value="Generate Report"/>
            </form>
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