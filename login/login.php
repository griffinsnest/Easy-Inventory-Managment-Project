<?php
    // Validates the login
    session_start();

    require "../database/connection.php";

    $connection = db_connect();

    $email = $_POST["email"];
    $pw = $_POST["password"];
    

    $query = "select user_id, first_name, last_name, user_type from users where email='".$email."' and password=sha2('".$pw."', 256);";

    $result = mysqli_query($connection, $query);

    if (!$result)
        die("Query Failed: " . mysqli_error(($connection)));
    else {
        if (mysqli_num_rows($result) == 1) {
            // getting rid of login error if exists
            if (isset($_SESSION['login_err'])) {
                unset($_SESSION['login_err']);
            }
            $row = mysqli_fetch_assoc($result);

            // storing email
            $_SESSION['email']=$email;

            // storing user_id
            $_SESSION['user_id'] = $row['user_id'];

            // getting and storing user name
            $_SESSION['fn'] = $row['first_name'];
            $_SESSION['ln'] = $row['last_name'];

            // getting and storing user role
            $user_role =  $row['user_type'];
            $_SESSION['user_role'] = $user_role;

            // next page
            if ($user_role == 1 or $user_role == 2) {
                header("Location: ../admin/homeView.php");
            }
            
            else {
                die("An error has occured, try reloading the page.");
            }
        }
        else {
            // setting login error
            $_SESSION['login_err'] = "Invalid Login";
            // seding back to login
            header("Location: ../index.php");
        }
    }
?>