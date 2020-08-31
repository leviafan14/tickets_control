<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/tick_mechan.css">
        <title>Поиск сотрудников</title>
    </head>
    <body>
    <center>
        <p class='a_navigate' style='margin-top:0px;padding-top:0px;'>Фильтр и поиск</p>
        <form name="f_filtr_m" method="POST" class="f_form" action="search_mech_back.php"/>
            <p>
                <?php echo $title_status_m;?>: 
                <select name="sct_status_filt" class="form_class">
                    <option value=0>Все</option>
                    <?php 
                        foreach($param_status as $status_m):?>     
                            <option value="<?php echo $status_m['id']; ?>"><?php echo $status_m['status'];?></option>
                        <?php endforeach;?>
                </select>
                <?php echo $title_category;?>:
                <select name="search_category" class="form_class">
                    <option value=0>Все</option>
                    <?php  
                    foreach($param_category as $category_srch):?>     
                        <option value="<?php echo $category_srch['id']; ?>"><?php echo $category_srch['title'];?></option>
                    <?php endforeach;?>
                </select>
                <select name="sct_search_mech" class="form_class">
                    <option value="-">-</option>
                     <?php 
                        require_once 'search_mechan_select.php';
                        foreach($param_search as $parameter):?>     
                        <option value="<?php echo $parameter['search_field']; ?>"><?php echo $parameter['parameter'];?></option>
                        <?php endforeach;?>
                </select>
                <input type="text" name="txt_srh_m" size="11" class="form_class"> 
                <input type="submit" name="s_search_m" value="Найти" class='btn btn-success btn-sm'>
            </p>
        </form>
    </center>    
    </body>
</html>