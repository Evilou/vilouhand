<?php
class SGBDMysql {
	// Identifiant de la connection
	private $idConnection;
	
	// Indique si une connection est actuellement active
	private $connexionActive;
	
	// Identifiant de transaction en cours (augmente avec la profondeur)
	private $idTransaction;
	
	// Indique si une transaction est active
	private $transactionActive;
	
	// permet de savoir si il faut annuler ou non une transaction en cours
	private $transactionAAnnuler;
	
	// Resultset de la derni�re requete envoy�e
	private $resultat;
	
	// Adresse de connection
	private $adresse;
	private $sgbd_mysqli;
	
	/**
	 * Cosntructeur du SGBD Mysql
	 *
	 * @param string $adresse
	 *        	Adresse de connection
	 * @param string $ident
	 *        	Identifiant de la connectino
	 * @param string $password
	 *        	Mot de passe de la connection
	 * @return SGBDMysql
	 */
	function SGBDMysql($adresse = 'localhost') {
		$this->adresse = $adresse;
		$this->idTransaction = 0;
		$this->connexionActive = FALSE;
	}
	
	/**
	 * Connexion au serveur associé au SGBD
	 *
	 * @return integer 0 en cas de succes, le code erreur sinon
	 */
	function connexion($ident = 'root', $password = '') {
		// Dans le cas d'une reconnexion on se déconnecte avant de relancer le process de connexion
		if ($this->connexionActive === TRUE) {
			$this->deconnexion ();
		}
		
		// connexion à la base de données
		$this->sgbd_mysqli = new mysqli ( $this->adresse, $ident, $password, "" );
		
		// Contrôle du statut de la connexion
		if ($this->sgbd_mysqli->connect_errno) {
			throw new Exception ( $this->sgbd_mysqli->connect_errno . ' : ' . $this->sgbd_mysqli->connect_error );
		}
		
		// On desactive le mode AUTOCOMMIT
		$this->sgbd_mysqli->autocommit ( FALSE );
		$this->sgbd_mysqli->query ( 'SET CHARACTER SET utf8' );
		
		$this->connexionActive = TRUE;
	}
	
	/**
	 * Deconnexion du serveur associé au SGBD
	 *
	 * @return integer 0 en cas de succes, le code erreur sinon
	 */
	function deconnexion() {
		if ($this->connexionActive === TRUE) {
			$this->sgbd_mysqli->close ();
			$this->connexionActive = FALSE;
			return TRUE;
		}
		throw new Exception ( "Impossible de se déconnecter : Connexion non active" );
	}
	
	/**
	 * Enclenche le début d'une transaction Mysql
	 *
	 * @return l'identifiant de la transaction -1 en cas d'echec
	 */
	function debuterTransaction() {
		if (! $this->idTransaction) {
			$this->sgbd_mysqli->begin_transaction ();
			$this->transactionAAnnuler = FALSE;
		}
		
		if ($this->sgbd_mysqli->errno) {
			throw new Exception ( $this->sgbd_mysqli->errno . ' : ' . $this->sgbd_mysqli->error );
		}
		
		$this->idTransaction ++;
		return $this->idTransaction;
	}
	
	/**
	 * Annule une la transaction courrante
	 */
	function annulerTransaction() {
		if ($this->idTransaction == 1) {
			$this->sgbd_mysqli->rollback ();
			$this->transactionAAnnuler = FALSE;
		} else {
			$this->transactionAAnnuler = TRUE;
			$this->idTransaction --;
		}
		return 0;
	}
	
	/**
	 * Termine ou annule la transaction courrante
	 */
	function terminerTransaction() {
		if ($this->idTransaction == 1) {
			if ($this->transactionAAnnuler === TRUE) {
				$this->annulerTransaction ();
			} else
				$this->sgbd_mysqli->commit ();
			$this->idTransaction = 0;
		} else {
			$this->idTransaction --;
		}
	}
	
	/**
	 * Envois d'une requete vers le serveur
	 *
	 * @param string $requete        	
	 */
	function envoyerRequete($requete, $multiple = FALSE) {
		if ($this->connexionActive) {
			if ($this->transactionAAnnuler === TRUE) {
				// la transaction va être annulée on ne fait donc rien
			} else {
				if ($multiple) {
					$this->resultat = $this->sgbd_mysqli->multi_query ( $requete );
				} else {
					$this->resultat = $this->sgbd_mysqli->query ( $requete );
				}
			}
			// Gestion des erreurs sur les requêtes
			if ($this->sgbd_mysqli->errno) {
				throw new Exception ( $this->sgbd_mysqli->errno . " : " . $this->sgbd_mysqli->error . "[$requete]" );
			}
		} else {
			throw new Exception ( "Impossible d'envoyer la requête : la connexion n'est pas active." );
		}
	}
	
	/**
	 * Connection à une base de données
	 *
	 * @param string$nomBDD nom
	 *        	de la base de données
	 * @return integer Le code erreur
	 */
	function choisirDB($nomBDD) {
		$this->sgbd_mysqli->select_db ( $nomBDD );
		
		if ($this->sgbd_mysqli->errno) {
			throw new Exception ( $this->sgbd_mysqli->errno . " : " . $this->sgbd_mysqli->error );
		}
	}
	
	/**
	 *
	 * @return number
	 */
	function getAffectedRow() {
		if ($this->connexionActive)
			return $this->sgbd_mysqli->affected_rows;
		else
			return 0;
	}
	
	/**
	 *
	 * @return string
	 */
	function getLastInsertID() {
		if ($this->connexionActive)
			return $this->sgbd_mysqli->insert_id;
		else
			return 0;
	}
	
	/**
	 * Traduction des informations r�cup�r�es pour une requete de type INSERT
	 *
	 * @param string $data        	
	 * @return string
	 */
	public static function traduireDataToInsertValues($data) {
		$listeVal = '';
		$listeVar = '';
		
		while ( list ( $key, $val ) = each ( $data ) ) {
			$val = trim ( addslashes ( stripcslashes ( utf8_decode ( $val ) ) ) );
			$listeVal .= ($listeVal == "" ? "" : ",");
			$listeVar .= ($listeVar == "" ? "" : ",");
			$listeVar .= "`$key`";
			$listeVal .= "'$val'";
		}
		
		return "($listeVar) VALUES ($listeVal)";
	}
	
	/**
	 * Traduction des informations r�cup�r�es pour une requete de type UPDATE
	 *
	 * @param string $data        	
	 * @return string
	 */
	public static function traduireDataToUpdateValues($data) {
		$requete = '';
		while ( list ( $key, $val ) = each ( $data ) ) {
			$val = trim ( addslashes ( stripcslashes ( utf8_decode ( $val ) ) ) );
			$requete .= ($requete == "" ? "" : ",");
			$requete .= " `$key` = '$val'";
		}
		return $requete;
	}
	
	/**
	 * Récupère le dernier resultat d'une requete
	 *
	 * @return string
	 */
	function getResultat($format = '') {
		if (! strcmp ( $format, 'TAB-ASSOC' )) {
			$numLignes = $this->resultat->num_rows;
			$tabRetour = array ();
			for($i = 0; $i < $numLignes; $i ++) {
				$tabRetour [$i] = $this->resultat->fetch_assoc ();
			}
			return $tabRetour;
		}
		if (! strcmp ( $format, 'SINGLE-ASSOC' )) {
			return $this->resultat->fetch_assoc ();
		}
		if (! strcmp ( $format, 'SINGLE' )) {
			return $this->resultat->fetch_row ();
		}
		return $this->resultat;
	}
}
?>
