<?php
$page_css = "viewTablesAvailable";
include('header.php');
?>

<div class="container">

    <?php

    if(isset($_SESSION['selected_restaurant_ID'])) {

        $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];

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
                <h2>Please enter your details below, then press preview to view your reservation details</h2>
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

    $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];
    $date_request = $_SESSION['date'];
    $time_request = $_SESSION['time'];

    $check_email="SELECT * FROM `customers` WHERE customer_email='$customer_email'";

    $run=mysqli_query($conn,$check_email);

    if(mysqli_num_rows($run)>0){
        echo "<script>alert('Email already in use, select Forgot Password')</script>";
        echo "<script>window.open('makeReservation.php','_self')</script>";
    }
    else {
        $add_customer = "INSERT INTO `customers`(`customer_title`, `customer_firstname`, `customer_lastname`, `customer_email`)
                                VALUES('$customer_title', '$customer_firstname', '$customer_lastname', '$customer_email')";
      //  $result = $mysqli->query($add_customer);

        if ($conn->query($add_customer) == TRUE) {
            $select_customer_query = mysqli_query($conn, "SELECT `customer_ID` FROM `customers` WHERE `customer_email`='$customer_email'");
            $select_customer_array = mysqli_fetch_array($select_customer_query);
            $customer_ID = $select_customer_array['customer_ID'];

            $current_date = date("ymd");
            $current_time = date("His");

            $reservation_ID = $current_date.$current_time;

            $add_reservation = "INSERT INTO `reservations`(`reservation_ID`,`restaurant_table_ID`, `customer_ID`, `date`, `start_time`) 
                                              VALUES('$reservation_ID','$selected_restaurant_ID', '$customer_ID', '$date_request', '$time_request')";

            if($conn->query($add_reservation) == TRUE){
                echo "<script>alert('Reserved table successfully')</script>";
            }
            else {
                echo "<script>alert('Customer added but reservation unsuccessful')</script>";
            }

          //  echo "<script>window.open('confirmedReservation.php','_self')</script>";

        } else {
            echo "Error: " . $add_customer . "<br>" . $conn->error;
        }
    }
}
?>
