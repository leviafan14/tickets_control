<?php
$fio_mech=htmlentities(trim($_POST['t_fio']));
$phone_mech=htmlentities(trim($_POST['n_phone_mech']));
$status_mech=trim($_POST['s_status_mech']);
$doc_mech=htmlentities(trim($_POST['t_doc']));
$paswrd=htmlentities(trim($_POST['t_pass']));
$paswrd_mech=password_hash($paswrd,PASSWORD_DEFAULT);
$category=trim($_POST['s_category']);
$cb_sms=trim($_POST['cb_sms']);
if(!$fio_mech||!$phone_mech||!$doc_mech||!$paswrd_mech){
    echo "<H4 style='color:lightsalmon;'>Заполните данные. "."<a style='text-decoration:none;color:#00FF7F;' href=all_mechan.php>Назад к механикам</a></H4>";
    exit();
}
else{
    require_once 'new_mechan_function.php';
    add_worker($fio_mech,$phone_mech,$status_mech,$doc_mech,$category,$paswrd_mech,$paswrd,$cb_sms);   
}
?>