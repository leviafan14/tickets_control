<?php
require_once 'tickets_connect.php';
$a_id=$_GET['a_id'];// Имя ссылки которая передаёт Id поля через GET
$type_link=$_GET['type_link']; // передаёт тип поля в ссылке
$trigger=$_GET['trigger']; // Указывает, что поле необходимо очистить
$id=htmlentities(trim($_POST['id'])); // Передаёт Id поля через POST
$value=htmlentities(trim($_POST['value'])); // Значение поля
$field=$_POST['field']; // Имя поля
$new=$_POST['new']; //Указывает, что создаётся новая запись
$insert=htmlentities(trim($_POST['insert']));// текст новой записи
$insert_title=htmlentities(trim($_POST['insert_title']));// описание новой записи
$dbfieldname=htmlentities(trim($_POST['insert_field']));//Название поля в таблице
$type=$_POST['type'];// Определяет, в какой таблице редактировать запись
$title=htmlentities(trim($_POST['title'])); //Описание категории
$category_edit=htmlentities(trim($_POST['category_status']));
$category_delete=$_GET['category'];
////////////////////////////////////////////////////////////////////////////////
//Изменить статус
if (isset($type)){
    if($type=='Status'){
        try{
            $s=$pdo->prepare("UPDATE status_mechan SET Status=:value WHERE Id=:id");
            $s->bindValue(':value',$value);
            $s->bindValue(':id',$id);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка обновления статуса сотрудника";
            exit();
        }
    header("Location:manage_param_mechan.php?parameter=status");
    exit();    
    }
    else{}
    //Изменить категорию
    if($type=='Category'){
        if($category_delete=='Default'){
            header("Location:help_for_categories.php?w=yes");
            exit();
        }
        else{}
        if($category_edit=='Default'){
            try{
                $s=$pdo->prepare("UPDATE category_employee SET Title=:title WHERE Id=:id");
                $s->bindValue(':title',$title);
                $s->bindValue(':id',$id);
                $s->execute();
            }
            catch (Exception $ex) {
                echo"Ошибка категории сотрудника";
                exit();
            }   
    }
    else{}
    if($category_edit!='Default'){
        try{
            $s=$pdo->prepare("UPDATE category_employee SET Value=:value, Title=:title WHERE Id=:id");
            $s->bindValue(':value',$value);
            $s->bindValue(':title',$title);
            $s->bindValue(':id',$id);
            $s->execute();
            }
            catch (Exception $ex) {
                echo"Ошибка категории сотрудника";
                exit();
            } 
    }
    header("Location:manage_param_mechan.php?parameter=category");
    exit();
    }   
    //Изменить параметр
    if($type=='Other'){
        try{
            $s=$pdo->prepare("UPDATE mechan_search_parameters SET Parameter=:value, Search_field=:field WHERE Id=:id");
            $s->bindValue(':value',$value);
            $s->bindValue(':field',$field);
            $s->bindValue(':id',$id);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка изменения параметров поиска сотрудников";
            exit();
        }
     header("Location:manage_param_mechan.php?parameter=search");
     exit();
    }    
}   
if ($new=='true'){// проверка параметра, который отвечает за создание новой записи
    //добавить статус
    if($field=='Status'){
        try{
            $s=$pdo->prepare("INSERT INTO status_mechan(Status) VALUES (:value)");
            $s->bindValue(':value',$insert);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка добавления нового статуса сотрудников";
            exit();
        }
    header("Location:manage_param_mechan.php?parameter=status");
    exit();    
    }
    //добавить категорию
    if($field=='Category'){
        try{
            $s=$pdo->prepare("INSERT INTO category_employee(Value,Title) VALUES (:value,:title)");
            $s->bindValue(':value',$insert);
            $s->bindValue(':title',$insert_title);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка добавления категории сотрудников";
            exit();
        }
    header("Location:manage_param_mechan.php?parameter=category");
    exit();
    }
    if($field=='Parameter'){
        try{
            $s=$pdo->prepare("INSERT INTO mechan_search_parameters(Parameter, Search_field) VALUES (:parameter,:field)");
            $s->bindValue(':parameter',$insert);
            $s->bindValue(':field',$dbfieldname);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка добавления параметров поиска сотрудников";
            exit();
        }
        header("Location:manage_param_mechan.php?parameter=search");
        exit();
    }
}
if($trigger=='delete'){
    if($type_link=='Other'){
        try{
            $s=$pdo->prepare("DELETE FROM mechan_search_parameters WHERE Id=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка удаления параметра поиска сотрудников";
            exit();
        }
        header("Location:manage_param_mechan.php?parameter=search");
        exit();
    }
    if($type_link=='Status'){
        try{
            $s=$pdo->prepare("DELETE FROM status_mechan WHERE Id=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка удаления статуса сотрудников";
            exit();
        }
    header("Location:manage_param_mechan.php?parameter=status");
    exit();    
    }
    if($type_link=='Category'){
        if($category_delete=='Default'){
            header("Location:help_for_categories.php?w=yes");
            exit();
        }
        else{
        try{
            $s=$pdo->prepare("DELETE FROM category_employee WHERE Id=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch (Exception $ex) {
            echo"Ошибка удаления категории сотрудника";
            exit();
        }
    header("Location:manage_param_mechan.php?parameter=category"); 
    exit();
    }
    }
}