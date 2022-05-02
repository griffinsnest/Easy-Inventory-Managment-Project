<?php
    session_start();
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Inventory Management System</title>
        <link rel="stylesheet" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0">
        <style type="text/css">
            body{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <h1>Login</h1>
        <p>Please Enter Your Login Information</p>
        <form name="login" action="login/login.php" method="post" autocomplete="off">
            Email: <input type="text" name="email" required /><br>
            Password: <input type="password" name="password" required/>
            <h3 class="error"> <?php if(isset($_SESSION['login_err'])) {echo $_SESSION['login_err'];} ?></h3>
            <input type="submit" name="Login" value="Login" />
        </form>
        <br>
        <form action="login/resetPasswordView.php">
            <input type="submit" value="Forgot Password?" />
        </form>
    </body>
</html>