<?php require 'search_ticket_select.php';?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/tick_mechan.css">
    </head>
    <body>
    <center>
        <form name="f_filtr" class="f_form" method="POST" action="search_tick_back.php"> 
             <p class='a_navigate' style='margin-top:0px;padding-top:0px;'>Фильтр и поиск </p>
            <p>
                <?php echo $title_type;?>:
                <select name="sct_type_filt" class="form_class">
                    <option value="Все">Все</option>
                        <?php  
                        foreach($param_search_type as $type_t):?>     
                        <option value="<?php echo $type_t['id']; ?>"><?php echo $type_t['type'];?></option>
                        <?php endforeach; ?>
                    </select>        
                <?php echo $title_class;?>:
                <select name="sct_class_filt"  class="form_class">
                    <option value="Все">Все</option>
                    <?php
                        foreach($param_search_class as $class_t):?>     
                        <option value="<?php echo $class_t['id']; ?>"><?php echo $class_t['class'];?></option>
                        <?php endforeach; ?>
                        </select>
                <?php echo $title_state;?>: 
                <select name="sct_state_filt"  class="form_class">
                    <option value="Все">Все</option>
                     <?php
                        foreach($param_search_state as $state_t):?>     
                         <option value="<?php echo $state_t['id']; ?>"><?php echo $state_t['state'];?></option>
                        <?php endforeach; ?>
                </select>
                <?php echo $title_status;?>: 
                <select name="sct_status_filt"  class="form_class">
                    <option value="Все">Все</option>
                    <?php 
                    foreach($param_search_status as $status_t):?>     
                    <option value="<?php echo $status_t['id']; ?>"><?php echo $status_t['status'];?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo $title_tarif;?>: 
                <select name="sct_tick" class="form_class">
                    <option value='Все'>Все</option>
                    <?php 
                    foreach($param_search_tarifs as $tarifs_t):?>     
                    <option value="<?php echo $tarifs_t['id']; ?>"><?php echo $tarifs_t['price'];?></option>
                    <?php endforeach; ?>
                </select> 
                <?php echo $title_date;?>: 
                <input type="checkbox" name="check_date" class="form_class"  checked  value="yes"/> 
                <input type="date" size="10" maxlength="10" class="form_class" name="dte_date1" required="" value="<?=date('Y-m-d');?>"/> - <input type="date"  class="form_class" name="dte_date2" size="10" maxlength="10" required="" value="<?=date('Y-m-d');?>"/>
                <p></p> 
                <select name="sct_search_tick"  class="form_class">
                    <option value="-">-</option>
                    <?php foreach($param_search as $parameter):?>     
                    <option value="<?php echo $parameter['value'];?>"><?php echo $parameter['name'];?></option>
                    <?php endforeach;?>
                </select>    
                <input type="text" name="txt_srh" size="100" maxlength="100" class="form_class">
                <input type="submit" name="s_filter_t" value="Найти" class='btn btn-success btn-sm'>
        </form> 
    </center>
    </body>
</html>