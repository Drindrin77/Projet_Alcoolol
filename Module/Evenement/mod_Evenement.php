<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Evenement.php");

class ModEvenement extends ModuleGenerique{

	function __construct(){
		$this->controleur = new ControleurEvenement();
		
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
		
		else 
			$action="AfficherListeEvenement";
				
		
		switch($action){
		
			case "AfficherListeEvenement":
				$this -> controleur -> AfficherListeEvenement();	
			break;

			case "detailEvenementPrive":
				if(isset($_POST["idEvent"]))
					$this -> controleur -> detailEvenementPrive();
				else
					$this -> controleur -> afficheErreur(403);

			break;

			case "detailEvenementPublic":
				if(isset($_POST["idEvent"]))
					$this -> controleur -> detailEvenementPublic();
				else
					$this -> controleur -> afficheErreur(403);
			break;
				

			default:
				$this -> controleur -> afficheErreur(404);
			break;
		}
				
	}
		
}

		
?>