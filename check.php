<?php
session_start();
require_once 'tickets_connect.php';
$_SESSION['login']=htmlentities($_POST['t_login']);;
$_SESSION['password']=htmlentities($_POST['t_pass']);
if(isset($_SESSION['login']) && isset($_SESSION['password']))
{
    $login=trim($_SESSION['login']);
    $password=trim($_SESSION['password']);
    if(empty($login) || empty($password)){   
        echo "Заполните все поля";
        exit();
    }
    else{}
    try{
        $s=$pdo->prepare("SELECT Login, paswrd, Category FROM mlogns WHERE Login=:login");
        $s->bindValue(':login',$login);
        $s->execute();
    }               
    catch (PDOException $ex){
        echo "Не удалось получить данные $ex";
        exit();
    }
    foreach($s->fetchAll() as $data){}
    $_SESSION['category']=$data['Category'];
    if($login==$data['Login'] and password_verify($password,$data['paswrd'])){
        if($data['Category']==2){
            header("location:all_tickets.php");
            exit();
        }
        else{}
        if ($data['Category']==1) {
            header("location:request1.php");
            exit();
        }
        else{}
    }
    else{
            echo "<center> <div class='d_check'> Вы указали</br>логин: <strong><span class='sloginpwd'>$login</span></strong></br>пароль: <strong><span class='sloginpwd'>$password</span></strong></br>"; 
        }
}
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/enter_css.css">
    </head>
    <body>
                <p>
                    <a href='enter.php'>Повторить попытку</a>
                </p>
        </center>
        </div>
    </body>
</html>
<?php  exit();?>