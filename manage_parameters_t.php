<?php require_once 'parameters_controller.php';?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/parameters_css.css">
        <title>Управление параметрами</title>
    </head>
    <body>
        <a href="all_tickets.php" class='a_menu_link'>Заявки</a><a href="parameters_controller_menu.php?param=tickets" class='a_menu_link'>Назад</a>
        <center>
            <h5>При удалении параметра удаляются все заявки с этим параметром</h5>
            <div id="div_type" class="div_param">
                <form name='f_new_type' class="f_param" action="manage_param_tickets_back.php" method="POST">
                    <input type="text" class="text" required placeholder='Добавить' name="insert">
                    <input type="hidden" name="new" value="true">
                    <input type="hidden" name="field" value="<?php echo $alias; ?>">
                    <p><input type="submit" value="OK" class="button"></p>
                </form>    
            <?php 
            foreach($param as $ticket):?>
                <?php if($ticket['priority']=='default'):?>
               <form name="f_type" class="f_param" action="manage_param_tickets_back.php" method="POST">
                   <input type='hidden' value='edit_parameter' name='operation'>
                    <input type="text" name="value" class="text" required  value="<?php echo $ticket["$alias"]; ?>">
                    <input type="hidden" name="field" value="<?php echo $alias; ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $ticket['id']; ?>">
                    <p>
                        <input type="submit" value="OK" class="button">
                        <label><a title='параметр по умолчанию удалить нельзя'><?php echo $ticket['priority'];?></a></label>
                    </p>
                </form>
                
                <?php else:?>
                    <form name="f_type" class="f_param" action="manage_param_tickets_back.php" method="POST">
                        <input type='hidden' value='edit_parameter' name='operation'>
                        <input type="text" name="value" class="text" required  value="<?php echo $ticket["$alias"]; ?>">
                        <input type="hidden" name="field" value="<?php echo $alias; ?>">
                        <input type="hidden" name="id" id="id" value="<?php echo $ticket['id']; ?>">
                        <p>
                            <input type="submit" value="OK" class="button">
                            <a href="manage_param_tickets_back.php?trigger=delete&a_id=<?php echo $ticket['id']; ?>&type_link=<?php echo $alias; ?>"name="a_id">Удалить</a>
                        </p>
                </form>
                <?php endif;?>
            <?php endforeach;?>
            </div>
       </center>        
    </body>
</html>        