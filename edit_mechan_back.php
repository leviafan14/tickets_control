<?php
require_once 'tickets_connect.php';
require_once 'new_mechan_select.php';
require_once 'load_mechan_functions.php';
$id_mech=$_GET['id_m'];
if(isset($id_mech) and !empty($id_mech)){
try{
    $s=$pdo->prepare("SELECT Number,N_doc,Status,Category FROM t_mechan WHERE Number=:id_mech LIMIT 1");
    $s->bindValue(':id_mech',$id_mech);
    $s->execute();       
    foreach($s->fetchAll() as $r_mech){   
        $numb_m=$r_mech['Number'];
        $status_m=$r_mech['Status'];
        $doc_m=$r_mech['N_doc'];
        $category=$r_mech['Category'];
    }
}
catch (Exception $ex) {
    echo "Не удалось получить информацию о сотрудниках";
    exit();    
    } 
try{                    
    $s=$pdo->prepare("SELECT paswrd FROM mlogns WHERE Login=:doc_m LIMIT 1");
    $s->bindValue(":doc_m",$doc_m);
    $s->execute();
    foreach($s->fetchAll() as $pswr_mech){
        $pswrd_m=$pswr_mech['paswrd'];
    }
}
catch (Exception $ex) {
    echo "Не удалось получить доступ к таблице";
    exit();    
}
    $result_check_category=check_category($category);  
    $result_load_status=load_status($status_m);
}
else{
    echo "Ошибка передачи параметра";
    exit();
}
?>