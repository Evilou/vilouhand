<?php
require_once ('config.php');
require_once 'modules/init_session.php';

try {
	$routage = new Routage ( T_HOST_BDD, T_LOGIN_BDD, T_PASSWORD_BDD, T_NOM_BDD );
	
	$routage->active_module ( Routage::MODULE_IMAGES );
	$routage->applicationRoutage ();
} catch ( Exception $e ) {
	header ( 'Content-Type: application/json;charset=UTF-8' );
	$objMess = array (
			"status" => Routage::STATUS_ERR,
			"message" => "GLOBAL [mapping.php] : " . $e->getMessage () 
	);
	echo json_encode ( $objMess );
}
?>