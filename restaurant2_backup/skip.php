<?php
$page_css = "skip";
include('header.php');

if(isset($_POST['selected_restaurant_ID'])){
    $_SESSION['selected_restaurant_ID'] = $_POST['selected_restaurant_ID'];
}
?>



    <div class="container">
        <h3>Please <a href="customerLogin.php">CLICK HERE</a> to SIGN IN!</h3> <!--Need to check which page they redirect from, then bring them back after login-->
        <h3>or <a href="viewTablesAvailable.php">CLICK HERE</a> to SKIP!</h3>
    </div>

<?php
include('footer.php');
?>