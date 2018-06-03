<?php
require_once T_ROOT_LIB . 'gestion_competitons/ModuleMatchs.php';
require_once T_ROOT_LIB . 'gestion_competitons/ModuleEngagements.php';
require_once T_ROOT_LIB . 'gestion_competitons/ModuleClubs.php';

/**
 * Module principal de gestion d'un club
 * 
 * @author Evilou
 *        
 */
class ModuleGestion extends Module {
	private $moduleMatchs;
	
	/**
	 * Activation du module de gestion de match
	 */
	public function activate() {
		$moduleMatchs = new ModuleMatchs ( $this->routage );
		$moduleMatchs->activate ();
		$moduleEngagements = new ModuleEngagements ( $this->routage );
		$moduleEngagements->activate ();
		$moduleEngagements = new ModuleClubs ( $this->routage );
		$moduleEngagements->activate ();
	}
	
	/**
	 * Permet de récupérer la liste des equipes associées au club principal
	 */
	public function getEquipesClubPrincipal() {
		$query_str = "SELECT ";
		$query_str .= " `equipe_ID`, `equipe_nom`, `equipe_categorie`, `equipe_club`,`equipe_photo` ";
		$query_str .= " FROM `equipes` ";
		$query_str .= " WHERE `equipe_club` = " . T_REF_CLUB;
		
		$result = $mysqli->query ( $query_str );
		$tab = array ();
		while ( $row = $result->fetch_assoc () ) {
			$tab [] = $row;
		}
		return $tab;
	}
	
	/**
	 * Application du routage pour le module
	 */
	public function applicationRoutage($page) {
	}
}
?>