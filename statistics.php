<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset=utf-8">
        <link rel="stylesheet" href="css/statistics_css.css">
        <title>Журнал</title>
        <?php 
        require_once "check_session.php";
        require_once 'functions_statistics.php';
        require_once "tickets_title_name.php";
        ?>
    </head>
    <body>
        <center>
        <table id="nav_stat">
            <tbody>
                <tr><td class="td_nav_stat"><a href="request1.php">Заявки</a></td><td id="td_nav_stat" class="td_nav_stat"><a href="my_journal.php" >Мой журнал</a></td></tr>
            </tbody>    
        </table>
            <p id="p_stat"><b>Статистка на </b><?php echo $date;?></p>    
        <table id="t_stat_no" class="table_stat">
            <tbody>
                <tr>
                    <td id="caption_no" class="t_caption">
                    <b>Количество невыполненных заявок: 
                    <?php echo "$result_no";?></b>
                    </td>
                </tr>
                <tr>
                    <td id="caption_yes" class="t_caption">
                        <b>Количество выполненных заявок:</b>
                        <?php echo "$result_yes";?>
                    </td>
                </tr>
            </tbody>
        </table>
        <table id="t_list_yes" class="table_stat">
            <caption id="caption_list" class="t_caption"><b>Список выполненных заявок:</b></caption>
            <thead id="th_list"><tr><td class='td_body'><b><?php echo $title_adres; ?></b></td><td class='td_type'><b><?php echo $title_type; ?></b></td></tr></thead>
            <tbody id="tb_list">
                <?php display_checked_tickets(date('d.m.Y'));?>
            </tbody> 
        </table>
        </center>
    </body>
</html>