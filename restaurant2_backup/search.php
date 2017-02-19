<?php
$page_css = "search";
include('header.php');

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
                        if (isset($_GET['restaurantCity']) && !empty($_GET['restaurantCity'])) {
                            echo "YAY YOU ENTERED A CITY";
                            $restaurant_table_size = $_GET['restaurantTableSize'];
                            $restaurant_city = $_GET['restaurantCity'];
                            //restaurant date & time
                            $uppercase_restaurant_city = strtoupper($restaurant_city);
                           /* $check_restaurant_query=mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                            INNER JOIN `restaurant_tables` ON restaurants.restaurant_ID=restaurant_tables.restaurant_ID 
                                                                              WHERE UPPER(restaurants.City)='$uppercase_restaurant_city'");
                            */
                            $check_restaurant_query=mysqli_query($conn,
                            "SELECT restaurant_name, city FROM `location` 
                                INNER JOIN `restaurants` ON location.location_ID=restaurant.location_ID
                                    INNER JOIN `restaurant_tables` ON restaurant.restaurant_ID=restaurant_tables.restaurant_ID)
                                        WHERE UPPER(city)='$uppercase_restaurant_city'");


                            if(mysqli_num_rows($check_restaurant_query)>0){
                                echo "found rows";
                                echo "<form id='restaurant_selection' name='form_search' action='skip.php' method='post'><div>";

                                    while($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)){
                                        $restaurant_name = $check_restaurant_array['restaurant_name'];
                                        $restaurant_id = $check_restaurant_array['restaurant_table_ID'];
                                        echo "<h1>restaurant name:". $restaurant_name ."</h1>";
                                        echo "<button><input type='submit' name='selected_restaurant' value='$restaurant_id'>SELECT</button>";
                                    }

                                echo "</div></form>";
                            }
                            else {
                                echo "<h1>no restaurants found</h1>";
                            }

                        } else {
                            echo "<script>alert('PLEASE ENTER A CITY, THEN PRESS SUBMIT!')</script>";
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
