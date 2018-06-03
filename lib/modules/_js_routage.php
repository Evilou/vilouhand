<?php
header ( 'Content-Type: application/javascript' );
// require_once '../config.php';
?>

if (document.addEventListener) {
	document.addEventListener("readystatechange", init_routage, false);
} else if (document.attachEvent) {
	document.attachEvent("onreadystatechange", init_routage);
}


// Génération d'un UUID
function generateUUID(){
    var d = new Date().getTime();
    if(window.performance && typeof window.performance.now === "function"){
        d += performance.now(); //use high-precision timer if available
    }
    var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = (d + Math.random()*16)%16 | 0;
        d = Math.floor(d/16);
        return (c=='x' ? r : (r&0x3|0x8)).toString(16);
    });
    return uuid;
}

/**
 * Script d'initilisation du routage
 */
function init_routage(){
	if ("complete" == document.readyState) {
		var body = document.getElementsByTagName('body')[0]; 
				
		if (body != null && body.getAttribute('role-main-div') != null){
			var tab = {
				url : "mapping.php",
				page : "<?php echo( isset($_REQUEST['page']) ? $_REQUEST['page'] : 'default-page' ) ?>" ,
				attributs : null,
				cible : body.getAttribute('role-main-div'),
				callback : null,
				callbackERR : null,
				silent :  false
			};

			requeteServeur(tab);
		}
	}
}

/**
 * 
 * @param param
 * @returns {Boolean}
 */
function requeteServeur(param) {
	var req = null;
		
	if (param.silent == null)
		param.silent = false;

	if (window.XMLHttpRequest)
		req = new XMLHttpRequest();
	else if (window.ActiveXObject)
		req = new ActiveXObject("Microsoft.XMLHTTP");

	req.onreadystatechange = function() {
		if (req.readyState == 4) {
			if (req.status == 200) {
					try{
						var jsonObj = JSON.parse(req.responseText);
						var objCible = document.getElementById(param.cible);

						var status = jsonObj['status'];
						if ( status === "FAILED" ){
							// En cas d'erreur on execute le callback de gestion d'erreur si il existe
							// Dans le cas où on gére les messages via un alert (mode non silent) il montera à l'écran 
							if (!param.silent)
								alert("ERREUR : " + jsonObj['message']);							
							if (param.callbackERR != null) {
								eval(param.callbackERR + "(jsonObj['message'])");
							}
						}else{
							if (objCible != null ){
								if (   jsonObj['datas-html'] != null ){
									// si des datas de type HTML sont envoyé, on les affiches dans la zone (permet de construire des zones complexes)
									objCible.innerHTML = jsonObj['datas-html'];
								}else{
									// sinon on affiche le message reçu simplement dans la zone
									if (jsonObj['message'] != null)
										objCible.innerHTML = jsonObj['message'];
								}
								initForm();
							}else{
								// pas de cible pour le message et pas d'erreur, l'execution sera complétement transparente si le mode silent est actif
								if (!param.silent)
									alert(status + " : " + jsonObj['message']);
							}
							// Le callback n'est pas executé si il y a une erreur
							if (param.callback != null && jsonObj['datas']) {
								eval(param.callback + "(jsonObj['datas'])");
							}
						}
					}catch(e){
						alert(e);
					}
			} else {
				alert("Error: returned status code " + req.status + " "
						+ req.statusText);
			}
		}
	};

	if (param.page != null) {
		param.url += "?page=" + param.page;
	}
	req.open("POST", param.url, true);
	
	// pour pouvoir envoyer des fichiers il ne faut pas touche à ça
	//req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
	//req.setRequestHeader("Content-Type", "multipart/form-data; charset=UTF-8");
	
	var paramToSend = param.attributs == null ? new FormData() : param.attributs;
	
	req.send(paramToSend);
	
	return false;
}