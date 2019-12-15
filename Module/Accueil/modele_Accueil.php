<?php

if(!defined('CONST_INCLUDE'))
	die('Acces   direct interdit !');
class ModeleAccueil extends ModeleGenerique{

	function getBoissons(){
		
		$requete = "SELECT * FROM boisson";
		$reqPrep = self::$connexion->prepare($requete);
		$reqPrep->execute();
		return $reqPrep->fetchAll();
		
		
	}
}
?>
