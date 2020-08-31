<?php 
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset=utf-8">
        <link rel="stylesheet" href="css/tick_mechan.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>Редактирование сотрудника</title>
<?php
require_once 'check_session.php';
require_once 'edit_mechan_back.php';
require_once 'mechan_title_name.php';
require_once 'load_mechan_functions.php';
?>
    </head>
    <body>
    <center>
        <p>Изменение данных сотрудника</p>
        <form name="f_edit_mech" method="POST" action="append_mech_back.php">
        <input type='hidden' name='empl_id' value=<?php echo $_GET['id_m'];?>>
            <p>
                <?php echo $title_fio;?>: <input type="text" class="form_class" required name="t_fio" value="<?php echo display_name($doc_m);?>">
                <span>
                    <?php echo $title_phone_m;?>: <input type="tel" required class="form_class" name="n_phone_mech" maxlength="11" size="11" pattern="[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}" value="<?php echo display_phone($doc_m);?>">
                </span>
            </p>
            <p>
                <?php echo $title_status_m;?>: 
                <select name="s_status_mech" class="form_class">
                    <?php foreach($result_load_status as $current_status):?>
                        <option style='background:#F8F8FF;color:#E6E6FA;' value="<?php echo $current_status['id'];?>"><?php echo $current_status['status'];?></option>
                     <?php endforeach;?>        
                    <?php 
                        foreach($param_status as $status):?>     
                        <option value="<?php echo $status['id'];?>"><?php echo $status['status'];?></option>
                    <?php endforeach;?>
                </select>
                <?php echo $title_category;?>:
                <select name="slt_category" class="form_class">
                    <?php 
                        foreach($result_check_category as $current_category):?>     
                             <option style='background:#F8F8FF;color:#E6E6FA;' value="<?php echo $current_category['id'];?>"><?php echo $current_category['title'];?></option>
                        <?php endforeach; 
                        foreach($param_category as $category):?>     
                            <option value="<?php echo $category['id'];?>"><?php echo $category['title'];?></option>
                        <?php endforeach;?>
                </select>
            </p>
            <p>
                <?php echo $title_numb_doc; ?>:
                <input type="text" class="form_class" name="t_doc" required value="<?php echo "$doc_m";?>">
                <?php echo $title_password_m;?>:
                <input type="text" class="form_class"  name="t_pswrd" value="" placeholder="только новый пароль">
                <label for='cb_pswrd' class="sms_label"><a title='Выслать новый пароль смс-сообщением'>СМС<input type='checkbox' name='cb_pswrd' value='send'></a></label>
                <input type="submit" class="btn btn-outline-success btn-sm" name="s_new_mech" value="Применить">
                <a class="btn btn-outline-secondary btn-sm" href="all_mechan.php">Отмена</a>
            </p>
        </form>
    </center>    
    </body>  
</html>