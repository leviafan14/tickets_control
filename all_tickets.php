<?php 
require_once 'check_session.php';
require_once 'load_tickets_functions.php';
require_once 'tickets_title_name.php';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tab_tick_mech.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>Заявки</title>
    </head>
    <body>
        <div id="d_menu"> <!-- Меню навигации и отображение баланса -->
            <a href='all_mechan.php' class='a_table_menu'>Сотрудники</a>
            <a href='print_tickets.php' class='a_table_menu'>Печать</a>
            <a href='parameters_controller_menu.php?param=tickets' target="_blank" class='a_table_menu'>Параметры</a>
            <a href='exit.php' class='a_table_menu'>Выход</a>
            <span class='s_menu'><span id='s_operator'><?php echo "Вы зашли как: "?><?php echo get_name_operator($_SESSION['login']);?></span></span><!--Выводит имя оператора -->
        </div>
        <center>
            <div id='d_main'> <!--Обёртка d_tickets_table и t_tickets  -->
                <div id='d_tickets_table'>
                    <table id='t_tickets' class='table table-hover'><!-- таблица с заявками -->
                        <thead class='a_navigate'>
                            <tr id='t_head'><th style='border-left:0px;'><?php echo $title_number_t;?></th><th><?php echo $title_type;?></th><th><?php echo $title_class;?></th><th><?php echo $title_time;?></th><th><?php echo $title_adres;?></th><th><?php echo $title_phone;?></th><th><?php echo $title_status;?></th><th><?php echo $title_state;?></th><th></th></tr>
                        </thead>
                        <tbody>     
                            <?php load_tickets($display="display");?>
                        </tbody>    
                    </table>
                </div>
            </div> <!--Конец d_main -->
            <?php echo kolrows($s); // вызов функции вывода количества заявок и текста запроса?>
        </center>    
        <?php require_once 'new_ticket.php'; require_once 'search_tickets.php';?>
    </body>
</html>