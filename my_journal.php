 <?php
    require_once 'functions_journal.php';
    require_once "tickets_title_name.php";
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <meta charset=utf-8">
        <link rel="stylesheet" href="css/statistics_css.css">
        <title>Мой журнал</title>
    </head>    
    <body>
        <center>
            <table id="nav_stat">
                <tbody>
                    <tr><td class="td_nav_stat"><a href="statistics.php">Журнал</a></td><td class="td_nav_stat"><a href="request1.php">Заявки</a></td></tr>
                </tbodyY>
            </table>
            <p id="p_stat_mechanic"><b>Cотрудник: </b><?php echo $fio_mechanic; ?></p>
            <table id="t_list_yes" class="table_stat">
                <caption id="caption_list" class="t_caption"><b>Список выполненных заявок:</b></caption>
                <thead id="th_list"><tr><td class='td_body'><b><?php echo $title_adres; ?></b></td><td class='td_type'><b><?php echo $title_type; ?></b></td></tr></thead>
                <tbody id="tb_list">
                <?php
                  personal_list($date,$fio_mechanic);
                  ?>
                </tbody>
            </table>
        </center>
    </body>
</html>