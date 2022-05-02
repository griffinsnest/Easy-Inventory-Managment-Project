<?php
    session_start();
    require './functions.php';
    // checking  user  authorization
    if ($_SESSION['user_role'] == 1) {
        $users = fetchUsersAdmin();
    }
    elseif ($_SESSION['user_role'] == 2) {
        $users = fetchUsers($_SESSION['user_role']);
    }
    
    

?>

<html>
    <head>
        <title>Manage Users</title>
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
            <h1>Manage Users | <a href="./homeView.php">Home</a></h1>
            <div id="usersFormMsg"><h2><?php if(isset($_SESSION['form_msg'])){echo $_SESSION['form_msg'];}?></h2></div>
            <div id="topUsersDiv">
                <div id="userTableDiv">
                    <h1>Current Users</h1>
                    <!-- https://stackoverflow.com/questions/4746079/how-to-create-a-html-table-from-a-php-array -->
                    <table id="userTable">
                        <thead>
                            <tr>
                                <th>ID</th> 
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $row): array_map('htmlentities', $row); ?>
                                <tr>
                                <td><?php echo implode('</td><td>', $row); ?></td>
                                <form name="deleteUser" action="deleteUser.php" method="post">
                                    <td>
                                        <input type="hidden" name="delete_user_id" value=<?php echo $row['id']; ?> >
                                        <input type="submit" name="s" value="Delete User" >
                                    </td>
                                </form>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div id="userSpaceDiv">
                </div>
            </div>
            <div id="bottomUsersDiv">
                <div id="addUserDiv">
                    <h1>Add User</h1>
                    <table>
                        <form name="add_user" action="addUser.php" method="post">
                            <tr>
                                <th>Email:</th>
                                <th><input type="text" name="email" required></th>
                            </tr>
                            <tr>
                                <th>First Name:</th>
                                <th> <input type="text" name="fn" required></th>
                            </tr>
                            <tr>
                                <th>Last Name:</th>
                                <th><input type="text" name="ln" required></th>
                            </tr>
                            <tr>
                                <th>Password:</th>
                                <th><input type="text" name="pw" required></th>
                            </tr>
                            <tr>
                                <th>User Role:</th>
                                <th><select name="role" required>
                                            <option value="">None</option>    
                                            <option value="1">Administrator</option>
                                            <option value="2">General User</option>
                                    </select>
                                </th>
                            </tr>
                            <tr>
                                <th></th>
                                <th><input type="submit" name="s" value="Add User"></th>
                            </tr>
                        </form>
                    </table>
                </div>
                <div id="updateUserDiv">
                    <h1>Update User</h1>
                    <form name="update_user" action="validateUserUpdate.php" method="post">
                        <label for="users">User to modify:</label>
                            <select name="users" required>
                                <option value="">ID</option>
                                <?php foreach($users as $row): array_map('htmlentities', $row);?>
                                    <option value=<?php echo $row['id']?> > <?php echo $row['id']?> </option>
                                <?php endforeach; ?>
                            </select>
                        <br>
                        <label for="options">Item to modify:</label>
                            <select name="options" required>
                                <option value="">Item</option>
                                    <?php foreach($users[0] as $key=>$value){
                                        //dont want to be able to modify id
                                        if ($key != "id") {
                                            echo "<option value=" . $key .">" . $key . "</option>";
                                        }}?>
                            </select>
                        <br>
                        <input type="text" placeholder="New Value" id="updateVal" name="updateVal" required>
                        <input type="submit" name="s" value="Update User">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>