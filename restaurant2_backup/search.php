<?php
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
                                        echo "<h1>restaurant name:". $restaurant_name ."</h1>";
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

                        <?php



                        /*
                            if(isset ($_POST['restaurantTableSize' && 'restaurantCity'])){
                                echo 'Restaurant Table Size:'.$_POST["restaurantTableSize"]; 
                                echo 'Restaurant City:'.$_POST["restaurantCity"]; 
                            }
                            else {
                                echo 'No Available Tables for Restaurants in requested City';
                            }
                        $restaurant_table_size = $_POST['restaurantTableSize'];
                        $restaurant_city = "Coventry";

                        $check_restaurant_query= "SELECT * FROM restaurant_tables WHERE Table_Size=`'.$restaurant_table_size.'` "
                            . "AND restaurant_tables.Restuarant_ID=restaurants.Restuarant_ID AND restaurants.City='$restaurant_city'"
                            . "AND availability=1";

                        $check_restaurant_result = mysqli_query($conn, $check_restaurant_query);


                        //       $check_restaurant_array = mysqli_fetch_array($check_restaurant_query);

                        if($check_restaurant_result){
                            while($check_restaurant_row = mysqli_fetch_assoc($check_restaurant_result)) {
                                $restaurant_city = $check_restaurant_row["City"];
                                $restaurant_table_size= $check_restaurant_row["Table_Size"];

                                echo "Restaurant City". $restaurant_city;
                                echo "Restaurant Table Size". $restaurant_table_size;
                            }

                        }
                        else {
                            echo "nothing in array, 0 rows";
                        }

                        //if(isset ($_SESSION['restaurantTableSize'])){// && ($_SESSION['restaurantCity'])){

                        // THIS WORKS ON ITS OWN -----------------------------------------================-->      echo 'Restaurant Table Size:'.$_POST["restaurantTableSize"];
                        // echo 'Restaurant City:'.$_POST["restaurantCity"];
                        // }
                        //  else {
                        // echo 'No Available Tables for Restaurants in requested City';
                        // }
                        ?>
                        
                        <!--Restaurant Table Size: <? echo $_POST["restaurantTableSize"]; ?><br>
                        Restaurant City: <? echo $_POST["restaurantCity"]; ?>-->
                       */
                        ?>
                    </p>
                </div>
        
        </div>

<?php
include('footer.php');
?>


<?php
/*
THIS WAS AT THE TOP
if(isset ($_POST['restaurantTableSize'])){
    echo"RECEIVED RESTAURANT TABLE";// AND CITY";
 //   $_SESSION['restaurantTableSize'] = $_POST['restaurantTableSize'];
    // $_SESSION['restaurantCity'] = $_POST['restaurantCity'];
  //  foreach($_SESSION['restaurantTableSize'] as $variable)
   // { // and print out the values
    //    echo 'The value of $_SESSION['."'".$variable."'".'] is '."'".$variable."'".' <br />';
   // }
    foreach($_SESSION["capacity"] as $key=>$value){

        echo 'The value of $_SESSION['."'".$key."'".'] is '."'".$value."'".' <br />';
    }
}
else {
    echo"DID NOT RECEIVE ANYTHING!!!!!!!!!!!!!!!";
    echo 'No Available Tables for Restaurants in requested City';
}
*/
?>

<?php
/*
        if(mysqli_num_rows($check_restaurant_query) > 0) {  
            echo "<script>window.open('search.php','_self')</script>";
            while($check_restaurant_array = mysqli_fetch_array($check_restaurant_query)){
                
            }
             
          //  $_SESSION['customerEmail']=$customer_email;//here session is used and value of $user_email store in $_SESSION.  
            $_SESSION['restaurantTableSize']=$restaurant_table_size;
            $_SESSION['restaurantCity']=$restaurant_city;
        }  
        else {  
          echo "<script>alert('No tables available. Please enter search criteria')</script>";  
        }  
    }
 * */

