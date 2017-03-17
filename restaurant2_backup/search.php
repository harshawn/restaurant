<?php
$page_css = "search";
include('header.php');

if(isset($_SESSION['customerEmail'])){
    $page_open = 'makeReservation.php';
}
else {
    $page_open = 'skip.php';
}

?>

<div class="container">
    <h1>Search Results</h1>

        <div class="container col-lg-3 form-group">
            <p id="modify_search_box">
                Modify/edit Search box
            </p>
        </div>

        <div class="container col-lg-9 form-group">
            <p id="search_results">

                <?php
                    if(isset($_GET['Go'])) {
                        if (isset($_GET['searchDate']) && !empty($_GET['searchDate'])) {

                            $restaurant_table_size = $_GET['restaurantTableSize'];
                            $restaurant_city = $_GET['restaurantCity'];
                            $restaurant_cuisine = $_GET['restaurantCuisine'];

                            $search_date = $_GET['searchDate'];
                            $search_time = $_GET['searchTime'];

                            $sql_date = date('Y-m-d',strtotime($search_date));
                            $sql_time = date('H:i:s', strtotime($search_time)); /*$sql_time = date('h:i:s a', strtotime($search_time)); <-- 'a' added am or pm*/

                            $check_date_query = mysqli_query($conn, "SELECT * FROM `reservations` WHERE `date`='$sql_date'");
                            $check_time_query = mysqli_query($conn, "SELECT * FROM `reservations` WHERE `start_time`='$sql_time'");

                            $_SESSION['requestDate'] = $sql_date;
                            $_SESSION['requestTime'] = $sql_time;

                            if(mysqli_num_rows($check_date_query) > 0) {

                                if(mysqli_num_rows($check_time_query) > 0) {
                                /*
                                    maybe do a count to see how many there are at this time, comparing it to the max tables
                                    if count==max-tables then say no available tables
                                    if count<max then say table free
                                    need to check time between and end time, like is 09:00am between any start and end time? no?
                                    show restaurant-table-id
                                */
                                    $check_reserved_tables_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                                INNER JOIN `location` ON restaurants.location_ID = location.location_ID
                                                                                INNER JOIN `restaurant_cuisine` ON restaurant_cuisine.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `cuisine` ON cuisine.cuisine_ID = restaurant_cuisine.cuisine_ID
                                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `reservations` ON reservations.restaurant_table_ID = restaurant_tables.restaurant_table_ID
                                                                                INNER JOIN `table_size` ON table_size.size_ID = restaurant_tables.size_ID
                                                                                WHERE `city`='$restaurant_city' AND `cuisine_name`='$restaurant_cuisine'
                                                                                                      AND `date`='$sql_date' AND `start_time`='$sql_time' 
                                                                                                              AND ('$restaurant_table_size' BETWEEN `minimum` AND `maximum`)
                                                                                GROUP BY restaurants.restaurant_name
                                                                                ");

                                        if (mysqli_num_rows($check_reserved_tables_query) > 0) {
                                            echo "<form action=$page_open method='POST'><div>";

                                            while($check_reserved_tables_array = mysqli_fetch_array($check_reserved_tables_query)) {

                                                $restaurant_table_id = $check_reserved_tables_array['restaurant_table_ID']; /*checking rows with ID from prev query*/

                                                $reservation_rows_query = mysqli_query($conn, "SELECT * FROM `reservations` INNER JOIN `restaurant_tables` 
                                                                                                                  ON restaurant_tables.restaurant_table_ID = reservations.restaurant_table_ID
                                                                                                                  WHERE reservations.restaurant_table_ID=$restaurant_table_id");
                                                $total_rows = mysqli_num_rows($reservation_rows_query);



                                                    $total_amount_query = mysqli_query($conn, "SELECT `table_amount` FROM `restaurant_tables` WHERE restaurant_table_ID='$restaurant_table_id'");
                                                    $total_amount_array = mysqli_fetch_array($total_amount_query);
                                                    $total_table_amount = $total_amount_array['table_amount'];

                                                    if ($total_rows < $total_table_amount) {
                                                        $restaurant_name = $check_reserved_tables_array['restaurant_name'];
                                                        echo "<h1>restaurant name:" . $restaurant_name . "</h1>";
                                                        $restaurant_id = $check_reserved_tables_array['restaurant_ID'];

                                                        echo "<input type='hidden' name='requestDate' value='$sql_date'>";
                                                        echo "<input type='hidden' name='requestTime' value='$sql_time'>";
                                                        echo "<button type='submit' name='selected_restaurant_ID' value='$restaurant_table_id'>SELECT</button>";

                                                    } else {
                                                        $restaurant_name = $check_reserved_tables_array['restaurant_name'];
                                                        echo "<h1>restaurant name:" . $restaurant_name . " is fully booked</h1>";
                                                    }




                                          }
                                          echo "</div></form>";
                                        }
                                        else {
                                            $check_restaurant_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                            INNER JOIN `location` ON restaurants.location_ID = location.location_ID
                                                                            INNER JOIN `restaurant_cuisine` ON restaurant_cuisine.restaurant_ID = restaurants.restaurant_ID
                                                                            INNER JOIN `cuisine` ON cuisine.cuisine_ID = restaurant_cuisine.cuisine_ID
                                                                            INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                            INNER JOIN `table_size` ON table_size.size_ID = restaurant_tables.size_ID
                                                                            WHERE `city`='$restaurant_city' AND `cuisine_name`='$restaurant_cuisine'
                                                                                                          AND ('$restaurant_table_size' BETWEEN `minimum` AND `maximum`)
                                                                            GROUP BY restaurants.restaurant_name
                                                                      ");

                                            if(mysqli_num_rows($check_restaurant_query) > 0) {

                                                echo "<form action=$page_open method='POST'><div>";
                                                while ($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)) {
                                                    $restaurant_name = $check_restaurant_array['restaurant_name'];
                                                    echo "<h1>restaurant name:" . $restaurant_name . "</h1>";
                                                    $restaurant_id = $check_restaurant_array['restaurant_ID'];

                                                    $restaurant_table_id = $check_restaurant_array['restaurant_table_ID'];

                                                    echo "<input type='hidden' name='requestDate' value='$sql_date'>";
                                                    echo "<input type='hidden' name='requestTime' value='$sql_time'>";
                                                    echo "<button type='submit' name='selected_restaurant_ID' value='$restaurant_table_id'>SELECT</button>";
                                                }
                                                echo "</div></form>";
                                            }
                                            else {
                                                echo "No restaurants found, please search again..";
                                            }
                                        }

                                }
                                else {
                                    echo "<h1><b>Time(s) is free at the following:</b></h1>";
                                    $check_restaurant_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                            INNER JOIN `location` ON restaurants.location_ID = location.location_ID
                                                                            INNER JOIN `restaurant_cuisine` ON restaurant_cuisine.restaurant_ID = restaurants.restaurant_ID
                                                                            INNER JOIN `cuisine` ON cuisine.cuisine_ID = restaurant_cuisine.cuisine_ID
                                                                            INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                            INNER JOIN `table_size` ON table_size.size_ID = restaurant_tables.size_ID
                                                                            WHERE `city`='$restaurant_city' AND `cuisine_name`='$restaurant_cuisine'
                                                                                                          AND ('$restaurant_table_size' BETWEEN `minimum` AND `maximum`)
                                                                            GROUP BY restaurants.restaurant_name
                                                                      ");

                                    if(mysqli_num_rows($check_restaurant_query) > 0) {

                                        echo "<form action=$page_open method='POST'><div>";
                                        while ($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)) {
                                            $restaurant_name = $check_restaurant_array['restaurant_name'];
                                            echo "<h1>restaurant name:" . $restaurant_name . "</h1>";
                                            $restaurant_id = $check_restaurant_array['restaurant_ID'];

                                            echo "<input type='hidden' name='requestDate' value='$sql_date'>";
                                            echo "<input type='hidden' name='requestTime' value='$sql_time'>";
                                            echo "<button type='submit' name='selected_restaurant_ID' value='$restaurant_table_id'>SELECT</button>";
                                        }
                                        echo "</div></form>";
                                    }
                                    else {
                                        echo "No restaurants found, please search again..";
                                    }
                                }

                            }
                            else {
                               $check_restaurant_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                            INNER JOIN `location` ON restaurants.location_ID = location.location_ID
                                                                            INNER JOIN `restaurant_cuisine` ON restaurant_cuisine.restaurant_ID = restaurants.restaurant_ID
                                                                            INNER JOIN `cuisine` ON cuisine.cuisine_ID = restaurant_cuisine.cuisine_ID
                                                                            INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                            INNER JOIN `table_size` ON table_size.size_ID = restaurant_tables.size_ID
                                                                            WHERE `city`='$restaurant_city' AND `cuisine_name`='$restaurant_cuisine'
                                                                                                          AND ('$restaurant_table_size' BETWEEN `minimum` AND `maximum`)
                                                                            GROUP BY restaurants.restaurant_name
                                                                      ");

                               if(mysqli_num_rows($check_restaurant_query) > 0) {
                                    echo "<h1><b>Date(s) and Time(s) are free for the following:</b></h1>";
                                    echo "<form action=$page_open method='POST'><div>";
                                    while ($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)) {
                                        $restaurant_name = $check_restaurant_array['restaurant_name'];
                                        echo "<h1>restaurant name:" . $restaurant_name . "</h1>";
                                        $restaurant_table_id = $check_restaurant_array['restaurant_table_ID'];

                                        echo "<input type='hidden' name='requestDate' value='$sql_date'>";
                                        echo "<input type='hidden' name='requestTime' value='$sql_time'>";
                                        echo "<button type='submit' name='selected_restaurant_ID' value='$restaurant_table_id'>SELECT</button>";
                                    }
                                    echo "</div></form>";
                               }
                               else {
                                   echo "No restaurants found, please search again..";
                               }
                            }
                            /*
                            $find_restaurant_query3 = mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                                INNER JOIN `location` ON restaurants.location_ID = location.location_ID
                                                                                        WHERE city='$restaurant_city'");
                            $find_restaurant_query4 = mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                                INNER JOIN `restaurant_cuisine` ON restaurant_cuisine.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `cuisine` ON cuisine.cuisine_ID = restaurant_cuisine.cuisine_ID
                                                                                        WHERE cuisine_name='$restaurant_cuisine'");

                            $find_restaurant_query5 = mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `table_size` ON table_size.size_ID = restaurant_tables.size_ID
                                                                                        WHERE table_amount>0 AND (minimum>='$restaurant_table_size' OR maximum<='$restaurant_table_size')");

                            $find_restaurant_query6 = mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `reservations` ON reservations.restaurant_table_ID = restaurant_tables.restaurant_table_ID
                                                                                        WHERE table_amount>0 AND (minimum>='$restaurant_table_size' OR maximum<='$restaurant_table_size')");

                            if (mysqli_num_rows($find_restaurant_query3) > 0) {
                                echo "<h1>found new cities</h1>";
                            }
                            if (mysqli_num_rows($find_restaurant_query4) > 0) {
                                echo "<h1>found new cuisines</h1>";
                            }
                            */

                        } else {
                            echo "<script>alert('PLEASE ENTER A DATE, THEN PRESS GO!')</script>";
                            echo "<script>window.open('home.php','_self')</script>";
                        }
                    }

                ?>
            </p>
        </div>
</div>

<?php
include('footer.php');
?>
