<?php
require_once 'check_session.php';
try{
    $result=$pdo->query("SELECT * FROM mechan_search_parameters");
    foreach($result as $row)
        $param_search[]=array('id'=>$row['Id'],'parameter'=>$row['Parameter'],'search_field'=>$row['Search_field']);
} 
catch (Exception $ex) {
    echo $ex;
    exit();
}