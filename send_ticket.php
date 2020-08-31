<?php
require_once'tickets_connect.php';
require_once 'smsc_api.php';
$info_title="Инфо:";
$time_title="Время:";
$tarif_title="Тариф:";
$id_tick=$_GET['id_tct'];       
//Получение данных из таблицы с заявками
try{
    $s=$pdo->prepare("SELECT Number,Type,Class,Tarif FROM atable WHERE Number=:id_tick LIMIT 1");
    $s->bindValue(':id_tick',$id_tick);
    $s->execute();
}
catch(PDOException $e){ 
    echo "Не удалось получить данные о заявке";
}
 // Выбор данных заявки
foreach($s->fetchAll() as $row_tick)
    {
        $n_tkt=$row_tick['Number'];
        $adress_tkt=$row_tick['Adress'];
        $type_tkt=$row_tick['Type'];
        $class_tkt=$row_tick['Class'];
        $descr_tkt=$row_tick['Description'];
        $time_tkt=$row_tick['Time'];
        $tarif_tkt=$row_tick['Tarif'];
    }
//Получение адреса заявки из таблицы с адресами
try{
    $s=$pdo->prepare("SELECT adress FROM ticket_adress WHERE id_ticket=:number_ticket LIMIT 1");
    $s->bindValue(":number_ticket",$id_tick);
    $s->execute();
    $adress=$s->fetchColumn();
}
catch (Exception $e) {
    echo "Не удалось получить адрес заявки";
}
//Получение типа заявки из таблицы с типами
try{
    $s=$pdo->prepare("SELECT Type FROM ticket_type WHERE Id=:id_type LIMIT 1");
    $s->bindValue(":id_type",$type_tkt);
    $s->execute();
   $type=$s->fetchColumn();
}
catch (Exception $e) {
    echo "Не удалось получить тип заявки";
    exit();
}
//Получение класса из таблицы с классами
try{
    $s=$pdo->prepare("SELECT Class FROM ticket_class WHERE Id=:id_type LIMIT 1");
    $s->bindValue(":id_type",$class_tkt);
    $s->execute();
    $class=$s->fetchColumn();
}
catch (Exception $e) {
    echo "Что-то пошло не так";
    exit();
}
//Получение описания заявки из таблицы с описаниями
try{
    $s=$pdo->prepare("SELECT description FROM ticket_description WHERE id_ticket=:number_ticket LIMIT 1");
    $s->bindValue(":number_ticket",$id_tick);
    $s->execute();
    $description=$s->fetchColumn();
}
catch (Exception $e) {
    echo "Не удалось получить описание заявки";
    exit();
}
//Получение времени заявки из таблицы с датой и временем
try{
    $s=$pdo->prepare("SELECT TIME_FORMAT(time,'%H:%i') as time FROM ticket_date WHERE id_ticket=:number_ticket LIMIT 1");
    $s->bindValue(":number_ticket",$id_tick);
    $s->execute();
    $time=$s->fetchColumn();
}
catch (Exception $e) {
    echo "Не удалось получить время заявки";
    exit();
}
//Получение тарифа заявки из таблицы с тарифами
try{
    $s=$pdo->prepare("SELECT Price FROM Tarifs WHERE Id=:id_tarif LIMIT 1");
    $s->bindValue(":id_tarif",$tarif_tkt);
    $s->execute();
    $tarif=$s->fetchColumn();
}
catch (Exception $e) {
    echo "Не удалось получить тариф";
    exit();
}
//Выбор сотрудников которым будет отправлено смс с заявкой
try{
    $s=$pdo->prepare("SELECT N_doc FROM t_mechan WHERE Status=1 AND Category=1");
    $s->execute();
    foreach($s->fetchAll() as $numbers){
        $search_txt[$i]=$numbers['N_doc'];
        $i++;
    }
}
catch(PDOException $e){
    echo "Не удалось получить данные о сотрудниках для отправки";
    exit();
}
//Проверка на наличие номеров для отправки
$count_numb=$s->rowCount();
if ($count_numb==0){
    echo "<H4>Нет подходящих номеров для отправки. <a style='text-decoration:none;color:#F0E68C;' href=all_mechan.php>Выбрать номера</a></H4>";
    exit();
}
//Отправка смс выбранным номерам
else{
    try{
        $search_array=implode(",",$search_txt);
        $s=$pdo->prepare("SELECT Phone_worker FROM Phones_workers WHERE Id_worker IN($search_array)");
        $s->execute();
        $phones=$s->fetchAll();
    } 
    catch (Exception $e) {
       echo "Не удалось получить телефоны сотрудников"; 
       exit();
    }
   $sender_message=$n_tkt."\n".$adress."\n".$type."\n".$class."\n".$info_title.$description."\n".$tarif_title.$tarif."\n".$time_title.$time;
    foreach($phones as $row_phone)
        { 
            $phone="+".$row_phone['Phone_worker'];
            send_sms($phone,$sender_message);//ВЫзов функции отправки смс
            //Проверка - было ли отправлено сообщение
    }
    if($m[1]>0){
            // Если сообщение отправлено, то изменить состояние заявки 
                $s=$pdo->prepare("UPDATE atable SET state=1 WHERE Number=:n_tkt");
                $s->bindValue(':n_tkt',$n_tkt);
                $s->execute();
            }
            else{}
    header("location:all_tickets.php");
    exit();
}
?>