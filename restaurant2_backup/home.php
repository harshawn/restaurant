<?php
$page_css = "home";
require_once('header.php');
?>

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

            <div class="form-group">
                <h3>In this city:</h3>
                <select class="form-control input-lg" name="restaurantCity" id="sel2">
                    <?php
                        $display_city_query = mysqli_query($conn, "SELECT city FROM location");
                        if(mysqli_num_rows($display_city_query)>0){
                            echo "<option>Any</option>";
                            while($display_city_array = mysqli_fetch_array($display_city_query)){
                                $all_cities = $display_city_array['city'];
                                echo "<option>". $all_cities ."</option>";
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <h3>Cuisine:</h3>
                <select class="form-control input-lg" name="restaurantCuisine" id="sel2">
                    <?php
                    $display_cuisine_query = mysqli_query($conn, "SELECT cuisine_name FROM cuisine");
                    if(mysqli_num_rows($display_cuisine_query)>0){
                        echo "<option>Any</option>";
                        while($display_cuisine_array = mysqli_fetch_array($display_cuisine_query)){
                            $all_cuisines = $display_cuisine_array['cuisine_name'];
                            echo "<option>". $all_cuisines ."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div id="date_time">

                <h3>For this date: </h3>
                <script>
                    $( function() {
                        $( "#datepicker" ).datepicker();
                    });
                </script>
                <p>Date: <input name="searchDate" type="text" id="datepicker"></p>

                <!-- http://timepicker.co/
                https://jqueryui.com/datepicker/ ***************** GO HERE *************************************-->
                <h3>and Time:</h3>
                <script>
                    $(document).ready(function(){
                        $('#timepicker').timepicker({
                            timeFormat: 'HH:mm', /*timeFormat: 'HH:mm p' <-- the 'p' added AM PM */
                            interval: 30,
                            minTime: '9:00am',
                            maxTime: '10:30pm',
                            defaultTime: '9:00am',
                            startTime: '9:00am',
                            dynamic: false,
                            dropdown: true,
                            scrollbar: true
                        });
                    });

                    $('.timepicker').timepicker({

                    });
                </script>

                <p>Time: <input name="searchTime" type="text" id="timepicker"></p>

            </div>

            <div id="home_go">
                <button class="btn btn-default" type="submit" name="Go">GO! <i class="glyphicon glyphicon-search"></i></button>
            </div>

        </form>

    </div>


<script>
    /*do not submit when "enter" key is pressed*/
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