<?php
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
function addUsedIp($clientIp){
	$count = 0;
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
		//	$stmt->execute();
	} catch( PDOException $Exception ) { // Gestion des erreurs
		// Affichage de l'erreur PDO
		echo $Exception->getMessage();
		exit();
	}
}