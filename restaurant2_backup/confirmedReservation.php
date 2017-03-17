<?php
$page_css = "viewTablesAvailable";
include('header.php');
?>

<div class="container">

    <?php
    if(isset($_SESSION['selected_restaurant_ID'])) {
        echo "<p>helloooooooooooooooo</p>";
        $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];
        echo $selected_restaurant_ID;

        $check_restaurant_tables_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                                    INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                    WHERE `restaurant_table_ID` = '$selected_restaurant_ID'                                                                                                          
                                                                              ");
        if(mysqli_num_rows($check_restaurant_tables_query)>0){
            while($check_restaurant_tables_array = mysqli_fetch_array($check_restaurant_tables_query)){
                $restaurant_name = $check_restaurant_tables_array['restaurant_name'];
                echo "<h1>You have selected ".$restaurant_name."</h1>";
            }
        }

        echo '
            <div class="form-login">
                <form action="" method="POST">
                <h2>Please enter your details below, then press confirm to view your reservation details</h2>
                    <input type="text" name="customerTitle" class="form-control input-sm chat-input" placeholder="Title e.g. Mr, Mrs, Miss">
                    <br>
                    <input type="text" name="customerFirstName" class="form-control input-sm chat-input" placeholder="Firstname">
                    <br>
                    <input type="text" name="customerLastName" class="form-control input-sm chat-input" placeholder="Lastname">
                    <br>
                    <input type="text" name="customerEmail" class="form-control input-sm chat-input" placeholder="Email">
                    <br>

                    <input type="submit" name="newCustomerConfirm" value="Confirm">
                    <br><br>
                </form>
            </div>
        ';
    }
    else {
        echo "nothing is here";
    }

    ?>

</div>

<?php
include('footer.php');
?>


<?php
if(isset($_POST['newCustomerConfirm']))
{
    $customer_title=$_POST['customerTitle'];
    $customer_firstname=$_POST['customerFirstName'];
    $customer_lastname=$_POST['customerLastName'];
    $customer_email=$_POST['customerEmail'];

    $check_email="SELECT * FROM `customers` WHERE customer_email='$customer_email'";

    $run=mysqli_query($conn,$check_email);

    if(mysqli_num_rows($run)>0){
        echo "<script>alert('Email already in use, select Forgot Password')</script>";
        echo "<script>window.open('makeReservation.php','_self')</script>";
    }
    else {
        $add_customer = "INSERT INTO customers(customer_title, customer_firstname, customer_lastname, customer_email)
                                VALUES('$customer_title','$customer_firstname','$customer_lastname','$customer_email')";

        if ($conn->query($add_customer) == TRUE) {
            echo "<script>window.open('makeReservation.php','_self')</script>";

            echo "<script>window.open('customerLogin.php','_self')</script>";

        } else {
            echo "Error: " . $add_customer . "<br>" . $conn->error;
        }
    }
}
?>
