<?php
if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');

require_once("controleur_Accueil.php");
class ModAccueil extends ModuleGenerique{

	function __construct(){
		$this->controleur= new ControleurAccueil();		
		$this->controleur->accueil();	


		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);
			
		else 
			$action="accueil";
		

		switch($action){

			case "accueil":
				$this -> controleur -> accueil();
			break;
				
			case "propos":
				$this -> controleur -> propos();
			break;

			default:
				$this -> controleur -> afficheErreur();
			break;

		}
		
	}



}
?>
