<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <link href="css/enter_css.css" rel="stylesheet">
        <title>Вход</title>
        <script type="text/javascript">
        var p='show';
        function hide(){
            document.getElementById('t_pass').setAttribute('type', 'text');
            p='hide';
            return p;
         }
         function show(){
            document.getElementById('t_pass').setAttribute('type', 'password');
            p='show';
            return p;
         }
         function showorhide(){
            if(p=='hide'){
                 show();
             }
             else
            if (p=='show'){
                hide();
                }
            else {
                alert('error');
            }
         }    
        </script> 
    </head>
    <body>
        <center>
            <div id="d_logo">
                <img id="img_logo" src="img/inettel_jpg.jpg"/>
            </div>
            <form name="f_enter" method="POST" action="check.php"/>
                <p class="p_registr">
                    <input type="text" name="t_login" id="t_login" class="input_reg" required placeholder="логин"/> 
                    <input type="password" name="t_pass" id='t_pass' class="input_reg" required placeholder="пароль"/>
                    <!--<input type="checkbox" class="sub_button" value='1' name='button' id='button' onchange="document.getElementById('t_pass').type = this.checked ? 'text' : 'password';"/></span>-->
                    <a onclick="showorhide()" id="btn_hideshow" title='показать/скрыть пароль' class="sub_button">✫</a>
                </p>
                <input type="submit" name="s_send" value="✔" class="sub_button"/>
            </form>
        </center>
    </body>
</html>