<?php
require_once("check_session.php");
$event=$_GET['event'];
function check_mobile_device() { 
    $mobile_agent_array = array('ipad', 'iphone', 'android', 'pocket', 'palm', 'windows ce', 'windowsce', 'cellphone', 'opera mobi', 'ipod', 'small', 'sharp', 'sonyericsson', 'symbian', 'opera mini', 'nokia', 'htc_', 'samsung', 'motorola', 'smartphone', 'blackberry', 'playstation portable', 'tablet browser');
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);    
    // var_dump($agent);exit;
    foreach ($mobile_agent_array as $value) {    
        if (strpos($agent, $value) !== false) return true;   
    }       
    return false; 
}
$is_mobile_device = check_mobile_device();
if($is_mobile_device and $event=='new'){
    header("location:new_ticket_from_mechan.php");
    exit();
}
else{}
if (!$is_mobile_device and $event=='new'){
    header("location:new_ticket.php");
    exit();
}
else{}
if($event=='edit'){
    if ($_GET['id_t']){
        $numb_ticket=$_GET['id_t'];
    }
    else{
        echo "Отсутствует номер заявки";
        exit();
    }
    header("location:edit_ticket_mechan.php?id_t=$numb_ticket");
    exit();
}

?>