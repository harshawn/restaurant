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

            <h3>In this area/city?:</h3>
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" name="restaurantCity" placeholder="e.g. Leicester, London">
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-screenshot"></i></button>
                </div>
            </div>

            <h3>For this date and time:</h3>
                <div class='input-group date' id='datetimepicker'>
                    <input type='text' class="form-control" name="restaurantDateTime"/>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>


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