<?php
$page_css = "search";
include('header.php');
?>


<link rel="stylesheet" href="css/search.css">

    <body>
        
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
                                $check_restaurant_query=mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                                INNER JOIN `restaurant_tables` ON restaurants.Restaurant_ID=restaurant_tables.Restaurant_ID 
                                                                                  WHERE Table_Size='$restaurant_table_size' AND UPPER(restaurants.City)='$uppercase_restaurant_city' AND Availability=1");

                                if(mysqli_num_rows($check_restaurant_query)>0){
                                    echo "found rows";
                                    while($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)){
                                        $restaurant_name = $check_restaurant_array['Restaurant_Name'];
                                        $restaurant_id = $check_restaurant_array['RestaurantTable_ID'];
                                        echo "<h1>restaurant name:". $restaurant_name ."</h1>";
                                        echo "<input type='submit' name='selected_restaurant' value='Select' id='.$restaurant_id.'>";
                                    }
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
