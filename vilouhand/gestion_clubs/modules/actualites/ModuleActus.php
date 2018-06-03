<?php
/**
 * 
 * @author Vilou
 *
 */
class ModuleActus extends Module {
	const TABLE_ACTUS = "actualites";
	const PAGE_GET_ACTUS = "getactus";
	const PAGE_EDIT_ACTU = "editactu";
	const PAGE_VALID_ACTU = "validactu";
	
	// TODO Gestion de l'affichage des actualités
	private $tableActus = ModuleActus::TABLE_ACTUS;
	
	/**
	 *
	 * @param Routage $routage        	
	 */
	public function ModuleActus(Routage $routage) {
		parent::__construct ( $routage );
		if (defined ( T_PREFIXE_TABLE ))
			$this->tableActus = T_PREFIXE_TABLE . ModuleActus::TABLE_ACTUS;
	}
	
	/**
	 */
	public function activate() {
		/**
		 * TODO lecture potentielle en base de données
		 * ATTENTION on ne passe plus par des scripts mais par des objets
		 */
		// ajout de la liste de pages
		/* ### upload d'image ### */
		$this->routage->setModuleRoutage ( ModuleActus::PAGE_GET_ACTUS, $this );
		$this->routage->ajouterPageSansIdent ( ModuleActus::PAGE_GET_ACTUS );
		$this->setDescription ( ModuleActus::PAGE_GET_ACTUS, "Récupération de la liste des actualités" );
		
		$this->routage->setModuleRoutage ( ModuleActus::PAGE_EDIT_ACTU, $this );
		$this->routage->ajouterPageSansIdent ( ModuleActus::PAGE_EDIT_ACTU );
		$this->setDescription ( ModuleActus::PAGE_EDIT_ACTU, "Affichage du formulaire de saisie des actualités" );
		
		$this->routage->setModuleRoutage ( ModuleActus::PAGE_VALID_ACTU, $this );
		$this->routage->ajouterPageSansIdent ( ModuleActus::PAGE_VALID_ACTU );
		$this->setDescription ( ModuleActus::PAGE_VALID_ACTU, "Validation de la saisie d'une actualités" );
	}
	
	/**
	 * Application du routage
	 */
	public function applicationRoutage($page) {
		$objMess = array ();
		
		switch ($page) {
			case ModuleActus::PAGE_GET_ACTUS :
				try {
					$objMess ['datas'] = array ();
					$objMess ['datas'] ['liste'] = $this->getActus ();
					$objMess ['datas'] ['nb'] = count ( $objMess ['datas'] ['liste'] );
					$objMess ['message'] = "Récupérations des actualités effectuée...";
					$objMess ['status'] = Routage::STATUS_OK;
				} catch ( Exception $e ) {
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
					unset ( $objMess ['data'] );
				}
				break;
			
			case ModuleActus::PAGE_EDIT_ACTU :
				$objMess ['datas-html'] = $this->getFormActus ();
				break;
			
			case ModuleActus::PAGE_VALID_ACTU :
				if (isset ( $_REQUEST ['titre-actu'] ) && isset ( $_REQUEST ['actu-content'] )) {
					$objMess ['datas'] = $this->saisieActu ( (isset ( $_REQUEST ['id-actu'] ) ? $_REQUEST ['id-actu'] : '-1'), $_REQUEST ['titre-actu'], $_REQUEST ['actu-content'], 1 );
					$objMess ['status'] = Routage::STATUS_WARNING;
					$objMess ['message'] = "En cours de dev....";
				} else {
					$objMess ['status'] = Routage::STATUS_WARNING;
					$objMess ['message'] = "En cours de dev....";
				}
				break;
			
			default :
				if (isset ( $objMess ['data'] ))
					unset ( $objMess ['data'] );
				$objMess ['message'] = 'Page inconnue ' . $page . '....';
				$objMess ['status'] = Routage::STATUS_ERR;
				break;
		}
		
		// retour de l'objet du message
		return $objMess;
	}
	
	/**
	 * Affichage de la saisie d'une actu
	 */
	public function getFormActus() {
		$formActus = '<form role-form="rich-form" role-form-page="' . ModuleActus::PAGE_VALID_ACTU . '"  id="form_actu">';
		$formActus .= '  <div class="form-item">';
		$formActus .= '    <span class="form-item-icon"><i class="fa fa-info fa-fw"></i></span>';
		$formActus .= '    <input role-form="item" role-form-name="form_actu" class="form-control" type="text" name="titre-actu" id="titre-actu" placeholder="Titre de l\'actualité" />';
		$formActus .= '  </div>';
		$formActus .= '  <div role-form="item" role-form-name="form_actu" class="form-item-div" name="actu-content" id="actu-content" contenteditable >';
		$formActus .= '  </div>';
		$formActus .= '  <div class="form-item">';
		$formActus .= '    <input type="submit" value="valider" />';
		$formActus .= '  </div>';
		$formActus .= '</form>';
		return $formActus;
	}
	
	/**
	 * Modification d'une actualité.
	 *
	 * @param unknown $idActu        	
	 * @param unknown $titreActu        	
	 * @param unknown $contenu        	
	 * @param number $type        	
	 */
	public function saisieActu($idActu, $titreActu, $contenu, $type = 1) {
		$sgbd = $this->routage->getSGBDRoutage ();
		$retour = array ();
		
		$retour ['message'] = "En cours de dev....";
		$sgbd->debuterTransaction ();
		try {
			// verouille l'actu si n
			$requete = "SELECT * FROM `" . $this->tableActus . "` WHERE `actualite_ID` = '$idActu' FOR UPDATE";
			$sgbd->envoyerRequete ( $requete );
			
			$tabDatas = array ();
			$tabDatas ['actualite_titre'] = $titreActu;
			$tabDatas ['actualite_date'] = time ();
			$tabDatas ['actualite_contenu'] = $contenu;
			
			if ($sgbd->getAffectedRow ()) {
				// Mise à jour;
				$setValues = SGBDMysql::traduireDataToUpdateValues ( $tabDatas );
				$requete = "UPDATE `" . $this->tableActus . "` SET $setValues WHERE `actualite_ID` = '$idActu'";
				$sgbd->envoyerRequete ( $requete );
			} else {
				$insertValues = SGBDMysql::traduireDataToInsertValues ( $tabDatas );
				$requete = "INSERT INTO `" . $this->tableActus . "` $insertValues";
				$sgbd->envoyerRequete ( $requete );
			}
			
			$retour ['id_actu'] = $idActu;
			$retour ['requete'] = $requete;
			$retour ['status'] = Routage::STATUS_OK;
		} catch ( Exception $e ) {
			$sgbd->annulerTransaction ();
			throw $e;
		}
		$sgbd->terminerTransaction ();
		return $retour;
	}
	
	/**
	 * Récupération des actus.
	 *
	 * TODO Il va falloir mettre en place la possibilité de récuperer des actus associé à une entité donnée (un club, un gestion d'evt etc).
	 *       Cette mécanique d'association se fera grâce à une table complémentaire permettant de gérer les liens entre une entité et une actualité
	 *      
	 * @throws Exception
	 */
	private function getActus() {
		$sgbd = $this->routage->getSGBDRoutage ();
		
		$nbActus = 0;
		$tab = array ();
		try {
			/*
			 * TODO Il va falloir ajouter la jointure sur la table des liens entité/actu. On pourra aussi ajouter des filtres de recherche sur les actualités
			 * Une actualité pourra être en base sous sa forme formattée et sous sa forme texte brut pour permettre de rendre possible certaines recherches sur le contenu
			 */
			$requete = "SELECT `actualite_ID`,`actualite_type`,`actualite_date`,`actualite_titre`,`actualite_contenu` FROM `" . $this->tableActus . "` ORDER BY `actualite_date` DESC";
			$sgbd->envoyerRequete ( $requete );
			$resultat = $sgbd->getResultat ( 'TAB-ASSOC' );
			
			$nbActus = $sgbd->getAffectedRow ();
			for($i = 0; $i < $nbActus; $i ++) {
				$row = $resultat [$i];				
				// remplissage de la actu avec les informations récupérées				
				$tab [] = $row;
			}
		} catch ( Exception $e ) {
			// erreur de récupération des données
			throw $e;
		}
		
		return $tab;
	}
}

?>