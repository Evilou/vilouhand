<?php
header ( 'Content-Type: application/javascript' );
// require_once '../config.php';
?>
/**
 * Le but de ce Script est de pouvoir mettre en place des formulaires pouvant
 * être enrichies avec des objets n'étant pas des inputs par défaut
 * 
 * 
 * Le formulaire devra avoir l'attribut role-form="rich-form". Les items de ce
 * formulaire devront avoir l'attribut role-form="item" pour ête pris en compte.
 * 
 * 
 */
if (document.addEventListener) {
	document.addEventListener("readystatechange", initForm, false);
} else if (document.attachEvent) {
	document.attachEvent("onreadystatechange", initForm);
}

/**
 * Initialisation des composants en vu d'une utilisation spécifique des
 * formulaire de type role-form
 */
function initForm() {
	if ("complete" == document.readyState) {
		var formulairesTab = document.getElementsByTagName('form');		
		$('form[role-form="rich-form"]').each(function(indForm, form) {
			// Initialisation du comportement du formulaire à la validation
			// (submit)
			if (form['role-state'] != 'initialized') {
				if (form.addEventListener) {
					form.addEventListener("submit", submitForm, false);
				} else if (document.attachEvent) {
					form.attachEvent("submit", submitForm);
				}
				form['role-state'] = 'initialized';
			}
		});
	}
}

/**
 * 
 * @param event
 */
function submitForm(event) {
	event.stopPropagation();
	event.preventDefault();
	submitRoleForm(event.target.id);
}

/**
 * 
 * @param idForm
 */
function submitRoleForm(idForm) {
	/**
	 * role-form-page ( page nécessaire à l'appel de la requête )
	 * role-form-cible ( identifiant de la zone cible )
	 */
	var formulaire = document.getElementById(idForm);
	
	if (formulaire != null && formulaire.getAttribute("role-form") != null) {

		var tab = {
			url : "mapping.php",
			page : formulaire.getAttribute("role-form-page"),
			attributs : getAttFromForm(formulaire.id),
			cible : formulaire.getAttribute("role-form-cible"),
			callback : formulaire.getAttribute("role-form-callback"),
			callbackERR : formulaire.getAttribute("role-form-callbackERR"),
			silent :  formulaire.getAttribute("role-form-silent")
		};

		requeteServeur(tab);
	}
}

/**
 * Extraction dest attribut d'un formulaire sous forme de chaine d'attributs
 * 
 * @param idFormulaire
 * @param tabChamps
 * @returns {String}
 */
function getAttFromForm(idFormulaire) {
	var formulaire = document.getElementById(idFormulaire);

	var formData = new FormData();

	var valueElement = "";
	var nameElement = "";
	var attributs = "";
	
    /**
     * On récupère tous les sous-items associées au formulaire
     */
	$('#' + idFormulaire ).find('*[role-form="item"][role-form-name="'+ idFormulaire +'"]').each(function(i, el) {		
		if (el["role-form"]) {
			nameElement = el["role-form"];
		} else if (el["name"]) {
			nameElement = el["name"];
		} else if (el["id"]) {
			nameElement = el["id"];
		}

		if (el['type'] == 'file') {
			var files = el.files;
			for (var i = 0; i < files.length; i++) {
				var file = files[i];

				// Vérification du type de fichier
				if (!file.type.match('image.*')) {
					continue;
				}

				// Add the file to the request.
				formData.append(nameElement, file, file.name);
			}

		} else {
			if (el['type'] == 'checkbox') {
				valueElement = (el.checked ? 'O' : 'N');
			} else if (el.value)
				valueElement = el.value;
			else
				valueElement = el.innerHTML;
			formData.append(nameElement, valueElement);
		}

	});
	return formData;
}