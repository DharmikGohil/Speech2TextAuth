<?php  
session_start();

//destroy session for logout user
session_unset();
session_destroy();

//after destroying session, user redirect to login.php
header('location: login.php');
exit;

?>