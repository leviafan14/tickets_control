<?php 
require_once 'check_session.php';
require_once 'tickets_connect.php'; ?>
<!DOCTYPE html>
<html lang="ru"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/parameters_css.css">
        <title>Управление смс-профилями</title>
    </head>
    <body>
    <div><a href="all_tickets.php" class='a_menu_link'>Заявки</a><a href="parameters_controller_menu.php?param=tickets" class='a_menu_link'>Назад</a></div>
    <center>
    <div id="main_div" class="div_param">    
        <form method="POST" action="smsprofile_controller.php" class="f_param">
            <input type="hidden" name="hidden_new" value="new">
            <p><input type="text" required class="text" name="t_title" placeholder="Название профиля"></p>
            <p><input type="text" class="text" required name="t_login" placeholder="логин">
            <input type="text" class="text" required name="t_password" placeholder="пароль"></p>
            <p><input type="submit" value="OK" class="button"></p>
        </form>
        <?php
        try{
            $session_query="SELECT * FROM smsprofiles";
            foreach($pdo->query($session_query) as $profile): ?>
            <form method="POST" action="smsprofile_controller.php" class="f_param">
                    <input type="hidden" name="hidden_edit" value="edit">
                    <input type="hidden" name="hidden_id" value="<?php echo $profile['id'];?>">
                    <p><input type="text" required class="text" name="t_title" value="<?php echo $profile['title'];?>">   
                    <select name="s_status" id="s_status" class="form_select">
                        <option style='background:#F8F8FF;color:#E6E6FA;' value="<?php echo $profile['status']; ?>"><?php if($profile['status']=='default'){echo 'по умолчанию';} else echo'резервный';?></option>
                        <option  value="nodefault">резервный</option>
                        <option  value="default">по умолчанию</option>
                </select></p> 
                    <p><input type="text" class="text" required name="t_login" value="<?php echo $profile['login'];?>">
                    <input type="text" class="text" required name="t_password" value="<?php echo $profile['password'];?>"></p>
                    <a href="smsprofile_controller.php"></a>
                    <?php if($profile['status']=='default'){
                        require_once 'smsc_api.php';
                        get_balance();
                    }
                    ?>
                    <p><input type="submit" value="OK" class="button"><a href="smsprofile_controller.php?trigger=delete&a_id=<?php echo $profile['id'];?>"name="a_id">Удалить</a></p>
                </form>
            <?php endforeach;
        }
        catch (Exception $ex) {
            echo "Ошибка получения данных  смс-профилей";
            exit();    
        }
        ?>
    </div>    
    </center>    
    </body>    
</html>