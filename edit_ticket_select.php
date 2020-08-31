<?php
require_once 'check_session.php';
require 'tickets_connect.php';
try{
    $fio_mechans=$pdo->query("SELECT Id_worker,Name FROM Names_workers");
    foreach($fio_mechans as $row){
        $fio[]=array('id_worker'=>$row['Id_worker'],'name'=>$row['Name']);  
    }
    return $fio;
}
catch (PDOException $e) {
    echo $e;
    exit();    
}