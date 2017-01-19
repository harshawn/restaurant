<?php
include('header.php');
?>

<link rel="stylesheet" href="css/restaurantsLogin.css">
    
    <body>
        
        <div class="container">
            <h1>Restaurants Login</h1>
                      
            <div class="form-login">
                <form action="" method="POST">
                    <input type="text" name="customerEmail" class="form-control input-sm chat-input" placeholder="Email">
                    <br>
                    <input type="text" name="customerPassword" class="form-control input-sm chat-input" placeholder="Password">
                    <br>
                    <input type="submit" name="Login" value="Login">
                    <br><br>
                </form>
            </div>
            
            
        </div>

<?php
include('footer.php');
?>

<?php  
/*
    if(isset($_POST['Login']))  
    {  
        $customer_email=$_POST['customerEmail'];  
        $customer_pass=$_POST['customerPassword'];  

        $check_customer="SELECT * FROM customers WHERE customer_email='$customer_email'AND customer_password='$customer_pass'";  

        $run=mysqli_query($conn,$check_customer);  

        if(mysqli_num_rows($run)) {  
            echo "<script>window.open('customerWelcome.php','_self')</script>";  
            $_SESSION['customerEmail']=$customer_email;//here session is used and value of $user_email store in $_SESSION.  
        }  
        else {  
          echo "<script>alert('Email or password is incorrect!')</script>";  
        }  
    }  
?>
 */

