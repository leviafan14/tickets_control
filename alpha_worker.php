<?php 
require_once 'mechan_title_name.php';
require_once 'new_mechan_function.php';
require_once 'connect_mechan.php';
//Контроллер количества пользователей, если пользователь уже есть то скрипт не будет выполняться
$row_worker=$pdo->query("SELECT Number FROM t_mechan LIMIT 1");
$rc=$row_worker->rowCount();
if($rc>=1){
    echo "<h3>В таблице уже есть минимум один пользователь. Количество пользователей: ".$row_worker->rowcount()."</h3>";
    exit();
}
else{
//------------------------------------------------------------------------------
// Контроллер вызова функии добавления пользователя
if($_GET['c']=='true'){
    $fio_mech=htmlentities(trim($_POST['t_fio']));
    $phone_mech=htmlentities(trim($_POST['n_phone_mech']));
    $status_mech=1;
    $doc_mech=htmlentities(trim($_POST['t_doc']));
    $paswrd=trim($_POST['password_emplay']);
    $paswrd_emplay=password_hash($paswrd,PASSWORD_DEFAULT);
    $category=2;
    add_first_worker($fio_mech,$phone_mech,$status_mech,$doc_mech,$category,$paswrd_emplay);
// Контроллер вставки статусов заявок
    try{
        $s=$pdo->query("SELECT Id FROM ticket_status");
        $count_status=$s->rowCount();
    }
    catch (Exception $e) {
        echo "Не удалось получить информацию о статусах заявок </br>".$e;
        exit();
    }
    if($count_status==0){
        try{
            $s=$pdo->query("INSERT INTO ticket_status(Status,Priority) VALUES ('Не выполнена','default'),('Выполнена','default')");
        } 
        catch (Exception $e) {
             echo "Не удалось добавить статусы в таблицу </br>".$e;
             exit();
        }
    }
    else{}
// Контроллер вставки состояний заявок
    try{
        $s=$pdo->query("SELECT Id FROM ticket_state");
        $count_state=$s->rowCount();
    }
    catch (Exception $e) {
        echo "Не удалось получить информацию о состояниях заявок </br>".$e;
        exit();
    }
    if($count_state==0){
        try{
            $s=$pdo->query("INSERT INTO ticket_state(State,Priority) VALUES ('Отправлена','default'),('Не отправлена','default')");
        } 
        catch (Exception $e) {
             echo "Не удалось добавить состояния в таблицу </br>".$e;
             exit();
        }
    }
    else{}
// Контроллер вставки статусов сотрудников
    try{
        $s=$pdo->query("SELECT Id FROM status_mechan");
        $count_status_mechan=$s->rowCount();
    }
    catch (Exception $e) {
        echo "Не удалось получить информацию о статусах сотрудников </br>".$e;
        exit();
    }
    if($count_status_mechan==0){
        try{
            $s=$pdo->query("INSERT INTO status_mechan(Status,State) VALUES ('Доступен','Default'),('Не доступен','Ordinary')");
        } 
        catch (Exception $e) {
             echo "Не удалось добавить статусы в таблицу </br>".$e;
             exit();
        }
    }
    else{}
// Контроллер вставки Категорий сотрудников
    try{
        $s=$pdo->query("SELECT Id FROM category_employee");
        $count_categories=$s->rowCount();
    }
    catch (Exception $e) {
        echo "Не удалось получить информацию о категориях сотрудников </br>".$e;
        exit();
    }
    if($count_categories==0){
        try{
            $s=$pdo->query("INSERT INTO category_employee(Value,Title,Status) VALUES ('Mechanic','Механик','Default'),('Operator','Оператор','Default')");
        } 
        catch (Exception $e) {
             echo "Не удалось добавить категории в таблицу </br>".$e;
             exit();
        }
    }
    else{}
    header("Location:enter.php");
    exit();
}
else{}
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tick_mechan.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>Первый запуск</title>
    </head>
    <body style='padding:5px;'>
    <a href='enter.php' type='button' class='btn btn-outline-success'>Вход</a>
    <center>
        <h4>Страница первого запуска</h4>
        <h6>Добавить первого оператора</h6>
        <div class='d_new'>
            <form name="f_new" method="POST" action="alpha_worker.php?c=true">
            <p>
                <?php echo $title_fio; ?>:
                <input type="text" name="t_fio" class="form_class" required placeholder='Иванов И.И.'>
                <?php echo $title_phone_m; ?>:
                <input type="tel" name="n_phone_mech" required maxlength="11" size="11" placeholder='7XXXXXXXXXX' pattern="[0-9]{3}[0-9]{3}[0-9]{3}[0-9]{2}" class="form_class">
            </p>
            <p>
                <?php echo $title_numb_doc; ?>: <input type="text" name="t_doc" class="form_class" required="" placeholder='Используется как логин'>
                <?php echo $title_password_m; ?>: <input type="password" name="password_emplay" class="form_class" required>
                <input type="submit" name="s_new_mech" value="Добавить" class='btn btn-outline-primary'>
            </p>
        </form>
        </div>
        <h5 style="color:red;">После завершении работы данную страницу следует либо переместить либо удалить</h5>   
    </center>
    </body>
</html>