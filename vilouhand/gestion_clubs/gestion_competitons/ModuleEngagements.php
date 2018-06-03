<?php
class ModuleEngagements extends Module {
	const PAGE_GET_EQUIPES = "listeEngagees";
	
	/**
	 */
	public function activate() {
		/**
		 * TODO lecture potentielle en base de données
		 */
		/* ### récupération d'image ### */
		$this->routage->setModuleRoutage ( ModuleEngagements::PAGE_GET_EQUIPES, $this );
		$this->routage->ajouterPageSansIdent ( ModuleEngagements::PAGE_GET_EQUIPES );
		$this->setDescription ( ModuleEngagements::PAGE_GET_EQUIPES, "Récupération d'une liste de matchs" );
	}
	
	/**
	 * Application du routage
	 */
	public function applicationRoutage($page) {
		$objMess = array ();
		
		switch ($page) {
			case ModuleEngagements::PAGE_GET_EQUIPES :
				try {
					if (isset ( $_POST ['idCompetition'] )) {
						$objMess ['datas'] = array ();
						$objMess ['datas'] ['liste'] = $this->getEquipesEngagees ( $_POST ['idCompetition'] );
						$objMess ['datas'] ['nb'] = count ( $objMess ['datas'] ['liste'] );
						$objMess ['message'] = "Récupérations des engagements effectuée...";
						$objMess ['status'] = Routage::STATUS_OK;
					} else {
						if (isset ( $objMess ['data'] ))
							unset ( $objMess ['data'] );
						$objMess ['message'] = 'Il manque des informations pour récupérer la liste des engagements...';
						$objMess ['status'] = Routage::STATUS_ERR;
					}
				} catch ( Exception $e ) {
					if (isset ( $objMess ['data'] ))
						unset ( $objMess ['data'] );
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
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
	 * Récupération des equipes engagées dans une compétitions.
	 * Ces équipes seront disponnible pour ajouter des match et les associer à cette compétition.
	 *
	 * @param unknown $idCompetitions
	 *        	Identifiant de la compétition
	 * @return unknown[]
	 */
	private function getEquipesEngagees($idCompetitions) {
		$query_str = "SELECT ";
		$query_str .= " equipe_ID, equipe_nom, equipe_categorie, equipe_club, equipe_photo ";
		$query_str .= " FROM `engagements` ";
		$query_str .= " INNER JOIN `equipes` ON  e_equipe = equipe_ID";
		$query_str .= " WHERE e_competition = " . $idCompetitions;
		
		$sgbd = $this->routage->getSGBDRoutage ();
		$sgbd->debuterTransaction ();
		try {
			$result = $sgbd->envoyerRequete ( $query_str );
			$tabResult = $sgbd->getResultat ( 'TAB-ASSOC' );
			$sgbd->terminerTransaction ();
		} catch ( Exception $e ) {
			$sgbd->annulerTransaction ();
			throw $e;
		}
		return $tabResult;
	}
	
	/**
	 * Génère les matchs d'une compétitions pour le club courant
	 *
	 * @param unknown $idCompetitions        	
	 */
	private function genereMatchs($idCompetitions) {
		$refClubPrincipal = T_REF_CLUB;
		$tabEquipe = getEquipesEngagees ( $idCompetitions );
		
		$cmpt = 0;
		
		// On parcours la liste des equipes engagées
		// On va creer les match manquants
		for($i = 0; $i < count ( $tabEquipe ); $i ++) {
			for($j = 0; $j < count ( $tabEquipe ); $j ++) {
				// si l'equipe fait parti du club et que ce n'est pas l'equipe courrante on verifie les matchs
				if ($i != $j && $tabEquipe [$i] ['equipe_club'] == $refClubPrincipal) {
					// match aller
					$cmpt ++;
					$match = getMatch ( $idCompetitions, $tabEquipe [$i] ['equipe_ID'], $tabEquipe [$j] ['equipe_ID'] );
					if (! isset ( $match ['match_ID'] )) {
						echo "$cmpt : " . $tabEquipe [$i] ['equipe_nom'] . ' VS ' . $tabEquipe [$j] ['equipe_nom'] . "\n";
						echo nouveauMatch ( $idCompetitions, $tabEquipe [$i] ['equipe_ID'], $tabEquipe [$j] ['equipe_ID'] ) . "\n";
					}
					// match retour
					$cmpt ++;
					$match = getMatch ( $idCompetitions, $idCompetitions, $tabEquipe [$j] ['equipe_ID'], $tabEquipe [$i] ['equipe_ID'] );
					if (! isset ( $match ['match_ID'] )) {
						echo nouveauMatch ( $tabEquipe [$j] ['equipe_ID'], $tabEquipe [$i] ['equipe_ID'] ) . "\n";
						echo "$cmpt : " . $tabEquipe [$j] ['equipe_nom'] . ' VS ' . $tabEquipe [$i] ['equipe_nom'] . "\n";
					}
				}
			}
		}
	}
	
	/**
	 * Récupération d'un match associé à une compétition
	 *
	 * @param unknown $idCompetitions        	
	 * @param unknown $idEquipe1        	
	 * @param unknown $idEquipe2        	
	 * @param unknown $idChampionnnat        	
	 * @return unknown|multitype:
	 */
	private function getMatch($idCompetitions, $idEquipe1, $idEquipe2) {
		$query_str = "SELECT * ";
		$query_str .= " FROM `" . PREFIXE_TABLE . "matchs` ";
		$query_str .= " INNER JOIN `planifications` ON  `p_match_ID` = `match_ID`";
		$query_str .= " WHERE p_competition_ID = " . $idCompetitions . " AND match_home = " . $idEquipe1 . " AND match_visitors = " . $idEquipe2;
		
		$sgbd = $this->routage->getSGBDRoutage ();
		$sgbd->debuterTransaction ();
		try {
			$result = $sgbd->envoyerRequete ( $query_str );
			$tabResult = $sgbd->getResultat ( 'TAB-ASSOC' );
			$sgbd->terminerTransaction ();
			
			if (count ( $tabResult ) != 1)
				return array ();
			else
				return $tabResult [0];
		} catch ( Exception $e ) {
			$sgbd->annulerTransaction ();
			throw $e;
		}
		
		return array ();
	}
	
	/**
	 *
	 * @param unknown $idCompetitions        	
	 * @param unknown $idEquipe1        	
	 * @param unknown $idEquipe2        	
	 */
	private function nouveauMatch($idCompetitions, $idEquipe1, $idEquipe2) {
		$sgbd = $this->routage->getSGBDRoutage ();
		$sgbd->debuterTransaction ();
		try {
			
			$query_str = "INSERT INTO `matchs` ( match_home, match_visitors) VALUES ( $idEquipe1, $idEquipe2)";
			
			// début transaction
			$result = $sgbd->envoyerRequete ( $query_str );
			
			$idMatch = $mysqli->insert_id;
			
			$query_str = "INSERT INTO `planifications` ( `p_competition_ID`, `p_match_ID`) VALUES ( '" . $idCompetitions . ", '" . $idMatch . "');";
			$result = $sgbd->envoyerRequete ( $query_str );
			$sgbd->terminerTransaction ();
		} catch ( Exception $e ) {
			$sgbd->annulerTransaction ();
			throw $e;
		}
	}
}
?>