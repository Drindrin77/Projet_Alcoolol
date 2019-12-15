<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Connexion.php");

class ModConnexion extends ModuleGenerique{

	function __construct(){
		$this->controleur = new ControleurConnexion();
		
		//SI PAS DE CONNEXION
			
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);		
		else 
			$action="menu";
		
		if($action==="deconnexion" && isset($_SESSION["id"]))
			$this ->  controleur -> deconnexion();	

		else if(!isset($_SESSION["id"])){
			
			switch($action){

				case "menu":					
					$this -> controleur -> menu();
				break;
                
				default:
					$this -> controleur -> afficheErreur();
				break;
			
			}			
		}	

		else
			$this -> controleur -> afficheErreur();
			

	}



}

		
?>