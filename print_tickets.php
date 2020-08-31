<?php
    require_once 'tickets_connect.php';
    require_once 'load_tickets_functions.php';
 ?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <style media="print">
        .a_table_menu{
           color:lightsalmon;
           text-align:center;
           text-decoration: none;
            }        
        .a_navigate{
           color:lightslategray;
           align:center;
           text-decoration: none;
           text-align: center;
            }
        #t_tickets{
            border-collapse:separate;
            border-spacing: 0px;
            font-size:16px;
            text-align:justify;
            padding:0px;
            margin:0px;
            width:100%;
            }    
         a{
           color:lightsalmon;
           text-decoration: none;
            }
            td{
            cell-spacing:0px;
            border-spacing:0px;
            padding:0px;
            margin:0px;
            }
            td{
                border-bottom: 1px solid #a52a2a; /* Линия внизу ячейки */
            }
            #d_menu{
                display: none;
            }
        </style> 
        <title>Печать</title>
    </head>
    <body>
        <div id="d_menu"><a href='all_tickets.php' class='a_menu'>| Заявки |</a> <a href="new_page.php" target="_blank" onclick="print(); return false;"> | Отправить на печать |</a>
        </div>
        <table id="t_tickets" cellspacing="0">
            <thead class='a_navigate'>
                <tr><td>Номер</td><td>Тип</td><td>Класс</td><td>Время</td><td>Адрес</td><td>Тариф</td><td>Описание</td></tr>
            </thead>
            <tbody>
            <?php
                load_tickets($display='print');?>
            </tbody>
        </table> 
    </body>
</html>