<!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<LINK rel=STYLESHEET
	href="styles/formulaires.css?v=<?= filemtime('styles/formulaires.css'); ?>"
	type="text/css">
<link
	href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"
	rel="stylesheet">

<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
<script src="modules/routage.js"></script>
<script src="modules/formulaires.js"></script>

<script>
function dataImage(data){
	var contenu = "";
	contenu += '<li><div>';
	contenu += '<span class="fa fa-times"></span>';
	contenu += '</div> <span>' + data['nom_image'] +'</span><select><option>Logo club</option>';
	contenu += '<option>Image Diverse</option>';
	contenu += '<option>Image Equipe</option>';
	contenu += '<option>Image Contact</option></select></li>';
	document.getElementById('liste_images').innerHTML += contenu;
	document.getElementById('nom_image').value = "";
	document.getElementById('fichier').value = "";
}
</script>
<style type="text/css">
ul {
	display: block;
}

ul li {
	list-style-type: none;
	display: flex;
	align-items: center;
}

li span:first-child {
	font-weight: bold;
}

span {
	margin: 2px;
}
</style>

</head>
<body>
	<div>
		<div>
			<form role-form="rich-form" role-form-page="uploadImg"
				role-form-cible="test" role-form-callback="dataImage"
				role-form-silent="true" id="mon_form">
				<!--
				la validation du choix doit :
					- réinitiliser la zone de selection
					- mêtre à jour la liste d'image  
				-->
				<input role-form="item" role-form-name="mon_form" type="text"
					name="nom_image" id="nom_image" placeholder="nom de l'image"
					style="margin: 6px;" /> <input role-form="item"
					role-form-name="mon_form" type="file" name="fichier" id="fichier" />
				<span class="fa fa-plus" onclick="submitRoleForm('mon_form');"></span>
			</form>
		</div>
		<ul id="liste_images">
		</ul>
		<div>
			<input type="button" value="valider" />
		</div>
	</div>
</body>
</html>
