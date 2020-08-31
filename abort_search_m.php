<?php
session_start();
unset($_SESSION['q_mech']);
unset($_SESSION['q_mech2']);
unset($_SESSION['txt_query_mechan']);
header("location:all_mechan.php");
exit();
?>