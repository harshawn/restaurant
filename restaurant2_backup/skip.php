<?php
$page_css = "skip";
include('header.php');

/*if(isset($_POST['selected_restaurant_ID'])){
    $_SESSION['selected_restaurant_ID'] = $_POST['selected_restaurant_ID'];
}*/
?>

<div class="container">
    <h3>please don't forget to sign in <a href="customerLogin.php">CLICK HERE</a> to SIGN IN!</h3> <!--Need to check which page they redirect from, then bring them back after login-->
    <h3>or you can <a href="makeReservation.php">CLICK HERE</a> to continue!</h3>
    <p>maybe just redirect to customer page with option to skip, skip button would only appear is restaurant_table_ID is set in session</p>
</div>

<?php
include('footer.php');
?>