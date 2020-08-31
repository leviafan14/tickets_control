<?php
session_start();
$login_mechan=$_SESSION['login'];
if(isset($_POST['ta_descript']) and isset($_POST['t_comment'])){
    $description=$_POST['ta_descript'];
$comment=$_POST['t_comment'];
}
else{}
if (isset($_GET['numb']) and $_GET['ev']=='uncheck'){
    require_once 'functions_request.php';
    $numb=$_GET['numb'];
    uncheck_ticket($numb);
    header("Location:request1.php");
    exit();
}
    if(isset($_POST['check']) and $_POST['check']=="func"){
        require_once 'functions_request.php';
        $b=$_GET['b'];
        $numb=$_POST['numb'];
        a_func($numb,$login_mechan,$description,$comment);
        header("Location:request1.php");
        exit();
    }
    else{}
?>