<?php
    require_once "check_session.php";
    require_once "tickets_title_name.php";
    if(!isset($_GET['numb'])){
        echo "Отсутствует номер заявки";
        exit();
    }
    else{}
    $numb_ticket=$_GET['numb'];
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/request2_css.css">
        <title>Заявка</title>
    </head>
    <body>
        <center>
            <form action="complate_ticket.php" method="POST">
            <input type="hidden" name="check" value="func">
            <input type="hidden" name="numb" value="<?php echo $alpha;?>">
            <table id="t2">
            <tbody>
                <?php
                    require 'connect_mechan.php';
                    require_once 'functions_request.php';
                    $alpha=$_GET['numb'];
                ?>
                <input type="hidden" name="check" value="func">
                <input type="hidden" name="numb" value="<?php echo $alpha;?>">
                <?php
                    try{
                        $s=$pdo->prepare("SELECT Number,Type,Class,State,Status,Tarif,Date,Create_user FROM atable WHERE Number=:alpha LIMIT 1");
                        $s->bindValue(':alpha',$alpha);
                        $s->execute();
                    } 
                    catch (PDOException $ex) {
                        echo "Ошибка получения данных";
                        exit();
                    }
                     foreach($s->fetchAll() as $row )
                    {
                        echo 
                        "<tr>"."<td>"."$title_number_t: "."<td>".$row['Number']."</td>"."</tr>".
                        "<tr>"."<td>"."$title_type: "."</td>"."<td>".display_type($row['Type'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_class: "."</td>"."<td>".display_class($row['Class'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_state: "."</td>"."<td>".display_state($row['State'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_phone: "."</td>"."<td>".display_phone($row['Number'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_status: "."</td>"."<td>".display_status($row['Status'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_adres: "."</td>"."<td>".display_adress($row['Number'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_tarif: "."</td>"."<td>".display_tarif($row['Tarif'])."</td>"."</tr>".
                        "<tr>"."<td>"."$title_time: "."</td>"."<td>".display_time($row['Number'])."</td>"."</tr>".        
                        "<tr>"."<td>"."$title_date: "."</td>"."<td>".$row['Date']."</td>"."</tr>";
                        if ($_SESSION['login']==$row['Create_user']){
                            echo "<tr><td>"."$title_create_user_tickets: "."</td><td><a id='a_crte_usr' href='check_user_platform.php?event=edit&id_t=$numb_ticket'>".display_create_ticket_user($row['Create_user'])."</a></td></tr>";
                        }
                        else{
                            echo "<tr>"."<td>"."$title_create_user_tickets: "."</td>"."<td>".display_create_ticket_user($row['Create_user'])."</td>"."</tr>";
                        }
                    "<tr><td colspan='2'><span id='empty_div'></span></td></tr>"; 
                    }
                    $descript=display_description($row['Number']);
                ?>
            </tbody>
            </table>
        <span class='description'>Описание: </span>    
        <div class='ta_descript'>
            <textarea  name='ta_descript'id='ta_descript' rows='3' readonly="false"><?php echo $descript; ?></textarea>
        </div>
        <?php 
            if($_GET['vw']=='y'):?>
                 <div style='border:1px solid #FFE4C4;border-radius:20px;width:40%;background-color:#FFE4C4;text-align:center;height:31px;font-size:18px;margin-top:5px;padding-top:5px;'
                   id='d_back'><a href='statistics.php' id='a_back'><span id='s_back'style='font-size:16px;width:100%;font-family:arial;'>Назад</span></a></div>
            <?php
                exit();
            ?>
        <?php else:?>
        <input type="text" name="t_comment" id="t_comment" placeholder="Примечание сотрудника">
        <table style="width:100%; text-align: center;">
            <tbody>
                <tr><td><input type="submit" class="ok_button" id='complate' name="complete" value="Выполнена"></form></td></tr>        
            </tbody>
        </table> 
       <div style='border:1px solid #FFE4C4;border-radius:20px;width:40%;background-color:#FFE4C4;text-align:center;height:31px;font-size:18px;margin-top:5px;padding-top:5px;'
       id='d_back'><a href='request1.php' id='a_back'><span id='s_back'style='font-size:16px;width:100%;font-family:arial;'>Назад</span></a></div>
       <?php endif; ?>
        </center>    
    </body>
</html>