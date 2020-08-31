<?php
require_once 'check_session.php';
require_once 'tickets_connect.php';
$type=trim($_POST['s_type']);
$class=trim($_POST['s_class']);
$state=trim($_POST['s_state']);
$phone=htmlentities(trim($_POST['n_phone']));
$descr=htmlentities(trim($_POST['t_descr']));
$status=trim($_POST['s_status']);
$adress=htmlentities(trim($_POST['t_adress']));
$time=htmlentities(trim($_POST['t_time']));
$tarif=trim($_POST['t_tarif']); 
$date=htmlentities(trim($_POST['d_date']));
$login=trim($_SESSION['login']);
if (!$adress || !$date){
    echo "<H4 style='color:lightsalmon;'>Введите все данные. "."<a style='text-decoration:none;color:#00FF7F;' href=all_tickets.php>К заявкам</a></H4>";
    exit();
}
else{}
    try{
        $s=$pdo->prepare("INSERT INTO atable (Type,Class,State,Status,Tarif,Date,create_user) VALUES (:type,:class,:state,:status,:tarif,:date,:login)");
        $s->bindValue(':type',$type);
        $s->bindValue(':class',$class);
        $s->bindValue(':state',2);
        $s->bindValue(':status',1);
        $s->bindValue(':tarif',$tarif);
        $s->bindValue(':date',$date);
        $s->bindValue(':login',$login);
        $s->execute(); 
        $last_insert_ticket_number = $pdo->lastInsertId();
    }
    catch(PDOException $ex) {
        echo "Ошибка вставки записи";
        exit();
    }
   //Добавление записи в таблицу с тел. номерами  
    try{
        $s=$pdo->prepare("INSERT INTO ticket_phone (phone,id_ticket) VALUES (:phone,:id_ticket)");
        $s->bindValue(':phone',$phone);
        $s->bindValue(':id_ticket',$last_insert_ticket_number);
        $s->execute(); 
    } 
    catch(PDOException $ex) {
        echo "Ошибка добавления телефона абонента";
        exit();
    }
    //Добавление записи в таблицу с адерсами   
    try{
        $s=$pdo->prepare("INSERT INTO ticket_adress (adress,id_ticket) VALUES (:adress,:id_ticket)");
        $s->bindValue(':adress',$adress);
        $s->bindValue(':id_ticket',$last_insert_ticket_number);
        $s->execute(); 
    } 
    catch(PDOException $ex) {
        echo "Ошибка добавления адреса";
        exit();
    }
    //Добавление записи в таблицу с описаниями 
    try{
        $s=$pdo->prepare("INSERT INTO ticket_description (description,id_ticket) VALUES (:description,:id_ticket)");
        $s->bindValue(':description',$descr);
        $s->bindValue(':id_ticket',$last_insert_ticket_number);
        $s->execute(); 
    } 
    catch(PDOException $ex) {
        echo "Ошибка добавления описания";
        exit();
    }
    //Добавление записи в таблицу с датой и временем
    if($time==NULL){
        try{
            $s=$pdo->prepare("INSERT INTO ticket_date (time,id_ticket) VALUES (NULL,:id_ticket)");
            $s->bindValue(':id_ticket',$last_insert_ticket_number);
            $s->execute(); 
        }  
        catch(PDOException $ex) {
            echo "Ошибка добавления времени";
            exit();
        }
    }
    else{
        try{
            $s=$pdo->prepare("INSERT INTO ticket_date (time,id_ticket) VALUES (:time,:id_ticket)");
            $s->bindValue(':time',$time);
            $s->bindValue(':id_ticket',$last_insert_ticket_number);
            $s->execute(); 
        } 
        catch(PDOException $ex) {
            echo "Ошибка добавления времени";
            exit();
        }
    }
    try{
        $s=$pdo->prepare("SELECT Category FROM mlogns WHERE Login=:login");
        $s->bindValue(':login',$login);
        $s->execute();
    }               
    catch (PDOException $ex){
        echo "Не удалось получить данные $ex";
        exit();
    }
    foreach($s->fetchAll() as $data){}
        if($data['Category']==2){
            header("location:all_tickets.php");
            exit();
        }
        else{}
        if ($data['Category']==1) {
            header("location:request1.php");
            exit();
        }
        else{}
    #header("location:all_tickets.php");
    #exit();
?>