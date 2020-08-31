<?php
 session_start();  
 $login=$_SESSION['login'];
try{
    require 'connect_mechan.php';
    $s=$pdo->prepare("SELECT Name FROM Names_workers WHERE Id_worker=:login LIMIT 1");
    $s->bindValue(':login',$login);
    $s->execute();
    $fio_mechanic=$s->fetchColumn();
}
catch(PDOException $ex) {
    echo "Ошибка получения имени сотрудника";
    exit();
}
//Подсчет общего количества выполненных заявок
///////////////////////////////////////////////////////////////
//Список выполненных заявок механиком за текущий день
function personal_list($date,$fiomechanic){
    require"check_session.php";
    require 'functions_request.php';
    require 'connect_mechan.php';
        //Получение идентификаторов заявок которые выполнены в указанную дату
    try{
        $s=$pdo->prepare("SELECT id_ticket FROM ticket_date WHERE Date_check=:date");
        $s->bindValue(':date',date('Y-m-d'));
        $s->execute();
        $i=0;
        foreach($s->fetchAll() as $result_tickets){
            $search_txt[$i]=$result_tickets['id_ticket'];
            $i++;
        }
    } 
    catch (Exception $ex) {
        echo "Ошибка получения идентификаторов заявок";
        exit();
    }
    try{
        if(!empty($search_txt)){
           $search_array=implode(",",$search_txt);
        }
        else{
            echo "Заявки не найдены";
            exit();
        }
        if(!empty($search_array)){
            $s=$pdo->query("SELECT Number,Type,Class,Create_user FROM atable WHERE otv_mechan=".$_SESSION['login']." AND Number IN ($search_array)");
        }
        else{
            echo "Заявки не найдены";
            exit();
        }
       
        foreach($s->fetchAll() as $row_list){ 
            $numb=$row_list['Number'];
           echo "<tr><td class='td_body'><a href=complate_ticket.php?ev=uncheck&numb=$numb><b>
           <span style='background:#FFE4C4; border-radius:10px; font-family:arial; padding:3px;'>".display_adress($row_list['Number'])."</span></b></a></td><td class='td_type'>".display_type($row_list['Type']).
           "</td></tr>"; 
            }
        echo "<tr><td><strong>Всего:". $s->rowCount()." </strong></td></tr></b>";
    }
    catch(PDOException $ex) {
        echo "Ошибка получения информации о заявке";
        exit();
    } 
}