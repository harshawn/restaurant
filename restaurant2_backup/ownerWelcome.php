<?php
$page_css = "restaurantsLogin";
include('header.php');
?>
        
<div class="container">

    <?php
    $owner_email=$_SESSION['ownerEmail'];

        if(isset($owner_email))
        {
            $check_owner_query = mysqli_query($conn, "SELECT * FROM `restaurant_owner` WHERE owner_email='$owner_email'");

            if(mysqli_num_rows($check_owner_query)>0) {
                while($check_owner_array = mysqli_fetch_array($check_owner_query)){
                    $owner_firstname = $check_owner_array['owner_firstname'];
                    echo "<h1> Welcome ". $owner_firstname . " </h1>";
                }
                echo '<form action="ownerWelcome.php" method="GET">
                        <button class="btn btn-default" type="submit" name="viewReservations" >View Reservations <i class="glyphicon glyphicon-time"></i></button>
                        <button class="btn btn-default" type="submit" name="viewDetails" >Change Details <i class="glyphicon glyphicon-user"></i></button>
                      </form>';

            }
            else {
                echo "NO USER FOUND?????";
            }
        }

        if(isset($_GET['viewReservations']))
        {
            $check_owner_query = mysqli_query($conn, "SELECT * FROM `restaurant_owner` WHERE `owner_email`='$owner_email'");

            if(mysqli_num_rows($check_owner_query)>0) {
            while($check_owner_array = mysqli_fetch_array($check_owner_query)) {
                $owner_ID = $check_owner_array['owner_ID'];
                echo '  
                    <form action="" method="GET">
                        <div class="form-group">
                        <h3>Select Restaurant</h3>
                            <select class="form-control input-lg" name="restaurantName" id="sel2">
                ';
                            $display_restaurants_query = mysqli_query($conn, "SELECT `restaurant_name` FROM `restaurants` WHERE `owner_ID`='$owner_ID' ");
                            if(mysqli_num_rows($display_restaurants_query)>0){
                                echo "<option>All</option>";

                                while($display_restaurants_array = mysqli_fetch_array($display_restaurants_query)){
                                    $restaurant_names = $display_restaurants_array["restaurant_name"];
                                    echo "<option>". $restaurant_names ."</option>";
                                }
                            }
                        echo '
                            </select>
                        </div>';
                }
            }

            echo '
                   <script>
                        $( function() {
                            $( "#datepicker" ).datepicker();
                        });
                    </script>
                    <p>Date: <input name="searchDate" type="text" id="datepicker"></p>
                    
                    <button class="btn btn-default" type="submit" name="Go">GO!<i class="glyphicon glyphicon-search"></i></button>
                    
                    </form>
            ';
        }

        if(isset($_GET['Go'])) {

            $restaurant_name = $_GET['restaurantName'];
            $search_date = $_GET['searchDate'];
            $sql_date = date('Y-m-d', strtotime($search_date));

            if($search_date == "") {
                echo "<script>alert('PLEASE ENTER A DATE, THEN PRESS GO!')</script>";
                echo "<script>window.open('ownerWelcome.php?viewReservations=','_self')</script>";
            }

            else {

                $check_owner_query = mysqli_query($conn, "SELECT * FROM `restaurant_owner` WHERE `owner_email`='$owner_email'");
                $check_owner_array = mysqli_fetch_array($check_owner_query);
                $owner_ID = $check_owner_array['owner_ID'];

                if ($_GET['restaurantName'] == "All") {
                    $view_reservations_query = mysqli_query($conn, "SELECT * FROM `reservations` 
                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_table_ID=reservations.restaurant_table_ID
                                                                INNER JOIN `restaurants` ON restaurants.restaurant_ID=restaurant_tables.restaurant_ID 
                                                                WHERE `date`='$sql_date' AND `owner_ID`='$owner_ID'");

                    if (mysqli_num_rows($view_reservations_query) > 0) {
                        echo '<table class="table table-bordered">
                          <tr><th>Restaurant Name</th><th>Date</th><th>Time</th><th>Party Size</th></tr>';

                        while ($view_reservations_array = mysqli_fetch_array($view_reservations_query)) {
                            $restaurant_name = $view_reservations_array['restaurant_name'];
                            $reservation_date = strtotime($view_reservations_array['date']);
                            $format_date = date('l dS F Y', $reservation_date);
                            $reservation_time = strtotime($view_reservations_array['start_time']);
                            $format_time = date('H:i a', $reservation_time);
                            $party_size = $view_reservations_array['party_size'];

                            echo '<tr><td>' . $restaurant_name . '</td><td>' . $format_date . '</td><td>' . $format_time . '</td><td>' . $party_size . '</td></tr>';

                        }
                        echo "</table>";
                    } else {
                        $format_date = date('l dS F Y', (strtotime($search_date)));
                        echo "No reservations found on " . $format_date;
                    }


                } else {
                    $view_reservations_query = mysqli_query($conn, "SELECT * FROM `reservations` 
                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_table_ID=reservations.restaurant_table_ID
                                                                INNER JOIN `restaurants` ON restaurants.restaurant_ID=restaurant_tables.restaurant_ID 
                                                                WHERE `restaurant_name`='$restaurant_name' AND `date`='$sql_date' AND `owner_ID`='$owner_ID'");


                    if (mysqli_num_rows($view_reservations_query) > 0) {
                        echo '<table class="table table-bordered">
                          <tr><th>Restaurant Name</th><th>Date</th><th>Time</th><th>Party Size</th></tr>';

                        while ($view_reservations_array = mysqli_fetch_array($view_reservations_query)) {
                            $restaurant_name = $view_reservations_array['restaurant_name'];
                            $reservation_date = strtotime($view_reservations_array['date']);
                            $format_date = date('l dS F Y', $reservation_date);
                            $reservation_time = strtotime($view_reservations_array['start_time']);
                            $format_time = date('H:i a', $reservation_time);
                            $party_size = $view_reservations_array['party_size'];

                            echo '<tr><td>' . $restaurant_name . '</td><td>' . $format_date . '</td><td>' . $format_time . '</td><td>' . $party_size . '</td></tr>';

                        }
                        echo "</table>";
                    } else {
                        $format_date = date('l dS F Y', (strtotime($search_date)));
                        echo "No reservations made at " . $restaurant_name . " on " . $format_date;
                    }
                }
            }



        }


    ?>

</div>

<?php
include('footer.php');
?>
