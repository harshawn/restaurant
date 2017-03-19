<?php
$page_css = "customerLogin";
include('header.php');
?>

        <div class="container">
            


            <?php

            $customer_email=$_SESSION['customerEmail'];

            if(isset($customer_email))
            {
                $check_customer_query = mysqli_query($conn, "SELECT * FROM `customers` WHERE customer_email='$customer_email'");

                if(mysqli_num_rows($check_customer_query)>0) {
                    while($check_customer_array = mysqli_fetch_array($check_customer_query)){
                        $customer_name = $check_customer_array['customer_firstname'];
                        echo "<h1> Welcome ". $customer_name . " </h1>";
                    }
                    echo '<form action="customerWelcome.php" method="GET">
                            <button class="btn btn-default" type="submit" name="viewReservations" >View Reservation History <i class="glyphicon glyphicon-time"></i></button>
                            <button class="btn btn-default" type="submit" name="viewDetails" >Change Details <i class="glyphicon glyphicon-user"></i></button>
                          </form>';

                }
                else {
                    echo "NO USER FOUND?????";
                }
            }

            if(isset($_GET['viewReservations']))
            {

                $check_customer_query = mysqli_query($conn, "SELECT * FROM `customers` WHERE customer_email='$customer_email'");
                $check_customer_array = mysqli_fetch_array($check_customer_query);
                $customer_id = $check_customer_array['customer_ID'];
                $view_reservations_query = mysqli_query($conn, "SELECT * FROM `reservations` 
                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_table_ID=reservations.restaurant_table_ID
                                                                INNER JOIN `restaurants` ON restaurants.restaurant_ID=restaurant_tables.restaurant_ID 
                                                                WHERE customer_ID='$customer_id'");

                if(mysqli_num_rows($view_reservations_query)>0) {
                    echo '<table class="table table-bordered">
                          <tr><th>Restaurant Name</th><th>Date</th><th>Time</th><th>Party Size</th></tr>';

                    while($view_reservations_array = mysqli_fetch_array($view_reservations_query)){
                        $restaurant_name = $view_reservations_array['restaurant_name'];
                        $reservation_date = strtotime($view_reservations_array['date']);
                        $format_date = date('l dS F Y', $reservation_date);
                        $reservation_time = strtotime($view_reservations_array['start_time']);
                        $format_time = date('H:i a', $reservation_time);
                        $party_size = $view_reservations_array['party_size'];

                        echo '<tr><td>'.$restaurant_name.'</td><td>'.$format_date.'</td><td>'.$format_time.'</td><td>'.$party_size.'</td></tr>';

                    }
                    echo "</table>";
                }
                else {
                    echo "no table";
                }



            }


            ?>

        </div>

<?php
include('footer.php');
?>
