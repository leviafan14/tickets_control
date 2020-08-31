<?php 
    require_once 'check_session.php';
    require_once 'tickets_title_name.php';
    require_once 'edit_ticket_select.php';
    require_once 'tarif_functions.php';
    require_once 'edit_ticket_back.php';
    require_once 'edit_ticket_function.php';
    $login=trim($_SESSION['login']);
    if ($_SESSION['login']!=$r_ticket['Create_user']){
        header("location:request1.php");
        exit();
    }
    echo $r_ticket['otv_mechan'];
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/request2_css.css">
        <title>Изменить</title>
    </head>
    <body>
        <?php $n_tick=$number_t;?>
    <center>
        <div style="width:100%;">
        <form name="f_edit" method="POST" action="append_edit_back.php?id_tick=<?php echo "$n_tick";?>">
            <table id="t2">
                <tbody>
                <tr><td>
                    <?php echo $title_number_t.":";?>
                </td></tr>
                <tr><td>
                <input type='text' disabled value="<?php echo $number_t;?>"/>
                </td></tr>
                <tr><td><?php echo $title_type;//Тип заявки ?>:</td></tr>
                <tr><td>
                   <select name="sct_type" class="form_class">
                       <?php display_type($type_t);?>
                        <?php foreach($param_type as $type):?>     
                            <option value="<?php echo $type['id'];?>"><?php echo $type['type'];?></option>
                        <?php endforeach;?>
                    </select>
                </td></tr>
                <tr><td>
                    <?php echo $title_class.":";//Класс заявки?>
                </tr></td>
                <tr><td>
                    <select name="sct_class" check="2" class="form_class">
                        <?php display_class($class_t);?>
                        <?php foreach($param_class as $class):?>     
                            <option value="<?php echo $class['id']; ?>"><?php echo $class['class'];?></option>
                        <?php endforeach;?>
                    </select>
                </td></tr>
                <tr><td>
                    <?php echo $title_state.":"; //Состояние заявки?>
                </td></tr>
                <tr><td>
                    <select name="sct_state" class="form_class">
                        <?php display_state($state_t);
                        foreach($param_state as $state):?>     
                            <option value="<?php echo $state['id'];?>"><?php echo $state['state'];?></option>
                        <?php endforeach;?>
                    </select> 
                </td></tr>  
               <tr><td>
                   <?php //Вывод телефона абонента
                    echo $title_phone.":";?>
                </td></tr>
                <tr><td>
                    <?php echo display_phone($number_t);?>
                </td></tr>
                <tr><td>
                    <?php  //Тариф абонента 
                        echo $title_tarif;?>:
                </td></tr>
                <tr><td>
                    <select name="t_tarif" class="form_class">
                        <?php
                            display_tarif($tarif_t);
                            load_tarifs();?>
                </select> 
                </td></tr>
                <tr><td>
                    <?php //ВЫвод адреса заявки
                        echo $title_adres; ?>:
                </td></tr>
                <tr><td>
                    <input type="text" class="form_class" name="txt_adress" size="40" maxlength="40" required value="<?php echo display_ticket_adress($number_t);?>">
                </td></tr>
                <tr><td>
                    <?php //Вывод описания заявки
                        echo $title_description.":";?>  
                </td></tr>
                <tr><td>
                    <?php echo display_description($number_t);?>
                </td></tr>
                <tr><td>
                    <?php // Вывод времени заявки
                        $time_date=display_time($number_t);
                        echo $title_time.":";?>
                </td></tr>
                <tr><td>
                    <input type='time' name='t_time' class='form_class' value="<?php echo $time_date['time'];?>"> 
                </td></tr>
                <tr><td>
                    <?php // Вывод даты заявки
                        echo $title_date.":";?>
                </td></tr>
                <tr><td>
                    <input type="date" class="form_class" name="dte_date" required value="<?php echo $date_t;?>">
                </tr></td>
                <tr><td>
                    <?php echo $title_status.":";//Статус заявки?>
                </td></tr>
                <tr><td>
                <select class="form_class" name="sct_status">
                    <?php display_status($status_t);?>
                    <?php foreach($param_status as $status):?>     
                        <option value="<?php echo $status['id'];?>"><?php echo $status['status'];?></option>
                    <?php endforeach;?>
                </select>
                </td></tr>
                <tr hidden><td>
                    <?php // Вывод  ФИО сотрудника, выполневшего заявку
                        echo $title_complete.":";?>
                </td></tr>
                <tr hidden><td>
                    <select class="form_class" disabled hidden name="sct_mechan">
                        <?php
                            display_employee($employee_t,$status_t,$user['id_worker']);
                    foreach($fio as $user):?>  
                        <option name="n_worker" value="<?php echo $user['id_worker'];?>"><?php echo $user['name'];?></option>
                    <?php endforeach;?>
                    </select>
                </td></tr>
                <tr hidden><td>
                    <?php echo $title_date_check.":";?>
                </td></tr>
                <tr hidden><td>
                    <input type="date" disabled hidden class="form_class" name="dte_date_check" value="<?php echo $time_date['date_check'];?>">
                </td></tr>
                <tr hidden><td>
                    <?php // Вывод имени сотрудника добавившего заявку
                        echo $title_create_user_tickets.":";?>
                </td></tr>
                <tr hidden><td>
                    <input type="text" disabled hidden class="form_class" name="usr_crte_tick" value="<?php echo $row['Name'];?>">
                </td></tr
                </tbody>
                </table>
        <table>
            <tbody>
            <tr>
            <td>
                <div style='width:100%;'>
                    <input type="submit" class="ok_button" id='append' name="append" value="Применить"/>
                </div>
            </td>
            <td>
                <div style='width:100%;'>
                    <form method='GET' action='request1.php'/>
                        <input type="submit" class="ok_button" id='b_cancel' name="b_cancel" value="Отменить"/>
                    </form>
                </div>
            </td>
            </tr>
            </tbody>
        </table>
        </form>
         </center>
        </div>
    </body>
</html>