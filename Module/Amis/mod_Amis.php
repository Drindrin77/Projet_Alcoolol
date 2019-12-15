<?php

if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');

require_once("controleur_Amis.php");

class ModAmis extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurAmis();
		
		//SI PAS DE CONNEXION	
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
		
		else 
			$action="voirMaListeAmi";

		switch($action){	

			case "voirSaListeAmi":
				if(isset($_POST["idUser"]))
					$this -> controleur -> voirSaListeAmi();
				else
					$this -> controleur -> afficheErreur(403);

			break;

			case "voirMaListeAmi":
				$this -> controleur -> voirMaListeAmi();
			break;

			default:
				$this -> controleur -> afficheErreur(404);
			break;
		
		}		
			
	}

}
		
?>