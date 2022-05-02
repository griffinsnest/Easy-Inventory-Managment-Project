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
            <h1>Login</h1>
            <p>Please Enter Your Email Address</p>
                <form action="password-reset-token.php" method="post">
                    <input type="email" name="email" id="email" >
                    <input type="submit" name="password-reset-token" class="btn btn-primary">
                </form>
        </div>
   </body>
</html>