<?php
    require_once 'tickets_connect.php';
    require_once 'tarif_functions.php';
    if (isset($_POST['edit']) && $_POST['edit']==true){
        edit_tarif($_POST['price'], $_POST['description'], $_POST['id']);
    }
    if (isset($_POST['new']) && $_POST['new']==true){
        insert_tarif($_POST['price'], $_POST['description']);
    }
    if(isset($_GET['type_link']) && $_GET['trigger']=='delete'){
        delete_tarif($_GET['a_id']);
    }
?>
<!DOCTYPE html>
 <html lang="ru">
     <head>
        <title>Тарифы</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/parameters_css.css">
     </head>
     <body>
            <a href="all_tickets.php" class='a_menu_link'>Заявки</a>
            <a href="parameters_controller_menu.php?param=tickets" class='a_menu_link'>Назад</a>
        <center>
        <h5>При удалении тарифа удаляются все заявки с этим тарифом</h5>
        <div id="div_other" class="div_param">
            <form name='f_new_param' class="f_param" action="tarif_param.php" method="POST">
                <input type="text" class="text" name="price" required placeholder='Стоимость'>
                <input type="text" name="description" class="text" required placeholder='Название'>
                <input type="hidden" name="field" value="tarif">
                <input type="hidden" name="new" value="true">
                <p><input type="submit" value="OK" class="button"></p>
            </form>
            <?php 
                try{
                    $tick_query="SELECT * FROM Tarifs";
                    $result=$pdo->prepare($tick_query);
                    $result->execute();
                }
                 catch (PDOException $ex) {
                    echo "Ошибка получения информации о тарифах";
                    exit();
                }
                foreach($result->fetchAll() as $tarif):?>
                    <form name="f_manage_tarif" class="f_param" action="tarif_param.php" method="POST">
                        <input type="text" name="price" class="text" required value="<?php echo $tarif['Price'];?>">
                        <input type="text" name="description" class="text" required  value="<?php echo $tarif['Description'];?>">
                        <input type="hidden" name="id" value="<?php echo $tarif['Id'];?>">
                        <input type="hidden" name="edit" value="true" />
                        <p>
                            <input type="submit" value="OK" class="button">
                            <a href="tarif_param.php?trigger=delete&a_id=<?php echo $tarif['Id'];?>&type_link=tarif" name="a_id">Удалить</a>
                        </p>
                </form>
           <?php endforeach;?>
        </div>
        </center>        
    </body>     
</html>