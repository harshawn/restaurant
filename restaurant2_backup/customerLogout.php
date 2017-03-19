<?php
/*session_destroy();*/
unset($_SESSION['customerEmail']);
header('Location: customerLogin.php');
exit;
?>