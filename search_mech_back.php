<?php
require_once 'check_session.php';
require_once 'tickets_connect.php';
require_once 'mechan_title_name.php';
require_once 'load_mechan_functions.php';
$status_mechan=$_POST['sct_status_filt'];
$search_mech=trim($_POST['sct_search_mech']);
$srh_param_m=htmlentities(trim($_POST['txt_srh_m']));
$category_param=trim($_POST['search_category']);
if(!isset($_SESSION['q_mech'])){
    if ($search_mech<>'-'){
        $_SESSION['q_mech']=search_txt_field_mehcan($status_mechan,$category_param,$search_mech,$srh_param_m);
        $_SESSION['txt_query_mechan']="$title_status_m: <strong style=color:#32CD32>".display_status($status_mechan)."</strong> $title_category: <strong style=color:#32CD32>".display_category($category_param)."</strong> $title_search: <strong style=color:#32CD32>$srh_param_m</strong>";
        header("location:all_mechan.php");
        exit();
    }
        else {$search_m="";} 
    if ($status_mechan<>0) $stus_mech="t_mechan.Status"."="."'$status_mechan'";
        else {$stus_mech="t_mechan.Status"."!"."="."'0'";}
    if ($category_param<>0) $cat_param="t_mechan.Category"."="."'$category_param'";
        else {$cat_param="t_mechan.Category!='0'";}    
    $q_srch_mechan=("SELECT Number,Status,Category,N_doc FROM t_mechan WHERE $stus_mech AND $cat_param"); 
    $_SESSION['q_mech']=$q_srch_mechan;                   
}
if(isset($_SESSION['q_mech'])){
    if ($search_mech<>'-'){
        $_SESSION['q_mech']=search_txt_field_mehcan($status_mechan,$category_param,$search_mech,$srh_param_m);
        $_SESSION['txt_query_mechan']="$title_search: <strong style=color:#32CD32>$srh_param_m</strong>";
        header("location:all_mechan.php");
        exit();
    }
    if ($status_mechan<>0) $stus_mech="Status"."="."'$status_mechan'";
        else {$stus_mech="`Status`"."!"."="."'0'";}
    if ($category_param<>0) $cat_param="Category"."="."'$category_param'";
        else {$cat_param="`Category`!='0'";}      
   $_SESSION['q_mech']=("SELECT Number,Status,Category,N_doc FROM t_mechan WHERE $stus_mech AND $cat_param"); 
   $_SESSION['txt_query_mechan']="$title_search: <strong style=color:#32CD32>$srh_param_m</strong>"; 
}
header("location:all_mechan.php");
exit();
?>