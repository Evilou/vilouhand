<?php
require_once 'SGBDMysql.php';
class Session {
	private $timeoutSession = 600;
	private $tableUtilisateurs = "utilisateurs";
	private $tableSessions = "sessions";
	private $sgbdSession;
	private $session_id = null;
	
	/**
	 *
	 * retourne le texte du script de Création des tables necessaire pour la session
	 *
	 * @param unknown_type $tableUtilisateurs        	
	 * @param unknown_type $tableSessions        	
	 */
	static public function getStructTable($tableUtilisateurs = 'utilisateurs', $tableSessions = 'sessions') {
		return "CREATE TABLE IF NOT EXISTS `$tableSessions` (
		 `session_ID` varchar(32) NOT NULL,
		 `session_user` varchar(10) NOT NULL,
		 `session_time` int(11) NOT NULL,
		 `session_creation_time` int(11) NOT NULL,
		 `session_action` varchar(32) NOT NULL,
		 `session_IP` varchar(15) NOT NULL,
		 PRIMARY KEY (`session_ID`,`session_user`),
		 KEY `session_user` (`session_user`)
		 )ENGINE=InnoDB ;
		
		 CREATE TABLE IF NOT EXISTS `$tableUtilisateurs` (
		 `login` varchar(10) NOT NULL,
		 `password` varchar(32) NOT NULL,
		 `mail` varchar(100) NOT NULL,
		 `date_creation` int(11) NOT NULL,
		 `type` enum('0','1') NOT NULL DEFAULT '1',
		 PRIMARY KEY (`login`)
		) ENGINE=InnoDB;";
	}
	function getSessionId() {
		return $this->session_id;
	}
	
	/**
	 *
	 * @param unknown $host        	
	 * @param unknown $login        	
	 * @param unknown $password        	
	 * @param unknown $base        	
	 * @param string $tableUtilisateurs        	
	 * @param string $tableSessions        	
	 * @throws Exception
	 */
	public function Session($session_id, SGBDMysql $sgbd, $tableUtilisateurs = 'utilisateurs', $tableSessions = 'sessions') {
		$this->tableUtilisateurs = $tableUtilisateurs;
		$this->tableSessions = $tableSessions;
		
		$this->sgbdSession = $sgbd;
		
		$this->session_id = $session_id;
		
		/* bloc de code à conditionner */
		/*
		 * if ($sgbd->envoyerRequete ( Session::getStructTable ( $tableUtilisateurs,$tableSessions), TRUE) === TRUE) {
		 * } else {
		 * echo 'La base de données n\'est pas compatible avec la mécanique de gestion de sessions';
		 * }
		 */
	}
	
	/**
	 * Getter du sgbd
	 */
	public function getSGBD() {
		return $this->sgbdSession;
	}
	
	/**
	 * Peremt de récupérer les information d'une session utilisateur
	 * c'est la session courante qui sera récupérée
	 */
	function get_session() {
		try {
			$this->getSGBD ()->debuterTransaction ();
			
			// récupération de la session courante
			$id_session = $this->getSessionId ();
			
			$requete = "SELECT session_id, session_user, session_time, session_creation_time, session_action, session_IP FROM " . $this->tableSessions . " WHERE session_id LIKE '$id_session' ";
			
			$this->getSGBD ()->envoyerRequete ( $requete );
			
			if ($this->getSGBD ()->getAffectedRow ()) {
				$tab = $this->getSGBD ()->getResultat ( "TAB-ASSOC" );
				$this->getSGBD ()->terminerTransaction ();
				return $tab [0];
			} else {
				$this->getSGBD ()->terminerTransaction ();
				return array ();
			}
		} catch ( Exception $err ) {
			$this->getSGBD ()->annulerTransaction ();
		}
	}
	
	/**
	 * RÃ©cupÃ©ration du niveau de l'utilisateur courant
	 * -1 en cas d'echec
	 */
	function getNiveauUser() {
		if (! $this->isOnline ())
			return - 1;
		
		$sesssion = $this->get_session ();
		
		$this->getSGBD ()->debuterTransaction ();
		$requete = "SELECT type FROM " . $this->tableUtilisateurs . " WHERE login = '" . $sesssion ["session_user"] . "'";
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		if ($this->getSGBD ()->getAffectedRow ()) {
			$tab = $this->getSGBD ()->getResultat ( "SINGLE-ASSOC" );
			$this->getSGBD ()->terminerTransaction ();
			return $tab ["type"];
		} else {
			$this->getSGBD ()->terminerTransaction ();
			return - 1;
		}
	}
	
	/**
	 * Supprime la session courante.
	 */
	function suppression_session() {
		$this->getSGBD ()->debuterTransaction ();
		
		$requete = "SELECT * FROM " . $this->tableSessions . " WHERE session_id LIKE '" . $this->getSessionId () . "' FOR UPDATE";
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$requete = "DELETE FROM " . $this->tableSessions . " WHERE session_id LIKE '" . $this->getSessionId () . "'";
		
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		$this->getSGBD ()->terminerTransaction ();
		return 0;
	}
	
	/**
	 * Supprime toute les sessions qui ne sont plus valide
	 * Une session n'est plus valide si l'utilisateur est restÃ© inactif plus de $this->timeoutSessions seconde(s)
	 */
	function clean_tab_session() {
		$this->getSGBD ()->debuterTransaction ();
		$requete = "SELECT * FROM " . $this->tableSessions . " FOR UPDATE";
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		$requete = "DELETE FROM " . $this->tableSessions . " WHERE session_time + " . $this->timeoutSession . " < " . time ();
		
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		$this->getSGBD ()->terminerTransaction ();
		if ($this->isOnline ())
			$this->update_session_user ();
		return 0;
	}
	
	/**
	 * met Ã  jour une session dÃ©jÃ  existante
	 */
	function update_session_user() {
		$session = $this->get_session ();
		
		if (isset ( $session ["session_id"] )) {
			// une mise Ã  jour devra incrementer le champs temps online de l'utilisateur
			$adresse = $_SERVER ['REMOTE_ADDR'];
			
			if (isset ( $_REQUEST ['page'] )) {
				$page = $_REQUEST ['page'];
			} else {
				$page = 'home';
			}
			
			$this->getSGBD ()->debuterTransaction ();
			$requete = "SELECT * FROM " . $this->tableSessions . " WHERE session_id LIKE '" . $this->getSessionId () . "' FOR UPDATE";
			$err = $this->getSGBD ()->envoyerRequete ( $requete );
			if ($err ['errno']) {
				$this->getSGBD ()->annulerTransaction ();
				return - 1;
			}
			
			$requete = "UPDATE " . $this->tableSessions . " SET session_IP = '$adresse' , session_action = '$page', session_time = " . time () . " WHERE session_id LIKE '" . $this->getSessionId () . "'";
			
			$err = $this->getSGBD ()->envoyerRequete ( $requete );
			if ($err ['errno']) {
				$this->getSGBD ()->annulerTransaction ();
				return - 1;
			}
			$this->getSGBD ()->terminerTransaction ();
			return 0;
		}
		return - 1;
	}
	
	/**
	 * initialise une session utilisateur
	 */
	function initialiser_session($utilisateur) {
		if (isset ( $_REQUEST ['page'] )) {
			$page = $_REQUEST ['page'];
		} else {
			$page = 'home';
		}
		
		$adresse = $_SERVER ['REMOTE_ADDR'];
		
		$this->getSGBD ()->debuterTransaction ();
		
		$requete = "SELECT * FROM " . $this->tableSessions . " FOR UPDATE";
		
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$requete = "INSERT INTO " . $this->tableSessions . " (session_ID, session_user, session_creation_time, session_time, session_IP, session_action) VALUES ('" . $this->getSessionId () . "', '" . $utilisateur . "', " . time () . " ," . time () . ",'" . $adresse . "','$page')";
		
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$this->getSGBD ()->terminerTransaction ();
		return 0;
	}
	
	/**
	 * Permet de savoir si le client courrant est identifiï¿½
	 *
	 * @return unknown_type
	 */
	function isOnline() {
		$session = $this->get_session ();
		return count ( $session ) > 0;
	}
	
	/**
	 * CrÃ©ation d'un compte utilisateur
	 *
	 * @param $login Identifiant
	 *        	de l'utilisateur
	 * @param $mdp Mot
	 *        	de passe
	 * @param $mail Adresse
	 *        	mail de l'utilisateur
	 * @param $niveau Niveau
	 *        	d'acces de l'utilisateur (0 = admin)
	 */
	function creerCompte($login, $mdp, $mail, $niveau) {
		$this->getSGBD ()->debuterTransaction ();
		
		$requete = "SELECT * FROM " . $this->tableUtilisateurs . " FOR UPDATE";
		
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$requete = "INSERT INTO " . $this->tableUtilisateurs . "(login,password,mail,date_creation,type) VALUES('$login','" . md5 ( $mdp ) . "','$mail','" . time () . "',$niveau')";
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$this->getSGBD ()->terminerTransaction ();
	}
	
	/**
	 * CrÃ©ation d'un compte utilisateur
	 *
	 * @param $login Identifiant
	 *        	de l'utilisateur
	 * @param $mdp Mot
	 *        	de passe
	 * @param $mail Adresse
	 *        	mail de l'utilisateur
	 * @param $niveau Niveau
	 *        	d'acces de l'utilisateur (0 = admin)
	 */
	function supprimerCompte($login) {
		$this->getSGBD ()->debuterTransaction ();
		
		$requete = "SELECT * FROM " . $this->tableUtilisateurs . " FOR UPDATE";
		
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$requete = "DELETE FROM " . $this->tableUtilisateurs . " WHERE login LIKE '$login'";
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return - 1;
		}
		
		$this->getSGBD ()->terminerTransaction ();
	}
	
	/**
	 * Verification d'une identification
	 *
	 * @param $login Identifiant        	
	 * @param $mdp Mot
	 *        	de passe
	 */
	function verifierIdentification($login, $mdp) {
		$this->getSGBD ()->debuterTransaction ();
		
		$requete = "SELECT * FROM " . $this->tableUtilisateurs . " WHERE login LIKE '$login' AND password LIKE '" . md5 ( $mdp ) . "'";
		$err = $this->getSGBD ()->envoyerRequete ( $requete );
		
		if ($err ['errno']) {
			$this->getSGBD ()->annulerTransaction ();
			return 0;
		}
		$verifOk = $this->getSGBD ()->getAffectedRow () == 1;
		$this->getSGBD ()->terminerTransaction ();
		return $verifOk;
	}
}
?>