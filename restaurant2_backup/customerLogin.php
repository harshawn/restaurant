<?php
$page_css = "customerLogin";
require_once('header.php');
/* USED THIS AS HELP ::::::::::::::::::::::::::::::::::::::::::::<<<<<<<<<<<<
 * http://www.c-sharpcorner.com/uploadfile/9582c9/script-for-login-logout-and-view-using-php-mysql-and-boots/
 */
?>
        
        <div class="container">
            <h1>Customer Login</h1>
                      
            <div class="form-login">
                <form action="" method="POST">
                    <input type="text" name="customerEmail" class="form-control input-sm chat-input" placeholder="Email">
                    <br>
                    <input type="text" name="customerPassword" class="form-control input-sm chat-input" placeholder="Password">
                    <br>
                    <input type="submit" name="Login" value="Login"> <input type="submit" name="customerRegister" value="Register">
                    <br><br>
                </form>
            </div>
            
            
        </div>
                
<?php
include('footer.php');
?>

<?php

    if (isset($_POST['Login'])) {

        $customer_email = $_POST['customerEmail'];
        $customer_pass = $_POST['customerPassword'];

        $check_customer = "SELECT * FROM `customers` WHERE customer_email='$customer_email'AND customer_password='$customer_pass'";

        $run = mysqli_query($conn, $check_customer);

        if(isset($_SESSION['selected_restaurant_ID'])) {
            if (mysqli_num_rows($run)) {
                $_SESSION['customerEmail'] = $customer_email;//here session is used and value of $user_email store in $_SESSION.
                echo "<script>window.open('makeReservation.php','_self')</script>";
            } else {
                echo "<script>alert('Email or password is incorrect!')</script>";
            }
        }
        else {
            if (mysqli_num_rows($run)) {
                $_SESSION['customerEmail'] = $customer_email;//here session is used and value of $user_email store in $_SESSION.
                echo "<script>window.open('customerWelcome.php','_self')</script>";
            } else {
                echo "<script>alert('Email or password is incorrect!')</script>";
            }
        }
    }

    if (isset($_POST['customerRegister'])) {
        echo "<script>window.open('customerRegistration.php','_self')</script>";
    }

?>