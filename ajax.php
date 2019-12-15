<?php


	if (session_status() == PHP_SESSION_NONE) 
	    session_start();
	
	define ('CONST_INCLUDE',NULL);
	
	define ('CONST_FILE_PATH_USER',"images/avatar/user/");
	define ('CONST_FILE_PATH_BOISSON',"images/Boisson/");
	require_once ("Generique/modele_generique.php");
	ModeleGenerique::initConnexionBD();

	$module = htmlspecialchars($_GET["module"]);	

	include_once "Module/".$module."/ajax".$module.".php";		
	$nom_module="Ajax".$module;
	$mod = new $nom_module();


?>
