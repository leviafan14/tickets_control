<?php
require_once 'tickets_connect.php';
require_once 'new_ticket_functions.php';
$a_id=$_GET['a_id'];// Имя ссылки которая передаёт Id поля через GET
$type_link=$_GET['type_link']; // передаёт тип поля в ссылке
$trigger=$_GET['trigger']; // Указывает, что поле необходимо очистить
$id=$_POST['id']; // Передаёт Id поля через POST
$value=htmlentities(trim($_POST['value'])); // Значение поля
$field=$_POST['field']; // Имя поля
$new=$_POST['new']; //Указывает, что создаётся новая запись
$insert=htmlentities(trim($_POST['insert']));// текст новой записи
$operation=$_POST['operation'];
$alias=$_POST['alias']; 
$parameter=$_POST['parameter'];
$tarif=$_POST['tarif'];
////////////////////////////////////////////////////////////////////////////////
if(isset($field) && $field!='Other' && $operation=='edit_parameter'){
    edit_parameters($field,$value,$id);
}
if(isset($field) && $field=='Other' && $operation=='edit_parameter'){
    edit_other_param($parameter,$alias,$id);   
}
if (isset($field) && isset($tarif) && $field=='tarif'){
    edit_tarif($alias,$parameter,$id);   
}
////////////////////////////////////////////////////////////////////////////////
if($new=='true' && $field=='tarif'){
    insert_tarif($alias,$parameter);  
}
if($new=='true' && $field!='Other'){
    insert_parameters($field,$insert);
}
if($new=='true' && $field=='Other'){
    insert_other_param($parameter,$alias);  
}
//Удаление параметров
if($trigger=='delete'){
    if(isset($type_link) and $type_link=='type'){
        try{
            //Удаление типа заяовк
            $s=$pdo->prepare("DELETE FROM ticket_type WHERE Id=:id LIMIT 1");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo "Ошибка удаления типа заявок $a_id";
            exit();
        }
        try{
            //Удаление всех заявок выбранного типа
            $s=$pdo->prepare("DELETE FROM atable WHERE Type=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo "Ошибка удаления заявок имеющих выбранный тип  $a_id";
            exit();
        }
    header("Location:manage_parameters_t.php?param=type");
    exit();
}
//Удаление вида(класса) и всех имеющих выбранный вид заявок  
    if(isset($type_link) and $type_link=='class'){
        try{
            $s=$pdo->prepare("DELETE FROM ticket_class WHERE Id=:id LIMIT 1");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка при удалении вида(класса)заявок';
            exit();
        }
        try{
//Удаление всех заявок имеющих удаляемый класс(вид)
            $s=$pdo->prepare("DELETE FROM atable WHERE Class=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo "Ошибка при удалении заявок класса $a_id";
            exit();
        }
    header("Location:manage_parameters_t.php?param=class");
    exit();
    }
 //Удаление статуса и всех заявок имеющих выбранный статус
    if(isset($type_link) and $type_link=='status'){
        try{
 //Удаление выбранного статуса       
            $s=$pdo->prepare("DELETE FROM ticket_status WHERE Id=:id LIMIT 1");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo 'Ошибка при удалении статуса';
            exit();
        }
        try{
//Удаление всех заявок имеющих удаляемый статус
            $s=$pdo->prepare("DELETE FROM atable WHERE Status=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo "Ошибка при удалении заявок со статусом $a_id";
            exit();
        }
    header("Location:manage_parameters_t.php?param=status");
    exit();
}    
 //Удаление выбранного статуса и всех заявок в выбранном состоянии 
    if(isset($type_link) and $type_link=='state'){
        try{
// Удаление состояния заявок            
            $s=$pdo->prepare("DELETE FROM ticket_state WHERE Id=:id LIMIT 1");
            $s->bindValue(':id',$a_id);
            $s->execute();
        }
        catch(PDOException $e){
            echo "Ошибка при удалении состояния заявок $a_id";
            exit();
        }
//Удаление заявок в выбранном состоянии        
        try{
            $s=$pdo->prepare("DELETE FROM atable WHERE State=:id");
            $s->bindValue(':id',$a_id);
            $s->execute();
        } 
        catch (PDOException $e) {
            echo "Ошибка при удалении заявок в выбранном состоянии $a_id";
            exit();
        }
    header("Location:manage_parameters_t.php?param=state");
    exit();
    }
//Удаление параметров для поиска по вводу текста    
if(isset($type_link) and $type_link=='other'){
    try{
        $s=$pdo->prepare("DELETE FROM ticket_search_param WHERE Id=:id LIMIT 1");
        $s->bindValue(':id',$a_id);
        $s->execute();
    }
    catch (PDOException $e) {
        echo "Ошибка при удалении параметра поиска $a_id";
        exit();
    }
    header("Location:search_param.php");
    exit();
}
}
?>