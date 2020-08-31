<?php
    require_once 'tickets_connect.php';
    require_once 'load_tickets_functions.php';
    session_start();
    if (!isset($_SESSION['q_load'])){
        $s=$pdo->query("SELECT Number,Type,Class,Tarif FROM atable WHERE Status='Не выполнена' AND Date<=CURDATE()");
        foreach($s->fetchAll() as $row)
            { 
                echo "<tr><td>".$row['Number']."</td><td>".$row['Type']."</td><td>".$row['Class']."</td><td>".$row['Tarif']."</td></tr>";
            }
    }
    else{      
        $q_load=$_SESSION['q_load'];
        $s=$pdo->prepare($q_load);
        $s->execute();
        $res_q=$s->fetchAll();
        foreach($res_q as $row){
            echo "<tr><td>".$row['Number']."</td><td>".$row['Type']."</td><td>".$row['Class']."</td><td>".$row['Description']."</td><td>".$row['Adress']."</td><td>".$row['Tarif']."</td><td>".$row['Time']."</td></tr>";
        }
        $kol_print=$s->rowCount();   
    }
    echo "<p> Дата печати: ".date('Y-m-d')." Количество заявок: ".$kol_print=$s->rowCount()."</p>";
?>