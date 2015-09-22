<?php
include 'functions.php';
$alreadyused = false;


	$session_name = 'sec_session_'.$_SERVER['REMOTE_ADDR'];   // Set a custom session naem
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    $cookie_name = 'winabeer';
    
    if(isset($_COOKIE[$cookie_name])){
    	echo 'used';
    	$alreadyused = true;
    } else {
    	$cookie_value = 'win_a_beer';
		$date_of_expiry = time() + (86400 * 1); // 86400 = 1 day
    	setcookie($cookie_name, $cookie_value, time() + (86400 * 1), $secure, $httponl,"/");
    }
    session_name($session_name);
    session_start(); 


$secure = 'SECURE'; // This stops JavaScript being able to access the session id.
$httponly = true; // Forces sessions to only use cookies.
$clientIp = get_client_ip()	;

$count = 0;

echo "<br/>Your IP:".get_client_ip();

// @todo Is user logged in by session
// @todo Is user logged in by IP
$usedip = getUsedIP();
$client = null;
foreach ($usedip as $temp){
	if($clientIp == $temp['usedip']){
		// error already played
		$alreadyused = true;
		$client = $temp;
		break;
	}
}

// @todo Is user logged in by Cookie 



// Is IP already used?

if($alreadyused == false) {
	// gamble and show win or loss
	echo ' maybe you won';
	// Update DB with Client_IP
	addUsedIp($clientIp, $session_name);
} else {
	// error, already played
	echo 'already played';
	// put counter up
	itterTry($client);
}

echo " ------	".$_COOKIE['winabeer'];