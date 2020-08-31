<?php 
require_once 'tickets_title_name.php';
require_once 'mechan_title_name.php';
?>
<!DOCTYPE html>
<html lang="ru"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=deivce-wdith, initial-scale=1.0">
        <link rel="stylesheet" href="css/parameters_css.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <title>Параметры</title>
    </head>
<?php
$param=$_GET['param'];
if($param=='tickets'):?>
    <body>
        <a href="all_tickets.php" class='a_menu_link'>Заявки</a>
    <center>
        <div id="d_main">
            <div id="d_parameters" > 
                <div id="div_type" class="div_search_param">
                    <a href="manage_parameters_t.php?param=type"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_type;?></h3></a>
                </div>
                <div id="div_class" class="div_search_param">
                    <a href="manage_parameters_t.php?param=class"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_class;?></h3></a>
                </div>
                <div id="div_status" class="div_search_param">    
                    <a href="manage_parameters_t.php?param=status"><h3 class="btn btn-outline-info btn-lg" ><?php echo $title_status;?></h3></a>
                </div>    
                <div id="div_state" class="div_search_param">
                    <a href="manage_parameters_t.php?param=state"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_state;?></h3></a>
                </div>
                 <div id="div_tarif" class="div_search_param">
                     <a href="tarif_param.php?param=tarif"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_tarif?></h3></a>
                </div>
                <div id="div_search" class="div_search_param">
                    <a href="search_param.php"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_search;?></h3></a>
                </div>  
                <div id="div_profiles" class="div_search_param">
                    <a href="smsprofiles.php"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_profiles;?></h3></a>
                </div>  
            </div> <!--Конец d_parameters -->
        </div>  <!--Конец d_main -->
    </center>    
    </body>
<?php endif;?>
<?php if($param=='mechan'):?>  
    <body>
        <a href="all_mechan.php" class='a_menu_link'>Сотрудники</a><a href="all_tickets.php" class='a_menu_link'>Заявки</a>
    <center>
        <div id="d_main">
            <div id="d_parameters" > 
                <div id="div_status" class="div_search_param">    
                    <a href="manage_param_mechan.php?parameter=status"><h3 class="btn btn-outline-info btn-lg" ><?php echo $title_status_m;?></h3></a>
                </div>  
                <div id="div_search" class="div_search_param">
                    <a href="manage_param_mechan.php?parameter=search"><h3 class="btn btn-outline-info btn-lg"><?php echo $title_search;?></h3></a>
                </div>
                <div id="div_category" class="div_search_param">    
                    <a href="manage_param_mechan.php?parameter=category"><h3 class="btn btn-outline-info btn-lg" ><?php echo $title_category;?></h3></a>
                </div>
            </div> <!--Конец d_parameters -->
        </div>  <!--Конец d_main -->
    </center>    
    </body>
<?php endif;?>    
</html>   