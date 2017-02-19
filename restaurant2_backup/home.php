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
                            while($display_city_array = mysqli_fetch_array($display_city_query)){
                                $all_cities = $display_city_array['city'];
                                echo "<option>". $all_cities ."</option>";
                            }
                        }
                    ?>
                </select>
            </div>


            <h3>For this date and time:</h3>
                <div class='input-group date' id='datetimepicker'>
                    <input type='text' class="form-control" name="restaurantDateTime"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>


            <div class="input-group date">
                <input type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
            </div>


            <script>
                //https://jsfiddle.net/Eonasdan/0Ltv25o8/
                //https://www.google.co.uk/webhp?sourceid=chrome-instant&ion=1&espv=2&ie=UTF-8#q=datetimepicker+bootstrap+cdn
                //http://stackoverflow.com/questions/30287973/how-to-use-the-bootstrap-datepicker
                $('#datetimepicker1').datetimepicker();
                $('.input-group.date').datepicker({
                    format: "yyyy/mm/dd",
                    startDate: "2012-01-01",
                    endDate: "2015-01-01",
                    todayBtn: "linked",
                    autoclose: true,
                    todayHighlight: true
                });
            </script>

            <button class="btn btn-default" type="submit" name="Go">GO!<i class="glyphicon glyphicon-search"></i></button>

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