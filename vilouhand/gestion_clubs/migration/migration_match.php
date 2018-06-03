<?php
setlocale ( LC_TIME, "fr_FR.UTF-8", "French_France.1252" );

error_reporting ( E_ALL );

// connexion à la base de données
$mysqli = new mysqli ( "localhost", "root", "", "tph" );

/**
 * ******************************************************************
 * Construction de la table des compétitions
 * Va engendrer :
 * - La suppression de la table championnats
 *
 *
 *
 * UPDATE `planifications`
 * INNER JOIN `tph2014_matchs` ON `planifications`.`p_match_ID` = `tph2014_matchs`.`match_ID`
 * SET `planifications`.`p_date` = `tph2014_matchs`.`match_date`
 * WHERE `planifications`.`p_match_ID`
 * IN (SELECT match_ID FROM `tph2014_matchs` where `tph2014_matchs`.`match_championnat` = 21)
 *
 * UPDATE `matchs`
 * INNER JOIN `tph2014_matchs` ON `matchs`.`match_ID` = `tph2014_matchs`.`match_ID`
 * SET `matchs`.`match_score_home` = `tph2014_matchs`.`match_score_home`, `matchs`.`match_score_visitors` = `tph2014_matchs`.`match_score_visitors`
 *
 *
 *
 * *******************************************************************
 */
// envois de la requête
$requete = "SELECT * FROM championnats";
$resultat = $mysqli->query ( $requete );

// Lecture du résultat
$numLignes = $resultat->num_rows;

for($i = 0; $i < $numLignes; $i ++) {
	// lecture ligne à ligne
	$ligne = $resultat->fetch_assoc ();
	$requete = "SELECT * FROM categories WHERE c_ref = '" . $ligne ['championnat_categorie'] . "'";
	$resultatC = $mysqli->query ( $requete );
	$categorie = - 1;
	if ($resultatC->num_rows === 1) {
		$categorieOBJ = $resultatC->fetch_assoc ();
		$categorie = $categorieOBJ ['c_ID'];
	}
	$requete = "INSERT INTO `competitions`(c_ID, c_saison_ID, c_nom, c_categorie_ID, c_url_ffhb) VALUES (" . $ligne ['championnat_ID'] . ', ' . $ligne ['championnat_saison'] . ", '" . addslashes ( $ligne ['championnat_nom'] ) . "', " . $categorie . ", '" . addslashes ( $ligne ['championnat_ffhb'] ) . "')";
	echo $requete . '<br/>';
	$mysqli->query ( $requete );
}

/**
 * ******************************************************************
 * Construction de la table des planifications
 * Va engendrer la suppression des champs (match_championnat, match_date, match_salle) de la table matchs
 * *******************************************************************
 */
$requete = "SELECT * FROM matchs";
$resultat = $mysqli->query ( $requete );

// Lecture du résultat
$numLignes = $resultat->num_rows;

for($i = 0; $i < $numLignes; $i ++) {
	// lecture ligne à ligne
	$ligne = $resultat->fetch_assoc ();
	
	// var_dump($ligne);
	$requete = "INSERT INTO `planifications`(p_competition_ID, p_match_ID, p_date, p_salle_ID) VALUES (" . $ligne ['match_championnat'] . ', ' . $ligne ['match_ID'] . ", " . (! strcmp ( "", $ligne ['match_date'] ) ? "NULL" : $ligne ['match_date']) . ", " . (! strcmp ( "", $ligne ['match_salle'] ) ? "NULL" : $ligne ['match_salle']) . ")";
	$mysqli->query ( $requete );
}
?>