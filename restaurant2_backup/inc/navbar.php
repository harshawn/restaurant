
<nav class="navbar navbar-default">
<div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
        <!--a id="nav-name-link" class="navbar-brand" href="home.php">Restaurant Reservation System</a-->
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a id="page-links" href="home.php">Home</a></li>
            <li><a id="page-links" href="ownerLogin.php">Owner Login</a></li>
            <li><a id="page-links" href="search.php">SEARCH</a></li>
            <!-- <li><a id="page-links" href="customerLogin.php">Customer Login</a></li> -->
            <li><a id="page-links" href="help.php">Help</a></li>

            <?php
            if(isset($_SESSION['customerEmail'])){
                $customer_email=$_SESSION['customerEmail'];
                $check_customer="SELECT customer_firstname FROM `customers` WHERE customer_email='$customer_email'";
                $run=mysqli_query($conn,$check_customer);
                $run_array = mysqli_fetch_array($run);
                $customer_name = $run_array['customer_firstname'];

                echo "<li><a id='page-links' href='customerWelcome.php'>View Account</a></li>";
                echo "<li><a id='page-links' href='customerLogout.php'>Not ".$customer_name."? LOGOUT</a></li>";
            }
            else {
                echo "<li><a id='page-links' href='customerLogin.php'>Customer Login</a></li>";
            }
            ?>

        </ul>
    </div>
</div>
</nav>
