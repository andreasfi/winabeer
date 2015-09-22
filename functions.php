<?php
function sessionCheck(){
	$usedip = getUsedIP();
	
}

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

function sec_session_start() {
    
	//setcookie("checkin",$session_name, $date_of_expiry ); 
	//$cookieParams = session_get_cookie_params();
    //session_set_cookie_params("checkin", $session_name, $cookieParams["lifetime"], $secure, $httponly);
               // Start the PHP session 
    //session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

/*
 * 
 * Database connections
 * 
 */
 
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

function addUsedIp($clientIp, $session_name){
	$count = 1;
	
	try {
		include './database-config.php';
		$stmt = $db->prepare("INSERT INTO usedip (
								sessionid,
								usedip,
								counter)
								VALUES (
								:sessionid,
								:usedip,
								:counter)");
	
		$stmt->bindParam(':sessionid', $session_name);
		$stmt->bindParam(':usedip', $clientIp);
		$stmt->bindParam(':counter', $count);
		$stmt->execute();
	} catch( PDOException $Exception ) { // Gestion des erreurs
		// Affichage de l'erreur PDO
		echo $Exception->getMessage();
		exit();
	}
}

function itterTry($client){
	$client['counter']++;
	try {	
			include './database-config.php';
			$stmt = $db->prepare("UPDATE usedip SET
										counter = :count
										WHERE id = :id");		
			$stmt->bindParam(':count', $client['counter']);
			$stmt->bindParam(':id', $client['id']);
			$stmt->execute();	
    		//header("Location: ./index.php");
	} catch( PDOException $Exception ) {
	    echo $Exception->getMessage();
		exit();
	}		
}