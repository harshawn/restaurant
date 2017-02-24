<?php
$page_css = "customerLogin";
include('header.php');
?>

        <div class="container">
            


            <?php

            if(isset($_SESSION['customerEmail']))
            {
                $customer_email=$_SESSION['customerEmail'];

                $check_customer="SELECT customer_firstname FROM `customers` WHERE customer_email='$customer_email'";

                $run=mysqli_query($conn,$check_customer);

                if(mysqli_num_rows($run)>0) {
                    while($run_array = mysqli_fetch_array($run)){
                        $customer_name = $run_array['customer_firstname'];
                        echo "<h1> Welcome ". $customer_name . " </h1>";
                    }
                }
                else {
                    echo "NO USER FOUND?????";
                }


            }
            ?>

        </div>

<?php
include('footer.php');
?>
