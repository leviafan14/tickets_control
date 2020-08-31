<?php
require_once 'check_session.php';
require_once 'tickets_connect.php';
$session_query="SELECT Number, Type, Class, State, Phone, Description, Status, Adress, Tarif, otv_mechan,"."TIME_FORMAT(Time,'%H:%i') AS Time".", Date, Date_check FROM atable WHERE Status!=:status AND Date<=:date ORDER BY Number DESC";
if (!isset($_SESSION['q_load'])){
    $time_format="%H:%i";
    try{
        $session_query="SELECT Number, Type, Class, State, Phone, Description, Status, Adress, Tarif, otv_mechan,"."TIME_FORMAT(Time,'%H:%i') AS Time".", Date, Date_check FROM atable WHERE Status!=:status AND Date<=:date ORDER BY Number DESC";
        $s=$pdo->prepare($session_query);
        $s->bindValue(':status','Выполнена');
        $s->bindValue(':date',date('Y-m-d'));
        $s->execute();
        $result=$s->fetchAll();
    } catch (Exception $ex) {
        echo $ex;
        exit();    
    }
     foreach($result as $row){
        $descr_title=$row['Description'];
        $number_ticket=$row['Number'];
       echo "<tr><td><a class='a_table_menu' href=edit_ticket.php?id_t=$number_ticket title="."'$descr_title'".">".$row['Number']."</a></td><td>".$row['Type']."</td><td>".$row['Class']."</td><td>".
$row['Phone']."</td><td>".$row['Status']."</td><td>".$row['Adress']."</td><td>".$row['Tarif']."</td><td>".$row['Time']."</td><td>".$row
['otv_mechan']."</td><td><a title='Отправить заявку' class='a_table_menu' href=send_ticket.php?id_tct=".$row['Number'].">".$row['State']."</a></td><td class='td_menu'><a class='a_table_menu' href=delete_record.php?id_r=".$row['Number'].">Удалить</a></td></tr>";
    }
   echo "<center><strong><p style=color:lightsalmon;margin:5px;padding:0px;>Загружены заявки невыполненные по текущий день</p></strong></center>";
}
else {
    $result=mysql_query($_SESSION['q_load']);
    $s=$pdo->prepare($_SESSION['q_load']);
    $s->execute();
    $result=$s->fetchAll();
    foreach($result as $row)
        {
        $descr_title=$row['Description'];
         $number_ticket=$row['Number'];
        echo "<tr><td><a class='a_table_menu' href=edit_ticket.php?id_t=$number_ticket title="."'$descr_title'".">".$row['Number']."</a></td><td>".$row['Type']."</td><td>".$row['Class']."</td><td>".
$row['Phone']."</td><td>".$row['Status']."</td><td>".$row['Adress']."</td><td>".$row['Tarif']."</td><td>".$row['Time']."</td><td>".$row
['otv_mechan']."</td><td><a title='Отправить заявку' class='a_table_menu' href=send_ticket.php?id_tct=".$row['Number'].">".$row['State']."</a></td><td><a class='a_table_menu' href=delete_record.php?id_r=".$row['Number'].">Удалить</a></td></tr>";
        }
     echo "<center><p style='margin:6px; font-size:16px;'><a class='a_table_menu' href='abort_search.php'>Сброс</a>".$_SESSION['txt_query']."</p></center>";
}
?>