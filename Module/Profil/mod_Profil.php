<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Profil.php");

class ModProfil extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurProfil();
		
		//SI PAS DE CONNEXION	
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
		
		else 
			$action ="";
			
		switch($action){

			case "profilPerso":
				$this-> controleur -> voirProfilPerso();
			break;

			case "profilAutre":
				if(isset($_GET["idUser"]))
					$this-> controleur -> voirProfilAutre();	
				else
					$this -> controleur -> afficheErreur(403);						
			break;

			case "modifierProfilPerso":
				$this -> controleur -> modifierProfilPerso();
			break;			
			
			default:
				$this -> controleur -> afficheErreur(404);
			break;
			
		}
			
	}

}
		
?>