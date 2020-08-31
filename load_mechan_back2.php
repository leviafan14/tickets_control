<?php
require_once 'check_session.php';
//require_once 'tickets_connect.php';
if (!isset($_SESSION['q_mech'])){
    try{
        $s=$pdo->prepare("SELECT * FROM t_mechan");
        $s->execute();
        foreach($s->fetchAll() as $row_mech)
            { 
                echo "<tr class='t1_tr'>"."<td><a class='a_table_menu' href=edit_mechan.php?id_m=".$row_mech['Number'].">".$row_mech['Number']."</a></td>"."<td>".$row_mech['FIOmech']."</td>"."<td>".$row_mech['Phone']."</td>"."<td>".$row_mech['Status']."</td>"."<td>".$row_mech['N_doc']."</td>"."<td>".$row_mech['Category']."</td>"."<td><a class='a_table_menu' href=delete_mech.php?id_m=".$row_mech['Number'].">"." Удалить</a></td></tr>";
            }   
        $kol_rows=$s->rowCount();
    }
    catch (Exception $ex) {
        echo "Ошибка получения информации о сотрудниках";
        exit();    
    }
}    
else {
    try{
        $q_mech=$_SESSION['q_mech'];
        $s=$pdo->prepare($q_mech);
        $s->execute();
        foreach($s->fetchAll() as $row_mech)
            {
                echo "<tr class='t1_tr'>"."<td>".$row_mech['Number']."</td>"."<td>".$row_mech['FIOmech']."</td>"."<td>".$row_mech['Phone']."</td>"."<td>".$row_mech['Status']."</td>"."<td>".$row_mech['N_doc']."</td>"."<td><a class='a_table_menu' href=edit_mechan.php?id_m=".$row_mech['Number'].">"."Изменить </a>"."<a class='a_table_menu' href=delete_mech.php?id_m=".$row_mech['Number'].">"." Удалить</a></td></tr>";
            }
        echo "<a href='abort_search_m.php'>Сброс</a>";   
        $kol_rows=$s->rowCount();
    }
    catch (Exception $ex) {
        echo "Ошибка получения информации о сотрудниках";
        exit();    
    }
}    
?>