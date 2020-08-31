<?php 
require_once 'edit_ticket_function.php';
require_once 'tickets_connect.php';
require_once 'check_session.php';
$n_tick=trim($_GET['id_tick']);
$t_type=trim($_POST['sct_type']);
$t_class=trim($_POST['sct_class']);
$t_state=trim($_POST['sct_state']);
$t_phone=trim($_POST['num_phone']);
$t_descr=trim($_POST['txt_descr']);
$t_status=trim($_POST['sct_status']);
$t_adress=trim($_POST['txt_adress']);
$t_tarif=trim($_POST['t_tarif']);
$t_time=($_POST['t_time']);
$t_date=trim($_POST['dte_date']);
$t_date_check=trim($_POST['dte_date_check']);
$now_date=date('Y-m-d'); //текущая дата
$otv_m=trim($_POST['sct_mechan']);
if ($otv_m!=NULL and $t_status==2){
    if($t_date_check!=NULL and $t_date_check!=$now_date){
        $t_date_check=$t_date_check;
    }
    else {}
    if ($t_date_check==NULL){
        $t_date_check=$now_date;
    }
    else {}
}
else{}
//Если статус не равен Выполнена(id 2), то дата выполнения и 
//выполнивший механик обнуляются
if ($t_status!=2 and $otv_m!=NULL){
    $t_date_check=NULL;
    $otv_m=NULL;
}
else {}
//Если статус равен "выполнена" и дата выполнения равна NULL и
// выполнивший механик равен NULL, то значение ответственному механику
// присваивается значение функции username() и дате выполнения присваивается
// текущая дата
if ($t_status==2 and $t_date_check==NULL and $otv_m==NULL){
    $otv_m=username();
    $t_date_check=date('Y-m-d');
}
else{}
//Если выполнивший механик равен NULL и статус равен выполнена(id 2), то 
// выполневшему механику присваивается результат функции username()
if ($otv_m==NULL and $t_status==2){
    $otv_m=username();
}
else{}
//обновление времени
if ($t_time!=NULL){
    try{
        $s=$pdo->prepare('UPDATE ticket_date SET time=:time WHERE id_ticket=:id_ticket');
        $s->bindValue(':time',$t_time);
        $s->bindValue(':id_ticket',$n_tick);
        $s->execute();
    } 
    catch (Exception $ex) {
        echo "не удалось обновить время заявки";
        exit();
    }
} 
else{}
    //обновление данных в основоной таблице
    try{
        $s=$pdo->prepare("UPDATE atable SET Type=:t_type,Class=:t_class,State=:t_state,Status=:t_status,
           Tarif=:t_tarif,Date=:t_date,otv_mechan=:otv_m WHERE Number=:n_tick");
        $s->execute(array(
                ':t_type' => $t_type,
                ':t_class'=>$t_class,
                ':t_state'=>$t_state,
                ':t_status'=>$t_status,
                ':t_tarif'=>$t_tarif,
                ':t_date'=>$t_date,
                ':otv_m'=>$otv_m,
                ':n_tick'=>$n_tick));
    }
    catch (Exception $ex) {
        echo "Не удалось обновить информацию о заявке";
        exit();       
    }
//Обновление описания заявки
    try{
        $s=$pdo->prepare('UPDATE ticket_description SET description=:description WHERE id_ticket=:id_ticket');
        $s->bindValue(":description",$t_descr);
        $s->bindValue(":id_ticket",$n_tick);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "не удалось обновить описание";
        exit();
    }
    //Обновление телефона заявки
    try{
        $s=$pdo->prepare('UPDATE ticket_phone SET phone=:phone WHERE id_ticket=:id_ticket');
        $s->bindValue(":phone",$t_phone);
        $s->bindValue(":id_ticket",$n_tick);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "не удалось обновить номер телефона";
        exit();
    }
    //Обновление адреса заявки
    try{
        $s=$pdo->prepare('UPDATE ticket_adress SET adress=:adress WHERE id_ticket=:id_ticket');
        $s->bindValue(":adress",$t_adress);
        $s->bindValue(":id_ticket",$n_tick);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "не удалось обновить адрес";
        exit();
    }
    // Изменение даты выполнения заявки
    try{
        $s=$pdo->prepare('UPDATE ticket_date SET date_check=:date_check WHERE id_ticket=:id_ticket');
        $s->bindValue(':date_check',$t_date_check);
        $s->bindValue(':id_ticket',$n_tick);
        $s->execute();
    } 
    catch (Exception $ex) {
        echo "не удалось обновить дату выполнения";
        exit();
    }
if($_SESSION['category']==2){
    header("location:all_tickets.php");
    exit();
}
else{}
if($_SESSION['category']==1){
    header("location:request1.php");
    exit();
}
?>