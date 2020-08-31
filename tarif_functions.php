<?php
require_once 'tickets_connect.php';
//Функция загрузки тарифов
function load_tarifs(){
    require 'tickets_connect.php';
    global $pdo;
    try{
        foreach($pdo->query("SELECT Id,Price FROM Tarifs") as $row){
            if ($row['Price']==0){
                 echo "<option value=".$row['Id'].">не указан</option>";
            }
            else{
                echo "<option value=".$row['Id'].">".$row['Price']."</option>";
            }
        }    
    }                   
    catch (PDOException $e) {
        echo "Ошибка получения информации о тарифах";
        exit();    
    }   
} 
//Функция добавления тарифа
function edit_tarif($price,$description,$id){
    require'tickets_connect.php';
    try{
        $s=$pdo->prepare("UPDATE Tarifs SET Price=:price,Description=:description WHERE Id=:id");
        $s->bindValue(':price',$price);
        $s->bindValue(':description',$description);
        $s->bindValue(':id',$id);
        $s->execute();
    }
    catch (PDOException $e) {
        echo "Ошибка обновления информации о тарифе";
        exit();
    }
}
//Функция добавления тарифа
function insert_tarif($price,$description){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("INSERT INTO Tarifs(Price,Description) VALUES (:price,:description)");
        $s->bindValue(':price',$price);
        $s->bindValue(':description',$description);
        $s->execute();
    }
    catch (PDOException $e) {
        echo "Ошибка добавления тарифа";
        exit();
    }
}
//Функция удаления тарифа и всех связанных с ним записей
function delete_tarif($id){
    require 'tickets_connect.php';
    try{
        $s=$pdo->prepare("DELETE FROM Tarifs WHERE Id=:id LIMIT 1");
        $s->bindValue(':id',$id);
        $s->execute(); 
    }
    catch(PDOException $e){
        echo "Ошибка удаления тарифа $id";
    }
    //Удаление всех записей с выбранным тарифом
    try{
        $s=$pdo->prepare("DELETE FROM atable WHERE Tarif=:id");
        $s->bindValue(':id',$id);
        $s->execute(); 
    }
    catch(PDOException $e){
        echo "Ошибка удаления тарифа $id";
        exit();
    }
}
?>