<?php
require_once 'check_session.php';
require_once"tickets_connect.php";
try{
    $result=$pdo->query("SELECT Id,Type FROM ticket_type");
    foreach($result as $row)
        $param_search_type[]=array('id'=>$row['Id'],'type'=>$row['Type']);
}
catch (PDOException $ex) {
    echo "Ошибка получения тиgа заявки";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,Class FROM ticket_class");
    foreach($result as $row)
        $param_search_class[]=array('id'=>$row['Id'],'class'=>$row['Class']);
}
catch (PDOException $ex) {
     echo "Ошибка получения класса заявки";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,Status FROM ticket_status");
    foreach($result as $row)
        $param_search_status[]=array('id'=>$row['Id'],'status'=>$row['Status']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения статуса заявки";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,State FROM ticket_state");
    foreach($result as $row)
        $param_search_state[]=array('id'=>$row['Id'],'state'=>$row['State']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения состояния заявки";
    exit();
}              
try{
    $result=$pdo->query("SELECT Id,Price FROM Tarifs");
    foreach($result as $row)
        $param_search_tarifs[]=array('id'=>$row['Id'],'price'=>$row['Price']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения тарифа заявки";
    exit();
}   
require_once 'other_param_select.php';            
?>