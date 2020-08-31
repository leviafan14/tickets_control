<?php
require_once 'tickets_connect.php';
try{
    $result=$pdo->query("SELECT * FROM ticket_search_param");
    foreach($result as $row)
        $param_search[]=array('id'=>$row['Id'],'value'=>$row['Value'],'name'=>$row['Name']);
} 
catch (Exception $ex) {
    echo "Ошибка получения параметров поиска заявок";
    exit();
}
?>