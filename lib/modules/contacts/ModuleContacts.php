<?php
class ModuleContacts extends Module {
	const PAGE_SEND_MAIL = "sendmail";
	const PAGE_FORM_MAIL = "formmail";
	
	/**
	 */
	public function activate() {
		/**
		 * TODO lecture potentielle en base de données
		 */
		$this->routage->setModuleRoutage ( ModuleContacts::PAGE_SEND_MAIL, $this );
		$this->routage->ajouterPageSansIdent ( ModuleContacts::PAGE_SEND_MAIL );
		$this->setDescription ( ModuleContacts::PAGE_SEND_MAIL, "Envoi d'un mail" );
		
		$this->routage->setModuleRoutage ( ModuleContacts::PAGE_FORM_MAIL, $this );
		$this->routage->ajouterPageSansIdent ( ModuleContacts::PAGE_FORM_MAIL );
		$this->setDescription ( ModuleContacts::PAGE_FORM_MAIL, "Envoi d'un mail" );
	}
	
	/**
	 * Application du routage
	 */
	public function applicationRoutage($page) {
		$objMess = array ();
		header ( 'Content-Type: text/html; charset=utf-8' );
		switch ($page) {
			case ModuleContacts::PAGE_FORM_MAIL :
				try {
					$objMess ['datas-html'] = $this->getFormulaireContacts ();
					$objMess ['message'] = "Formulaire récupéré...";
					$objMess ['status'] = Routage::STATUS_OK;
				} catch ( Exception $e ) {
					$objMess ['status'] = Routage::STATUS_ERR;
					$objMess ['message'] = $e->getMessage ();
					unset ( $objMess ['data'] );
				}
				break;
			case ModuleContacts::PAGE_SEND_MAIL :
				try {
					$this->sendMail ( array (
							'contact' => 'dsa.sylvain@gmail.com',
							'sujet' => '[Contact Tarbes Pyrénées Handball]',
							'corps' => 'coucou',
							'mail' => 'ssousa@isia.fr' 
					) );
					$objMess ['message'] = "Envoi du mail effectuée...";
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
	 * envois un mail au contact du site
	 *
	 * @param unknown $param        	
	 */
	private function sendMail($param) {
		// TODO Posibilité de controler les paramètre en vue de certifier l'intégrité de l'envoi
		$adressMail = $param ['contact'];
		$sujetMail = $param ['sujet'];
		try {
			$message = $param ["corps"];
			$headers = 'From: ' . $param ["mail"] . "\n";
			$headers .= 'Reply-To: ' . $param ["mail"] . "\n";
			$headers .= 'Content-Type: text/plain; charset="UTF-8"' . "\n";
			$headers .= 'Content-Transfer-Encoding: 8bit';
			
			mail ( $adressMail, $sujetMail, $message, $headers );
		} catch ( Exception $e ) {
			throw $e;
		}
	}
	private function getFormulaireContacts() {
		$formContactHTML = "";
		$formContactHTML .= '<form role-form="rich-form" role-form-page="' . ModuleContacts::PAGE_SEND_MAIL . '"  id="form-contacts">';
		$formContactHTML .= '	<input role-form="item" role-form-name="form-contacts" type="hidden" name="fromform" value="fromform" />';
		$formContactHTML .= '	<div class="form-item">';
		$formContactHTML .= '		<span class="form-item-icon"><i class="fa fa-user fa-fw"></i></span>';
		$formContactHTML .= '		<input role-form="item" role-form-name="form-contacts" class="form-control" type="text" name="nom" id="nom" placeholder="Nom" />';
		$formContactHTML .= '	</div>';
		$formContactHTML .= '	<div class="form-item">';
		$formContactHTML .= '		<span class="form-item-icon"><i class="fa fa-user fa-fw"></i></span>';
		$formContactHTML .= '		<input role-form="item" role-form-name="form-contacts" class="form-control" type="text" name="prenom" id="prenom" placeholder="Prénom" />';
		$formContactHTML .= '	</div>';
		$formContactHTML .= '	<div class="form-item">';
		$formContactHTML .= '		<span class="form-item-icon"><i class="fa fa-phone fa-fw"></i></span>';
		$formContactHTML .= '		<input role-form="item" role-form-name="form-contacts" class="form-control" type="text" name="telephone" id="telephone" placeholder="Téléphone" />';
		$formContactHTML .= '	</div>';
		$formContactHTML .= '	<div class="form-item">';
		$formContactHTML .= '		<span class="form-item-icon"><i class="fa fa-envelope fa-fw"></i></span>';
		$formContactHTML .= '		<input role-form="item" role-form-name="form-contacts" class="form-control" type="text" name="mail" id="mail" placeholder="Adresse Mail" />';
		$formContactHTML .= '	</div>';
		$formContactHTML .= '	<div class="form-item-text">';
		$formContactHTML .= '		<TextArea role-form="item" role-form-name="form-contacts" class="form-control text-libre" name="commentaires" id="commentaires">';
		$formContactHTML .= '		</TextArea>';
		$formContactHTML .= '	</div>';
		$formContactHTML .= '	<input type="submit" value="valider" />';
		$formContactHTML .= '</form>';
		return $formContactHTML;
	}
}

?>