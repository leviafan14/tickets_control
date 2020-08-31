<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/tab_tick_mech.css">
        <title>Помощь</title>
        <?php
$type=$_GET['t'];
if ($type=='s'){
    $type='status';
}
if ($type=='c'){
    $type='category';
}
function action_default_category($type){
    echo 
    "<center>"
    ."<h3 style='font-family: serif;color:#696969;'>"
    . "Категории и параметры по-умолчанию(Default) изменить и удалить нельзя</h3>
    </center>";
    echo "<div style='margin:10px;'>
                <h3 style='font-family: serif;color:#696969;'>
                    Категории учётных записей могут иметь один из двух статусов:
                </h3>    
            <ul style='font-family: serif;font-size:14px;color:#696969;'>
                <li>
                    Default(по-умолчанию);
                </li>
                <li>
                    Ordinary(обычный).
                </li>
            </ul>
            <span style='font-family: serif;font-size:14px;color:#696969;'>
                Учётные записи и параметры со статусом Default нельзя удалить или изменить. 
                Так как,они напрямую используются во многих <br> функциях 
                приложения и их отсутсвие либо изминение приведёт к 
                многочисленным сбоям.</span><br>
            <p>
               <a style='
                   background-color: #F0E68C;border:1px solid #F0E68C;
                    border-radius: 20px;font-family: serif;font-size:14px;
                    color:#696969;text-decoration:none;margin:5px;padding:3px;'
                    href=manage_param_mechan.php?parameter=$type>
                    Мне всё понятно</a>
            </p>
        </div>";
    exit();
}
?>
    </head>
    <body>
        <?php action_default_category($type); ?>;
    </body>
</html>