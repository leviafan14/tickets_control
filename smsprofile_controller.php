<?php
require_once 'smsprofile_functions.php';
$new_profile=htmlentities($_POST['hidden_new']);
$edit_profile=htmlentities($_POST['hidden_edit']);
$delete_profile=htmlentities($_GET['trigger']);
if(isset($new_profile) && $new_profile=='new'){//Добавление нового профиля
    $title=trim(htmlentities($_POST['t_title']));
    $login=trim(htmlentities($_POST['t_login']));
    $password=trim(htmlentities($_POST['t_password']));
    new_profile($title,$login,$password);
}
else{}
if(isset($edit_profile) && $edit_profile=='edit'){// Редактирование профиля
    $id=trim(htmlentities($_POST['hidden_id']));
    $title=trim(htmlentities($_POST['t_title']));
    $login=trim(htmlentities($_POST['t_login']));
    $password=trim(htmlentities($_POST['t_password']));
    $status=trim(htmlentities($_POST['s_status']));
    edit_profile($title,$login,$password,$status,$id);
}
else{}
if(isset($delete_profile) && $delete_profile=='delete'){ // Удаление профиля
    $id=trim(htmlentities($_GET['a_id']));
    delete_profile($id);
}
else{
}
header("location:smsprofiles.php");
exit();
?>