function initListeActus(idListeObj){
	var listeObj = document.getElementById(idListeObjs);
	
	if (listeObj != null && listeActus.getAttribute("role-list") != null) {
		var tab = {
			url : "mapping.php",
			page : formulaire.getAttribute("role-list-page"),
			attributs : new FormData(),
			cible : formulaire.getAttribute("role-liste-cible"),
			callback : formulaire.getAttribute("role-list-callback"),
			callbackERR : formulaire.getAttribute("role-list-callbackERR"),
			silent :  formulaire.getAttribute("role-list-silent")
		};

		requeteServeur(tab);
	}
}

/**
 * 
 */
function genereObjList(){
	
}


/**
 * Gestionnaire d'affichage des actualités d'une liste
 */
function GestionnaireActu(idListeActu) {
	// Id de l'objet liste à gérer
	this.idListeActu = idListeActu;
	
	this.initActus = function() {
		var req = null;

		if (window.XMLHttpRequest)
			req = new XMLHttpRequest();
		else if (window.ActiveXObject)
			req = new ActiveXObject("Microsoft.XMLHTTP");

		req.gestionnaireActu = this;
		req.onreadystatechange = function() {
			if (req.readyState == 4) {
				if (req.status == 200) {
					var datasActu = null;
					datasActu = req.responseText;
					var tabDatas = JSON.parse(datasActu);
					for (var ind = 0; ind < tabDatas.length ; ind++){
						this.gestionnaireActu.genereObjActu(tabDatas[ind]);
					}
				}
			}
		};

		var url = "datas/getactu.php";
		req.open("GET", url, true);
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");

		req.send();
	}


	
	this.genereObjActu = function (tabData) {		
		var elementListe = document.getElementById(this.idListeActu);
		if (elementListe != null) {
			var mainObj = document.createElement("li");
			mainObj.className = "actualite-obj";
			var actuElement = document.createElement("div");
			actuElement.className = "actualite";
			var imageElement = document.createElement("div");
			imageElement.className = "image";
			var enteteElement = document.createElement("div");
			enteteElement.className = "entete";
			var accrocheElement = document.createElement("span");
			accrocheElement.className = "accroche";
			var dateElement = document.createElement("span");
			dateElement.className = "date";
			var detailElement = document.createElement("div");
			detailElement.id = this.idListeActu + "_detailActu_" + tabData.ID;
			detailElement.className = "detail";
			var contenuElement = document.createElement("span");
			contenuElement.className = "contenu";
			enteteElement.gestionnaire = this;
			
			if (tabData.type == "0"){
				mainObj.style.order = "-1";
			}
			
			
			// Il va falloir ajouter une div avec l'image pour gérer le retaillage
			//mainObj.style.backgroundImage = "url(style/datas/" + "logoTPH.jpg" + ")";
			var imageContainer = document.createElement('div');
			var imageActu = document.createElement('img');
			imageContainer.appendChild(imageActu);
			if (tabData['image'] == null){
				imageActu.src = "style/datas/tphNB.png";		
			}else{
				imageActu.src = 'images/' + tabData['image'];				
			}
			imageContainer.className = 'image-actu-container';
			imageActu.className = 'image';
			detailElement.appendChild(imageContainer);
			accrocheElement.innerHTML = tabData.titre;
			dateElement.innerHTML = tabData.date;
			contenuElement.innerHTML = tabData.contenu;

			enteteElement.appendChild(accrocheElement);
			enteteElement.appendChild(dateElement);
			//actuElement.appendChild(imageElement);
			actuElement.appendChild(enteteElement);

			detailElement.appendChild(contenuElement);

			mainObj.appendChild(actuElement);
			mainObj.appendChild(detailElement);
			elementListe.appendChild(mainObj);
		}
	}

}