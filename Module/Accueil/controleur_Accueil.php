<?php
if(!defined('CONST_INCLUDE'))
 	die('Acces   direct interdit !');
 
require_once ("modele_Accueil.php");
require_once ("vue_Accueil.php");

class ControleurAccueil extends ControleurGenerique{
	
	public function __construct(){
		$this->modele=new ModeleAccueil();
		$this->vue= new VueAccueil();
	}

	public function afficheErreur(){
		$this-> vue-> vue_erreur();
	}

	public function accueil(){
		$this -> vue -> accueil();
	}
	
	public function propos(){
		$this -> vue -> propos();
	}
}
?>
