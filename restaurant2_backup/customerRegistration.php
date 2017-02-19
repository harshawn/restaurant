<?php
$page_css = "customerLogin";
include('header.php');
?>
        
        <div class="container">
            <h1>Customer Registration</h1>
                      
            <div class="form-login">
                <form action="" method="POST">
                    <input type="text" name="customerTitle" class="form-control input-sm chat-input" placeholder="Title e.g. Mr, Mrs, Miss">
                    <br>
                    <input type="text" name="customerFirstName" class="form-control input-sm chat-input" placeholder="Firstname">
                    <br>
                    <input type="text" name="customerLastName" class="form-control input-sm chat-input" placeholder="Lastname">
                    <br>
                    <input type="text" name="customerEmail" class="form-control input-sm chat-input" placeholder="Email">
                    <br>
                    <input type="text" name="customerPassword" class="form-control input-sm chat-input" placeholder="Password">
                    <br>
                    <input type="submit" name="customerRegister" value="Register">
                    <br><br>
                </form>
            </div>

        </div>

<?php
include('footer.php');
?>

<?php  

    if(isset($_POST['customerRegister']))
    {
        $customer_title=$_POST['customerTitle'];
        $customer_firstname=$_POST['customerFirstName'];
        $customer_lastname=$_POST['customerLastName'];
        $customer_email=$_POST['customerEmail'];
        $customer_pass=$_POST['customerPassword'];  

        $check_email="SELECT * FROM `customers` WHERE customer_email = $customer_email";

        $run=mysqli_query($conn,$check_email);

        if(mysqli_num_rows($run)>0){
                echo "<script>alert('Email already in use, select Forgot Password')</script>";
        }

        else {
            $add_customer = "INSERT INTO customers(customer_title, customer_firstname, customer_lastname, customer_email, customer_password)
                                VALUES('$customer_title','$customer_firstname','$customer_lastname','$customer_email','$customer_pass')";

            if ($conn->query($add_customer) == TRUE) {
                echo "<script>alert('New record created successfully')</script>";

                echo "<script>window.open('customerWelcome.php','_self')</script>";
                $_SESSION['customerEmail']=$customer_email;//here session is used and value of $user_email store in $_SESSION.
            } else {
                echo "Error: " . $add_customer . "<br>" . $conn->error;
            }
        }  

    }  
?>