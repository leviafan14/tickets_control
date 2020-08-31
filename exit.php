<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['password']);
unset($_POST['h_balance']);
unset($_SESSION['q_mech']);
unset($_SESSION['q_mech2']);
unset($_SESSION['txt_query_mechan']);
header("location: enter.php");
exit();
?>