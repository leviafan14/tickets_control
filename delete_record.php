<?php
require_once 'check_session.php';
require_once 'tickets_connect.php';
$id_record=$_GET['id_r'];
//Удаление записи из таблицы с заявками
try{
    $s=$pdo->prepare("DELETE FROM atable WHERE Number=:id_record LIMIT 1");
    $s->bindValue(':id_record',$id_record);
    $s->execute();
}
catch(PDOException $e){
    echo "ошибка удаления записи из таблицы с заявками";
    exit();
}
//Удаление записи из таблицы с адресами
try{
    $s=$pdo->prepare("DELETE FROM ticket_adress WHERE id_ticket=:id_record LIMIT 1");
    $s->bindValue(':id_record',$id_record);
    $s->execute();
}
catch(PDOException $e){
    echo "ошибка удаления записи из таблицы с заявками";
    exit();
}
//Удаление записи из таблицы с описаниями
try{
    $s=$pdo->prepare("DELETE FROM ticket_description WHERE id_ticket=:id_record LIMIT 1");
    $s->bindValue(':id_record',$id_record);
    $s->execute();
}
catch(PDOException $e){
    echo "ошибка удаления записи из таблицы с заявками";
    exit();
}
//Удаление записи из таблицы с датой и временем заявок
try{
    $s=$pdo->prepare("DELETE FROM ticket_date WHERE id_ticket=:id_record LIMIT 1");
    $s->bindValue(':id_record',$id_record);
    $s->execute();
}
catch(PDOException $e){
    echo "ошибка удаления записи из таблицы с заявками";
    exit();
}
//Удаление записи из таблицы с телефонными номерами
try{
    $s=$pdo->prepare("DELETE FROM ticket_phone WHERE id_ticket=:id_record LIMIT 1");
    $s->bindValue(':id_record',$id_record);
    $s->execute();
}
catch(PDOException $e){
    echo "ошибка удаления записи из таблицы с заявками";
    exit();
}
header("location:all_tickets.php");
exit();
?>