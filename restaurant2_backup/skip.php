<?php
$page_css = "skip";
include('header.php');
?>

<div>

    <?php

    if(isset($_POST['selected_restaurant'])) {
        echo "<p>helloooooooooooooooo</p>";
        $selected_restaurant = $_POST['selected_restaurant'];
        echo $selected_restaurant;
    }
/*
    $db = new mysqli("address","id","password","DBname");
    if (mysqli_connect_errno()) {
        echo "Connection Failed: " . mysqli_connect_errno();
        exit();
    }

    $stmt = $db->prepare("INSERT INTO users (name, email, mobile, city, message) VALUES (?, ?, ?, ?, ?)");
    $stmt -> bind_param('sssss', $fname, $femail, $fmobile, $fcity, $fmessage);

    $fname = $_POST['fname'];
    $femail = $_POST['femail'];
    $fmobile = $_POST['fmobile'];
    $fcity = $_POST['fcity'];
    $fmessage = $_POST['fmessage'];

    $stmt -> execute();
    $stmt -> close();
    $db -> close();
    }
        */
    ?>

</div>

<?php
include('footer.php');
?>