<?php

if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');

require_once("controleur_Boisson.php");

class ModBoisson extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurBoisson();
		
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
			
		else 
			$action="erreur";
	
		switch ($action) {

			case "afficheBoisson":
				if(isset($_POST["id"]))
					$this -> controleur -> boissonParID();	
				else
					$this-> controleur -> afficheErreur(403);
			break;

			case "creerBoisson":
				if(isset($_SESSION["id"]))
					$this -> controleur -> creerBoisson();
				else
					$this -> controleur -> afficheErreur(401);
			break;

			case "testAlcoolemie":
				$this -> controleur -> testAlcoolemie();
			break;

			default:
				$this-> controleur -> afficheErreur(404);
			break;
		}				
			
	}

}
		
?>