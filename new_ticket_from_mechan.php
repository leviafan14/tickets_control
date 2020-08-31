<?php
require_once 'check_session.php';
require_once 'tickets_title_name.php';
require_once'tickets_connect.php';
require_once'new_ticket_select.php';?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/request2_css.css">
    </head>
    <body>
        <center>
        <div class='d_new'>
            <table id="t_nav">
            <tbody>
                <tr><td class='td_nav'><a class='link_div' name="a_new_ticket" href='request1.php'>Заявки</a></td><td class='td_nav'><a name="a_statistics" class="link_div" href="statistics.php">Журнал</a></td><td class='td_nav'><a name="l_exit" class="link_div" href='exit_mechan.php'>Выход</a></td></tr>
            </tbody>
        </table> 
                <table id='t3'>
                    <form name="f_new" method="POST" action="new_ticket_back.php">
                        <tr><td><span> <?php echo $title_date?>:</td></tr>
                        <tr><td><input type="date" name="d_date" class="form_class" required=""  value="<?=date('Y-m-d');?>"/></span></td></tr>
                    <tr><td><span> <?php echo $title_time;?>:</td></tr>
                    <tr><td><input type="time" name="t_time" class="form_class"></span></td></tr>
                    <tr><td><span><?php echo $title_type;?>: </td></tr>
                    <tr><td><select name="s_type" class="form_class">
                            <?php 
                                foreach($param_type as $type):?>     
                                    <option value="<?php echo $type['id'];?>"><?php echo $type['type'];?></option>
                                <?php endforeach; ?>
                        </select>
                    </span></td></tr>
                    <tr><td><span><?php echo $title_tarif;?>:</td></tr>
                    <tr><td><select name="t_tarif" class="form_class">
                        <?php
                            require_once 'tarif_functions.php';
                            load_tarifs();
                        ?>
                    </select>
                    </span></td></tr>   
                    <tr><td><span><?php echo $title_class;?>:</td></tr>
                    <tr><td><select name="s_class" class="form_class">
                                <?php
                                foreach ($param_class as $class): ?>
                                    <option value="<?php echo $class['id']; ?>"><?php echo $class['class'];?></option>
                                <?php  endforeach; ?>       
                            </select>
                    </span></td></tr>
                    <tr><td><span><?php echo $title_phone;?>:</td></tr>
                    <tr><td><input type="tel" name="n_phone" pattern="[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}"  placeholder="7XXXXXXXXXX" maxlength="11" size="11" class="form_class" /></span></td></tr>
                    <tr><td><span><?php echo $title_adres?>:</td></tr>
                    <tr><td><input type="text" name="t_adress" required="" class="form_class" size="20" placeholder="улица дом-кв" /></span></td></tr>
                <tr><td><span><?php echo $title_description;?>:</td></tr>
                <tr><td><input type="text" name="t_descr" class="form_class" size="43"/></span></td></tr>
            </table>
            <input type="submit" id='s_new' name="s_new" value="Добавить" class='btn btn-success btn-sm'>
            </center>
        </form>
        </div> 
    </body>
</html>