<?php
    session_start();
    require "../database/connection.php";
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        checkForm();
    }
    else {
        $_SESSION['form_msg'] = "Something went wrong";
        header("Location: ./usersView.php");
    }

    
    function checkForm() {
        $form_msg = "";
        //'users', 'options', 'updateVal'
        $user = trim(htmlspecialchars($_POST['users']));
        $option = trim(htmlspecialchars($_POST['options']));
        $val = trim(htmlspecialchars($_POST['updateVal']));
        $connection = db_connect();
        switch ($option) {
            case 'email':
                // https://stackoverflow.com/questions/13719821/email-validation-using-regular-expression-in-php
                if(!filter_var($val, FILTER_VALIDATE_EMAIL)) {
                    $form_msg = "Email is not valid!";
                } else {
                    $form_msg = updateUser($connection, "email_address", $val, $user);
                }
                break;
            case 'fn':
                if(!ctype_alpha($val)) {
                    $form_msg = "First name is not valid!";
                } else {
                    $form_msg = updateUser($connection, "first_name", $val, $user);
                }
                break;
            case 'ln':
                if(!ctype_alpha($val)) {
                    $form_msg = "First name is not valid!";
                } else {
                    $form_msg = updateUser($connection, "last_name", $val, $user);
                }
                break;
            case 'role':
                if($val != '1' && $val != '2') {
                    $form_msg = "Not a valid user role";
                } else {
                    $form_msg = updateUser($connection, "user_type", $val, $user);
                }
                break;
        }
        mysqli_close($connection);
        $_SESSION['form_msg'] = $form_msg;
        header("Location: ./usersView.php");
    }

    function updateUser($connection, $col, $val, $id) {
        //$query = "update user set " . $col . " = " . $val . "where user_id = " . $id . ";";
        $query = "update users set $col = '$val' where user_id = $id;";
        if (mysqli_query($connection, $query)) {
            return "Update successful. User $id's $col is now $val.";
        } else {
            return "update failed" . mysqli_error($connection);
        }
    }


?>
