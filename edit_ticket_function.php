<?php
/*function select_mechan(){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("SELECT Id_worker,Name FROM Names_workers");
        $s->execute();
        $fio_mechans=$s->fetchAll();
        foreach($fio_mechans as $fio_row){
            echo " <option value=".$fio_row['Id_worker'].">".$fio_row['Name']."</option>";
        }
       return $fio_row;                 
    }
    catch (Exception $ex) {
    echo $ex;
    exit();    
    }
}
 * 
 */
//-----------------------------------------------------------------------------
//Вывод имени под которым пользователь прошёл авторизацию
function username(){
    require_once 'check_session.php';
    $login=$_SESSION['login'];
   /*try{
    require'tickets_connect.php';
    $s=$pdo->prepare("SELECT Id_worker FROM Names_workers WHERE N_doc=:login LIMIT 1");
    $s->bindValue(':login',$_SESSION['login']);
    $s->execute();
    $login_user=$s->fetchAll();
    foreach ($login_user as $user){
        $user['Id_worker'];
    }
}
catch (Exception $ex) {
    echo $ex;
    exit();    
    }
    return $user['Id_worker'];
    * 
    */
    return $login;
}
//-----------------------------------------------------------------------------
//Вывод текущего типа заявки
function display_type($id_type){
    require 'tickets_connect.php';
    try{
    $s=$pdo->prepare("SELECT Id,Type FROM ticket_type WHERE Id=:id_type LIMIT 1");
    $s->bindValue(':id_type',$id_type);
    $s->execute();
    $type_title=$s->fetchAll();
    foreach($type_title as $row){
        echo "<option id='data_id' style='background:#F8F8FF;color:#E6E6FA;' value=".$row['Id'].">".$row['Type']."</option>";
    }
}
catch (Exception $ex) {
    echo "Ошибка получения типа заявки";
    exit();    
    }
}
//-----------------------------------------------------------------------------
//Вывод текущего класса заявки
function display_class($id_class){
    require 'tickets_connect.php';
    try{
    $s=$pdo->prepare("SELECT Id,Class FROM ticket_class WHERE Id=:id_class LIMIT 1");
    $s->bindValue(':id_class',$id_class);
    $s->execute();
    $class_title=$s->fetchAll();
    foreach($class_title as $row){
        echo "<option id='data_id' style='background:#F8F8FF;color:#E6E6FA;' value=".$row['Id'].">".$row['Class']."</option>";
    }
}
catch (Exception $ex) {
    echo "Ошибка получения класса заявки";
    exit();    
    }
}
//-----------------------------------------------------------------------------
//Вывод текущего статуса заявки
function display_status($id_status){
    require 'tickets_connect.php';
    try{
    $s=$pdo->prepare("SELECT Id,Status FROM ticket_status WHERE Id=:id_status LIMIT 1");
    $s->bindValue(':id_status',$id_status);
    $s->execute();
    $status_title=$s->fetchAll();
    foreach($status_title as $row){
        echo "<option id='data_id' style='background:#F8F8FF;color:#E6E6FA;' value=".$row['Id'].">".$row['Status']."</option>";
    }
}
catch (Exception $ex) {
    echo "Ошибка получения статуса заявки";
    exit();    
    }
}
//-----------------------------------------------------------------------------
//Вывод текущего состояния заявки
function display_state($id_state){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("SELECT Id,State FROM ticket_state WHERE Id=:id_state LIMIT 1");
        $s->bindValue(':id_state',$id_state);
        $s->execute();
        foreach($s->fetchAll() as $row){
            echo "<option id='data_id' style='background:#F8F8FF;color:#E6E6FA;' value=".$row['Id'].">".$row['State']."</option>";
        }
    }
    catch (Exception $ex) {
        echo "Ошибка получения состояния заявки";
        exit();    
    }
}
//-----------------------------------------------------------------------------
//Вывод описания текущей заявки
function display_description($id_ticket){
    require 'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT description FROM ticket_description WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){
            if($row['description']==NULL){
                $current_descr='описание отсутствует';
                echo "<input type=text class=form_class name=txt_descr size=100 maxlength=100 placeholder='$current_descr'>";
            }
            else{
                $current_descr=$row['description'];
                echo "<input type=text class=form_class name=txt_descr size=100 maxlength=100 value='$current_descr'>";
            }
        }
    }
    catch (Exception $ex) {
        echo "Ошибка получения описания заявки";
        exit();    
    }
}
//-----------------------------------------------------------------------------
//Вывод времени текущей заявки
function display_time($id_ticket){
    require 'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT date_check,TIME_FORMAT(time,'%H:%i') AS time FROM ticket_date WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){}
    }
    catch (Exception $ex) {
        echo "Ошибка получения времени заявки";
        exit();    
    }
    return $row;
}
//------------------------------------------------------------------------------
//Вывод адреса выполнения заявки
function display_ticket_adress($id_ticket){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT adress FROM ticket_adress WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){}
     }
    catch (PDOException $e) {
        echo "Ошибка получения адреса заявки";
        exit();    
    }
return $row['adress']; 
}
//------------------------------------------------------------------------------
//Вывод телефона абонента
function display_phone($id_ticket){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT phone FROM ticket_phone WHERE id_ticket=:id_ticket LIMIT 1");
        $s->bindValue(":id_ticket",$id_ticket);
        $s->execute();
        foreach($s->fetchAll() as $row){}
    }   
    catch (PDOException $e) {
        echo $e;
        exit();    
    }
    if ($row['phone']==0){
        $phone="<input type='tel' class='form_class' name='num_phone' maxlength='11' size='11'  placeholder='Не указан' pattern='[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}'/>";
    }
    else{
        $phone="<input type='tel' class='form_class' name='num_phone' maxlength='11' size='11' value=".$row['phone']." pattern='[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}'/>";
    }
return $phone; 
}
//-----------------------------------------------------------------------------
//Вывод ФИО сотрудника, который выполнил заявку
function display_employee($id_employee,$id_status_ticket,$id_check_employee){
    if ($id_status_ticket==1 and $id_employee==NULL){
            echo "<option style='background-color:'#F8F8FF';color:#E6E6FA;' value=NULL >Нет</option>";
    }
    else{   
        require 'tickets_connect.php';
        try{
            $s=$pdo->prepare("SELECT Name FROM Names_workers WHERE Id_worker=:id_employee LIMIT 1");
            $s->bindValue(':id_employee',$id_employee);
            $s->execute();
            foreach($s->fetchAll() as $row){
                echo "<option style='background-color:'#F8F8FF';color:#E6E6FA;' value=".$id_check_employee.">".$row['Name']."</option>";
            }
        }
        catch (PDOException $e) {
            echo "Ошибка получения имени сотрудника";    
        }
    }
}
function display_tarif($id_tarif){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("SELECT Id,Price FROM Tarifs WHERE Id=:id_tarif");
        $s->bindValue(':id_tarif',$id_tarif);
        $s->execute();
        foreach($s->fetchAll() as $row){
            if ($row['Price']==0){
                 echo "<option style='background:#F8F8FF;color:#E6E6FA;' value=".$row['Id'].">не указан</option>";
            }
            else{
                echo "<option style='background:#F8F8FF;color:#E6E6FA;' value=".$row['Id'].">".$row['Price']."</option>";
            }
            
        };
    }
    catch (PDOException $e) {
        echo "Ошибка получения тарифа заявки";
        exit();
    }
}

?>