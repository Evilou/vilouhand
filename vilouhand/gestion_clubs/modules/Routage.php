<?php
require_once 'SGBDMysql.php';
require_once 'Session.php';
require_once 'Module.php';
require_once 'images/ModuleImages.php';
require_once 'actualites/ModuleActus.php';
require_once 'contacts/ModuleContacts.php';

/**
 * Classe permettant de gérer la gestion de session avec base de données et de prendre en compte la notion de "page"
 *
 * @author Evilou
 *        
 */
class Routage {
	/**
	 * Moteur de gestion du routage dans l'application
	 *
	 * @var unknown_type
	 */
	// Liste des pages défaut
	const PAGE_DEFAUT = "default-page";
	const PAGE_LOGIN = "login";
	const PAGE_LOGOFF = "fermetureSession";
	const PAGE_NEED_IDENT = "identNeeded";
	const PAGE_VERIF_IDENT = "verifIdent";
	const PAGE_EN_CONSTRUCTION = "enContruction";
	
	// Liste des statuts
	const STATUS_OK = "SUCCESS";
	const STATUS_ERR = "FAILED";
	const STATUS_WARNING = "WARNING";
	
	// Liste des modules
	const MODULE_IMAGES = "mod_images";
	const MODULE_CONTACTS = "mod_contacts";
	const MODULE_ACTUS = "mod_actus";
	
	/**
	 * Gestionnaire de base de données
	 *
	 * @var SGBDMysql
	 */
	private $sgbd;
	
	/**
	 * Nom de la base de données à utiliser
	 */
	private $bdName;
	
	/**
	 * Session courante
	 *
	 * @var Session
	 */
	private $session;
	
	/**
	 * Tableau des pages qui ne nécéssite pas d'identification
	 */
	private $pageSansIdent;
	
	/**
	 * Tableau de routage pour le routage spécifique
	 */
	private $tableRoutage;
	
	/**
	 * Constructeur
	 *
	 * @param string $host URL
	 *        	de la base de données
	 * @param String $login Identifiant
	 *        	de connexion à la base de données
	 * @param string $password Mot
	 *        	de passe pour la connexion à la base de données
	 * @param string $bdName Nom
	 *        	de la base de données
	 */
	public function Routage($host, $login, $password, $bdName) {
		$this->sgbd = new SGBDMysql ( $host );
		$this->sgbd->connexion ( $login, $password );
		$this->sgbd->choisirDB ( $bdName );
		$this->pageSansIdent = array (
				Routage::PAGE_DEFAUT,
				Routage::PAGE_LOGIN,
				Routage::PAGE_VERIF_IDENT,
				Routage::PAGE_NEED_IDENT,
				Routage::PAGE_LOGOFF,
				Routage::PAGE_EN_CONSTRUCTION 
		);
		$this->tableRoutage = array ();
		define ( 'START', microtime () );
	}
	
	/**
	 * Activation du module defaut du moteur
	 *
	 * @param string $nom_module        	
	 */
	public function active_module($nom_module) {
		switch ($nom_module) {
			case Routage::MODULE_IMAGES :
				$module = new ModuleImages ( $this );
				$module->activate ();
				break;
			case Routage::MODULE_CONTACTS :
				$module = new ModuleContacts ( $this );
				$module->activate ();
				break;
			case Routage::MODULE_ACTUS :
				$module = new ModuleActus ( $this );
				$module->activate ();
				break;
		}
	}
	
	/**
	 * Ajout d'un nom de page à la liste des pages ne nécéssitant pas d'identification
	 *
	 * @param string $type        	
	 * @param string $newPage        	
	 * @throws Exception
	 */
	public function ajouterPageSansIdent($newPage) {
		// TODO il faut verfier le comportement à effectuer pour les pages de fonctionnement du site
		foreach ( $this->pageSansIdent as $page ) {
			if (! strcmp ( $page, $newPage )) {
				throw new Exception ( "impossible d'ajouter cette page. Elle est déjà présente" );
			}
		}
		
		$this->pageSansIdent [] = $newPage;
	}
	
	/**
	 * Récupération du SGBD courrant
	 */
	public function getSGBDRoutage() {
		return $this->sgbd;
	}
	
	/**
	 * Permet de savoir si une page données nécéssite une identification
	 *
	 * @param string $page        	
	 */
	private function indentNeeded($page) {
		return ! in_array ( $page, $this->pageSansIdent );
	}
	
	/**
	 * Récupération du module de routage
	 */
	private function getModuleRoutage($page) {
		if (isset ( $this->tableRoutage [$page] )) {
			return $this->tableRoutage [$page];
		} else {
			return null;
		}
	}
	
	/**
	 * Initialisation du script de routage associé à une page
	 *
	 * @param string $page Nom
	 *        	de la page
	 * @param string $script Nom
	 *        	du script
	 */
	public function setModuleRoutage($page, Module $module) {
		$this->tableRoutage [$page] = $module;
	}
	
	/**
	 * Récupération de la page courante et prise en compte de la gestion des droits
	 */
	private function getPage() {
		// On regarde si la demande est une structure HTML ou des données ( affichage ou traitement ) affichage par défaut
		// si la page n'est pas renseignée on prend la page défaut
		$page = isset ( $_REQUEST ["page"] ) ? $_REQUEST ["page"] : Routage::PAGE_DEFAUT;
		
		// intialisation de la clef de session
		$clef_session = 'ROUTAGE-DEFAUT';
		
		if (defined ( T_CLEF_SESSION )) {
			$clef_session = T_CLEF_SESSION;
		}
		
		// récupération de l'identifiant de session
		$session_id = isset ( $_SESSION ['session_id_' . $clef_session] ) ? $_SESSION ['session_id_' . $clef_session] : uniqid ( md5 ( $clef_session ) . '_' );
		
		$_SESSION ['session_id_' . $clef_session] = $session_id;
		
		if (! strcmp ( '', $session_id ))
			throw new Exception ( 'identifiant de session non valide' );
			
			// Création de la session
		$this->session = new Session ( $session_id, $this->sgbd, "utilisateurs", "sessions" );
		
		// nettoyage des sessions en situation de TIMEOUT
		$this->session->clean_tab_session ();
		
		// on verifie que la session est valide pour la page demandée
		if (! $this->session->isOnline ()) {
			// Redirection vers la page de login si besoin
			if ($this->indentNeeded ( $page )) {
				$page = Routage::PAGE_NEED_IDENT;
			}
		}
		
		// Construction de l'objet à retourner
		$objPage = array (
				"asked" => (isset ( $_REQUEST ["page"] ) ? $_REQUEST ["page"] : ""),
				"page" => $page 
		);
		
		return $objPage;
	}
	
	/**
	 * Lance la mécanique de routage
	 */
	public function applicationRoutage() {
		// initilisation du header
		header ( 'Content-Type: application/json;charset=UTF-8' );
		
		$objMess = array (
				"status" => Routage::STATUS_OK 
		);
		try {
			$pageObj = $this->getPage ();
			
			$page = $pageObj ["page"];
			
			/*
			 * TODO C'est ici qu'il faut mettre en place le systeme de statistique sur le site
			 * il va falloir enregistrer la date et la page pour commencer
			 */
			
			$module = $this->getModuleRoutage ( $page );
			
			if ($module != null) {
				// ajout du script si il existe
				try {
					$objMess = $module->applicationRoutage ( $page );
				} catch ( Exception $e ) {
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
				}
			} else {
				switch ($page) {
					// Contrôle de l'identité
					case Routage::PAGE_VERIF_IDENT :
						try {
							$objMess ['page_found'] = Routage::PAGE_VERIF_IDENT;
							if ($this->session->isOnline ()) {
								$objMess ['message'] = "La session est déjà active...";
								$objMess ['status'] = Routage::STATUS_WARNING;
							} else if (isset ( $_POST ["login"] ) && isset ( $_REQUEST ["password"] )) {
								if ($this->session->verifierIdentification ( $_REQUEST ["login"], $_POST ["password"] )) {
									$objMess ['message'] = "Identification réussie...";
									$this->session->initialiser_session ( $_REQUEST ['login'] );
								} else {
									$objMess ['status'] = Routage::STATUS_ERR;
									$objMess ['message'] = "Echec de l'identification...";
								}
							} else {
								$objMess ['status'] = Routage::STATUS_ERR;
								$objMess ['message'] = "Il manque des informations pour permettre la vérification de l'identification";
							}
						} catch ( Exception $e ) {
							$objMess ['status'] = Routage::STATUS_ERR;
							$objMess ['message'] = $e->getMessage ();
						}
						break;
					// Page de déconnexion
					case Routage::PAGE_LOGOFF :
						try {
							$this->session->suppression_session ();
							$objMess ['message'] = "Déconnexion effetuée...";
						} catch ( Exception $e ) {
							$objMess ['status'] = Routage::STATUS_ERR;
							$objMess ['message'] = $e->getMessage ();
						}
						break;
					
					// page en construction
					case Routage::PAGE_EN_CONSTRUCTION :
						$objMess ['message'] = 'Page ' . $pageObj ['asked'] . ' en construction....';
						$objMess ['status'] = Routage::STATUS_WARNING;
						break;
					
					// page nécessitant une authentification
					case Routage::PAGE_NEED_IDENT :
						$objMess ['message'] = 'Page ' . $pageObj ['asked'] . ' nécessite une identification....';
						$objMess ['status'] = Routage::STATUS_ERR;
						break;
					
					// Page défaut
					case Routage::PAGE_DEFAUT :
						$objMess ['datas-html'] = "<p>Bienvenu dans la page défaut du système de routage....</p>";
						break;
					
					// Page d'identification
					case Routage::PAGE_LOGIN :
						$objMess ['datas-html'] = $this->getLoginHTML ();
						break;
					
					// page inconnue
					default :
						$objMess ['message'] = 'Page inconnue ' . $pageObj ['asked'] . '....';
						$objMess ['status'] = Routage::STATUS_ERR;
						break;
				}
			}
		} catch ( Exception $e ) {
			$objMess ['status'] = Routage::STATUS_ERR;
			$objMess ['message'] = $e->getMessage ();
		}
		
		$objMess ['sessionID'] = $this->session->getSessionId ();
		
		// header('Content-Type: text/html;charset=UTF-8');
		
		echo json_encode ( $objMess );
	}
	
	/**
	 * Affichage de la demande d'identification
	 */
	public function getLoginHTML() {
		$formLoginHTML = '<form role-form="rich-form" role-form-page="' . Routage::PAGE_VERIF_IDENT . '"  id="form_login">';
		$formLoginHTML .= '  <div class="form-item">';
		$formLoginHTML .= '    <span class="form-item-icon"><i class="fa fa-user fa-fw"></i></span>';
		$formLoginHTML .= '    <input role-form="item" role-form-name="form_login" class="form-control" type="text" name="login" id="login" placeholder="Identifiant" />';
		$formLoginHTML .= '  </div>';
		$formLoginHTML .= '  <div class="form-item">';
		$formLoginHTML .= '    <span class="form-item-icon"><i class="fa fa-key fa-fw"></i></span>';
		$formLoginHTML .= '    <input role-form="item" role-form-name="form_login" class="form-control" type="password" name="password" id="password" placeholder="Mot de passe" />';
		$formLoginHTML .= '  </div>';
		$formLoginHTML .= '  <div class="form-item">';
		$formLoginHTML .= '    <input type="submit" value="valider" />';
		$formLoginHTML .= '  </div>';
		$formLoginHTML .= '</form>';
		return $formLoginHTML;
	}
	
	/**
	 * Desctructeur
	 */
	function __destruct() {
		$this->sgbd->deconnexion ();
	}
}
?>