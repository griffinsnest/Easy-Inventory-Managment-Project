<?php
    session_start();
    require "../database/connection.php";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        addUser();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./usersView.php");
    }

    function addUser() {
        $addUserMsg = "";
        $email = $_POST['email'];
        $fn = $_POST['fn'];
        $ln = $_POST['ln'];
        $pw = $_POST['pw'];
        $role = $_POST['role'];

        //validating info
        
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_msg = "Email is not valid!\n";
        }
        
        if(!ctype_alpha($fn)) {
            $form_msg .= "First name is not valid!\n";
        }
        if(!ctype_alpha($ln)) {
            $form_msg .= "First name is not valid!\n";
        }

        // if no errors
        if(empty($form_msg)) {
            $connection = db_connect();
            $query = "insert into users (email, first_name, last_name, PASSWORD, user_type)
                        values ('$email', '$fn', '$ln', sha2('$pw', 256), $role);";
            if (mysqli_query($connection, $query)) {
                $form_msg = "$fn $ln has been added";
            } else {
                $form_msg = "update failed" . mysqli_error($connection);
            }
            mysqli_close($connection);
        }

        $_SESSION['form_msg'] = $form_msg;
        header("Location: ./usersView.php");

    }


?>