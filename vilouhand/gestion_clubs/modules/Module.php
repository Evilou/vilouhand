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
	public function __construct(Routage $routage) {
		$this->routage = $routage;
		$this->descriptionsPages = array ();
	}
	
	/**
	 * initialisationd de la description d'une page du module
	 * @param string $page Référence de la page
	 * @param string $description Description de la page
	 */
	public function setDescription($page, $description) {
	    $this->descriptionsPages [$page] = $description;
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