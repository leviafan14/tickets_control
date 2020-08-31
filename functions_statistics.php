<?php
$date=date('Y-m-d');
$result_no=tickets_stat($date,1);
//////////////////////////////////////////////////////////////////////
$result_yes=tickets_stat($date,2);  
function tickets_stat($date, $status){
    require 'connect_mechan.php';
    if ($status==1){  
        try{    
            $s=$pdo->prepare("SELECT Number FROM atable WHERE Date<=:date AND Status=:status");
            $s->bindValue(':date',$date);
            $s->bindValue(':status',1);
            $s->execute();
            $stat=$s->rowCount();
        }
        catch(PDOException $ex) {
            echo "Ошибка получения статистики не выполненных заявок";
            exit();
        }  
    }   
    if ($status==2){ 
        try{    
            $s=$pdo->prepare("SELECT id_ticket FROM ticket_date WHERE date_check=:date");
            $s->bindValue(':date',$date);
            $s->execute();
            $stat=$s->rowCount();
        }
        catch(PDOException $ex) {
            echo "Ошибка получения статистики выполненных заявок";
            exit();
        }
    }
    return $stat; 
}
function display_checked_tickets($date){
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
    catch(PDOException $e){
        echo "Ошибка получения идентифиакторов заявок";
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
            $s=$pdo->query("SELECT Number,Type,Class FROM atable WHERE Number IN ($search_array)");
        }
        else{
            echo "Заявки не найдены";
            exit();
        }
        
    }
    catch (PDOException $ex) {
        exit();
    }
    foreach($s->fetchAll() as $row_list){
        $id_complate_ticket=$row_list['Number'];
      echo "<tr><td class='td_body'><a href='request2.php?vw=y&numb=$id_complate_ticket'><span style='background:#FFE4C4; padding:5px; border:1px solid #FFE4C4;border-radius:20px'>".display_adress($row_list['Number'])."</span></a></td><td class='td_type'>".display_type($row_list['Type'])."</td></tr>";   
    }
}