<?php
    //Code implmentation of source code found at https://laratutorials.com/php-send-reset-password-link-email/
    if(isset($_POST['password']) && $_POST['reset_link_token'] && $_POST['email']) {
        require "../database/connection.php";
        $connection = db_connect();
        $emailId = $_POST['email'];
        $token = $_POST['reset_link_token'];
        $password =$_POST['password'];
        $query = mysqli_query($connection,"SELECT * FROM password_reset WHERE link = '$token' and email = '$emailId';");
        $row = mysqli_num_rows($query);
        if($row){
            mysqli_query($connection,"UPDATE users set PASSWORD = sha2('$password', 256) WHERE email= '$emailId';");
            echo '<p>Congratulations! Your password has been updated successfully.</p>';
            mysqli_query($connection,"DELETE FROM password_reset WHERE link = '$token' and email = '$emailId';");
        } else {
            echo "<p>Something went wrong. Please try again</p>";
        }
    }
?>