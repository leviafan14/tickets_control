<?php
require_once 'check_session.php';
try{
    $result=$pdo->query("SELECT * FROM status_mechan");
    foreach($result as $row)
        $param_status[]=array('id'=>$row['Id'],'status'=>$row['Status'],'state'=>$row['State']);
} 
catch (Exception $ex) {
    echo "Ошибка получения статусов сотрудников";
    exit();
}
try{
    $result_category=$pdo->query("SELECT * FROM category_employee");
    foreach($result_category as $row_category)
        $param_category[]=array('id'=>$row_category['Id'],'value'=>$row_category['Value'],'title'=>$row_category['Title'],'status'=>$row_category['Status']);
}
catch (Exception $ex) {
    echo "Ошибка получения категорий сотрудников";
    exit();
}
?>