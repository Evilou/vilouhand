<?php
/**
 * Module de routage
 * @author Vilou
 *
 */
abstract class Module {
	public $routage;
	public $descriptionsPages;
	
	/**
	 * Constructeur
	 */
	public function Module(Routage $routage) {
		$this->routage = $routage;
		$descriptionsPages = array ();
	}
	public function setDescription($page, $description) {
		$descriptionsPages [$page] = $description;
	}
	
	/**
	 * Application du routage pour le module
	 */
	public abstract function applicationRoutage($page);
	
	/**
	 * Active les différentes pages d'un module
	 */
	public abstract function activate();
}
?>