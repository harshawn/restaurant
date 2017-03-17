<?php
$page_css = "viewTablesAvailable";
include('header.php');
?>

<div class="container">

    <?php
    if(isset($_SESSION['reservation_number'])) {

        $reservation_number = $_SESSION['reservation_number'];

        $format_reservation_number = implode("-", str_split($reservation_number, 3));

        $reservation_query = mysqli_query($conn,"SELECT * FROM `reservations` 
                                                 INNER JOIN `customers` ON customers.customer_ID=reservations.customer_ID
                                                 INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_table_ID=reservations.restaurant_table_ID
                                                 INNER JOIN `restaurants` ON restaurants.restaurant_ID=restaurant_tables.restaurant_ID
                                                 WHERE `reservation_number`='$reservation_number'");
        $reservation_array = mysqli_fetch_array($reservation_query);
        $customer_firstname = $reservation_array['customer_firstname'];
        $restaurant_name = $reservation_array['restaurant_name'];
        $start_time = strtotime($reservation_array['start_time']);
        $format_time = date('H:iA', $start_time);

        echo "<h1>Hi ".$customer_firstname.", </h1><h1>Here is your reservation number: <b>".$format_reservation_number."</b></h1>
              <h1>Please print or save this, to show on arrival at:</h1><h1>".$restaurant_name." for ".$format_time."</h1>";

    }

    else {
        echo "nothing is here";
    }

    ?>

</div>

<?php
include('footer.php');
?>