<?php require 'new_mechan_select.php';?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tick_mechan.css">
        <title>Новый сотрудник</title>
    </head>
    <body>
    <center>
        <div class='d_new'>
        <form name="f_new" method="POST" action="new_mechan_back.php">
            <p>
                <?php echo $title_fio; ?>:
                <input type="text" name="t_fio" class="form_class" required placeholder='Иванов И.И.'>
                <?php echo $title_phone_m; ?>:
                <input type="tel" name="n_phone_mech" required maxlength="11" size="11" placeholder='7XXXXXXXXXX' pattern="[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}" class="form_class">
                <?php echo $title_status_m; ?>:
                <select name="s_status_mech" class="form_class" required>
                    <?php  
                        foreach($param_status as $status):?>     
                            <option value="<?php echo $status['id']; ?>"><?php echo $status['status'];?></option>
                        <?php endforeach; ?>
                </select>
            </p>
            <p>
                <?php echo $title_numb_doc; ?>: <input type="text" name="t_doc" class="form_class" required placeholder='Используется как логин'>
                <?php echo $title_password_m; ?>: <input type="text" name="t_pass" class="form_class" required>
                <?php echo $title_category; ?>:
                <select name="s_category" class="form_class" required>
                        <?php  
                        foreach($param_category as $category):?>     
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['title'];?></option>
                        <?php endforeach; ?>
                </select>
                <label for='cb_sms' class="sms_label"><a title='Выслать логин и пароль смс-сообщением'>СМС<input type='checkbox' id='cb_sms' name='cb_sms' value='send'></a></label>
                <input type="submit" name="s_new_mech" value="Добавить" class='btn btn-success btn-sm'>
            </p>
        </form>
        </div>    
    </center>
    </body>
</html>