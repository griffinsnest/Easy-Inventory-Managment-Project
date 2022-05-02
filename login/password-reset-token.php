<?php
    //Code implmentation of source code found at https://laratutorials.com/php-send-reset-password-link-email/
    require "../database/connection.php";
    require "../phpmailer/includes/PHPMailer.php";
    require "../phpmailer/includes/Exception.php";
    require "../phpmailer/includes/SMTP.php";
   
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $connection = db_connect();

    if(isset($_POST['password-reset-token']) && $_POST['email']){
        $email = $_POST['email'];
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($connection, $query);
        $row= mysqli_fetch_array($result);
        if($row){
            $token = md5($email).rand(10,9999);
            $expFormat = mktime(
            date("H")+2, date("i"), date("s"), date("m") ,date("d"), date("Y")
            );
            $expDate = date("Y-m-d H:i:s",$expFormat);

            $query = "insert into password_reset (email, link, expDate) values ('$email', '$token', '$expDate');";
           
            mysqli_query($connection,$query);

            //$link = "<a href='http://localhost/inventory_manager/login/new-password.php?key=".$email."&token=".$token."'>Click To Reset password</a>";
            $link = "<a href='https://easy-inventory-managment.herokuapp.com//login/new-password.php?key=".$email."&token=".$token."'>Click To Reset password</a>";
            

            $mail = new PHPMailer();
            $mail->CharSet =  "utf-8";
            $mail->IsSMTP();
            // sets GMAIL as the SMTP server
            $mail->Host = "in-v3.mailjet.com";
            // enable SMTP authentication
            $mail->SMTPAuth = true;                  
            // Mailjet username
            $mail->Username = "2fcfa000dac6d0385009c635e8fb34d3";
            // Mailjet password
            $mail->Password = "89badf69ec10a48b805542f34c22a1b7";
            $mail->SMTPSecure = "tls";  
            // set the SMTP port for the GMAIL server
            $mail->Port = "587";
            $mail->setFrom('easy.inventory.manager@gmail.com','Easy Inventory Management Team') ;
            $mail->AddAddress($email);
            $mail->Subject  =  'Reset Password';
            $mail->IsHTML(true);
            $mail->Body    = 'Click On This Link to Reset Password '.$link.'';
            if($mail->Send())
            {
            echo "Check Your Email and Click on the link sent to your email";
            }
            else
            {
            echo "Mail Error - >".$mail->ErrorInfo;
            }
        }
    else{
        echo "Invalid Email Address. Go back";
    }
    }
?>
