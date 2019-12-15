<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Message.php");

class ModMessage extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurMessage();
		
		//SI PAS DE CONNEXION	
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
		
		else
			$action = "menu";

			
		switch($action){

			case "menu":
				$this -> controleur -> menu();
			break;

			default:
				$this -> controleur -> afficheErreur(404);
			break;
			
		}
			
	}

}
		
?>