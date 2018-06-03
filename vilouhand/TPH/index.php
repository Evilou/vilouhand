<!DOCTYPE html >
<html>
<head>
<?php
require_once 'config.php';
?>
<script type="text/javascript">
</script>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- 
	Information d'entete pouvant être récupérée en base de données en foncton de la référence du club
	On peut noter ici le nom du club associé à la référence
-->
<meta name="description" content="Tarbes Pyrénées Handball">  

<?php

require_once '../gestion_clubs/load_header.php';
?>

</head>

<body role-main-div="main">
	<div id="main"></div>
	<script>
		var gestionnaire = new GestionnaireMatchs('test');
		gestionnaire.getDatas(null);
	</script>
</body>
</html>
