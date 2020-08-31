<?php 
require_once 'mechan_title_name.php';
require_once'load_mechan_functions.php';
//Вызов функции восстановления данных сотрудника
if(isset($_POST['id_worker'])and !empty($_POST['id_worker'])){
    restore_worker($_POST['id_worker']);
}
else{}
//Вызов функции восстановления категорий сотрудников
if(isset($_POST['restore_categories']) and !empty($_POST['restore_categories'])){
    restore_categories();
}
else{}
//Вызов функции восстановления статусов сотрудников
if(isset($_POST['restore_statuses']) and !empty($_POST['restore_statuses'])){
    restore_statuses();
}
else{}
//Вызов функции восстановления статусов заявок
if(isset($_POST['restore_statuses_tickets']) and !empty($_POST['restore_statuses_tickets'])){
    restore_statuses_tickets();
}
else{}
//Вызов функции восстановления состояний заявок
if(isset($_POST['restore_states_tickets']) and !empty($_POST['restore_states_tickets'])){
    restore_states_tickets();
}
else{}
if(isset($_POST['restore_all']) and !empty($_POST['restore_all'])){
    restore_all();
}
else{}
if(isset($_POST['delete_all_workers']) and !empty($_POST['delete_all_workers'])){
    delete_all_workers();
}
else{}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tab_tick_mech.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">       
        <title>Восстановление</title>
    </head>
    <body style="padding:10px;">        
    <a type="button" class="btn btn-outline-success"  href='enter.php'>Вход</a>
    <a type="button" class="btn btn-outline-success"  href='alpha_worker.php'>Добавить первого пользователя</a>
        <center>
            <h5 class="h5">Восстановление информации о сотрудниках</h5>
            <table class='table table-hover'>
                <thead class='a_navigate'>
                    <tr><td><?php echo $title_number_m;?></td><td><?php echo $title_fio;?></td>
                        <td><?php echo $title_phone_m;?></td><td><?php echo $title_status_m;?></td>
                        <td><?php echo $title_numb_doc;?></td><td><?php echo $title_password_m;?></td>
                        <td><?php echo $title_category;?></td>
                    </tr>
                </thead>
                <tbody>
                    <?php load_mechan_restore();?>
                </tbody>
            </table>
            <p><strong>*</strong> - Текущий параметр</p>
            <h5 class="h5">Восстановление параметров</h5>
            <table id="table_restore_parameters">
                <tbody>
                    <tr style='text-align:center'>
                        <td>
                            <form name="rest_categories" method="POST"action="restore.php">
                                <input type="submit" class="btn btn-outline-secondary" value="Восстановить статусы сотрудников">
                                <input type="hidden" value="restore_categories">
                            </form>
                        </td>
                        <td>
                            <form name="rest_statuses" method="POST"action="restore.php">
                                <input type="submit" class="btn btn-outline-secondary" value="Восстановить категории сотрудников">
                                <input type="hidden" value="restore_statuses">
                            </form> 
                        </td>
                    </tr>
                    <tr style='text-align:center'>
                        <td>
                            <form name="rest_statusues_tickets" method="POST"action="restore.php">
                                <input type="submit" class="btn btn-outline-secondary" value="Восстановить статусы заявок">
                                <input type="hidden" value="restore_stat_tickets">
                            </form>
                        </td>
                        <td>
                            <form name="rest_states_tickets" method="POST"action="restore.php">
                                <input type="submit" class="btn btn-outline-secondary" value="Восстановить состояния заявок">
                                <input type="hidden" value="restore_states_tickets">
                            </form> 
                        </td>
                    </tr>
                    <tr style='text-align:center'>
                        <td>
                            <form name="rest_states_tickets" method="POST"action="restore.php">
                                <input type="submit" class="btn btn-outline-secondary" value="Восстановить все параметры">
                                <input type="hidden" name='restore_all' value="restore_all">
                             </form>
                        </td>
                        <td>
                            <form name="rest_all_workers" method="POST"action="restore.php">
                                <input type="submit" class="btn btn-outline-secondary" value="Удалить всех сотрудников">
                                <input type="hidden" name='delete_all_workers' value="delete_all_workers">
                             </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
    </body>
</html>