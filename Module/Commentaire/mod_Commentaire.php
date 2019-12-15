<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Commentaire.php");

class ModCommentaire extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurCommentaire();
		
		//SI PAS DE CONNEXION	
		if(isset($_GET["action"]) && isset($_POST["idBoisson"]) && isset($_POST["commentaire"])){

			$action = htmlspecialchars($_GET["action"]);		
	
			switch($action){

				case "envoyerCommentaire":
					$this -> controleur -> envoyerCommentaire();	
				break;

				case "commenterCommentaire":
					if(isset($_POST["idCommentaire"]))
						$this -> controleur -> commenterCommentaire();
					else		
						$this -> controleur -> afficheErreur(403);

				default:
					$this -> controleur -> afficheErreur(404);
				break;									
			}
			
		}
		else
			$this -> controleur -> afficheErreur(403);
	}
}
		
?>