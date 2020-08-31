<?php
$parameter=$_GET['parameter'];
require_once 'tickets_connect.php';
require_once'search_mechan_select.php';
require_once 'new_mechan_select.php';
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/parameters_css.css">
        <title>Управление параметрами</title>
    </head>
    <body>
        <a href="all_mechan.php" class='a_menu_link'>Сотрудники</a>
        <a href="all_tickets.php" class='a_menu_link'>Заявки</a>
        <a href="parameters_controller_menu.php?param=mechan" class='a_menu_link'>Назад</a>
    <center>
         <!--СТАТУСЫ --->
        <div id="d_main_mechan">
        <!--Добавить новый статус -->
            <?php if(isset($parameter)and $parameter=='status'):?>
            <div id="div_status" class="div_param">
                <form name='f_new_status' class="f_param" action="manage_param_mechan_back.php" method="POST">
                    <input type="text" class="text" required placeholder='Добавить статус' name="insert">
                    <input type="hidden" name="new" value="true">
                    <input type="hidden" name="field" value="Status">
                    <p class='p_button'><input type="submit" value="OK" class="button"></p>
                </form>
            <?php 
           // Загрузка статусов из базы
            foreach($param_status as $status_mechan):
                if ($status_mechan['state']!='Default'):?>
                    <form name="f_status_mechan" class="f_param" action="manage_param_mechan_back.php" method="POST">
                        <input type="text" name="value" class="text" required  value="<?php echo $status_mechan['status']; ?>">
                        <input type="hidden" name="field" value="Status">
                        <input type="hidden" name="type" value="Status">
                        <input type="hidden" name="id" value="<?php echo $status_mechan['id'];?>">
                        <label><a href='help_for_categories.php?t=s' title='Состояние'><?php echo $status_mechan['state'];?></a></label>
                        <p class='p_button'>
                            <input type="submit" value="OK" class="button">
                            <a href="manage_param_mechan_back.php?trigger=delete&a_id=<?php echo $status_mechan['id']; ?>&type_link=Status" name="a_id">Удалить</a>
                        </p>    
                </form>
                 <?php else:?> 
                    <form name="f_status_mechan" class="f_param" action="manage_param_mechan_back.php" method="POST">
                        <input type="text" disabled name="value" class="text" required  value="<?php echo $status_mechan['status'];?>">
                        <input type="hidden" name="field" value="Status">
                        <input type="hidden" name="type" value="Status">
                        <input type="hidden" name="id" value="<?php echo $status_mechan['id']; ?>">
                        <label><a href='help_for_categories.php?t=s' title='Состояние'><?php echo $status_mechan['state'];?></a></label>
                    </form>
            <?php endif;endforeach;?>
        </div>
         <!--КАТЕГОРИИ --->
        <?php endif; ?>
         <?php if(isset($parameter)and $parameter=='category'):?>
            <div id="div_category" class="div_param">
                <!--Добавить новую категорию --->
                <form name='f_new_category' class="f_param" action="manage_param_mechan_back.php" method="POST">
                    <input type="text" class="text" required placeholder='Добавить категорию' name="insert">
                    <input type="text" class="text" required placeholder='Добавить описание' name="insert_title">
                    <input type="hidden" name="new" value="true">
                    <input type="hidden" name="field" value="Category">
                    <input type="submit" value="OK" class="button">
                </form>
            <?php 
            //Загрузка категорий из базы
            foreach($param_category as $category):
                if ($category['status']!='Default'):?>
                    <form name="f_category" class="f_param" action="manage_param_mechan_back.php" method="POST">
                        <input type="text" name="value" class="text" required  value="<?php echo $category['value'];?>">
                        <input type="text" name="title" class="text" required  value="<?php echo $category['title'];?>">
                        <input type="hidden" name="category_status" value="<?php echo $category['status'];?>">
                        <label for="category_status"><a href='help_for_categories.php?t=c' title='статус категории'><?php echo $category['status'];?></a></label>
                        <input type="hidden" name="field" value="Category">
                        <input type="hidden" name="type" value="Category">
                        <input type="hidden" name="id" value="<?php echo $category['id'];?>">
                        <p class='p_button'>
                            <input type="submit" value="OK" class="button">
                            <a href="manage_param_mechan_back.php?
                            trigger=delete&a_id=<?php echo $category['id'];?>
                            &type_link=Category&category=<?php echo $category['status'];?>" 
                            name="a_id">Удалить</a>
                        </p>    
                    </form>
                <?php else:?> 
                    <form name="f_category" class="f_param" action="manage_param_mechan_back.php" method="POST">
                        <input type="text" disabled name="value" class="text" required  value="<?php echo $category['value'];?>">
                        <input type="text" name="title" class="text" required  value="<?php echo $category['title'];?>">
                        <input type="hidden" name="category_status" value="<?php echo $category['status'];?>">
                        <input type='hidden' name='type' value='Category'/>
                        <input type="hidden" name="id" value="<?php echo $category['id'];?>">
                        <p class='p_button'>
                            <input type="submit" value="OK" class="button">
                            <label for="category_status"><a href='help_for_categories.php?t=c' title='статус категории'><?php echo $category['status'];?></a></label>
                        </p>
                    </form>
            <?php endif; endforeach;?>
        </div>      
        <?php endif;?>    
        <!--ПОИСК--->
        <?php if(isset($parameter)and $parameter=='search'):?>
        <center>
        <div id="d_other" class="div_param">
            <form name='f_new_param' class="f_param" action="manage_param_mechan_back.php" method="POST">
                <input type="text" class="text" required placeholder='Добавить параметр' name="insert">
                <input type="text" class="text" required placeholder='Укажите поле таблицы' name="insert_field">
                <input type="hidden" name="new" value="true">
                <p>
                    <input type="hidden" name="field" value="Parameter">
                    <input type="submit" value="OK" class="button">
                </p>    
            </form>
            <?php 
                foreach($param_search as $other_param):?>
            <form name="f_other_param" class="f_param" action="manage_param_mechan_back.php" method="POST">
                <input type="text" name="value" class="text" required  value="<?php echo $other_param['parameter']; ?>">
                <input type="text" name="field" class="text" required value="<?php echo $other_param['search_field']; ?>">
                <input type="hidden" name="type" value="Other">
                <input type="hidden" name="id" value="<?php echo $other_param['id']; ?>">
                <p>
                    <input type="submit" value="OK" class="button">
                    <a href="manage_param_mechan_back.php?trigger=delete&a_id=<?php echo $other_param['id'];?>&type_link=Other" name="a_id">Удалить</a>
                </p>
            </form>
                <?php endforeach;?>
        </div> 
         <?php endif;?> 
        </div>
    </center>        
    </body>
</html>