<?php
require 'tickets_connect.php';
function send_login_password($fio_mech,$doc_mech,$paswrd,$phone_mech,$cb_sms){
try{
    if ($cb_sms=='send'){
        require 'tickets_connect.php';
        require_once 'smsc_api.php';
        $message="ФИО: ".$fio_mech."\n"."Логин: ".$doc_mech."\n"."Пароль: ".$paswrd;
        send_sms($phone_mech,$message);
    }
    else {}
}
catch (Exception $ex) {
        echo "Ошибка отправки смс сообщения";
        exit(); 
    }
}
function add_to_t_mechan($fio_mech,$phone_mech,$status_mech,$doc_mech,$category){
   require 'tickets_connect.php';
   //Добавление в таблицу t_mechan - содержит id статуса, № документа, id категории
    try{
        $s=$pdo->prepare("INSERT INTO t_mechan (Status,N_doc,Category) VALUES (:status_mech,:doc_mech,:category)");
        $s->bindValue(':status_mech',$status_mech);
        $s->bindValue(':doc_mech',$doc_mech);
        $s->bindValue(':category',$category);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "Ошибка добавления в таблицу";
        exit();    
    }
    //Добавление в таблицу Names_workers - содержит имена сотрудников
    try{
        $s=$pdo->prepare("INSERT INTO  Names_workers (Name,Id_worker) VALUES (:name,:id_worker)");
        $s->bindValue(':name',$fio_mech);
        $s->bindValue(':id_worker',$doc_mech);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "Ошибка добавления в таблицу";
        exit();    
    }
    //Добавление в таблицу Phones_workers - содержит имена сотрудников
    try{
        $s=$pdo->prepare("INSERT INTO  Phones_workers (Phone_worker,Id_worker) VALUES (:phone_worker,:id_worker)");
        $s->bindValue(':phone_worker',$phone_mech);
        $s->bindValue(':id_worker',$doc_mech);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "Ошибка добавления в таблицу";
        exit();    
    }
}
function add_to_mlogins($doc_mech,$paswrd_mech,$category){
    require 'tickets_connect.php';
     try{
        $s=$pdo->prepare("INSERT INTO mlogns (Login,paswrd,Category) VALUES (:doc_mech,:paswrd_mech,:category)");
        $s->bindValue(':doc_mech',$doc_mech);
        $s->bindValue(':paswrd_mech',$paswrd_mech);
        $s->bindValue(':category',$category);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "Ошибка добавления в таблицу";
        exit();    
    }
}
function add_worker($fio_mech,$phone_mech,$status_mech,$doc_mech,$category,$paswrd_mech,$paswrd,$cb_sms){
    add_to_t_mechan($fio_mech,$phone_mech,$status_mech,$doc_mech,$category);
    add_to_mlogins($doc_mech,$paswrd_mech,$category);
    send_login_password($fio_mech,$doc_mech,$paswrd,$phone_mech,$cb_sms);
    header("location:all_mechan.php");
    exit();
}
function add_first_worker($fio_mech,$phone_mech,$status_mech,$doc_mech,$category,$paswrd_mech){
    add_to_t_mechan($fio_mech,$phone_mech,$status_mech,$doc_mech,$category);
    add_to_mlogins($doc_mech,$paswrd_mech,$category);
}
?>