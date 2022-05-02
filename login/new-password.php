<html>
   <head>
        <!-- Code implmentation of source code found at https://laratutorials.com/php-send-reset-password-link-email/ -->
      <title>Inventory Management System</title>
       <!-- CSS -->
       <link rel="stylesheet" href="../style.css">
        <style type="text/css">
            body{
                text-align: center;
            }
        </style>
    <body>
        <div class="main">
            <h1>Reset Password</h1>
            <?php
                if($_GET['key'] && $_GET['token']){
                    require "../database/connection.php";
                    $connection = db_connect();
                    $email = $_GET['key'];
                    $token = $_GET['token'];
                    $query = mysqli_query($connection, "SELECT * FROM password_reset WHERE link = '$token' and email = '$email';");

                    $curDate = date("Y-m-d H:i:s");
                    if (mysqli_num_rows($query) > 0) {
                        $row= mysqli_fetch_array($query);
                        if($row['expDate'] >= $curDate){ 
                            echo <<<ABC
                                <form action="update-forget-password.php" method="post">
                                    <input type="hidden" name="email" value = $email>
                                    <input type="hidden" name="reset_link_token" value = $token>
                                    <label>New Password</label>
                                    <input type="password" name='password'>               
                                    <label>Confirm New Password</label>
                                    <input type="password" name='cpassword'>
                                    <input type="submit" name="new-password" class="btn btn-primary">
                                </form>
                            ABC;}
                    } else {
                        $query2 = "DELETE FROM password_reset WHERE link = '$token' and email = '$email';" ;
                        mysqli_query($connection, $query2);
                        echo "It has been over 24 hours since request of password reset, please request another reset token";
                    }
                }
            ?>
        </div>
    </body>
</html>
