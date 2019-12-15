<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Requete.php");

class ModRequete extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurRequete();
		
		//SI PAS DE CONNEXION	
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
			
		switch($action){

			case "menu":
				$this -> controleur -> menu();
			break;

			default:
				$this -> controleur -> afficheErreur();
			break;
			
		}
			
	}

}
		
?>