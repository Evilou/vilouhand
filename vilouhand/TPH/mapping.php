<?php
require_once ('config.php');

require_once (T_ROOT_LIB . 'config_bdd.php');
require_once (T_ROOT_LIB . 'gestion_competitons/ModuleGestion.php');

try {
	// Définition du routage
	$routage = new Routage ( T_HOST_BDD, T_LOGIN_BDD, T_PASSWORD_BDD, T_NOM_BDD );
	
	// partie des modules généraux
	$routage->active_module ( Routage::MODULE_IMAGES );
	$routage->active_module ( Routage::MODULE_CONTACTS );
	$routage->active_module ( Routage::MODULE_ACTUS );
	
	// partie des modules spécifiques
	$moduleGestClub = new ModuleGestion ( $routage );
	$moduleGestClub->activate ();
	
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