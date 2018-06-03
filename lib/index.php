<?php
require_once 'modules/init_session.php';
?>
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
<script
	src="modules/routage_js.php<?php if (isset($_REQUEST['page']) ) echo '?page='.$_REQUEST['page'];?>"></script>
<script src="modules/formulaires.js"></script>

</head>
<body role-main-div="main">
	<div id="main"></div>
</body>
</html>
