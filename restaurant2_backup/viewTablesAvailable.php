<?php
$page_css = "viewTablesAvailable";
include('header.php');
?>

<div>

    <?php
    if(isset($_SESSION['selected_restaurant_ID'])) {
        echo "<p>helloooooooooooooooo</p>";
        $selected_restaurant_ID = $_SESSION['selected_restaurant_ID'];
        echo $selected_restaurant_ID;

    $find_restaurant_query5 = mysqli_query($conn, "SELECT * FROM `restaurants`
                                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `reservations` ON reservations.restaurant_table_ID = restaurant_tables.restaurant_table_ID
                                                                                        WHERE '$search_time' NOT BETWEEN `start_time` AND `end_time`");


    $check_restaurant_tables_query = mysqli_query($conn, "SELECT * FROM `restaurants` 
                                                                                INNER JOIN `restaurant_tables` ON restaurant_tables.restaurant_ID = restaurants.restaurant_ID
                                                                                INNER JOIN `table_size` ON table_size.size_ID = restaurant_tables.size_ID
                                                                                INNER JOIN `reservations` ON reservations.restaurant_table_ID = restaurant_tables.restaurant_table_ID
                                                                                WHERE restaurant_tables.restaurant_ID='$selected_restaurant_ID' AND `table_amount`>0
                                                                                            AND (`minimum`>='$restaurant_table_size' OR `maximum`<='$restaurant_table_size') 
                                                                                                          
                                                                          ");

    }
    else {
        echo "nothing is here";
    }

    ?>

</div>

<?php
include('footer.php');
?>