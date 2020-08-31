<?php 
require_once 'tickets_title_name.php';
require_once 'tickets_connect.php';
require 'new_ticket_select.php';?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tick_mechan.css">
    </head>
    <body>
        <div class='d_new'>
            <form name="f_new" method="POST" action="new_ticket_back.php">
                <center>
                    <p id="p_main">
                        <p id="p_first_block">
                            <span> <?php echo $title_date?>: <input type="date" name="d_date" class="form_class" required=""  value="<?=date('Y-m-d');?>"/></span>
                            <span><?php echo $title_adres?>: <input type="text" name="t_adress" required="" class="form_class" size="40" maxlength="40" placeholder="улица, дом, квартира(опционально)" /></span>
                            <span><?php echo $title_phone;?>: <input type="tel" name="n_phone" pattern="[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}"  placeholder="7XXXXXXXXXX" maxlength="11" size="11" class="form_class" /></span>
                        </p>
                    <p id="second_block">   
                    <span><?php echo $title_type;?>: 
                        <select name="s_type" class="form_class">
                            <?php 
                                foreach($param_type as $type):?>     
                                    <option value="<?php echo $type['id'];?>"><?php echo $type['type'];?></option>
                                <?php endforeach; ?>
                        </select>
                    </span>
                    <span><?php echo $title_tarif;?>: 
                    <select name="t_tarif" class="form_class">
                        <?php
                            require_once 'tarif_functions.php';
                            load_tarifs();
                        ?>
                    </select>
                    </span>        
                    <span><?php echo $title_class;?>: 
                            <select name="s_class" class="form_class">
                                <?php
                                foreach ($param_class as $class): ?>
                                    <option value="<?php echo $class['id']; ?>"><?php echo $class['class'];?></option>
                                <?php  endforeach; ?>       
                            </select>
                    </span>   
                <span> <?php echo $title_time;?>: <input type="time" name="t_time" class="form_class"></span>
            </p>                         
            </center>
            <center> 
                <span><?php echo $title_description;?>: <input type="text" name="t_descr" class="form_class" size="100" maxlength="100"></span>
                <input type="submit" name="s_new" value="Добавить" class='btn btn-success btn-sm'>
            </center>
        </form>
        </div> 
    </body>
</html>