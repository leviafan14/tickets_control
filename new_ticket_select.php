<?php
try{
    $result=$pdo->query("SELECT * FROM ticket_type");
    foreach($result as $row)
        $param_type[]=array('type'=>$row['Type'],'id'=>$row['Id']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения типов заявок";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,Class FROM ticket_class");
    foreach($result as $row)
        $param_class[]=array('class'=>$row['Class'],'id'=>$row['Id']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения классов заявок";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,Status FROM ticket_status");
    foreach($result as $row)
        $param_status[]=array('status'=>$row['Status'],'id'=>$row['Id']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения статусов заявок";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,State FROM ticket_state");
    foreach($result as $row)
        $param_state[]=array('state'=>$row['State'],'id'=>$row['Id']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения состояний заявок";
    exit();
}