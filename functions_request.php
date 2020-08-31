<?php
session_start();
function display_tickets(){
    require 'connect_mechan.php';
    $date_ticket=date('Y-m-d');
    try{
        $s=$pdo->prepare("SELECT Number,Type,Class FROM atable WHERE Date<=:date_ticket AND Status=:status ORDER BY Number DESC");
        $s->bindValue(':date_ticket', $date_ticket);
        $s->bindValue(':status',1);
        $s->execute();
    }
    catch (PDOException $ex) {
        echo "Ошибка получения данных";
        exit();
    }
    foreach($s->fetchAll() as $row ){
        echo "<tr class='t1_tr' >"."<td class='td_numb'>"."<a href=request2.php?numb=".$row['Number'].">".$row['Number']."</a>"."</td>"."<td class='td_numb'>"."<a href=request2.php?numb=".$row['Number'].">".display_adress($row['Number'])."</a>"."</td><td class='td_numb'>"."<a href=request2.php?numb=".$row['Number'].">".display_type($row['Type'])."</a>"."</td><td class='td_numb'>"."<a href=request2.php?numb=".$row['Number'].">".display_class($row['Class'])."</a>"."</td></tr>";
    }
}
// Вывод адреса заявки
function display_adress($adress_id){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT adress FROM ticket_adress WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(':id_ticket', $adress_id);
        $s->execute();
        $adress_value=$s->fetchColumn();
        return $adress_value;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения адреса";
        exit();
    }
}
// Вывод описания заявки
function display_description($descr_id){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT description FROM ticket_description WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(':id_ticket', $descr_id);
        $s->execute();
        $descr_value=$s->fetchColumn();
        return $descr_value;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения описания";
        exit();
    }
}
// Вывод типа заявки
function display_type($type_id){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT Type FROM ticket_type WHERE Id=:id LIMIT 1");
        $s->bindValue(':id', $type_id);
        $s->execute();
        $type_value=$s->fetchColumn();
        return $type_value;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения типа заявки";
        exit();
    }
}
// Вывод класса заявки
function display_class($class_id){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT Class FROM ticket_class WHERE Id=:id LIMIT 1");
        $s->bindValue(':id', $class_id);
        $s->execute();
        $class_value=$s->fetchColumn();
        return $class_value;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения класса заявки";
        exit();
    }
}
// Вывод телефона заявки
function display_phone($id_ticket){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT phone FROM ticket_phone WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(':id_ticket',$id_ticket);
        $s->execute();
        $phone=$s->fetchColumn();
        if ($phone==0){
            $phone="Не указан";
        }
        else{}
        return $phone;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения номера телефона";
        exit();
    }
}
//Вывод статуса заявки
function display_status($id_status){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT Status FROM ticket_status WHERE Id=:id LIMIT 1");
        $s->bindValue(':id',$id_status);
        $s->execute();
        $status=$s->fetchColumn();
        return $status;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения статуса";
        exit();
    }
}
// Вывод состояния заявки
function display_state($id_state){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT State FROM ticket_state WHERE Id=:id LIMIT 1");
        $s->bindValue(':id',$id_state);
        $s->execute();
        $state=$s->fetchColumn();
        return $state;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения состояния";
        exit();
    }
}
//Вывод тарифа
function display_tarif($id_tarif){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT Price FROM Tarifs WHERE Id=:id LIMIT 1");
        $s->bindValue(':id',$id_tarif);
        $s->execute();
        $tarif=$s->fetchColumn();
        if ($tarif==0){
            $tarif="не указан";
        }
        else{}
        return $tarif;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения тарифа";
        exit();
    }
}
//Вывод времени заявки
function display_time($id_ticket){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT time FROM ticket_date WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(':id_ticket',$id_ticket);
        $s->execute();
        $time=$s->fetchColumn();
        return $time;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения времени";
        exit();
    }
}
///////////////////////////////////////////////////////////////////////////////
function a_func($numb,$login_mechan,$description,$comment){
    require 'connect_mechan.php';
    $check=2;
    if(!empty($comment)){
        $description="$description пр: $comment";  
    }
    //Обновление описания заявки
    try{
        $date_check=date('Y-m-d');
        $s=$pdo->prepare("UPDATE ticket_description SET description=:description WHERE id_ticket=:numb LIMIT 1");
        $s->bindValue(':description',$description);
        $s->bindValue(':numb',$numb);
        $s->execute();
    }
    catch (PDOException $ex) {
        echo "Ошибка выполнения операции";
        exit();
    }
    //Изменение статуса заявки
    try{
        $s=$pdo->prepare("UPDATE atable SET Status=:check, otv_mechan=:id_worker WHERE Number=:numb LIMIT 1");
        $s->bindValue(':check',$check);
        $s->bindValue(':numb',$numb);
        $s->bindValue(':id_worker',$login_mechan);
        $s->execute();
    }
    catch (PDOException $ex) {
        echo "ОШибка выполнения операции";
        exit();
    }
    //Изменение даты выполнения заявки
    try{
        $s=$pdo->prepare("UPDATE ticket_date SET date_check=:date WHERE id_ticket=:numb LIMIT 1");
        $s->bindValue(':date',$date_check);
        $s->bindValue(':numb',$numb);
        $s->execute();
    }
    catch (PDOException $ex) {
        echo "ОШибка выполнения операции";
        exit();
    }
    $_POST['numb']=NULL;
    $_POST['check']=NULL;
    $_GET['numb']=NULL;
}
function display_create_ticket_user($user_id){
    require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT Name FROM Names_workers WHERE Id_worker=:id_worker LIMIT 1");
        $s->bindValue(':id_worker', $user_id);
        $s->execute();
        $worker_name=$s->fetchColumn();
        return $worker_name;
    }
    catch (PDOException $ex) {
        echo "Ошибка получения имени сотрудника создавшего заявку";
        exit();
    }
}

// Отмена выполнения заявки

function uncheck_ticket($numb){
    require 'connect_mechan.php';
    $uncheck=1;
    $login_mechan=NULL;
    $date_uncheck=NULL;
    //Изменение статуса заявки
    try{
        $s=$pdo->prepare("UPDATE atable SET Status=:uncheck, otv_mechan=:id_worker WHERE Number=:numb LIMIT 1");
        $s->bindValue(':uncheck',$uncheck);
        $s->bindValue(':numb',$numb);
        $s->bindValue(':id_worker',$login_mechan);
        $s->execute();
    }
    catch (PDOException $ex) {
        echo "ОШибка выполнения операции </br> $ex";
        exit();
    }
    //Изменение даты выполнения заявки
    try{
        $s=$pdo->prepare("UPDATE ticket_date SET date_check=:date WHERE id_ticket=:numb LIMIT 1");
        $s->bindValue(':date',$date_uncheck);
        $s->bindValue(':numb',$numb);
        $s->execute();
    }
    catch (PDOException $ex) {
        echo "ОШибка выполнения операции </br> $ex";
        exit();
    }
    $_GET['numb']=NULL;
}