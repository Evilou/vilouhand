<?php
class ModuleMatchs extends Module {
	const PAGE_GET_MATCHS = "getmatchs";
	private $listeParam;
	
	/**
	 * Intégration du module dans la table de routage
	 */
	public function activate() {
		/**
		 * TODO lecture potentielle en base de données
		 */
		$this->routage->setModuleRoutage ( ModuleMatchs::PAGE_GET_MATCHS, $this );
		$this->routage->ajouterPageSansIdent ( ModuleMatchs::PAGE_GET_MATCHS );
		$this->setDescription ( ModuleMatchs::PAGE_GET_MATCHS, "Récupération d'une liste de matchs" );
		
		$this->listeParam = array (
				'idCompetition',
				'idEquipe',
				'played',
				'idequipe1',
				'idequipe2',
				'idclub',
				'categorie',
				'nbItems',
				'firstItem' 
		);
	}
	
	/**
	 * Application du routage associé à ce module
	 */
	public function applicationRoutage($page) {
		// header ( 'Content-Type: text/html;charset=UTF-8' );
		$objMess = array ();
		
		switch ($page) {
			case ModuleMatchs::PAGE_GET_MATCHS :
				try {
					$tabParam = array ();
					// récupération des paramètres
					for($indParam = 0; $indParam < count ( $this->listeParam ); $indParam ++) {
						if (isset ( $_REQUEST [$this->listeParam [$indParam]] ))
							$tabParam [$this->listeParam [$indParam]] = $_REQUEST [$this->listeParam [$indParam]];
					}
					
					$objMess ['datas'] ['liste'] = $this->getMatchs ( $tabParam );
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
	 * Récupération des matchs
	 *
	 * @param
	 *        	param Paramètre permettant de filter la récupération de match*
	 *        	Liste des paramètres (aucun n'est obligatoire)
	 *        	- idCompetition : on récupère tous les matchs associés à une compétition
	 *        	- idEquipe : on récupère tous les matchs de l'equipe représentée par cette identifiant
	 *        	- played : Y/N permet de savoir si un match est joué 'Y' ou non 'N'
	 *        	- idequipe1 et idequipe2 : Idenditiants des equipes des matchs à récuperer
	 *        	- idclub : idenditiant du club d'au moins une des equipes des matchs à récuperer
	 *        	- categorie : Categorie des matchs à récupérer
	 *        	- nbItems : Nombre d'item à récupérer
	 *        	- firstItem : Indice du première item à récupérer (aucun effet si nbItems non reseigné)
	 */
	private function getMatchs($param) {
	/* Requete avec jointure pour récupérere la liste des match planifiée
	 * 
	 * select `matchs`.`match_ID` AS `match_ID`,
	       `matchs`.`match_score_home` AS `match_score_home`,
	       `matchs`.`match_score_visitors` AS `match_score_visitors`,
	       `equipe1`.`equipe_ID` AS `equipe1_ID`,
	       `equipe1`.`equipe_nom` AS `equipe1_nom`,
	       `club1`.`club_ID` AS `club1_ID`,
	       `club1`.`club_nom` AS `club1_nom`,
	       `images1`.`image_fichier` AS `club1_logo`,
	       `equipe2`.`equipe_ID` AS `equipe2_ID`,
	       `equipe2`.`equipe_nom` AS `equipe2_nom`,
	       `club2`.`club_ID` AS `club2_ID`,
	       `club2`.`club_nom` AS `club2_nom`,
	       `images1`.`image_fichier` AS `club2_logo`,
	       `planifications`.`p_ID` AS `p_ID`,
	       `planifications`.`p_date` AS `p_date`,
	       `planifications`.`p_salle_ID` AS `p_salle_ID`,
	       `competitions`.`c_ID` AS `c_ID`,
	       `competitions`.`c_saison_ID` AS `c_saison_ID`,
	       `competitions`.`c_nom` AS `c_nom`,
	       `competitions`.`c_url_ffhb` AS `c_url_ffhb`,
	       `competitions`.`c_categorie_ID` AS `c_categorie_ID`,
	       `competitions`.`c_type` AS `c_type` 
	       FROM `matchs` join `equipes` `equipe1` on (`matchs`.`match_home` = `equipe1`.`equipe_ID`)
	                     join `clubs` `club1` on (`equipe1`.`equipe_club` = `club1`.`club_ID`)
	                     left join `images` `images1` on (`club1`.`club_logo` = `images1`.`image_ID`)
	                     join `equipes` `equipe2` on (`matchs`.`match_visitors` = `equipe2`.`equipe_ID`)
	                     join `clubs` `club2` on (`equipe2`.`equipe_club` = `club2`.`club_ID`)
	                     left join `images` `images2` on (`club2`.`club_logo` = `images2`.`image_ID`)
	                     left join `planifications` on (`planifications`.`p_match_ID` = `matchs`.`match_ID`)
	                     join `competitions` on (`competitions`.`c_ID` = `planifications`.`p_competition_ID`)	
	 */
			
		$refClubPrincipal = T_REF_CLUB;
		
		$sgbd = $this->routage->getSGBDRoutage ();
		
		$sgbd->debuterTransaction ();
		
		$ordre = 'DESC';
		
		try {
			// Condition initiale
			$condition = " WHERE (`club1_ID` = '" . $refClubPrincipal . "'  OR `club2_ID` = '" . $refClubPrincipal . "') ";
			
			/* filtre des matchs sur une compétition */
			if (isset ( $param ['idCompetition'] )) {
				$condition .= " AND (`c_ID` = '" . $param ['idCompetition'] . "') ";
			}
			
			/* filtre pour une équipe donnée */
			/* Securiser pour les equipes du club principal */
			if (isset ( $param ['idEquipe'] )) {
				$condition .= " AND ( `equipe1_ID` = '" . $param ['idEquipe'] . "'   OR `equipe2_ID` = '" . $param ['idEquipe'] . "' ) ";
			}
			
			/* filtre sur l'etat d'un match (played = Y/N) */
			if (isset ( $param ['played'] )) {
				if (! strcmp ( 'Y', $param ['played'] )) {
					$ordre = 'DESC';
					$condition .= ' AND ( ( NOT `match_score_home` = 0 AND NOT `match_score_visitors` = 0) AND NOT `p_date` = \'\') ';
				} else {
					$ordre = 'ASC';
					$condition .= ' AND ( ( `match_score_home` = 0 AND `match_score_visitors` = 0) AND NOT `p_date` = \'\'';
					$todayTime = time ();
					$condition .= '  AND `p_date` >  ' . ($todayTime) . ") ";
				}
			}
			
			/* Affiche tous les matchss entre 2 equipes */
			/* Securiser pour les equipes du club principal pour equipe 1 ou equipe 2 */
			if (isset ( $param ['idequipe1'] ) && isset ( $param ['idequipe2'] )) {
				$condition .= ' AND ( ( `equipe1_ID` = ' . $param ['idequipe1'] . ' AND `equipe2_ID` = ' . $param ['idequipe2'] . ') ';
				$condition .= '    OR ( `equipe1_ID` = ' . $param ['idequipe2'] . ' AND `equipe2_ID` = ' . $param ['idequipe1'] . ') ) ';
			}
			
			/* tous les matchs d'un club */
			if (isset ( $param ['idclub'] )) {
				$condition .= " AND ( `club1_ID` = " . $param ["idclub"] . " OR `club2_ID` = " . $param ["idclub"] . ") ";
			}
			
			/* tous les matchs d'une categorie */
			if (isset ( $param ['categorie'] )) {
				$condition .= " AND ( `c_categorie_ID` = '" . $param ["categorie"] . ") ";
			}
			
			/* envois de la requete */
			$requete = "SELECT * FROM `matchs_complets` $condition ORDER BY p_date $ordre ";
			
			/*
			 * Ajout de la limitation au niveau de la requête
			 *
			 * possible de faire le tri sur le parcours du resultat ci-dessous
			 */
			if (isset ( $param ['nbItems'] )) {
				$requete .= " LIMIT ";
				if (isset ( $param ['firstItem'] ))
					$requete .= $param ['firstItem'] . ', ';
				$requete .= $param ['nbItems'] . ', ';
			}
			
			/*
			 * Ajout des conditions pour le filtre elle auront une influance sur la quantité de données
			 */
			$sgbd->envoyerRequete ( $requete );
			$resultat = $sgbd->getResultat ( 'TAB-ASSOC' );
			
			$nbMatchs = $sgbd->getAffectedRow ();
			
			$sgbd->terminerTransaction ();
		} catch ( Exception $e ) {
			$sgbd->annulerTransaction ();
			throw $e;
		}
		
		$tab = array ();
		
		// Parcours de la liste des matchs récupérés pour construire le tableau de résultat
		for($i = 0; $i < $nbMatchs; $i ++) {
			$row = $resultat [$i];
			$match = array ();
			$match ['ID'] = $row ['match_ID'];
			
			// Gestion de la date sous toute ses formes
			$date = $row ['p_date'];
			$match ['dateInt'] = $date;
			if ($date) {
				$match ['date'] = utf8_encode ( strftime ( '%d %b', $date ) );
				$match ['jour'] = utf8_encode ( strftime ( '%d', $date ) );
				$match ['moi'] = utf8_encode ( strftime ( '%b', $date ) );
				$match ['heure'] = utf8_encode ( strftime ( '%Hh%M', $date ) );
			}
			
			// Informations du championnat
			$match ['competition_id'] = $row ['c_ID'];
			$match ['competition'] = $row ['c_nom'];
			
			// On recherche si une des deux equipes fait partie du club
			if ($row ['club1_ID'] == $refClubPrincipal) {
				$match ['equipe-club'] = $row ['equipe1_ID'];
			} else if ($row ['club2_ID'] == $refClubPrincipal) {
				$match ['equipe-club'] = $row ['equipe2_ID'];
			}
			
			// gestion des informations de l'équipe 1
			$equipe1 = array ();
			$equipe1 ['ID'] = $row ['equipe1_ID'];
			$equipe1 ['nom'] = $row ['equipe1_nom'];
			$equipe1 ['score'] = $row ['match_score_home'];
			$equipe1 ['club_ID'] = $row ['club1_ID'];
			$equipe1 ['logo'] = $row ['club1_logo'];
			$equipe1 ['gagant'] = (($row ['match_score_home'] > $row ['match_score_visitors']) ? 'oui' : 'non');
			
			$match ['equipe1'] = $equipe1;
			
			// gestion des informations de l'équipe 2
			$equipe2 = array ();
			$equipe2 ['ID'] = $row ['equipe2_ID'];
			$equipe2 ['nom'] = $row ['equipe2_nom'];
			$equipe2 ['score'] = $row ['match_score_visitors'];
			$equipe2 ['club_ID'] = $row ['club2_ID'];
			$equipe2 ['logo'] = $row ['club2_logo'];
			$equipe2 ['gagant'] = (($row ['match_score_home'] < $row ['match_score_visitors']) ? 'oui' : 'non');
			
			$match ['equipe2'] = $equipe2;
			
			// on ajoute le tableau des informations du match au tableau principal
			$tab [] = $match;
		}
		return $tab;
	}
}
?>