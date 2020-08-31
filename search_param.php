 <!DOCTYPE html>
 <html lang="ru">
     <head>
        <title>Параметры поиска</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/parameters_css.css">
     </head>
     <body>
         <a href="all_tickets.php" class='a_menu_link'>Заявки</a><a href="parameters_controller_menu.php?param=tickets" class='a_menu_link'>Назад</a>
     <center>
        <div id="div_other" class="div_param">
            <form name='f_new_param' class="f_param" action="manage_param_tickets_back.php" method="POST">
                <input type="text" class="text" name="alias" required placeholder='Имя'>
                <input type="text" name="parameter" class="text" required placeholder='Значение'>
                <input type="hidden" name="field" value="Other">
                <input type="hidden" name="new" value="true">
                <p><input type="submit" value="OK" class="button"></p>
            </form>
            <?php 
                require_once 'other_param_select.php';
                foreach($param_search as $other_param):?>
                <form name="f_other_param" class="f_param" action="manage_param_tickets_back.php" method="POST">
                    <input type='hidden' value='edit_parameter' name='operation'>
                    <input type="text" name="alias" class="text" required value="<?php echo $other_param['name'];?>">
                    <input type="text" name="parameter" class="text" required  value="<?php echo $other_param['value'];?>">
                    <input type="hidden" name="field" value="Other">
                    <input type="hidden" name="id" value="<?php echo $other_param['id'];?>">
                    <p><input type="submit" value="OK" class="button">
                        <a href="manage_param_tickets_back.php?trigger=delete&a_id=<?php echo $other_param['id']; ?>&type_link=other" name="a_id">Удалить</a>
                    </p>
                </form>
           <?php endforeach;?>
        </div>    
    </center>        
    </body>     
</html>