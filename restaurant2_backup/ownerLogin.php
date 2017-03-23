<?php
$page_css = "restaurantsLogin";
include('header.php');
?>
        
        <div class="container">
            <h1>Restaurants Login</h1>
                      
            <div class="form-login">
                <form action="" method="POST">
                    <input type="text" name="ownerEmail" class="form-control input-sm chat-input" placeholder="Email">
                    <br>
                    <input type="password" name="ownerPassword" class="form-control input-sm chat-input" placeholder="Password">
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

if(isset($_POST['Login']))
{
    $owner_email=$_POST['ownerEmail'];
    $owner_pass=$_POST['ownerPassword'];

    $check_owner="SELECT * FROM `restaurant_owner` WHERE owner_email='$owner_email'AND owner_password='$owner_pass'";

    $run=mysqli_query($conn,$check_owner);

    if(mysqli_num_rows($run)) {
        echo "<script>window.open('ownerWelcome.php','_self')</script>";
        $_SESSION['ownerEmail']=$owner_email;//here session is used and value of $user_email store in $_SESSION.
    }
    else {
        echo "<script>alert('Email or password is incorrect!')</script>";
    }
}
?>

