<?php
class ModuleImages extends Module {
	const PAGE_UPLOAD_IMAGE = "uploadImg";
	const PAGE_GET_IMAGE = "getImg";
	const TABLE_IMAGES = "images";
	
	/**
	 */
	public function activate() {
		/**
		 * TODO lecture potentielle en base de données
		 * ATTENTION on ne passe plus par des scripts mais par des objets
		 */
		// ajout de la liste de pages
		
		/* ### upload d'image ### */
		$this->routage->setModuleRoutage ( ModuleImages::PAGE_UPLOAD_IMAGE, $this );
		$this->routage->ajouterPageSansIdent ( ModuleImages::PAGE_UPLOAD_IMAGE );
		$this->setDescription ( ModuleImages::PAGE_UPLOAD_IMAGE, "Ajout d'une image sur le serveur" );
		
		/* ### récupération d'image ### */
		$this->routage->setModuleRoutage ( ModuleImages::PAGE_GET_IMAGE, $this );
		$this->routage->ajouterPageSansIdent ( ModuleImages::PAGE_GET_IMAGE );
		$this->setDescription ( ModuleImages::PAGE_GET_IMAGE, "Réccupération du chemin d'une image se trouvant sur le serveur." );
	}
	
	/**
	 * Récupération d'une image
	 * 
	 * @param String $refImage
	 *        	Référence de l'image à récupérer
	 */
	public function getImage($refImage) {
		$sgbd = $this->routage->getSGBDRoutage ();
		$sgbd->debuterTransaction ();
		try {
			$requete = "SELECT `image_fichier` FROM " . ModuleImages::TABLE_IMAGES . " WHERE `image_nom` ='" . $refImage . "'";
			$sgbd->envoyerRequete ( $requete );
			$resultat = $sgbd->getResultat ( 'SINGLE-ASSOC' );
			if (isset ( $resultat ['image_fichier'] ))
				return $resultat ['image_fichier'];
			else
				return '';
		} catch ( Exception $e ) {
			$result = $sgbd->annulerTransaction ();
			throw $e;
		}
		$sgbd->terminerTransaction ();
	}
	
	/**
	 * Application du routage
	 */
	public function applicationRoutage($page) {
		$objMess = array ();
		
		switch ($page) {
			/**
			 * Upload d'une nouvelle image
			 */
			case ModuleImages::PAGE_UPLOAD_IMAGE :
				try {
					// Routage d'upload image
					require_once 'uploadImage.php';
				} catch ( Exception $e ) {
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
					unset ( $objMess ['data'] );
				}
				break;
			
			/**
			 * Récupération des images
			 */
			case ModuleImages::PAGE_GET_IMAGE :
				try {
					header ( 'Content-Type: text/HTML; charset=UTF-8' );
					/**
					 * Il faut mettre en place une gestion des statuts d'une image dans le moteur.
					 * Les images sont créés avec un statut défaut à 0
					 */
					// Controle de la récupération des images
					$objMess ['data'] = array ();
					$objMess ['status'] = Routage::STATUS_OK;
					$refImage = "";
					
					if (isset ( $_REQUEST ['refImage'] )) {
						$refImage = $_REQUEST ['refImage'];
					} else {
						$refImage = 'defaut';
						$objMess ['message'] = 'Référence image non renseignée ...';
						$objMess ['status'] = Routage::STATUS_WARNING;
					}
					
					// Récupération de l'image
					$chemin = ModuleImages::getImage ( $refImage );
					
					if (strcmp ( $chemin, "" )) {
						$objMess ['data'] ['reference'] = $refImage;
						$objMess ['data'] ['path'] = $chemin;
					} else {
						$objMess ['status'] = Routage::STATUS_ERR;
						$objMess ['message'] = "Impossible de trouver une image pour la référence '" . $refImage . "'";
						if (isset ( $objMess ['data'] ))
							unset ( $objMess ['data'] );
					}
				} catch ( Exception $e ) {
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
					if (isset ( $objMess ['data'] ))
						unset ( $objMess ['data'] );
				}
				break;
		}
		
		// retour de l'objet du message
		return $objMess;
	}
}
?>
