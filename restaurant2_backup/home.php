<?php
require_once('header.php');
?>

<link rel="stylesheet" href="css/home.css">

    <h1 id="home_header">Restaurant Reservation System</h1>

    <div class="container">

        <form action="search.php" method="GET">

            <?php
                $table_size = 1;
            ?>

            <div class="form-group">
                <h3>Find me a table for:</h3>
                <select class="form-control input-lg" name="restaurantTableSize" id="sel2">
                    <?php
                        for($i=0; $i<10; $i++){
                            echo '<option>'.$table_size.'</option>';
                            $table_size++;
                        }
                    ?>
                </select>
            </div>

            <h3>In this area/city?:</h3>
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="restaurantCity" placeholder="e.g. Leicester, London">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-screenshot"></i></button>
                </div>
            </div>

            <h3>For this date and time:</h3>
            <div class="input-group input-group-smll">
                <input type="text" class="form-control" name="restaurantDateTime" placeholder="e.g. Date, Time">

            </div>

            <button class="btn btn-default" type="submit" name="Go">GO!<i class="glyphicon glyphicon-search"></i></button>

        </form>

    </div>

<script>
    $(document).ready(function() {
        //form input - this refers to the class in the form
        $('form input').keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>


<?php
require_once('footer.php');
?>

<?php
/*
if(isset($_POST['submit'])){
    if(isset($_GET['Go'])) {
        if (preg_match_all("/OPTION VALUE=\"([0-9]*)/", $_POST['restaurantTableSize'])) {
            $restaurant_capacity = $_POST['restaurantTableSize'];
            $sql="SELECT * FROM Restaurants WHERE  Max_Capacity LIKE '%".$restaurant_capacity."%' ";
            $result=mysqli_query($sql);
            $row=mysqli_fetch_array($result);
            if($row > 0) {
                while ($row) {
                    $_SESSION["capacity"] = $row['Max_Capacity'];
                }
                echo "<script>window.open('search.php?table=".$restaurant_capacity."?','_self')</script>";
            }

        }
        else {
            echo "Please enter search criteria";
        }
    }
}
*/
?>



<?php
/*
if(isset($_POST['Go']))
{
    $_SESSION['restaurantTableSize'] = $_POST['restaurantTableSize'];
    //$_SESSION['restaurantCity'] = $_POST['restaurantCity'];

    $restaurant_table_size = $_SESSION['restaurantTableSize'];
    $restaurant_city = "Coventry";$_SESSION['restaurantCity'];

    $check_restaurant_query="SELECT * FROM restaurant_tables WHERE Table_Size='$restaurant_table_size' "
        . "AND restaurant_tables.Restuarant_ID=restaurants.Restuarant_ID AND restaurants.City='$restaurant_city'"
        . "AND availability=1";

    //  $check_restaurant_query=mysqli_query($conn,$check

    //  $_SESSION['customerEmail']=$customer_email;//here session is used and value of $user_email store in $_SESSION.
    //     $_SESSION['restaurantTableSize']=$restaurant_table_size;
    //     $_SESSION['restaurantCity']=$restaurant_city;

    if(mysqli_num_rows($check_restaurant_query) > 0) {
        echo "<script>window.open('search.php?table='.$restaurant_table_size.'?city='.$restaurant_city.'?','_self')</script>";
        // while($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)){
        // $restaurant_city = $check_restaurant_array["City"];
        //  $_SESSION['restaurantTableSize'] = $restaurant_city;
        // $restaurant_table_size= $check_restaurant_array["Table_Size"];
        //  $_POST = $restaurant_table_size;
        // }
    }
}
else {
    echo "<script>alert('No tables available. Please enter search criteria')</script>";
}
*/
?>

