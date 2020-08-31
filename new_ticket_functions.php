<?php
function create_ticket(){
    require 'tickets_connect.php';
    $type=htmlentities($_POST['s_type']);
    $class=htmlentities($_POST['s_class']);
    $state=htmlentities($_POST['s_state']);
    $phone=htmlentities(trim($_POST['n_phone']));
    $descr=htmlentities(trim($_POST['t_descr']));
    $status=trim($_POST['s_status']);
    $adress=htmlentities(trim($_POST['t_adress']));
    $time=htmlentities(trim($_POST['t_time']));
    $tarif=trim($_POST['t_tarif']); 
    $date=htmlentities(trim($_POST['d_date']));
}
//Функция редактирования параметров
function edit_parameters($field,$value,$id){
    require 'tickets_connect.php';
     if($field=='type'){
            $append="UPDATE ticket_type SET Type=:value WHERE Id=:id LIMIT 1";
            $parameter="type";
        }
        if($field=='class'){
            $append="UPDATE ticket_class SET Class=:value WHERE Id=:id LIMIT 1";
            $parameter="class";
        }
        if($field=='status'){
            $append="UPDATE ticket_status SET Status=:value WHERE Id=:id LIMIT 1";
            $parameter="status";
        }
        if($field=='state'){
            $append="UPDATE ticket_state SET State=:value WHERE Id=:id LIMIT 1";
            $parameter="state";
        }
    try{
        $s=$pdo->prepare($append);
        $s->bindValue(':value',$value);
        $s->bindValue(':id',$id);
        $s->execute();
    } 
    catch (Exception $ex) {
        echo "Ошибка редактирования параметров поиска";
        exit();
    }
    header("Location:manage_parameters_t.php?param=$parameter");
    exit();
}
//Функция добавления параметров
function insert_parameters($field,$insert){
    require 'tickets_connect.php';
    if($field=='type'){
        $query="INSERT INTO ticket_type(Type) VALUES (:value)"; 
        $parameter="type";
    }
    if($field=='class'){
        $query="INSERT INTO ticket_class(Class) VALUES (:value)";
        $parameter="class";
    }
    if($field=='status'){
        $query="INSERT INTO ticket_status(Status) VALUES (:value)";
        $parameter="status";
    }
    if($field=='state'){
        $query="INSERT INTO ticket_state(State) VALUES (:value)";
        $parameter='state';
    }
    try{
        $s=$pdo->prepare($query);
        $s->bindValue(':value',$insert);
        $s->execute();
    }
    catch (Exception $ex) {
        echo"Ошибка добавления параметров поиска";
        exit();
    }
    header("Location:manage_parameters_t.php?param=$parameter");
    exit();
}
//Функция добавления параметров для поиска через ввод данных
function insert_other_param($parameter,$alias){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("INSERT INTO ticket_search_param(Value,Name) VALUES (:parameter,:alias)");
        $s->bindValue(':parameter',$parameter);
        $s->bindValue(':alias',$alias);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "Ошибка добавления параметров поиска";
        exit();
    }
    header("Location:search_param.php");
    exit();
}
//Функция редактирования параметров для поиска через ввод данных
function edit_other_param($parameter,$alias,$id){
    require'tickets_connect.php';
    try{    
        $s=$pdo->prepare("UPDATE ticket_search_param SET Value=:parameter,Name=:alias WHERE Id=:id LIMIT 1");
        $s->bindValue(':parameter',$parameter);
        $s->bindValue(':alias',$alias);
        $s->bindValue(':id',$id);
        $s->execute();
    }
    catch (Exception $ex) {
        echo "Ошибка получения параметров поиска";
        exit();
    }
    header("Location:search_param.php");
    exit();
}
//Функция получения типов заявок
function load_type(){
    require_once 'tickets_connect.php';
    global $title;
    global $alias;
    global $p_id;
    global $p_type;
    global $param;
    $alias='type';
    $title='Тип';
    try{
        $result=$pdo->query("SELECT * FROM ticket_type");
        foreach($result as $row){
            $param[]=array('type'=>$row['Type'],'id'=>$row['Id']);
        }
    }
    catch (PDOException $ex) {
        echo "Ошибка получения типов";
        exit();
    }
}
//Функция получения классов заявок
function load_class(){
    require_once 'tickets_connect.php';
    global $title;
    global $alias;
    global $param;
    $alias='class';
    $title='Класс';
    try{
        $result=$pdo->query("SELECT * FROM ticket_class");
        foreach($result as $row)
            $param[]=array('class'=>$row['Class'],'id'=>$row['Id']);
    }
    catch (PDOException $ex) {
        echo "Ошибка получения классов(видов)";
        exit();
    }
}
//Функция получения статусов заявок
function load_status(){
    require_once 'tickets_connect.php';
    global $title;
    global $alias;
    global $param;
    $alias='status';
    $title='Статус';
    try{
        $result=$pdo->query("SELECT * FROM ticket_status");
        foreach($result as $row)
            $param[]=array('status'=>$row['Status'],'id'=>$row['Id'],'status'=>$row['Status'],'priority'=>$row['Priority']);
    }
    catch (PDOException $ex) {
        echo "Ошибка получения статусов";
        exit();
    }
}
//Функция получения состояний заявок
function load_state(){
    require_once 'tickets_connect.php';
    global $title;
    global $alias;
    global $param;
    $alias='state';
    $title='Состояние';
    try{
        $result=$pdo->query("SELECT * FROM ticket_state");
        foreach($result as $row)
            $param[]=array('state'=>$row['State'],'id'=>$row['Id'],'priority'=>$row['Priority']);
    }
    catch (PDOException $ex) {
        echo "Ошибка получения состояний";
        exit();
    }
}
//Функция получения параметров поиска через ввод данных
function load_search(){
    require_once 'tickets_connect.php';
    try{
        $result=$pdo->query("SELECT * FROM ticket_search_param");
        foreach($result as $row)
            $param_search[]=array('id'=>$row['Id'],'value'=>$row['Value'],'name'=>$row['Name']);
    } 
    catch (Exception $ex) {
        echo "Ошибка получения параметров поиска";
        exit();
    }
}
//Функция для отображения параметров
function control($p){
    if(isset($p)){    
        if($p=="type"){
            load_type();
        }
        if($p=='class'){
            load_class();
        }
        if($p=='status'){
            load_status();
        }
        if($p=='state'){
            load_state();
        }
        if($p=='other'){
            load_other();
        }  
    }
    else{
        echo"отсутсвует параметр";
        exit();
    }
}