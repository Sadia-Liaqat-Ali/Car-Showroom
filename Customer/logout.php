<?php
session_start();
session_unset();
session_destroy();
header("Location:../index.php"); // Change 'login.php' if your login page has a different name
exit();
?>
