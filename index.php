<?php
session_start();
$session_name = 'sec_session_'.$_SERVER['REMOTE_ADDR'];   // Set a custom session name
$secure = 'SECURE'; // This stops JavaScript being able to access the session id.
$httponly = true; // Forces sessions to only use cookies.
$clientIp = $_SERVER['REMOTE_ADDR'];
$alreadyused = false;
$count = 0;
// Function to get the client IP address
echo $_SERVER['REMOTE_ADDR'];
echo "<br/>Your IP:".$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

function get_client_ip() {
	$ipaddress = '';
	if ($_SERVER['HTTP_CLIENT_IP'])
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if($_SERVER['HTTP_X_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if($_SERVER['HTTP_X_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	else if($_SERVER['HTTP_FORWARDED_FOR'])
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if($_SERVER['HTTP_FORWARDED'])
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if($_SERVER['REMOTE_ADDR'])
		$ipaddress = $_SERVER['	'];
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
// Get DB for...
function getUsedIP(){
	try {
		include './database-config.php';
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$statement = $db-> prepare('SELECT * FROM usedip'); // Get all used IPs
		$statement->execute();
		$usedip = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $usedip;
	} catch (PDOException $Exception ) {
		echo $Exception->getMessage();
		exit();
	}
}
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
	try {
		include './database-config.php';
		$stmt = $db->prepare("INSERT INTO usedip (
								usedip,
								counter)
								VALUES (
								:usedip,
								:counter)");
	
		$stmt->bindParam(':usedip', $clientIp);
		$stmt->bindParam(':counter', $count);
		//$stmt->execute();
	} catch( PDOException $Exception ) { // Gestion des erreurs
		// Affichage de l'erreur PDO
		echo $Exception->getMessage();
		exit();
	}
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


