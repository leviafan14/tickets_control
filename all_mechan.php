<?php
require_once 'check_session.php';
require_once 'mechan_title_name.php';
require_once'load_mechan_functions.php';?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tab_tick_mech.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">      
        <title>Сотрудники</title>
    </head>
    <body>
        <div id="d_menu">
            <a class='a_table_menu' href='all_tickets.php'>Заявки</a>
            <a href='parameters_controller_menu.php?param=mechan' class='a_table_menu'>Параметры</a>
            <a href='exit.php' class='a_table_menu'>Выход</a>
        </div>
        <center>   
            <table id="t_mech" class='table table-hover'>
                <thead class='a_navigate'>
                    <tr><td><?php echo $title_number_m;?></td><td><?php echo $title_fio;?></td><td><?php echo $title_phone_m;?></td><td><?php echo $title_status_m;?></td><td><?php echo $title_numb_doc;?></td><td><?php echo $title_category;?></td></tr>
                </thead>
                <tbody>
                    <?php load_mechan();?>
                </tbody>
            </table>
            <?php kolrows($s);?>     
        </center>   
        <?php require_once 'new_mechan.php';require_once 'search_mechan.php';?>
    </body>
</html>