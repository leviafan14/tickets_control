<?php 
require_once "check_session.php";
require_once "tickets_title_name.php";
require_once("functions_request.php");
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link href="css/request1.css" rel="stylesheet">
        <title>Список</title>
    </head>
    <body>
    <div id="main_div">     
        <center>
        <table id="t_nav">
            <tbody>
                <tr><td class='td_nav'><a class='link_div' name="a_new_ticket" href='check_user_platform.php?event=new'>Добавить</a></td><td class='td_nav'><a name="a_statistics" class="link_div" href="statistics.php">Журнал</a></td><td class='td_nav'><a name="l_exit" class="link_div" href='exit_mechan.php'>Выход</a></td></tr>
            </tbody>
        </table>    
        <table id="t1">
            <caption id="capt"><b>Список заявок:</b></caption>
            <thead id='th1'><tr class='td_numb'><td><b><?php echo $title_num_t?></b></td><td id='td_adress'><b><?php echo $title_adres;?></b></td><td><b><?php echo $title_type;?></b></td><td><b><?php echo $title_class;?></b></td></tr></thead>
            <tbody>
                <?php
                        display_tickets();  
                ?>
            </tbody>
        </table>    
        <div>             
        </center>
    </body>
</html>