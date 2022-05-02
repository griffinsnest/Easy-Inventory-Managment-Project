<?php
    session_start();
    require "../database/connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        deleteUser();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./usersView.php");
    }

    function deleteUser() {
        $connection = db_connect();
        $deleteUserMsg = "";
        $deleteUserId = $_POST["delete_user_id"];
        if ($_SESSION['user_id'] == $deleteUserId) {
            $deleteUserMsg = "User cannot delete itself";
        } else {
            $query = "delete from users where user_id = $deleteUserId;";
            if (mysqli_query($connection, $query)) {
                $deleteUserMsg = "User $deleteUserId has been removed";
            } else {
                $deleteUserMsg = "update failed" . mysqli_error($connection);
            }
            mysqli_close($connection);
        }
        $_SESSION['form_msg'] = $deleteUserMsg;
        header("Location: ./usersView.php");
    }

?>