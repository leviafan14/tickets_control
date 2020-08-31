<?php
//Удаление сотрудника происходит путём удаления информации о сотруднике
//из разных таблиц по номеру документа (N_doc)
require_once 'tickets_connect.php';
$num_mech=htmlspecialchars($_GET['id_m']);
//Выборка номера документа сотрудника из таблицы t_mechan
try{
    $s=$pdo->prepare("SELECT N_doc FROM t_mechan WHERE Number=:num_mech LIMIT 1");
    $s->bindValue(':num_mech',$num_mech);
    $s->execute();
    foreach($s->fetchAll() as $n_doc_mechan){
        $n_doc=$n_doc_mechan['N_doc'];
    }
} 
catch (Exception $ex) {
    echo "Ошибка запроса номера документа сотрудника";
    exit();    
    }  
//Удаление логина и пароля сотрудника из таблицы mlogns
try{
    $s=$pdo->prepare("DELETE FROM mlogns WHERE Login=:n_doc LIMIT 1");
    $s->bindValue(':n_doc',$n_doc);
    $s->execute();
} 
catch (Exception $ex) {
    echo "Ошибка удаления логина и пароля";
    exit();
}
//Удаление имени сотрудника из таблицы Names_workers
try{
    $s=$pdo->prepare("DELETE FROM Names_workers WHERE Id_worker=:n_doc LIMIT 1");
    $s->bindValue(':n_doc',$n_doc);
    $s->execute();
} 
catch (Exception $ex) {
    echo "Ошибка удаления имени сотрудника";
    exit();
}
//Удаление телефона сотрудника из таблицы Phones_workers
try{
    $s=$pdo->prepare("DELETE FROM Phones_workers WHERE Id_worker=:n_doc LIMIT 1");
    $s->bindValue(':n_doc',$n_doc);
    $s->execute();
} 
catch (Exception $ex) {
    echo "Ошибка удаления теелефона сотрудника";
    exit();
}
//Удаление записи о сотруднике из таблицы t_mechan
try{
    $s=$pdo->prepare("DELETE FROM t_mechan WHERE Number=:num_mech LIMIT 1");
    $s->bindValue(':num_mech',$num_mech);
    $s->execute();
}
catch (Exception $ex) {
    echo "Ошибка удаления информации о сотруднике";
    exit();    
    }
header("location:all_mechan.php");
exit();
?>