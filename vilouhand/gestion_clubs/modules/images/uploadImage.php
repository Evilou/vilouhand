<?php
if (! defined ( 'TABLE_IMAGE' )) {
	header ( "HTTP/1.1 403 Forbidden" );
	die ();
}

// Structure de la table des images
// CREATE TABLE IF NOT EXISTS `images` (
// `image_id` int(10) NOT NULL AUTO_INCREMENT,
// `image_nom` varchar(60) NOT NULL,
// `image_fichier` varchar(255) NOT NULL,
// `image_statut` int(2) DEFAULT '0',
// PRIMARY KEY (`image_id`),
// UNIQUE KEY `image_nom` (`image_nom`)
// ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

// ################################################################################
// ATTENTION
// ---------------------------------
// il faut creer un dossier images et un dossiers images/tmp à la racine du site
//
// ################################################################################

$objMess ['datas'] = array ();

// Dans les versions de PHP antiéreures à 4.1.0, la variable $HTTP_POST_FILES
// doit être utilisée à la place de la variable $_FILES.
$uploaddir = '';

$result = $this->sgbd->debuterTransaction ();

$nbFichiers = isset ( $_FILES ) ? count ( $_FILES ) : 0;

foreach ( $_FILES as $fichier ) {
	if (! isset ( $_REQUEST ["nom_image"] ) || ! strcasecmp ( "", $_REQUEST ["nom_image"] )) {
		$result = $this->sgbd->annulerTransaction ();
		throw new Exception ( "Le nom de l'image n'a pas été renseigné." );
	}
	
	$nomFichierSource = $uploaddir . basename ( $fichier ['name'] );
	
	// Génération du nom de fichier de l'image
	do {
		$nomUnique = md5 ( $nomFichierSource . microtime () . mt_rand () );
	} while ( file_exists ( $nomUnique ) == true );
	
	$nomFichierSource = $nomUnique;
	
	$img = null;
	
	// On vérifie que le fichier est bien une image
	if (preg_match ( "/^image\/(.*)/", $fichier ['type'], $regs )) {
		if (! strcasecmp ( $regs [1], 'png' )) {
			$img = imagecreatefrompng ( $fichier ['tmp_name'] );
			$nomFichierSource = $nomFichierSource . '.png';
		} else {
			$img = imagecreatefromjpeg ( $fichier ['tmp_name'] );
			$nomFichierSource = $nomFichierSource . '.jpg';
		}
	}
	
	// initialisation du repertoire de destination
	$nomFichierDestTMP = 'images/tmp/' . $nomFichierSource;
	$nomFichierDest = 'images/' . $nomFichierSource;
	
	// Protège le cas d'une image où le fichier n'est pas une image ou si le format n'est pas compatible
	if ($img) {
		try {
			if (move_uploaded_file ( $fichier ['tmp_name'], $nomFichierDestTMP )) {
				$objMess ['status'] = Routage::STATUS_OK;
				$objMess ['message'] = "Le fichier est valide, et a été téléchargé avec succès.";
				
				if (isset ( $_REQUEST ["type_image"] )) {
					$type = $_REQUEST ["type_image"];
					// ajout d'un controle sur la valeur en request
				}
				
				// on protège les caractères particuliers
				$nom_image = addslashes ( $_REQUEST ["nom_image"] );
				
				// TODO On pourrait vérifier les message d'erreur pour les rendres plus sympa (Sexy) et en français
				$result = $this->sgbd->envoyerRequete ( "INSERT INTO " . TABLE_IMAGE . "( image_nom, image_fichier) VALUES( '" . $nom_image . "', '" . $nomFichierSource . "')" );
				
				$id_image = $this->sgbd->getLastInsertID ();
				
				if ($id_image) {
					$objMess ['datas'] ['id_image'] = $id_image;
					$objMess ['datas'] ['nom_image'] = $_REQUEST ["nom_image"];
					$objMess ['datas'] ['fichier_image'] = $nomFichierSource;
				} else {
					$objMess ['message'] = "Le fichier n'a pas été correctement aujouté.";
					$objMess ['status'] = Routage::STATUS_ERR;
				}
			} else {
				// Attention à la gestion des erreurs ici
				$result = $this->sgbd->annulerTransaction ();
				throw new Exception ( "Attaque potentielle par téléchargement de fichiers." );
			}
			copy ( $nomFichierDestTMP, $nomFichierDest );
			unlink ( $nomFichierDestTMP );
		} catch ( Exception $e ) {
			$result = $this->sgbd->annulerTransaction ();
			unlink ( $nomFichierDestTMP );
			throw $e;
		}
	}
}

// Dans le cas où il n'y a pas de fichier on est en erreur
if ($nbFichiers === 0) {
	$objMess ['message'] = "Le fichier n'a pas été correctement aujouté.";
	$objMess ['status'] = Routage::STATUS_ERR;
}
$result = $this->sgbd->terminerTransaction ();
?>