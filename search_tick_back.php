<?php
require_once 'check_session.php';
require_once 'tickets_title_name.php';
require_once 'tickets_connect.php';
$type_tick=trim($_POST['sct_type_filt']);;
$class_tick=trim($_POST['sct_class_filt']);
$state_tick=trim($_POST['sct_state_filt']);
$status_tick=trim($_POST['sct_status_filt']);
$date_check=($_POST['check_date']);
$date1=trim($_POST['dte_date1']);
$date2=trim($_POST['dte_date2']);
$search_tick=trim($_POST['sct_search_tick']);
$tarif_tick=trim($_POST['sct_tick']);
$srh_param=htmlentities(trim($_POST['txt_srh']));
    if ($type_tick<>0) $t_zav="Type=$type_tick AND";
        else {$t_zav="Type"."!"."="."0"." AND";}
    if ($class_tick<>0) $c_zav="Class=$class_tick AND";
        else {$c_zav="Class"."!"."="."0"." AND";}
    if ($state_tick<>0) $state_zav="State=$state_tick AND";
        else {$state_zav="State"."!"."="."0"." AND";}
    if ($status_tick<>0) $status_zav="Status=$status_tick AND";
        else {$status_zav="Status"."!"."="."0"." AND";}
    if ($tarif_tick!='Все'){$tarif="Tarif=$tarif_tick";}
        else{$tarif="Tarif!=0";}
    if ($search_tick!='-'){
        if($search_tick=='Adress'){
            try{
                $param="%$srh_param%";
                $s=$pdo->prepare("SELECT id_ticket FROM ticket_adress WHERE adress LIKE '$srh_param%'");
                $s->execute();
                $i=0;
                foreach($s->fetchAll() as $result_adress){
                   $search_txt[$i]=$result_adress['id_ticket'];
                    $i++;
                }   
            }
            catch(PDOException $e){
                echo "Ошибка подключения к таблице с адресами";
                exit();
            }
        }
        if($search_tick=='Phone'){
            try{
                $s=$pdo->prepare("SELECT id_ticket FROM ticket_phone WHERE phone LIKE '$srh_param%'");
                $s->execute();
                $i=0;
                foreach($s->fetchAll() as $result_phone){
                   $search_txt[$i]=$result_phone['id_ticket'];
                    $i++;
                }
            }
            catch(PDOException $e){
                echo "Ошибка подключения к таблице с телефонными номерами";
                exit();
            }
        }
        if($search_tick=='Description'){
            try{
                $s=$pdo->prepare("SELECT id_ticket FROM ticket_description WHERE description LIKE '$srh_param%'");
                $s->execute();
                $i=0;
                foreach($s->fetchAll() as $result_description){
                   $search_txt[$i]=$result_description['id_ticket'];
                    $i++;
                }
            }
            catch(PDOException $e){
                echo "Ошибка подключения к таблице с описаниями заявок";
                exit();
            }
        }
        if($search_tick=='Number'){
            try{
                $s=$pdo->prepare("SELECT Number FROM atable WHERE Number LIKE '$srh_param%'");
                $s->execute();
                $i=0;
                foreach($s->fetchAll() as $result_number){
                   $search_txt[$i]=$result_number['Number'];
                    $i++;
                }
            }
            catch(PDOException $e){
                echo "Ошибка подключения к таблице с заявками";
                exit();
            }
        }
        $search_array=implode(",",$search_txt);
         if($date_check=='yes'){
            $_SESSION['q_load']=("SELECT Number,Type,Class,State,Status,Tarif,otv_mechan,Date FROM atable WHERE $t_zav $c_zav $state_zav $status_zav $tarif AND Date BETWEEN '$date1' AND '$date2' AND Number IN ($search_array)");
            $_SESSION['txt_query']="$title_search:<strong style=color:#32CD32>$srh_param</strong>";
         }
        else{
            $_SESSION['q_load']=("SELECT Number,Type,Class,State,Status,Tarif,otv_mechan,Date FROM atable WHERE Number IN ($search_array) AND $t_zav $c_zav $state_zav $status_zav $tarif AND Date!='0000-00-00'");
            $_SESSION['txt_query']="$title_search:<strong style=color:#32CD32>$srh_param</strong>";
        }
        header("Location:all_tickets.php");
        exit();
    }
    else{
    if ($type_tick<>0) $t_zav="Type=$type_tick AND";
        else {$t_zav="Type"."!"."="."0"." AND";}
    if ($class_tick<>0) $c_zav="Class=$class_tick AND";
        else {$c_zav="Class"."!"."="."0"." AND";}
    if ($state_tick<>0) $state_zav="State=$state_tick AND";
        else {$state_zav="State"."!"."="."0"." AND";}
    if ($status_tick<>0) $status_zav="Status=$status_tick AND";
        else {$status_zav="Status"."!"."="."0"." AND";}
     if ($tarif_tick<>'Все') $tarif="Tarif=$tarif_tick";
     else{$tarif="Tarif!=0";}
    if($date_check=='yes'){
        $_SESSION['q_load']=("SELECT Number,Type,Class,State,Status,Tarif,otv_mechan,Date FROM atable WHERE $t_zav $c_zav $state_zav $status_zav $tarif AND Date BETWEEN '$date1' AND '$date2'");
        $_SESSION['txt_query']="$title_search:<strong style=color:#32CD32>$srh_param</strong>";
        }
    else{
        $_SESSION['q_load']=("SELECT Number,Type,Class,State,Status,Tarif,otv_mechan,Date FROM atable WHERE $t_zav $c_zav $state_zav $status_zav $tarif AND Date!='0000-00-00'");
        $_SESSION['txt_query']="$title_search:<strong style=color:#32CD32>$srh_param</strong>";
        }    
}
header("location:all_tickets.php");
exit();
?>