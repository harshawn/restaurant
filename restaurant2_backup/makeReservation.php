<?php
$page_css = "viewTablesAvailable";
include('header.php');
?>

<div class="container">

    <?php
    if(isset($_SESSION['customerEmail'])) {
        $_SESSION['selected_restaurant_ID'] = $_POST['selected_restaurant_ID'];
    }

        if (isset($_SESSION['selected_restaurant_ID'])) {

            $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];

            $check_restaurant_tables_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                                        INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                        WHERE `restaurant_table_ID` = '$selected_restaurant_ID'                                                                                                          
                                                                                  ");
            if (mysqli_num_rows($check_restaurant_tables_query) > 0) {
                while ($check_restaurant_tables_array = mysqli_fetch_array($check_restaurant_tables_query)) {
                    $restaurant_name = $check_restaurant_tables_array['restaurant_name'];
                    echo "<h1>You have selected " . $restaurant_name . "</h1>";
                }
            }

            if(isset($_SESSION['customerEmail'])) {

                $customer_firstname_query = mysqli_query($conn, "SELECT `customer_firstname` FROM `customers` WHERE `customer_email`='$customer_email'");
                $customer_firstname_array = mysqli_fetch_array($customer_firstname_query);
                $customer_firstname = $customer_firstname_array['customer_firstname'];

                echo "Hello ".$customer_firstname." please press confirm to place your reservation";
                echo '
                    <div class="form-login">
                        <form action="" method="POST">
                            <input type="submit" name="customerConfirm" value="Confirm">
                            <br><br>
                        </form>
                    </div>
                    ';
            }
            else {
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
                        <input type="text" name="newCustomerEmail" class="form-control input-sm chat-input" placeholder="Email">
                        <br>
    
                        <input type="submit" name="newCustomerConfirm" value="Confirm">
                        <br><br>
                    </form>
                </div>
            ';
            }

        } else {
            echo "nothing is here";
        }

    ?>

</div>

<?php
include('footer.php');
?>

<?php

if(isset($_POST['customerConfirm'])){

    $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];
    $date_request = $_SESSION['requestDate'];
    $time_request = $_SESSION['requestTime'];
    $party_size = $_SESSION['restaurant_table_size'];

    $customer_email = $_SESSION['customerEmail'];

    $get_customer_query = mysqli_query($conn, "SELECT * FROM `customers` WHERE `customer_email`='$customer_email'");
    $get_customer_array = mysqli_fetch_array($get_customer_query);
    $customer_ID = $get_customer_array['customer_ID'];

    $customer_firstname = $get_customer_array['customer_firstname'];
    $_SESSION['customer_firstname'] = $customer_firstname;

    $current_date = date("ymd");
    $current_time = date("His");

    $turnover_time_query = mysqli_query($conn, "SELECT `turnover_time` FROM `restaurant_tables` WHERE `restaurant_table_id`='$selected_restaurant_ID'");
    $turnover_time_array = mysqli_fetch_array($turnover_time_query);
    $turnover_time = $turnover_time_array['turnover_time'];

    $end_time = date("H:i", strtotime($turnover_time + $time_request));
    echo "<script>alert($end_time)</script>";


    $reservation_number = $current_date.$current_time;
    $_SESSION['reservation_number'] = $reservation_number;
    $add_reservation_customer = "INSERT INTO `reservations`(`restaurant_table_ID`, `customer_ID`, `reservation_number`, `party_size`, `date`, `start_time`) 
                                              VALUES('$selected_restaurant_ID', '$customer_ID', '$reservation_number', '$party_size', '$date_request', '$time_request')";

    if($conn->query($add_reservation_customer) == TRUE){
        echo "<script>alert('Reserved table successfully')</script>";
        echo "<script>window.open('confirmedReservation.php', '_self')</script>";
    }
    else {
        echo "<script>alert('Reservation unsuccessful')</script>";
    }
}


if(isset($_POST['newCustomerConfirm']))
{
    $customer_title=$_POST['customerTitle'];
    $customer_firstname=$_POST['customerFirstName'];
    $customer_lastname=$_POST['customerLastName'];
    $customer_email=$_POST['newCustomerEmail'];

    $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];
    $date_request = $_SESSION['requestDate'];
    $time_request = $_SESSION['requestTime'];
    $party_size = $_SESSION['restaurant_table_size'];

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
            $new_customer_ID = $select_customer_array['customer_ID'];

            $current_date = date("ymd");
            $current_time = date("His");

            $reservation_number = $current_date.$current_time;
            $_SESSION['reservation_number'] = $reservation_number;
            $add_reservation = "INSERT INTO `reservations`(`restaurant_table_ID`, `customer_ID`, `reservation_number`, `party_size`, `date`, `start_time`) 
                                              VALUES('$selected_restaurant_ID', '$new_customer_ID', '$reservation_number', '$party_size', '$date_request', '$time_request')";

            if($conn->query($add_reservation) == TRUE){
                echo "<script>alert('Reserved table successfully')</script>";
                echo "<script>window.open('confirmedReservation.php', '_self')</script>";
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
