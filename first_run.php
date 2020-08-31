<?php
//Контроллер количества пользователей, если пользователей нет, то перееадресация на страницу добавления первого пользователя
require_once 'connect_mechan.php';
$row_count=$pdo->query("SELECT Number FROM t_mechan");
$row_count->execute();
$row_users=$row_count->rowcount();
if($row_users<1){
    require_once ("alpha_worker.php");
}
else{
    //header("location:enter.php");
    //exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title>Первый запуск</title>
    </head>
    <body>
        <div id="div_status" class="div_param">
                <form name='f_new_status' class="f_param" action="" method="POST">
                    <p>Добавить статусы заявок по умолчанию
                    <input type="submit" value="Добавить" class="button"></p>
                </form>
        </div>    
    </body>
</html>