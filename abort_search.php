<?php
session_start();
unset($_SESSION['q_load']);
unset($_SESSION['q_load2']);
unset($_SESSION['txt_query']);
header("location:all_tickets.php");
exit();
?>