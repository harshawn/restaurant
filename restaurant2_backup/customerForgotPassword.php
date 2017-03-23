<?php
$page_css = "customerLogin";
require_once('header.php');
/* USED THIS AS HELP ::::::::::::::::::::::::::::::::::::::::::::<<<<<<<<<<<<
 * http://www.c-sharpcorner.com/uploadfile/9582c9/script-for-login-logout-and-view-using-php-mysql-and-boots/
 *
 */
?>
        

                
<?php
include('footer.php');
?>

<?php

    if (isset($_POST['sendCustomerEmail'])) {

        $customer_email = $_POST['customerEmail'];

        $check_customer = "SELECT * FROM `customers` WHERE customer_email='$customer_email'";

        $run = mysqli_query($conn, $check_customer);

        if(mysqli_num_rows($run)>0){

            $run_array = mysqli_fetch_array($run);
            $customer_firstname = $run_array['customer_firstname'];
            $customer_password = $run_array['customer_password'];
            /**************
             **************
             * https://github.com/Synchro/PHPMailer
             * used this http://phpmailer.worxware.com/?pg=examplebgmail
             * http://stackoverflow.com/questions/16048347/send-email-using-gmail-smtp-server-through-php-mailer
             ***************
             **************
             */
            require_once('PHPMailer/class.phpmailer.php');
            require_once('PHPMailer/class.smtp.php');
            $mail = new PHPMailer;
    //      $mail->SMTPDebug = 2;                               // Enable verbose debug output
            $mail->IsSMTP();                                      // Set mailer to use SMTP
            $mail->SMTPAuth = TRUE;                               // Enable SMTP authentication
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->Port = 587;                                    // TCP port to connect to
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Username = 'freetables.noreply@gmail.com';                 // SMTP username
            $mail->Password = 'p13232291';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->setFrom('no-reply@freetables.com', 'freetables-noreply');
            $mail->addAddress($customer_email);     // Add a recipient
       //     $mail->addAddress('ellen@example.com');               // Name is optional
       //     $mail->addReplyTo('info@example.com', 'Information');
       //     $mail->addCC('cc@example.com');
       //     $mail->addBCC('bcc@example.com');
       //     $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
       //     $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // the message
            $msg = "<p>Hi ".$customer_firstname.",</p>
                    <p>Here is your password reminder: <b>".$customer_password."</b></p> 
                    <p>If you have trouble logging in, please contact us. Thanks, \n\nAdmin Team\nadminteam@gmail.com</p>";
            // use wordwrap() if lines are longer than 70 characters
            $msg = wordwrap($msg,70);

            $mail->Subject = 'Forgot Password Request';
            $mail->Body    = $msg;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                echo '
                      <div class="container">
                          <h1>Reminder could not be sent.</h1>
                      </div>';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo '
                    <div class="container">
                        <h1>Reminder has been sent..</h1>
                        <h3>Please check your emails and then <a href="customerLogin.php">Login</a></h3>
                        <p>If you have not received your email, please <a href="help.php"><b>Contact Us</b></a>.</p>
                    </div>';
            }
        }
        else {
            echo "<script>alert('The email you entered does not exist in our system')</script>";
            echo "<script>window.open('customerForgotPassword.php', '_self')</script>";
        }
    }
    else{
        echo '
         <div class="container">
            <h1>Customer Forgot Password</h1>
                      
            <div class="form-login">
                <form action="" method="POST">
                    <input type="text" name="customerEmail" class="form-control input-sm chat-input" placeholder="Email">
                    <br>
                    <input type="submit" name="sendCustomerEmail" value="Send Email">
                    <br><br>
                </form>
            </div>

        </div>
        ';
    }

?>