<?
//8/16/11
//set by client
/*
$config["recipient"]["pass"]="good@somespamplaguedwebsite.com"; //this is where we will send good email
$config["recipient"]["fail"]="junk@somespamplaguedwebsite.com"; //this is where we will send junk email
$config["recipient"]["admin"]="admin@somespamplaguedwebsite.com"; //this is where we will send important notifications (ex. service status, errors, etc.). Set to boolean false to deactivate.
*/
$config["recipient"]["pass"]="comments@justsalad.com"; //this is where we will send good email
$config["recipient"]["fail"]="tiffany@agwd.net"; //this is where we will send junk email
$config["recipient"]["admin"]="tiffany@agwd.net"; //this is where we will send important notifications (ex. service status, errors, etc.). Set to boolean false to deactivate.


$config["api_key"]="5Qzx7G7M8wDCpQxxFDmCeAg89fTaCpSI"; //obtained from http://websitespam.com
$config["log"]="/home/agbeta/logs/root-access.log"; //the location of your log
$config["log_lines"]=100; //number of log lines to send
$config["mode"]="production"; //development OR production
$config["threshold"]["pass"]=1; //if the score is less or equal to this number, the test is has been passed
$config["threshold"]["modify"]=2.5; //modify script behavior (rewrite subject, send to an enemy's email address, impose an additional challenge, display a message, etc.)
$config["host"] = "websitespam.com";//this is the domain they are to reference for processing
$config["path"] = "/check/";

function ws_checkIt($form_data_array) {
	global $config;
	$post_data = "&ws_mode=".base64_encode($config["mode"]);
	foreach($form_data_array as $key => $val){
		$post_data .= "&".$key."=".base64_encode($val);
	}
	$log = ws_getLog($config["log_lines"],$form_data_array["ws_ip"]);
	if($log){
		$post_data .= "&ws_log=".base64_encode($log);
	}
	elseif($config["recipient"]["admin"]){
		ws_notify($config["recipient"]["admin"],"Warning: Failed Log Processing","The anti-spam system could not use the log file for proper anti-spam processing.\n\nIMPORTANT: This message is only sent when NO log data is being submitted for processing. THIS MESSAGE HAS NOTHING TO DO WITH LOG-RELATED TEST ACCURACY ISSUES.\n\nFirst, please check the file path and permission for '".$config["log"]."'. If this problem persists, the file path is correct, and the file permissions permit webserver access to the logs, your log filter may be too strict to permit the sending of any log data.");
	}
	$http_response = '';
	$eol = "\r\n";
	$content_length = strlen($post_data);
	$fp = fsockopen($config["host"], 80, $errno, $errstr, 2);
	if (!$fp) {
		return false;
	} 
	$header = "POST ".$config["path"]." HTTP/1.1$eol";
	$header .="Host: ".$config["host"]."$eol";
	$header .="User-Agent: ".$config["api_key"]."$eol";
	$header .="Content-Type: application/x-www-form-urlencoded$eol";
	$header .="Content-Length: $content_length$eol";
	$header .="Connection: Close$eol$eol";
	fputs($fp, $header.$post_data);
	while (!feof($fp)){ 
		$http_response .= fgets($fp, 128);
	}
	fclose($fp);
	//echo $header.$post_data;
	//echo "#".$http_response."#";
	preg_match("/".$config["api_key"]."(.*)".$config["api_key"]."/s",$http_response,$pregs);
	//print_r($pregs);
	//echo "##".$pregs[1]."##";
	return $pregs[1];
}

function ws_procStatCode($code){
	global $config;
	/*current codes
	200: accepted
	401: unauthorized
	-->Other codes to be published at websitespam.com later
	*/
	if($config["mode"]=="development"){
		$ret["recipient"]=$config["recipient"]["admin"];
		$ret["subject"]="IN DEVELOPMENT MODE: ";
	}
	elseif(preg_match("/([0-9]*):([0-9]*):([\-0-9.]*)/",$code,$pregs)){
		$ret["status"]=$pregs[1];
		$ret["accuracy"]=$pregs[2];
		$ret["score"]=$pregs[3];
		if($ret["status"]==200){
			if($ret["accuracy"]<80){
				$ret["recipient"]=$config["recipient"]["pass"];
				$ret["subject"]="Warning: Test Accuracy";
				if($config["recipient"]["admin"]){
					ws_notify($config["recipient"]["admin"],$ret["subject"],"The antispam system is receiving invalid data when processing form submissions. Please verify your data by running the script in development mode.");
				}
			}
			elseif($ret["score"]<=$config["threshold"]["pass"]){
				$ret["recipient"]=$config["recipient"]["pass"];
				$ret["subject"]="";
			}
			elseif($ret["score"]<=$config["threshold"]["modify"]){
				$ret["recipient"]=$config["recipient"]["pass"];
				$ret["subject"]="****SPAM(".$ret["score"].")**** ";
			}
			else{
				$ret["recipient"]=$config["recipient"]["pass"];
				$ret["subject"]="";
			}
			if($ret["score"]>$config["threshold"]["modify"]){
				$ret["recipient"]=$config["recipient"]["fail"];
				$ret["subject"]="****SPAM(".$ret["score"].")**** ";
			}
		}
	}
	elseif(preg_match("/(4[0-9]{2}).*/",$code,$pregs)){
		$ret["status"]=$pregs[1];
		$ret["recipient"]=$config["recipient"]["pass"];
		$ret["subject"]="";
		if($config["recipient"]["admin"]){
			ws_notify($config["recipient"]["admin"],"Warning: Unauthorized Access","You are not authorized to use the anti-spam system. The following status code was returned: ".$ret["status"].". To learn the meaning of this status code, please visit http://www.websitespam.com.");
		}
	}
	else{
		return false;
	}
	return $ret;
}

function ws_getLog($back_lines=50,$filter=false){
	global $config;
	if(!is_readable($config["log"])){
		//echo "Can't read ".$config["log"];
		return false;
	}
	$cursor = -1;
	$fh = fopen($config["log"], 'r');
	fseek($fh, $cursor, SEEK_END);
	$char = fgetc($fh);
	if($char=="\n"){
		$cnt=-1;
	}
	else $cnt = 0;
	while ($char !== false && $cnt<$back_lines) {
		if(isset($line)){
			$line = $char . $line;
		}
		else $line = "";
		fseek($fh, $cursor--, SEEK_END);
		$char = fgetc($fh);
		if($char === "\n" /*|| $char === "\r" */){
			$cnt++;
		}
	}
	fclose($fh);
	if($filter){
		//echo "Before Filter: ".$line;
		if(preg_match_all("/".$filter.".*\n/",$line,$pregs)){
			$filtered_line="";
			for($i=0;$i<count($pregs[0]);$i++){
				$filtered_line .= $pregs[0][$i];
			}
			$line = $filtered_line;
			//echo "After Filter: ".$filtered_line;
		}
		else {
			//echo "Can't find ".$filter;
			return false;
		}
	}
	return rtrim($line,"\n");
}

function ws_catArray($user_input=false,$key_exclude=false){
    if(!$user_input){
        $user_input = $_POST;
    }
    if($key_exclude){
        if(!is_array($key_exclude)){
            $exclude_array[]=$key_exclude;
        }
        else $exclude_array=$key_exclude;
    }
    $ret = "";
    foreach($user_input as $key => $val){
        if($key_exclude){
            if(!in_array($key,$exclude_array)){
                 $ret.=$val;
            }
        }
        else $ret.=$val;
    }
    return $ret;
}

function ws_notify($to, $subject, $body){
	//__FILE__, __LINE__
	$append="This message is generated by the anti-spam script running at ".__FILE__." (line ".__LINE__.") for ".$_SERVER['HTTP_HOST'].". You are receving this message because a form on your website is integrated with the anti-spam system available at http://www.websitespam.com and you have chosen to be notified of circumstances that effect the level of protection your form has against automated spambots. To help protect your forms from automated spam submissions, do not deactivate this message. You can learn more about this project by visiting http://www.websitespam.com.";
	mail($to,"WS_".$subject,$body."\r\n\r\n".$append);
}

function multiMail($to, $subject, $body_plain, $body_html, $from=false, $reply_to=false){
	$html_text .= $body_html."\r\n";
	$boundary = uniqid('np');
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Subject: ".$subject."\r\n";
	if($from){
		$headers .= "From: ".$from."\r\n";
	}
	$headers .= "Content-Type: multipart/alternative;boundary=" . $boundary . "\r\n";
	$body = "This is a MIME encoded body."; 
	$body .= "\r\n\r\n--" . $boundary . "\r\n";
	$body .= "Content-type: text/plain;charset=iso-8859-1\r\n\r\n";
	$body .= $body_plain;
	$body .= "\r\n\r\n--" . $boundary . "\r\n";
	$body .= "Content-type: text/html;charset=iso-8859-1\r\n\r\n";
	$body .= $html_text;
	$body .= "\r\n\r\n--" . $boundary . "--";
	if(!$reply_to){
		$sent = mail($to,$subject,$body,$headers);
	}
	else {
		$sent = mail($to,$subject,$body,$headers,"-f".$reply_to);
	}
	return $sent;
}
?>