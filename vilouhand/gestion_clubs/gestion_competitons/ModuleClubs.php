<?php
class ModuleClubs extends Module {
	const PAGE_GET_CLUBS = "getclubs";
	const TABLE_CLUBS = "clubs";
	private $tableClubs = ModuleClubs::TABLE_CLUBS;
	private $tableImages = ModuleImages::TABLE_IMAGES;
	private $listeParam;
	
	/**
	 *
	 * @param Routage $routage        	
	 */
	public function ModuleClubs(Routage $routage) {
		parent::__construct ( $routage );
		if (defined ( T_PREFIXE_TABLE )) {
			$this->tableClubs = T_PREFIXE_TABLE . ModuleClubs::TABLE_CLUBS;
			$this->tableImages = T_PREFIXE_TABLE . ModuleImages::TABLE_IMAGES;
		}
	}
	
	/**
	 * Intégration du module dans la table de routage
	 */
	public function activate() {
		/**
		 * TODO lecture potentielle en base de données
		 */
		$this->routage->setModuleRoutage ( ModuleClubs::PAGE_GET_CLUBS, $this );		
		// la page de récupération des clubs ne nécessite pas d'identification
		$this->routage->ajouterPageSansIdent ( ModuleClubs::PAGE_GET_CLUBS );
		$this->setDescription ( ModuleClubs::PAGE_GET_CLUBS, "Récupération d'une liste des clubs" );
		
		$this->listeParam = array (
				'idclub',
				'txtclub' 
		);
	}
	
	/**
	 * Application du routage associé à ce module
	 */
	public function applicationRoutage($page) {
		header ( 'Content-Type: text/html;charset=UTF-8' );
		$objMess = array ();
		
		switch ($page) {
			case ModuleClubs::PAGE_GET_CLUBS :
				try {
					$tabParam = array ();
					// récupération des paramètres
					for($indParam = 0; $indParam < count ( $this->listeParam ); $indParam ++) {
						
						if (isset ( $_REQUEST [$this->listeParam [$indParam]] ))
							$tabParam [$this->listeParam [$indParam]] = $_REQUEST [$this->listeParam [$indParam]];
					}
					$objMess ['datas'] ['liste'] = $this->getClubs ( $tabParam );
					$objMess ['datas'] ['nb'] = count ( $objMess ['datas'] ['liste'] );
					$objMess ['message'] = "Récupérations des matchs effectuée...";
					$objMess ['status'] = Routage::STATUS_OK;
				} catch ( Exception $e ) {
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
					unset ( $objMess ['data'] );
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
	 * Récupération d'une liste de club
	 *
	 * @param unknown $param        	
	 * @throws Exception
	 */
	private function getClubs($param) {
		$refClubPrincipal = T_REF_CLUB;
		
		$sgbd = $this->routage->getSGBDRoutage ();
		
		$sgbd->debuterTransaction ();
		
		try {
			$condition = "";
			
			if (isset ( $param ['idclub'] )) {
				if (strcmp ( "", $condition )) {
					$condition .= " AND ";
				}
				
				$condition .= " `" . $this->tableClubs . "`.`club_ID` = '" . $param ['idclub'] . "'";
			}
			
			if (isset ( $param ['txtclub'] )) {
				if (strcmp ( "", $condition )) {
					$condition .= " AND ";
				}
				$condition .= " LOWER(`" . $this->tableClubs . "`.`club_nom`) LIKE '%" . strtolower ( $param ["txtclub"] ) . "%'";
			}
			
			$query_str = "SELECT ";
			
			$query_str .= " `club_ID`, `club_nom`, `club_court`, `club_logo`, `image_nom`, `image_fichier` ";
			
			$query_str .= " FROM `" . $this->tableClubs . "` ";
			
			$query_str .= " INNER JOIN `" . $this->tableImages . "`  ON `" . $this->tableImages . "`.`image_ID` = `" . $this->tableClubs . "`.`club_logo` ";
			
			if (strcmp ( "", $condition )) {
				$query_str .= " WHERE $condition ";
			}
			$result = $sgbd->envoyerRequete ( $query_str );
			$tabResult = $sgbd->getResultat ( 'TAB-ASSOC' );
			
			$sgbd->terminerTransaction ();
		} catch ( Exception $e ) {
			$sgbd->annulerTransaction ();
			throw $e;
		}
		
		return $tabResult;
	}
}
?>