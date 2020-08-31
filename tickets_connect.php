<?php
date_default_timezone_set('Asia/Yekaterinburg');
$host="localhost";
$user="g90890zj_tickets";
$paswd="R7yon8Cu5ofIcODuqesO62c3H1mE7o";
$charset="utf8";
$db="g90890zj_tickets";
$dsn="mysql:host=$host;dbname=$db;charset=$charset";
try{
   $pdo=new PDO($dsn,$user,$paswd);
   $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $pdo->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY,1);
} catch (PDOException $e) {
    echo "Error </br>";
    echo $e->getMessage();
    exit();
}
?>