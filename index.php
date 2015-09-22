<?php
include 'functions.php';

session_start();
$session_name = 'sec_session_'.$_SERVER['REMOTE_ADDR'];   // Set a custom session name
$secure = 'SECURE'; // This stops JavaScript being able to access the session id.
$httponly = true; // Forces sessions to only use cookies.
$clientIp = get_client_ip()	;
$alreadyused = false;
$count = 0;
// Function to get the client IP address
echo $_SERVER['REMOTE_ADDR'];
echo "<br/>Your IP:".$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

// @todo Is user logged in by session
// @todo Is user logged in by IP
// @todo Is user logged in by Cookie 


// Get DB for...

$usedip = getUsedIP();
// Is IP already used?
foreach ($usedip as $temp){
	if($clientIp == $temp['ip']){
		// error already played
		$alreadyused = true;
		break;
	}
}

if($alreadyused == false) {
	// gamble and show win or loss
	echo 'somethin';
	// Update DB with Client_IP
	addUsedIp();
} else {
	// error, already played
	// put counter up
}

if (isset($_GET["logout"])) {
	// Unset all session values
	$_SESSION = array();// get session parameters
	$params = session_get_cookie_params();// Delete the actual cookie.
	setcookie(session_name(),'', time() - 42000,$params["path"],$params["domain"],$params["secure"],$params["httponly"]);
	session_destroy();// Destroy session
	header('Location: ./');
} elseif (!empty($_SESSION['username']) && ($_SESSION['logged_in'] == 1)) {
	//echo 'yes';
	$login = true;
}


