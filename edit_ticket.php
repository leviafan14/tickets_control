<?php 
    require_once 'check_session.php';
    require_once 'tickets_title_name.php';
    require_once 'edit_ticket_select.php';
    require_once 'tarif_functions.php';
    require_once 'edit_ticket_back.php';
    require_once 'edit_ticket_function.php';
    $login=trim($_SESSION['login']);
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/tick_mechan.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>Изменить</title>
    </head>
    <body>
        <?php $n_tick=$number_t;?>
    <center>
        <p>Редактировать заявку № <?php echo $number_t;?></p>
        <form name="f_edit" method="POST" action="append_edit_back.php?id_tick=<?php echo "$n_tick";?>">
            <p>
                <?php echo $title_type;//Тип заявки ?>: 
                <select name="sct_type" class="form_class">
                   <?php display_type($type_t);?>
                    <?php foreach($param_type as $type):?>     
                    <option value="<?php echo $type['id'];?>"><?php echo $type['type'];?></option>
                    <?php endforeach;?>
                </select> 
<!---------------------------------------------------------------------------->
                <?php echo $title_class;//Класс заявки?>:
                <select name="sct_class" check="2" class="form_class">
                    <?php display_class($class_t);?>
                    <?php foreach($param_class as $class):?>     
                    <option value="<?php echo $class['id']; ?>"><?php echo $class['class'];?></option>
                    <?php endforeach;?>
                </select>
            </p>
            <p>
<!---------------------------------------------------------------------------->                
                <?php echo $title_state; //Состояние заявки?>: 
                <select name="sct_state" class="form_class">
                    <?php 
                     display_state($state_t);
                     foreach($param_state as $state):?>     
                    <option value="<?php echo $state['id'];?>"><?php echo $state['state'];?></option>
                    <?php endforeach;?>
                </select> 
<!---------------------------------------------------------------------------->                
                <?php //Вывод телефона абонента
                echo $title_phone.":".display_phone($number_t);?>
            </p>
<!---------------------------------------------------------------------------->            
            <p>
                <?php  //Тариф абонента 
                echo $title_tarif;?>:
                <select name="t_tarif" class="form_class">
                    <?php
                        display_tarif($tarif_t);
                        load_tarifs();
                    ?>
                </select> 
<!---------------------------------------------------------------------------->                
                <?php //ВЫвод адреса заявки
                echo $title_adres; ?>:
                <input type="text" class="form_class" name="txt_adress" size="40" maxlength="40" required value="<?php echo display_ticket_adress($number_t);?>">
            </p>
<!---------------------------------------------------------------------------->            
            <p>
                <?php //Вывод описания заявки
                echo $title_description.":";display_description($number_t);?>  
            </p>
<!---------------------------------------------------------------------------->            
            <p>
                <?php // Вывод времени заявки
                $time_date=display_time($number_t);
                echo $title_time.":";?>
                <input type='time' name='t_time' class='form_class' value="<?php echo $time_date['time'];?>"> 
<!---------------------------------------------------------------------------->                
                <?php // Вывод даты заявки
                echo $title_date;?>:
                <input type="date" class="form_class" name="dte_date" required value="<?php echo $date_t;?>">
<!---------------------------------------------------------------------------->                
                <?php echo $title_status;//Статус заявки?>: 
                <select class="form_class" name="sct_status">
                    <?php display_status($status_t);?>
                    <?php foreach($param_status as $status):?>     
                    <option value="<?php echo $status['id'];?>"><?php echo $status['status'];?></option>
                    <?php endforeach;?>
                </select>
                <?php // Вывод  ФИО сотрудника, выполневшего заявку
                echo $title_complete;?>:
                <select class="form_class" name="sct_mechan">
                    <?php
                        display_employee($employee_t,$status_t,$user['id_worker']);
                    foreach($fio as $user):?>  
                        <option name="n_worker" value="<?php echo $user['id_worker'];?>"><?php echo $user['name'];?></option>
                    <?php endforeach;?>
                </select>
                <?php echo $title_date_check;?>:
                <input type="date" class="form_class" name="dte_date_check" value="<?php echo $time_date['date_check'];?>">
                 <?php echo $title_create_user_tickets;?>:
                <input type="text" disabled class="form_class" name="usr_crte_tick" value="<?php echo $row['Name'];?>">
            </p>
            <input type="submit" class="btn btn-outline-success btn-sm" name="s_new" value="Применить">
            <a class="btn btn-outline-secondary btn-sm" href="all_tickets.php">Отмена</a>
        </form>
        </center>     
    </body>
</html>