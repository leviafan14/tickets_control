<?php
session_start();
require_once 'tickets_connect.php';
$id_m=htmlspecialchars($_POST['empl_id']);// Id сотрудника
$fio=htmlspecialchars($_POST['t_fio']);// Имя сотрудника
$m_phone=htmlspecialchars($_POST['n_phone_mech']);//телефон сотрудника
$m_status=htmlspecialchars($_POST['s_status_mech']);//статус сотрудника
$m_doc=htmlspecialchars($_POST['t_doc']);//№ документа (логин) сотрудника
$m_pswrd=htmlspecialchars($_POST['t_pswrd']); //пароль сотрудника
$category_employee=htmlspecialchars($_POST['slt_category']);//категория сотрудника
//Получения данных редактируемого сотрудника
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
//Если логин из БД совпадает с логином сессии, то логин в сессии меняется на логин с формы
if($doc_m==$_SESSION['login']){
    $_SESSION['login']=$m_doc;
}
else{$_SESSION['login']=$_SESSION['login'];}
try{
    //Если новый пароль указан
    if(!empty($m_pswrd)){
        try{
            $s=$pdo->prepare("UPDATE mlogns SET Login=:m_doc,paswrd=:m_pswrd,Category=:category WHERE Login=:login");
            $s->bindValue(':m_doc',$m_doc);
            $s->bindValue(':m_pswrd',password_hash($m_pswrd,PASSWORD_DEFAULT));
            $s->bindValue(':login',$doc_m);
            $s->bindValue(':category',$category_employee);
            $s->execute();
        }
        catch(PDOException $e){
            echo "не удалось изменить данные (изменение без пароля)";
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
    //Если новый пароль не указан
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
}
catch (Exception $ex) {
    echo "Ошибка обновления таблицы с логинами";
    exit();
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
//Отправка логина и пароля смс-сообщением
if($_POST['cb_pswrd']=='send'){
    require_once 'smsc_api.php';
    if($m_pswrd!=''){
        $sms_message='логин: '.$m_doc."\n".'пароль: '.$m_pswrd;
    }
    else{
         $sms_message='логин: '.$m_doc;
    }
    send_sms($m_phone, $sms_message);
}
else{}
header("location:all_mechan.php");
exit();
?>