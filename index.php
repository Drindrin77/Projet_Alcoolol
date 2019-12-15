<?php

	if (session_status() == PHP_SESSION_NONE) 
	    session_start();
	
	define ('CONST_INCLUDE',NULL);
	define ('CONST_FILE_PATH_USER',"images/avatar/user/");
	define ('CONST_FILE_PATH_BOISSON',"images/Boisson/");

	require_once ("Generique/controleur_generique.php");
	require_once ("Generique/modele_generique.php");
	require_once ("Generique/module_generique.php");
	require_once ("Generique/vue_generique.php");

	ModeleGenerique::initConnexionBD();

	if(isset($_GET["module"]))
		$module = htmlspecialchars($_GET["module"]);
	
	else
		$module = "Accueil";

	$arrayModule = array("Connexion","Boisson","Accueil","Recherche"); 

	if(isset($_SESSION['id'])){
		array_push($arrayModule,"Profil","Amis","Message","Commentaire","Evenement","Requete");	
	}
	
	if(in_array($module, $arrayModule)){
		
		include_once "Module/".$module."/mod_".$module.".php";		
		$nom_module="Mod".$module;
		$mod = new $nom_module();
	
		$mod->getControleur()->getVue()->tamponVersContenu();
		require_once("template.php");
		
	}
	else
		header('Location: index.php');		
	
			
	
	
?>