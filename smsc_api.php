<?php
// SMSC.RU API (smsc.ru) ������ 3.5 (18.12.2016)
require_once 'tickets_connect.php'; // Самописная проверка наличия профиля смс по умолчанию. Если при отправке сообщения
//                                  // профиль не определён, то сценарий обывается
$select_default_profile="SELECT login,password FROM smsprofiles WHERE status='default' LIMIT 1";
foreach($kol=$pdo->query($select_default_profile) as $result){};
if(isset($_GET['id_tct'])&&$kol->rowCount()<1){
    echo "<span>Не определён профиль смс по умолчанию. <b><a style='color:#F0E68C;text-decoration:none' href='smsprofiles.php'>Выбрать профиль</a></b></span>";
    exit();
}
else{}
//конец провекри
define("SMSC_LOGIN", $result['login']);			// ����� ������� 
define("SMSC_PASSWORD", $result['password']);	// ������ ��� MD5-��� ������ � ������ �������� 
define("SMSC_POST", 0);					// ������������ ����� POST
define("SMSC_HTTPS", 0);				// ������������ HTTPS ��������
define("SMSC_CHARSET", "UTF-8");	// ��������� ���������: utf-8, koi8-r ��� windows-1251 (�� ���������)
define("SMSC_DEBUG", 1);				// ���� �������
define("SMTP_FROM", "api@smsc.ru");     // e-mail ����� �����������

function send_sms($phones, $message, $translit = 0, $time = 0, $id = 0, $format = 0, $sender = false, $query = "", $files = array())
{
    global $m;
	static $formats = array(1 => "flash=1", "push=1", "hlr=1", "bin=1", "bin=2", "ping=1", "mms=1", "mail=1", "call=1");
	$m = _smsc_send_cmd("send", "cost=3&phones=".urlencode($phones)."&mes=".urlencode($message).
					"&translit=$translit&id=$id".($format > 0 ? "&".$formats[$format] : "").
					($sender === false ? "" : "&sender=".urlencode($sender)).
					($time ? "&time=".urlencode($time) : "").($query ? "&$query" : ""), $files);

	// (id, cnt, cost, balance) ��� (id, -error)

	if (SMSC_DEBUG) {
                
                if ($m[1] > 0) {}
                          //echo "сообщение отправлено"; 
			
		else {
                    
			echo "<H4>Что-то пошло не так, сообщение не отправлено. <a style='text-decoration:none;color:#F0E68C;' href=all_tickets.php> Вернуться к заявкам</a></H4>";
                        exit();
                }
                            
	}

	return $m;
}


function send_sms_mail($phones, $message, $translit = 0, $time = 0, $id = 0, $format = 0, $sender = "")
{
	return mail("send@send.smsc.ru", "", SMSC_LOGIN.":".SMSC_PASSWORD.":$id:$time:$translit,$format,$sender:$phones:$message", "From: ".SMTP_FROM."\nContent-Type: text/plain; charset=".SMSC_CHARSET."\n");
}

function get_sms_cost($phones, $message, $translit = 0, $format = 0, $sender = false, $query = "")
{
	static $formats = array(1 => "flash=1", "push=1", "hlr=1", "bin=1", "bin=2", "ping=1", "mms=1", "mail=1", "call=1");

	$m = _smsc_send_cmd("send", "cost=1&phones=".urlencode($phones)."&mes=".urlencode($message).
					($sender === false ? "" : "&sender=".urlencode($sender)).
					"&translit=$translit".($format > 0 ? "&".$formats[$format] : "").($query ? "&$query" : ""));

	// (cost, cnt) ��� (0, -error)

	if (SMSC_DEBUG) {
		if ($m[1] > 0)
			echo "��������� ��������: $m[0]. 11 SMS: $m[1]\n";
		else
			echo "������ �", -$m[1], "\n";
	}

	return $m;
}

function get_status($id, $phone, $all = 0)
{
	$m = _smsc_send_cmd("status", "phone=".urlencode($phone)."&id=".urlencode($id)."&all=".(int)$all);

	// (status, time, err, ...) ��� (0, -error)

	if (!strpos($id, ",")) {
		if (SMSC_DEBUG )
			if ($m[1] != "" && $m[1] >= 0)
				echo "������ SMS = $m[0]", $m[1] ? ", ����� ��������� ������� - ".date("d.m.Y H:i:s", $m[1]) : "", "\n";
			else
				echo "������ �", -$m[1], "\n";

		if ($all && count($m) > 9 && (!isset($m[$idx = $all == 1 ? 14 : 17]) || $m[$idx] != "HLR")) // ',' � ���������
			$m = explode(",", implode(",", $m), $all == 1 ? 9 : 12);
	}
	else {
		if (count($m) == 1 && strpos($m[0], "-") == 2)
			return explode(",", $m[0]);

		foreach ($m as $k => $v)
			$m[$k] = explode(",", $v);
	}

	return $m;
}

function get_balance()
{
	$m = _smsc_send_cmd("balance"); // (balance) ��� (0, -error)

	/*if (SMSC_DEBUG) {
		if (!isset($m[1]))
                    if($m[0]<20){
			echo "<span style=color:red;>".$m[0]." руб. необходимо пополнить </span>","\n";
                    }
                    else{
			echo "<span style=color:#32CD32;>".$m[0]." руб.</span>","\n";
                    }  
                else {}
			
	}

	return isset($m[1]) ? false : $m[0];
         */
        if (SMSC_DEBUG) {
		if (!isset($m[1]))
                    if($m[0]<20){
			echo "<span style='color:red;font-size:16px;'>".$m[0]." руб. необходимо пополнить </span>";
                    }
                    else{
			echo "<span style='border-bottom:1px solid #F0E68C;border-radius:10px;color:#32CD32;font-size:16px;margin:0px;padding:3px;'>баланс ".$m[0]." руб.</span>";
                    }  
                else {}
			
	}

	return isset($m[1]) ? false : $m[0];
}

function _smsc_send_cmd($cmd, $arg = "", $files = array())
{
	$url = $_url = (SMSC_HTTPS ? "https" : "http")."://smsc.ru/sys/$cmd.php?login=".urlencode(SMSC_LOGIN)."&psw=".urlencode(SMSC_PASSWORD)."&fmt=1&charset=".SMSC_CHARSET."&".$arg;

	$i = 0;
	do {
		if ($i++)
			$url = str_replace('://smsc.ru/', '://www'.$i.'.smsc.ru/', $_url);

		$ret = _smsc_read_url($url, $files, 3 + $i);
	}
	while ($ret == "" && $i < 5);

	if ($ret == "") {
		if (SMSC_DEBUG)
			echo "";

		$ret = ","; // ��������� �����
	}

	$delim = ",";

	if ($cmd == "status") {
		parse_str($arg, $m);

		if (strpos($m["id"], ","))
			$delim = "\n";
	}

	return explode($delim, $ret);
}

function _smsc_read_url($url, $files, $tm = 5)
{
	$ret = "";
	$post = SMSC_POST || strlen($url) > 2000 || $files;

	if (function_exists("curl_init"))
	{
		static $c = 0; // keepalive

		if (!$c) {
			$c = curl_init();
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($c, CURLOPT_CONNECTTIMEOUT, $tm);
			curl_setopt($c, CURLOPT_TIMEOUT, 60);
			curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
		}

		curl_setopt($c, CURLOPT_POST, $post);

		if ($post)
		{
			list($url, $post) = explode("?", $url, 2);

			if ($files) {
				parse_str($post, $m);

				foreach ($m as $k => $v)
					$m[$k] = isset($v[0]) && $v[0] == "@" ? sprintf("\0%s", $v) : $v;

				$post = $m;
				foreach ($files as $i => $path)
					if (file_exists($path))
						$post["file".$i] = function_exists("curl_file_create") ? curl_file_create($path) : "@".$path;
			}

			curl_setopt($c, CURLOPT_POSTFIELDS, $post);
		}

		curl_setopt($c, CURLOPT_URL, $url);

		$ret = curl_exec($c);
	}
	elseif ($files) {
		if (SMSC_DEBUG)
			echo " curl\n";
	}
	else {
		if (!SMSC_HTTPS && function_exists("fsockopen"))
		{
			$m = parse_url($url);

			if (!$fp = fsockopen($m["host"], 80, $errno, $errstr, $tm))
				$fp = fsockopen("212.24.33.196", 80, $errno, $errstr, $tm);

			if ($fp) {
				stream_set_timeout($fp, 60);

				fwrite($fp, ($post ? "POST $m[path]" : "GET $m[path]?$m[query]")." HTTP/1.1\r\nHost: smsc.ru\r\nUser-Agent: PHP".($post ? "\r\nContent-Type: application/x-www-form-urlencoded\r\nContent-Length: ".strlen($m['query']) : "")."\r\nConnection: Close\r\n\r\n".($post ? $m['query'] : ""));

				while (!feof($fp))
					$ret .= fgets($fp, 1024);
				list(, $ret) = explode("\r\n\r\n", $ret, 2);

				fclose($fp);
			}
		}
		else
			$ret = file_get_contents($url);
	}

	return $ret;
}

?>
