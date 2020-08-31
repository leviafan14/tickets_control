<?php
require_once 'tickets_connect.php';
//-----------------------------------------------------------------------------
//Функция отображения заявок
function load_tickets($display){ //Функция отображения заявок
    global $pdo;
    global $s;
    require_once 'check_session.php';
    require 'tickets_connect.php';
    if (!isset($_SESSION['q_load'])){ // Загружает заявки без результатов поиска
        try{
            $s=$pdo->prepare("SELECT Number,Type,Class,State,Status,Tarif FROM atable WHERE Status!=:status AND Date<=:date ORDER BY Number DESC");
            $s->bindValue(':status',2);
            $s->bindValue(':date',date('Y-m-d'));
            $s->execute();
        }
        catch (Exception $ex) {
            echo "Ошибка загрузки информации из таблицы с заявками";
            exit();    
        }
    }       
    else {
    // Загружает результат поиска
        try{
            $s=$pdo->prepare($_SESSION['q_load']);
            $s->execute();
        }
        catch(PDOException $ex){
            echo "Не найдено";
        }
    }
    if($display=='print'){
    while($row=$s->fetch()){// Вывод записей на экран
        $number_ticket=$row['Number'];
        echo "<tr><td>".$row['Number']."</td>"
                . "<td>".display_type($row['Type'])."</td><td>".display_class($row['Class'])."</td><td>".display_time($row['Number'])."</td>"
                . "<td>".display_adress($row['Number'])."</td>"
                . "<td>".display_tarif($row['Tarif'])."</td>"
                . "<td>".display_description($row['Number'])."</td></tr>";
    }
    }
    else{
        while($row=$s->fetch()){// Вывод записей на экран
        $descr_title= display_description($row['Number']);
        $number_ticket=$row['Number'];
        echo "<tr><td><a class='table_menu' href=edit_ticket.php?id_t=$number_ticket title="."'$descr_title'".">".$row['Number']."</a></td>"
                . "<td>".display_type($row['Type'])."</td><td>".display_class($row['Class'])."</td><td>".display_time($row['Number'])."</td>"
                . "<td>".display_adress($row['Number'])."</td><td>". display_phone($row['Number'])."</td>"
                . "<td>".display_status($row['Status'])."</td>"
                . "<td class='td_menu'><a title='Отправить заявку' class='table_menu' href=send_ticket.php?id_tct=".$row['Number']."?sms=true>".display_state($row['State'])."</a>"
                . "</td><td class='td_menu'><a title='Удалить заявку' class='table_menu' href=delete_record.php?id_r=".$row['Number'].">"
                . "<span class='delete_button'>&nbsp;×&nbsp;</span></a></td></tr>";
    }
 }
}
//-----------------------------------------------------------------------------
//Функция вывода типа заявки
function display_type($id_type){
    require'tickets_connect.php';
    try{
        $s=$pdo->prepare("SELECT Type FROM ticket_type WHERE Id=:id_type LIMIT 1");
        $s->bindValue(":id_type",$id_type);
        $s->execute();
        foreach($s->fetchAll() as $row){}
    }
    catch (Exception $ex) {
        echo "Ошибка отображения типов заявки";
        exit();    
    }
    return $row['Type'];
}
//------------------------------------------------------------------------------
//Функция вывода класса заявки
function display_class($id_class){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT Class FROM ticket_class WHERE Id=:id_class LIMIT 1");
        $s->bindValue(":id_class",$id_class);
        $s->execute();
        foreach($s->fetchAll() as $row){}
     }
    catch (Exception $ex) {
        echo "Ошибка отображения классов заявки";
        exit();    
    }
    return $row['Class'];
}
//------------------------------------------------------------------------------
//Функция вывода статуса заявки
function display_status($id_status){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT Status FROM ticket_status WHERE Id=:id_status LIMIT 1");
        $s->bindValue(":id_status",$id_status);
        $s->execute();
        foreach($s->fetchAll() as $row){}
    }
    catch (Exception $ex) {
        echo "Ошибка отображения статусов заявки";
        exit();    
    }
    return $row['Status'];
}
//-----------------------------------------------------------------------------
//Функция вывода состояния заявки
function display_state($id_state){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT State FROM ticket_state WHERE Id=:id_state LIMIT 1");
        $s->bindValue(":id_state",$id_state);
        $s->execute();
        foreach($s->fetchAll() as $row){}
     }
    catch (Exception $ex) {
        echo "Ошибка отображения состояний заявки";
        exit();    
    }
    return $row['State'];
}
//------------------------------------------------------------------------------
//Функция вывода адреса заявки
function display_adress($id_ticket){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT adress FROM ticket_adress WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){}
     }
    catch (Exception $ex) {
        echo "Ошибка отображения адреса заявки";
        exit();    
    }
return $row['adress'];
}
//-----------------------------------------------------------------------------
//Функция вывода назначенного времени заявки
function display_time($id_ticket){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT TIME_FORMAT(time,'%H:%i') AS time FROM ticket_date WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){
            if($row['time']==NULL){
                $row['time']='--:--';
            }
        }
    }
    catch (Exception $ex){
        echo "Ошибка отображения времени заявки";
        exit();    
    }
    return $row['time'];
}
//-----------------------------------------------------------------------------
//Функция вывода телефона заявки
function display_phone($id_ticket){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT phone FROM ticket_phone WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){
            if($row['phone']==0){
                $row['phone']='не указан';
            }
        }
    }
    catch (Exception $ex) {
        echo "Ошибка отображения телефона абонента";
        exit();    
    }
    return $row['phone'];
}
//------------------------------------------------------------------------------
//Функция вывода описания заявки
function display_description($id_ticket){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT description FROM ticket_description WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){
            if($row['description']==NULL){
                $row['description']='описание отсутствует';
            }
        }
    }
    catch (Exception $ex) {
        echo "Ошибка отображения описания заявки";
        exit();    
    }
    return $row['description'];
}
//-----------------------------------------------------------------------------
// Функция вывода текущего тарифа
function display_tarif($id_tarif){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("SELECT Id,Price FROM Tarifs WHERE Id=:id_tarif LIMIT 1");
        $s->bindValue(':id_tarif',$id_tarif);
        $s->execute();
        foreach($s->fetchAll() as $row){
            if ($row['Price']==0){
                 $row['Price']="не указан";
            }
            else{
                 $row['Price']=$row['Price'];
            }
        }    
    }
    catch (PDOException $e) {
        echo "Ошибка отображения тарифа заявки";
        exit();
    }
   return $row['Price'];
}
//-----------------------------------------------------------------------------
//Функция подсчётка количества строк
function kolrows($row){// Функция подсчёта количества записей и отображения текста запроса
    echo"<p id='p_kol_rows'><span id='s_kol_rows'>Записей: ".$row->rowCount()."</span>";
    if(isset($_SESSION['txt_query'])){ // Выводит на экран текст запроса в понятном для пользователя виде
        echo "<span style='margin:6px; font-size:16px;'><a class='a_table_menu' href='abort_search.php'>Сброс</a>".$_SESSION['txt_query']."</span>";
    }
    else{}
    if(!isset($_SESSION['txt_query'])){ // Выводит на экран сообщение (следующая строка)
      echo "<strong><span id='s_unchecked_tickets'>Загружены заявки невыполненные по текущий день</span></strong>";  
    }
    echo"</p>";
}
//Функция выввода имени сотрудника прошедшего авторизацию
function get_name_operator($login){
   require 'connect_mechan.php';
    global $pdo;
    if(isset($login)){
        try{
            $s=$pdo->prepare("SELECT Name FROM Names_workers WHERE Id_worker=:login LIMIT 1");
            $s->bindValue(':login',$login);
            $s->execute();
            $row=$s->fetch(PDO::FETCH_ASSOC);// Вывод записей на экран
                echo $row['Name'];
            
        }
        catch (Exception $ex) {
            echo "Ошибка вывода имени сотрудника";
            exit();    
        }
    }
    else{
        echo "Отсутствуют данные";
        exit();
    }
}
?>