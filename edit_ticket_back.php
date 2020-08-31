<?php
require_once 'check_session.php';
$id_ticket=$_GET['id_t'];
$login=trim($_SESSION['login']);
require_once 'tickets_connect.php';
$s=$pdo->prepare("SELECT Number,Type,Class,State,Status,Tarif,Date,otv_mechan,Create_user FROM atable WHERE Number=:id_ticket");
$s->bindValue(':id_ticket',$id_ticket);
$s->execute();
    foreach($s->fetchAll() as $r_ticket)
        {   
            $number_t=$r_ticket['Number'];
            $type_t=$r_ticket['Type'];
            $class_t=$r_ticket['Class'];
            $state_t=$r_ticket['State'];
            $status_t=$r_ticket['Status'];
            $tarif_t=$r_ticket['Tarif'];
            $date_t=$r_ticket['Date'];
            $employee_t=$r_ticket['otv_mechan'];
            $create_user=$r_ticket['Create_user'];
        };
try{
    $result=$pdo->query("SELECT Id,Type FROM ticket_type");
    foreach($result as $row)
        $param_type[]=array('id'=>$row['Id'],'type'=>$row['Type']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения типа заявки";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,Class FROM ticket_class");
    foreach($result as $row)
        $param_class[]=array('id'=>$row['Id'],'class'=>$row['Class'],'status'=>$row['Status']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения класса заявки";
    exit();
}
try{
    $result=$pdo->query("SELECT Id,State FROM ticket_state");
    foreach($result as $row)
        $param_state[]=array('id'=>$row['Id'],'state'=>$row['State']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения состояния заявки";
    exit();
} 
try{
    $result=$pdo->query("SELECT Id,Status FROM ticket_status");
    foreach($result as $row)
        $param_status[]=array('id'=>$row['Id'],'status'=>$row['Status']);
}
 catch (PDOException $ex) {
    echo "Ошибка получения статуса заявки";
    exit(); 
}
try{
    $s=$pdo->prepare("SELECT Name FROM Names_workers WHERE Id_worker=:id_worker LIMIT 1");
    $s->bindValue(':id_worker',$create_user);
    $s->execute();
    foreach($s->fetchAll() as $row){}}
 catch (PDOException $ex) {
    echo "Ошибка получения ФИО сотрудника создавшего заявку $ex";
    exit(); 
}

?>