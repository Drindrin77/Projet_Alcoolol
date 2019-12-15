<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Connexion.php");
include_once ("modele_Connexion.php");

class ControleurConnexion extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleConnexion();
		$this->vue = new VueConnexion();

    }
    public function afficheErreur(){
		$this-> vue-> vue_erreur();
	}
	
	public function menu(){
		$this -> vue -> affiche_menu($this -> modele ->insertToken());
	}        

	public function deconnexion(){
		session_destroy();
		header('Location: index.php');		
	}
}

?>