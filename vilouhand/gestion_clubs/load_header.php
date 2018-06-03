<?php
// composants externes
?>
<LINK
	href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
	rel="stylesheet">	
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<?php
// partie standard à charger completement (meme si les modules ne sont pas activés)
?>
<LINK rel=STYLESHEET
	href="<?php echo T_ROOT_LIB; ?>modules/styles/formulaires.css?v=<?= filemtime( T_ROOT_LIB.'modules/styles/formulaires.css'); ?>"
	type="text/css">
<script
	src="<?php echo T_ROOT_LIB; ?>modules/_js_routage.php<?php if (isset($_REQUEST['page']) ) echo '?page='.$_REQUEST['page'];?>"></script>
<script src="<?php echo T_ROOT_LIB; ?>modules/_js_formulaires.php"></script>

<?php
// partie spécifique à charger en meme temps que le module à priori
?>
<script
	src="<?php echo T_ROOT_LIB; ?>gestion_competitons/_js_gestionMatchs.php"></script>
<LINK rel=STYLESHEET
	href="<?php echo T_ROOT_LIB; ?>gestion_competitons/styles/matchs.css?v=<?= filemtime( T_ROOT_LIB.'gestion_competitons/styles/matchs.css'); ?>"
	type="text/css">
