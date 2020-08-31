<?php
require_once 'tickets_connect.php';
//Функция загрузки сотрудников
function load_mechan(){
    require_once 'tickets_connect.php';
    global $pdo;
    global $s;
    //Проверка, есть ли сессия с результатами поиска
    if (!isset($_SESSION['q_mech'])){   
    try{
    //Если нет сессии, то выполняется запрос к таблице t_mechan с запросом
        // всех данных
        $s=$pdo->prepare("SELECT Number,Status,N_doc,Category FROM t_mechan");
        $s->execute();
        $q_mech=$s->fetchAll();
    }
    catch (Exception $ex) {
        echo "Не удалось получить информацию о сотрудниках";
        exit();    
    }
} 
//Если есть сессия с поиском, то запрос берётся из куки сессии
else {
    try{
        $s=$q_mech=$pdo->query($_SESSION['q_mech']);
    }
    catch (Exception $ex) {
        echo "Не удалось получить информацию о сотрудниках";  
    }
}
// Отображение данных в виде таблицы
foreach($q_mech as $row_mech){
        echo"<tr class='t1_tr'>"."<td><a class='table_menu' title='Редактировать' href=edit_mechan.php?id_m=".$row_mech['Number'].">".$row_mech['Number']."</a></td><td>".display_name($row_mech['N_doc'])."</td><td>".display_phone($row_mech['N_doc'])."</td><td>".display_status($row_mech['Status'])."</td><td>".$row_mech['N_doc']."</td><td>".display_category($row_mech['Category'])."</td><td><a class='table_menu' title='Удалить' href=delete_mech.php?id_m=".$row_mech['Number'].">"."<span class='delete_button'>&nbsp;×&nbsp;</span></a></a></td></tr>";
    }   
$kol_rows=$s->rowCount();// Подсчёт записей выведенных на экран
}
//------------------------------------------------------------------------------
//Функция подсчёта записей
function kolrows($row){
    echo"<p id='p_kol_rows'><span id='s_kol_rows'>Записей: ".$row->rowCount()."</span>";
    if(isset($_SESSION['q_mech'])){ // Выводит на экран текст запроса в понятном для пользователя виде
        echo "<span style='margin:6px; font-size:16px;'><a class='a_table_menu' href='abort_search_m.php'>Сброс</a>".$_SESSION['txt_query_mechan']."</span>";
    }
    else{}
    if(!isset($_SESSION['q_mech'])){ // Выводит на экран сообщение (следующая строка)
      echo "<strong><span id='s_unchecked_tickets'>Отображены все сотрудники</span></strong>";  
    }
    echo"</p>";
}
//------------------------------------------------------------------------------
//Функция выборки категории сотрудника
function check_category($category){
    require'tickets_connect.php';
    try{                    
    $s=$pdo->prepare("SELECT * FROM category_employee WHERE Id=:id_cat LIMIT 1");
    $s->bindValue(":id_cat",$category);
    $s->execute();
    foreach($s->fetchAll() as $cat){
        $p_category[]=array('id'=>$cat['Id'],'value'=>$cat['Value'],'title'=>$cat['Title']);
}
     }
catch (Exception $ex) {
        echo "Не удалось получить категорию сотрудника";
        exit();    
    }
return $p_category;
}
//------------------------------------------------------------------------------
//Функция вывода категории сотрудника на экран
function display_category($category){
    foreach(check_category($category) as $title){}
    return $title['title'];
}
//------------------------------------------------------------------------------
//Функция выборки статуса сотрудника
function load_status($status){
    require'tickets_connect.php';
    try{                    
        $s=$pdo->prepare("SELECT * FROM status_mechan WHERE Id=:id_status LIMIT 1");
        $s->bindValue(":id_status",$status);
        $s->execute();
        foreach($s->fetchAll() as $row){
            $array_status[]=array('id'=>$row['Id'],'status'=>$row['Status']);
        }
    }
    catch (Exception $ex) {
        echo "Не удалось получить статус сотрудника $ex";
        exit();    
    }
    return $array_status;
}
//------------------------------------------------------------------------------
//Функция вывода статуса сотрдуника на экран
function display_status($status){
    $load_status_function=load_status($status);
    foreach($load_status_function as $status_title){}
    return $status_title['status'];
}
//------------------------------------------------------------------------------
//Функция выборки номера телефона сотрудника
function check_phone($phone){
    require'tickets_connect.php';
    try{                    
    $s=$pdo->prepare("SELECT Phone_worker FROM Phones_workers WHERE Id_worker=:phone_id LIMIT 1");
    $s->bindValue(":phone_id",$phone);
    $s->execute();
    $phone=$s->fetchAll();
    foreach($phone as $row){
        $phone_worker[]=array('phone'=>$row['Phone_worker']);
}
     }
catch (Exception $ex) {
        echo "Не удалось получить телефон сотрудника";
        exit();    
    }
return $phone_worker;
}
//------------------------------------------------------------------------------
//Функция вывода номера телефона сотрудника на экран
function display_phone($phone){
    $load_phone_function=check_phone($phone);
    foreach($load_phone_function as $phone_number){}
    return $phone_number['phone'];
}
//------------------------------------------------------------------------------
//Функция выборки Ф.И.О. сотрудника
function check_name($name_id){
    require'tickets_connect.php';
    try{                    
    $s=$pdo->prepare("SELECT Name FROM Names_workers WHERE Id_worker=:name_id LIMIT 1");
    $s->bindValue(":name_id",$name_id);
    $s->execute();
    $result=$s->fetchAll();
    foreach($result as $row){
        $name[]=array('id'=>$row['Id'],'name'=>$row['Name']);
}
     }
catch (Exception $ex) {
        echo "Не удалось получить Ф.И.О. сотрудника";
        exit();    
    }
return $name; 
}
//------------------------------------------------------------------------------
//Функция вывода Ф.И.О. сотрудника на экран
function display_name($name_id){
    $load_name_function=check_name($name_id);
    foreach($load_name_function as $name_worker){
    }
    return $name_worker['name'];
}
//-----------------------------------------------------------------------------
//Функция поиска сотрудника по вводу в строку поиска
function search_txt_field_mehcan($status,$category,$field_param,$search_param){
    require'tickets_connect.php';
if ($status==0) {$status_searh="Status!=0";}
    else $status_searh="Status=$status";
    if ($category==0) {$category_searh="Category!=0";}
        else $category_searh="Category=$category";
if(isset($field_param) and isset($search_param)){    
    if($field_param=='Number'){
        $number_worker=("SELECT Number,N_doc,Status,Category FROM t_mechan WHERE $status_searh AND $category_searh AND Number LIKE '%$search_param%'");
        return $number_worker;
    }
    else {}
    if($field_param=='FIOmech'){
        try{
            $s=$pdo->prepare("SELECT Id_worker FROM Names_workers WHERE Name LIKE '$search_param%'");
            $s->execute();
            $i=0;
            $result=$s->fetchAll();
            foreach($result as $row){
                $search[$i]=$row['Id_worker'];
                $i++;
                echo $search[$i]."</br>";
            } 
        }
        catch (Exception $ex) {
            echo 'Ошибка поиска имени сотрудника </br>';
            exit();    
        }
            $search_array = implode(",", $search);
            $name_worker="SELECT Number,N_doc,Status,Category FROM t_mechan WHERE $status_searh AND $category_searh AND N_doc IN ($search_array)";
            return $name_worker;
    }
    else {}
    if($field_param=='Phone'){
        try{
            $s=$pdo->prepare("SELECT Id_worker FROM Phones_workers WHERE Phone_worker LIKE '$search_param%'");
            $s->execute();
            $i=0;
            $result=$s->fetchAll();
            foreach($result as $row){
                $search[$i]=$row['Id_worker'];
                $i++;
                //$search[$i];
            } 
        }
        catch (Exception $ex) {
            echo 'Ошибка поиска телефона сотрудника ';
            exit();    
        }
        $search_array = implode(",", $search);
        $phone_worker="SELECT Number,N_doc,Status,Category FROM t_mechan WHERE $status_searh AND $category_searh AND N_doc IN ($search_array)";
    return $phone_worker;
    }
    else {}
    if($field_param=='N_doc'){
        try{
            $s=$pdo->prepare("SELECT Login FROM mlogns WHERE Login LIKE '$search_param%'");
            $s->execute();
            $i=0;
            $result=$s->fetchAll();
            foreach($result as $row){
                $search[$i]=$row['Login'];
                $i++;
            }
        }
        catch (Exception $ex) {
            echo 'Ошибка поиска номера телефона сотрудника ';
            exit();    
        }
        $search_array = implode(",", $search);
        $login_worker="SELECT Number,N_doc,Status,Category FROM t_mechan WHERE $status_searh AND $category_searh AND N_doc IN ($search_array)";
    return $login_worker;
    }
    else {
        echo "Указан неверный параметр поиска";
        exit();
    }
}    
}
//-----------------------------------------------------------------------------
//Функции использующися на странице restore.php - станица для восстановления
//Функция загрузки сотрудников для восстановления данных
function load_mechan_restore(){
require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("SELECT Number,Status,N_doc,Category FROM t_mechan");
        $s->execute();
        
    }
    catch (Exception $ex) {
        echo "Не удалось получить информацию о сотрудниках";
        exit();    
    }
    // Отображение данных в виде таблицы
    foreach($s->fetchAll() as $row_mech){
        echo "<form name='f_restore_worker' method='POST' action='restore.php'>"
            ."<input type='hidden' name='id_worker' value=".$row_mech['Number'].">".
            "<tr class='t1_tr'><td>".$row_mech['Number']."</td>".
            "<td>".restore_name_worker($row_mech['N_doc'])."</td>".
            "<td>".restore_phone_worker($row_mech['N_doc'])."</td>";
            restore_status_worker($row_mech['Status']);
            echo"<td>".restore_login_worker($row_mech['N_doc'])."</td>".
                "<td><input type='password' class='form-control'name='pass_worker' placeholder='новый пароль'></td>";
            restore_category_worker($row_mech['Category']);
        echo "<td><input type='submit' class='btn btn-outline-primary' value='применить'></td></tr></form>";
        
    }   
    $kol_rows=$s->rowCount();// Подсчёт записей выведенных на экран
}
function restore_name_worker($name_id){
    $name="<input type='text' class='form-control' required name='name_worker' value='".display_name($name_id)."'".">";
    return $name;
}
function restore_phone_worker($phone){
    $name="<input type='text' class='form-control' required name='phone_worker' value='".display_phone($phone)."'".">";
    return $name;
}
//Восстановление логина (номер документа) пользователя
function restore_login_worker($login){
    $name="<input type='text' class='form-control' required name='login_worker' size=4 value='".$login."'".">";
    return $name;
}
//Восстановление категории сотрудника
function restore_category_worker($id_category){
    require 'connect_mechan.php';
    echo "<td><select name='categories' class='form-control'>";
    //Получение текущей категории сотрудника из category_employee
    try{
        $s=$pdo->prepare("SELECT Id,Value,Title FROM category_employee WHERE Id=:id_cat LIMIT 1");
        $s->bindValue(":id_cat",$id_category);
        $s->execute();
    }
    catch(PDOException $e){
        echo "Ошибка получения текущей категории сотрудника";
        exit();
    }
    foreach($s->fetchAll() as $row){
        $id=$row['Id'];
        $title=$row['Title'];
        echo "<option value='$id'>* $title</option>";
    }
    //Получение всех категрий из category_employee
    try{
        $result=$pdo->query("SELECT * FROM category_employee");
    }
    catch(PDOException $e){
        echo "Ошибка получения категорий";
        exit();
    }
    foreach($result->fetchAll() as $row){
        $id=$row['Id'];
        $title=$row['Title'];
        echo "<option value='$id'>$title</option>";
    }
    echo"</select></td>";
}
//Восстановление статуса сотрудника
function restore_status_worker($id_status){
    require 'connect_mechan.php';
    echo "<td><select name='statuses' class='form-control'>";
    //Получение текущей категории сотрудника из category_employee
    try{
        $s=$pdo->prepare("SELECT Id,Status FROM status_mechan WHERE Id=:id_status LIMIT 1");
        $s->bindValue(":id_status",$id_status);
        $s->execute();
    }
    catch(PDOException $e){
        echo "Ошибка получения текущего статуса сотрудника";
        exit();
    }
    foreach($s->fetchAll() as $row){
        $id=$row['Id'];
        $status=$row['Status'];
        echo "<option value='$id' placeholder>*$status</option>";
    }
    //Получение всех категрий из category_employee
    try{
        $result=$pdo->query("SELECT Id,Status FROM status_mechan");
    }
    catch(PDOException $e){
        echo "Ошибка получения статусов";
        exit();
    }
    foreach($result->fetchAll() as $row){
        $id=$row['Id'];
        $status=$row['Status'];
        echo "<option value='$id'>$status</option>";
    }
    echo"</select></td>";
}
//Восстановление параметров пользователя
function restore_worker($id_worker){
    require 'connect_mechan.php';
    if(isset($id_worker) and !empty($id_worker)){
        $id_m=htmlspecialchars($_POST['id_worker']);
        $fio=htmlspecialchars($_POST['name_worker']);
        $m_phone=htmlspecialchars($_POST['phone_worker']);
        $m_status=htmlspecialchars($_POST['statuses']);
        $m_doc=htmlspecialchars($_POST['login_worker']); 
        $m_pswrd=htmlspecialchars($_POST['pass_worker']); 
        $category_employee=htmlspecialchars($_POST['categories']);
        require 'connect_mechan.php';
    try{
        $s=$pdo->prepare("SELECT Number,Status,Category,N_doc FROM t_mechan WHERE Number=:id_m LIMIT 1");
        $s->bindValue(':id_m',$id_m);
        $s->execute();
        foreach($s->fetchAll() as $n_doc){
            $number_m=$n_doc['Number'];
            $category_empl=$n_doc['Category'];
            $m_status_m=$n_doc['Status'];
            $doc_m=$n_doc['N_doc'];
        } 
    }
    catch (Exception $ex) {
        echo "Ошибка получения информации о заявке";
        exit();    
    }
    if(isset($id_worker) and !empty($id_worker)){
        $id_m=htmlspecialchars($_POST['id_worker']);
        $fio=htmlspecialchars($_POST['name_worker']);
        $m_phone=htmlspecialchars($_POST['phone_worker']);
        $m_status=htmlspecialchars($_POST['statuses']);
        $m_doc=htmlspecialchars($_POST['login_worker']); 
        $m_pswrd=htmlspecialchars($_POST['pass_worker']); 
        $category_employee=htmlspecialchars($_POST['categories']);
        if($m_pswrd!=''){
        try{
            $s=$pdo->prepare("UPDATE mlogns SET Login=:m_doc,paswrd=:m_pswrd,Category=:category WHERE Login=:login");
            $s->bindValue(':m_doc',$m_doc);
            $s->bindValue(':m_pswrd',password_hash($m_pswrd,PASSWORD_DEFAULT));
            $s->bindValue(':login',$doc_m);
            $s->bindValue(':category',$category_employee);
            $s->execute();
        }
        catch(PDOException $e){
            echo "не удалось изменить данные";
            exit();
        }
        try{
            $s=$pdo->prepare("UPDATE Phones_workers SET Id_worker=:id_worker WHERE Id_worker=:old_id");
            $s->bindValue(':id_worker',$m_doc);
            $s->bindValue(':old_id',$doc_m);
            $s->execute();
            
        } catch (PDOException $e) {
            echo "не удалось изменить данные";
            exit();
        }
        try{
            $s=$pdo->prepare("UPDATE Names_workers SET Id_worker=:id_worker WHERE Id_worker=:old_id");
            $s->bindValue(':id_worker',$m_doc);
            $s->bindValue(':old_id',$doc_m);
            $s->execute();
            
        } catch (PDOException $e) {
            echo "не удалось изменить данные";
            exit();
        }
    }
    else{
        try{
            $s=$pdo->prepare("UPDATE mlogns SET Login=:m_doc,Category=:category WHERE Login=:login");
            $s->bindValue(':m_doc',$m_doc);
            $s->bindValue(':login',$doc_m);
            $s->bindValue(':category',$category_employee);
            $s->execute();
        }
        catch (PDOException $e) {
            echo "не удалось изменить данные";
            exit();
        }
        try{
           $s=$pdo->prepare("UPDATE Phones_workers SET Id_worker=:id_worker WHERE Id_worker=:old_id");
            $s->bindValue(':id_worker',$m_doc);
            $s->bindValue(':old_id',$doc_m);
            $s->execute();   
        } 
        catch (PDOException $e) {
            echo "не удалось изменить данные";
            exit();
        }
        try{
            $s=$pdo->prepare("UPDATE Names_workers SET Id_worker=:id_worker WHERE Id_worker=:old_id");
            $s->bindValue(':id_worker',$m_doc);
            $s->bindValue(':old_id',$doc_m);
            $s->execute();
            
        } catch (PDOException $e) {
            echo "не удалось изменить данные";
            exit();
        }
    }
        try{    
            $s=$pdo->prepare("UPDATE t_mechan SET Status=:m_status,N_doc=:m_doc,Category=:category WHERE Number=:id_m");
            $s->bindValue(':m_status',$m_status);
            $s->bindValue(':m_doc',$m_doc);
            $s->bindValue(':id_m',$id_m);
            $s->bindValue(':category',$category_employee);
            $s->execute();
        }
        catch (Exception $ex) {
            echo "Ошибка обновления информации о сотруднике";
            exit();    
    }
        try{
            $s=$pdo->prepare("UPDATE Names_workers SET Name=:name WHERE Id_worker=:id_m");
            $s->bindValue(':name',$fio);
            $s->bindValue(':id_m',$m_doc);
            $s->execute();
        } 
        catch (Exception $ex) {
            echo "Ошибка обновления имени сотрудника";
            exit(); 
        }
        try{
            $s=$pdo->prepare("UPDATE Phones_workers SET Phone_worker=:phone_worker WHERE Id_worker=:id_m");
            $s->bindValue(':phone_worker',$m_phone);
            $s->bindValue(':id_m',$m_doc);
            $s->execute();
        } 
        catch (Exception $ex) {
            echo "Ошибка обновления телефона сотрудника";
            exit(); 
        } 
    }
    }
}
//Восстановление параметров
//Восстановление категорий сотрудников
function restore_categories(){
    require 'connect_mechan.php';
    //Удаление всех категорий
    try{
        $s=$pdo->query("DELETE FROM category_employee");
    } 
    catch (PDOException $ex) {
        echo "Не удалось удалить категориии сотрудников </br>$ex";
        exit();
    }
    //Обнуление автоинкремента
    try{
        $s=$pdo->query("ALTER TABLE category_employee AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex) {
        echo "Ошибка обнуления category_employee <br/>$ex";
        exit();
    }
    //Вставка категорий по умолчанию
    try{
        $s=$pdo->query("INSERT INTO category_employee(Value,Title,Status) VALUES ('Mechanic','Механик','Default'),('Operator','Оператор','Default')");
    } 
    catch (Exception $ex) {
        echo "Не удалось добавить категории сотрудников в таблицу </br>$ex";
        exit();
    }
}
//Восстановление статусов сотрудников
function restore_statuses(){
    require 'connect_mechan.php';
    //Удаление всех статусов
    try{
        $s=$pdo->query("DELETE FROM status_mechan");
    } 
    catch (Exception $ex) {
        echo "Не удалось удалить статусы сотрудников из таблицы </br>$ex";
        exit();
    }
    //Обнуление автоинкремента
    try{
        $s=$pdo->query("ALTER TABLE status_mechan AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex) {
        echo "Ошибка обнуления status_mechan <br/> $ex";
        exit();
    }
    //Вставка статусов по умолчанию
    try{
        $s=$pdo->query("INSERT INTO status_mechan(Status,State) VALUES ('Доступен','Default'),('Не доступен','Ordinary')");
    } 
    catch (PDOException $ex) {
        echo "Не удалось добавить статусы сотрудников в таблицу </br>$ex";
        exit();
    }
}
//Восстановление статусов заявок
function restore_statuses_tickets(){
    require 'connect_mechan.php';
    //Удаление всех статусов
    try{
        $s=$pdo->query("DELETE FROM ticket_status");
    } 
    catch (PDOException $ex) {
        echo "Не удалось удалить категории из таблицы</br>$ex";
        exit();
    }
    //Обнуление автоинкремента
    try{
        $s=$pdo->query("ALTER TABLE ticket_status AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex) {
        echo "Ошибка обнуления ticket_status $ex";
        exit();
    }
    //Вставка статусов по умолчанию
    try{
        $s=$pdo->query("INSERT INTO ticket_status(Status,Priority) VALUES ('Не выполнена','default'),('Выполнена','default')");
    } 
    catch (PDOException $ex) {
        echo "Не удалось добавить статусы в таблицу </br>$ex";
        exit();
    }
}
//Восстановление состояний заявок
function restore_states_tickets(){
    require 'connect_mechan.php';
    //Удаление всех статусов
    try{
        $s=$pdo->query("DELETE FROM ticket_state");
    } 
    catch (PDOException $ex) {
        echo "Не удалось удалить состояния заявок<br/>$ex";
        exit();
    }
    //Обнуление автоинкремента
    try{
        $s=$pdo->query("ALTER TABLE ticket_state AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex) {
        echo "Ошибка обнуления ticket_state <br/> $ex";
        exit();
    }
    //Вставка статусов по умолчанию
    try{
        $s=$pdo->query("INSERT INTO ticket_state(State,Priority) VALUES ('Отправлена','default'),('Не отправлена','default')");
    } 
    catch (PDOException $ex) {
        echo "Не удалось добавить состояния в таблицу </br>".$ex;
        exit();
    }
}
//Удаление всех статусов
function delete_all_tickets(){
    require 'connect_mechan.php';
    $tables=array('atable','ticket_adress','ticket_class','ticket_type','ticket_date','ticket_description','ticket_phone','ticket_search_param','Tarifs','smsprofiles');
    foreach($tables as $table_name){
    //Удаление записей из таблицы заявок
    try{
        $s=$pdo->query("DELETE FROM $table_name");
    } 
    catch (PDOException $ex) {
        echo "Не удалось удалить записи из таблицы ". $table_name."</br>".$ex;
        exit();
    }
    //Обнуление автоинкремента
    try{
        $s=$pdo->query("ALTER TABLE $table_name AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex){
        echo "Ошибка обнуления $table_name $ex";
        exit();
    }
  }//Конец foreach
}
//Восстановление параметров поиска заявок
function restore_search_tickets(){
    require 'connect_mechan.php';
    try{
        $pdo->query("DELETE FROM ticket_search_param");
    }
    catch(PDOExecption $ex){
        echo "Не удалось удалить параметры поиска заявок";
        exit();
    }
    try{
        $pdo->query("ALTER TABLE ticket_search_param AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex){
        echo "Ошибка обнуления ticket_search_param";
        exit();
    }
}
//Восстановление параметров поиска сотрудников
function restore_search_workers(){
    require 'connect_mechan.php';
    try{
        $pdo->query("DELETE FROM mechan_search_parameters");
    }
    catch(PDOExecption $ex){
        echo "Не удалось удалить параметры поиска сотрудников";
        exit();
    }
    try{
        $pdo->query("ALTER TABLE mechan_search_parameters AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex){
        echo "Ошибка обнуления mechan_search_parameters";
        exit();
    }
}
function delete_all_workers(){
    require 'connect_mechan.php';
    $tables=array('mlogns','Names_workers','Phones_workers','t_mechan');
    foreach($tables as $table_name){
    //Удаление записей из таблицы с сотрудниками
    try{
        $s=$pdo->query("DELETE FROM $table_name");
    } 
    catch (PDOException $ex) {
        echo "Не удалось удалить записи из таблицы ". $table_name."</br>".$ex;
        exit();
    }
    //Обнуление автоинкремента
    try{
        $s=$pdo->query("ALTER TABLE $table_name AUTO_INCREMENT=0");
    } 
    catch (PDOException $ex){
        echo "Ошибка обнуления $table_name $ex";
        exit();
    }
  }
}
//Восстановление всех параметров
function restore_all(){
    require 'connect_mechan.php';
    delete_all_tickets();
    restore_states_tickets();
    restore_statuses_tickets();
    restore_categories();
    restore_statuses();
    restore_search_tickets();
    restore_search_workers();
}
?>