<?php
function get_curl($url,$post=0,$referer=0,$cookie=0,$header=0,$ua=0,$nobaody=0,$addheader=0){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $httpheader[] = "Accept: */*";
    $httpheader[] = "Accept-Encoding: gzip,deflate,sdch";
    $httpheader[] = "Accept-Language: zh-CN,zh;q=0.8";
    $httpheader[] = "Connection: close";
    if($addheader){
        $httpheader = array_merge($httpheader, $addheader);
    }
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    if($post){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
    if($header){
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
    }
    if($cookie){
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
    }
    if($referer){
        if($referer==1){
            curl_setopt($ch, CURLOPT_REFERER, 'http://m.qzone.com/infocenter?g_f=');
        }else{
            curl_setopt($ch, CURLOPT_REFERER, $referer);
        }
    }
    if($ua){
        curl_setopt($ch, CURLOPT_USERAGENT,$ua);
    }else{
        curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36');
    }
    if($nobaody){
        curl_setopt($ch, CURLOPT_NOBODY,1);
    }
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}
function get_ip_city($ip){
    $url = 'http://whois.pconline.com.cn/ipJson.jsp?json=true&ip=';
    $city = get_curl($url.$ip);
    $city = mb_convert_encoding($city, "UTF-8", "GB2312");
    $city = json_decode($city, true);
    if ($city['city']) {
        $location = $city['pro'].$city['city'];
    } else {
        $location = $city['pro'];
    }
    if($location){
        return $location;
    }else{
        return false;
    }
}

function daddslashes($string, $force = 0, $strip = FALSE) {
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC || $force) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val, $force, $strip);
            }
        } else {
            $string = addslashes($strip ? stripslashes($string) : $string);
        }
    }
    return $string;
}

    function json($code,$data = '') {//JSON输出
        $udata = array('code'=>$code,'msg'=>$data);
        $jdata = json_encode($udata);
        die($jdata);
    }

    function addlog($type,$user,$info){
        $g_date = date('Y-m-d H:i:s', time());
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		if (!ip2long($ip)) {
			$ip = '未知';
		}
        $addinfo = ['type'=>$type,'uid'=>$user,'info'=>$info,'time'=>$g_date,'ip'=>$ip];
        DB::table('log')->add($addinfo);
    }

	function addcode($lx){
	    $ip = getIp();
	    $time = time();
	    /**$res = DB::table('code')->where('ip',$ip)->find();
	    if($time - $res['time'] < 60 && $res){
	        json(-1,'频繁获取验证码，请在'.$res['time'] - $time.'秒后再次获取。');
	    }**/
	    $code = get_str(6,0,0);
	    $resx = DB::table('code')->add(['code'=>$code,'lx'=>$lx,'time'=>$time,'ip'=>$ip]);
	    if(!$resx){
	        return 0;
	    }
	    return $code;
	}

	function adduserlog($uid,$lx,$info){
	    $date = date('Y-m-d H:i:s', time());
	    $res = DB::table('agent')->where('id',$agentid)->find();
	    $udata['uid'] = $uid;
	    $udata['lx'] = $lx;
	    $udata['info'] = $info;
	    $udata['addtime'] = $date;
	    DB::table('userlog')->add($udata);
	    if($res){
            return true;
        }
        return false;
	}

    function curl_get($url){
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
        curl_setopt($ch, CURLOPT_TIMEOUT, 7);
        $content=curl_exec($ch);
        curl_close($ch);
        return($content);
    }

    function send_post($url, $post_data) {
      $postdata = http_build_query($post_data);
      $options = array(
        'http' => array(
          'method' => 'POST',
          'header' => 'Content-type:application/x-www-form-urlencoded',
          'content' => $postdata,
          'timeout' => 15 * 60 // 超时时间（单位:s）
        )
      );
      $context = stream_context_create($options);
      $result = file_get_contents($url, false, $context);

      return $result;
    }

    function sendemail($title, $contant, $tomail, &$msg = '', $debug = false)
    {
        global $G;
    	require_once ('email/PHPMailer.php');
        require_once ('email/SMTP.php');
        require_once ('email/Exception.php');
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->SMTPDebug = $debug;
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = $G['config']['SMTP_Address'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = $G['config']['SMTP_Port'];
        $mail->CharSet = 'UTF-8';
        $mail->FromName = $G['config']['SMTP_name'];
        $mail->Username = $G['config']['SMTP_User'];
        $mail->Password = $G['config']['SMTP_Pwd'];
        $mail->From = $G['config']['SMTP_User'];
        $mail->isHTML(true);
        $mail->addAddress($tomail);
        $mail->Subject = $title;
        $mail->Body = $contant;
        $mail->SMTPOptions = array(
           'ssl' => array(
               'verify_peer' => false,
               'verify_peer_name' => false,
               'allow_self_signed' => true
            )
        );
    	//echo $mail->SMTPDebug;
        $re = $mail->send();
        if($re){
            return true;
        }else{
            $msg = '邮件发送失败返回错误：'.$mail->ErrorInfo;
            return false;
        }
    }

    function SendTipsMail($tomail,$content,&$BackMsg,$debug = false){
        global $G;
        include_once 'email/MailTemplate.php';
        $c = '';
        foreach ($content as $array){
            $con = '';
            foreach ($array['content'] as $line){
                $con .= str_replace('[content]',$line,$MailTipsLine);
            }
            $c .= str_replace('[content]',$con,str_replace('[title]',$array['title'],$MailTipsCon));
        }
        $html = str_replace('[content]',$c,$MailTipsFram);
        return sendemail($array['title'].' - '.$G['config']['sitename'],$html,$tomail,$BackMsg,$debug);
    }

    function isJson($data = '', $assoc = true) {
        $data = json_decode($data, $assoc);
        if (($data && is_object($data)) || (is_array($data) && !empty($data))) {
            return $data;
        }
        return false;
    }

    function IsUsername($Argv){
        $RegExp='/^[a-z0-9_]{8,12}$/'; //由小写字母跟数字组成并且长度在8-12字符之间
        return preg_match($RegExp,$Argv)?$Argv:false;
    }
    function IsUserpwd($Argv){
        $RegExp='/^[a-z0-9_]{8,20}$/'; //由小写字母跟数字组成并且长度在8-20字符之间
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    function IsMail($Argv){
        $RegExp='/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    function IsQQ($Argv){
        $RegExp='/^[1-9][0-9]{5,11}$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

    function IsTel($Argv){
        $RegExp='/[0-9]{3,4}-[0-9]{7,8}$/';
        return preg_match($RegExp,$Argv)?$Argv:false;
    }

	function get_str($length = 25,$lx = 0,$lx2 = NULL){//随机码
	    if($lx == 0){
	        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    }elseif($lx == 1){
	        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
	    }else{
	        $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	    }
        $len = strlen($str)-1;
        $randstr = '';
        for ($i=0;$i<$length;$i++) {
            $num = mt_rand(0,$len);
            $randstr .= $str[$num];
            if (!(($i+1) % 5) && $i && ($i+1)<$length && $lx2){
                $randstr .= '-';
            }
        }
        return $randstr;
   }

	function textbooltonum($text){//布尔文本型转换为数字0或1
        if ($text == 'on' || $text == 'true') {
            return '1';
        } else {
            return '0';
        }
    }

	function getIp() {//获取IP
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        if($ip != ""){
            $arr = explode(",",$ip);
            return $arr[0];
        }else{
            return $_SERVER["REMOTE_ADDR"];
        }
	}


	function http_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    function purge($string,$trim = true,$filter = true,$force = 0, $strip = FALSE) {
		$encode = mb_detect_encoding($string,array("ASCII","UTF-8","GB2312","GBK","BIG5"));
		if($encode != 'UTF-8'){
			$string = iconv($encode,'UTF-8',$string);
		}
		if($trim){$string=preg_replace('/\s+/','',$string);}
		if($filter){
			$farr = array(
				"/<(\\/?)(script|i?frame|style|html|body|title|link|meta|object|\\?|\\%)([^>]*?)>/isU",
				"/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",
				"/select |insert |and |or |create |update |delete |alter |count |\'|\/\*|\*|\.\.\/|\.\/|\^|union |into |load_file|outfile |dump/is"
			);
			$string = preg_replace($farr,'',$string);
		}
		define('MAGIC_QUOTES_GPC',ini_set("get_magic_quotes_gpc",'On') ? true : false);
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = purge($val, $force, $strip);
				}
			} else {
				$string = addslashes($strip ? stripslashes($string) : $string);
			}
		}

		return $string;
	}

	function check_phone($phone){//匹配手机号
        return preg_match('#^13[\d]{9}$|^14[5,6,7,8,9]{1}\d{8}$|^15[^4]{1}\d{8}$|^16[6]{1}\d{8}$|^17[0,1,2,3,4,5,6,7,8]{1}\d{8}$|^18[\d]{9}$|^19[8,9]{1}\d{8}$#',$phone) ? true : false;
	}

	function check_email($email){//匹配邮箱
        return preg_match('/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i',$email) ? true : false;
	}

	function txt_zhong($str, $leftStr, $rightStr){//取文本中间
		$left = strpos($str, $leftStr); //左边
		$right = strpos($str, $rightStr,$left); //右边
		if($left < 0 or $right < $left) return '';
		return substr($str, $left + strlen($leftStr), $right-$left-strlen($leftStr));
	}

	function txt_you($str, $leftStr){//取文本右边
		$left = strpos($str, $leftStr);
		return substr($str, $left + strlen($leftStr));
	}

	function txt_zuo($str, $rightStr){//取文本左边
		$right = strpos($str, $rightStr);
		return substr($str, 0, $right);
	}

    function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }
        if($operation == 'DECODE') {
            if(((int)substr($result, 0, 10) == 0 || (int)substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }

?>