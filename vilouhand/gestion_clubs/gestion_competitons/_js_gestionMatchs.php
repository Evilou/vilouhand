<?php
header ( 'Content-Type: application/javascript' );
?>
/**
 * Classe de gestion des l'affichage des matchs
 */
function GestionnaireMatchs(id_gest) {
	this.ID = id_gest;
	
	window[this.ID] = this;
	
	/**
	 * Récupération des datas match à afficher
	 */
	this.getDatas = function(param){
		var tab = {
				url : "mapping.php",
				page : "getmatchs",
				attributs : null,
				cible : null,
				callback : this.ID + ".traiteDataMatchs" ,
				callbackERR :null,
				silent :  false
			};

			requeteServeur(tab);
	}
	
	/**
	 * Traitement des données des matchs récupérés
	 */
	this.traiteDataMatchs = function(datas){
		// positionnement sur la zone à remplir
		var idMainDiv = "main-matchs-gest-" + this.ID;
		mainDiv = document.getElementById(idMainDiv);

		// Si la zone n'existe pas on la créé et on la place dans le body
		if (mainDiv == null){
			mainDiv = document.createElement('div');
			mainDiv.id = idMainDiv;
			mainDiv.className = 'matchs-container';
			document.getElementsByTagName('body')[0].appendChild(mainDiv);
		}else{
			// on ne fait rien si la zone existe
		}
		
		for( var indice = 0; indice < datas['nb'] ; indice ++ ){
			// génération de l'affichage d'un math 
			var objMatch = this.genereObjMatch(datas['liste'][indice]);
			if (objMatch != null){
				mainDiv.appendChild(objMatch );				
			}
		}
	}
	
	/**
	 * Génère un composant permettant de representer un match
	 * @param datasMatch Données necessaires à la génération de l'objet
	 */
	this.genereObjMatch = function( datasMatch ){
		var idObjMatch = this.ID + 'match-' + datasMatch.ID;
		
		// création du composant principal
		var mainObj = document.getElementById(idObjMatch);

		if (mainObj == null ){
			// création d'un nouveau composant
			mainObj = document.createElement('li');
			mainObj.className = 'visu match-obj';
			mainObj.id = idObjMatch;
		}else{
			mainObj.innerHTML = "";
		}
				
		var nomCompetition = document.createElement('span');
		nomCompetition.className = 'nom-competition';
		
		// l'information peut être le nom d'un championnat ou d'une coupe ou autre
		if (datasMatch['competition'] != null) {
			nomCompetition.innerHTML = datasMatch['competition'];
		}
		mainObj.appendChild(nomCompetition);
		
		// Gestion des informations complementaires (date, salle, etc...)
		var infosContainer = document.createElement('div');
		infosContainer.className = "infos-container";
		mainObj.appendChild(infosContainer);
		
		
		// gestion des information date et heure du match
		if (datasMatch['dateInt'] != null && datasMatch['jour'] != null && datasMatch['moi']  != null && datasMatch['heure']  != null ) {
			var dateInt = datasMatch['dateInt'];
			var date = document.createElement('div');
			date.className = 'date';
			
			var jour = document.createElement('span');
			jour.className = 'jour';
			jour.innerHTML = datasMatch['jour'];
			
			var moi = document.createElement('span');
			moi.className = 'moi';
			moi.innerHTML = datasMatch['moi'];

			var heure = document.createElement('span');
			heure.className = 'heure';
			heure.innerHTML = datasMatch['heure'];

			date.appendChild(jour);
			date.appendChild(moi);
			date.appendChild(heure);
			infosContainer.appendChild(date);		
		}
		
		// ajout des equipes du match
		var equipe1 = this.genereObjEquipe(datasMatch['equipe1']);
		var equipe2 = this.genereObjEquipe(datasMatch['equipe2']);
		
		
		// récupération de l'équipe du club
		mainObj.setAttribute('idequipe', datasMatch['equipe-club']);
		
		/*
		 *  TODO on pourrait ici récupérer la couleur qu'on l'on aurait renseignée sur l'équipe
		 *  au lieu de le mettre dans la CSS
		 */
		
		if (equipe1 != null && equipe2 != null){
			// mise en évidence de l'équipe du club
			if (datasMatch['equipe-club'] == datasMatch['equipe1']['ID']){
				equipe1.setAttribute('mon-club', 'true');
			}
			if (datasMatch['equipe-club'] == datasMatch['equipe2']['ID']){
				equipe2.setAttribute('mon-club', 'true');
			}
						
			var equipesContainer = document.createElement('div');
			equipesContainer.className = 'equipes-container';
			
			equipesContainer.appendChild(equipe1); 
			equipesContainer.appendChild(equipe2); 
			mainObj.appendChild(equipesContainer); 
		}
		return mainObj
	}

	/**
	 * Génère un composant permettant de representer une équipe
	 * @param dataEquipe
	 * 
	 * @returns {___anonymous2560_2566}
	 */
	this.genereObjEquipe = function ( dataEquipe ) {
		// création du composant principal
		var mainObj = document.createElement('div');
		mainObj.className = 'equipe';
		
		if (dataEquipe['gagnant']){
			mainObj.setAttribute('gagnant', true);
		}
		
		var logoContainer  = document.createElement('div');
		logoContainer.className = 'logo-container';
		
		var logo = document.createElement('img');
		logo.className = 'logo-club';
		logo.src = 'images/' + dataEquipe['logo'];
		
		
		logoContainer.appendChild(logo);
		
		var nom = document.createElement('span');
		nom.className = 'nom';
		nom.innerHTML = dataEquipe['nom'];

		var score = document.createElement('span');
		score.className = 'score';
		score.innerHTML = dataEquipe['score'];
		
		
		mainObj.appendChild(logoContainer);
		mainObj.appendChild(nom);
		mainObj.appendChild(score);
		return mainObj;
	}

}