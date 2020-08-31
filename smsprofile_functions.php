<?php
function new_profile($title,$login,$password){
    $status='nodefault';
    try{
        require 'tickets_connect.php';
        $s=$pdo->prepare("INSERT INTO smsprofiles(title,login,password,status) VALUES (:title,:login,:password,:status)");
        $s->bindValue(':title',$title);
        $s->bindValue(':login',$login);
        $s->bindValue(':password',$password);
        $s->bindValue(':status',$status);
        $s->execute();
    }
    catch (PDOException $ex){
        echo $ex;
        exit();
    }
}
function delete_profile($id){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("DELETE FROM smsprofiles WHERE id=:id LIMIT 1");
        $s->bindValue(':id',$id);
        $s->execute();
    }
    catch(PDOException $e){
        echo "Ошибка удаления смс-профия";
        exit();
    }
}
function edit_profile($title,$login,$password,$status,$id){
    require 'tickets_connect.php';
    try{
        foreach($kol=$pdo->query("SELECT id,status FROM smsprofiles WHERE status='default' LIMIT 1") as $result){
        }
        if($status=='default' && $kol->rowCount()>=1 && $id!=$result['id']){
            echo "Уже назначен профиль по умолчанию";
            exit();
        }
        else{} 
    }
    catch (PDOException $e){
        echo "Ошибка получения данных смс-профиля";
        exit();
    }
    try{
        $s=$pdo->prepare("UPDATE smsprofiles SET title=:title, login=:login, password=:password, status=:status WHERE id=:id");
        $s->execute(array(
            ':title'=>$title,
            ':login'=>$login,
            ':password'=>$password,
            ':status'=>$status,
            ':id'=>$id));
    }
    catch (PDOException $e){
        echo "Ошибка обновления информации смс-профиля";
        exit();
    }
}
?>