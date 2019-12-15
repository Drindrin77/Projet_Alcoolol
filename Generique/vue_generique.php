<?php
if(!defined('CONST_INCLUDE'))
	die('Acces   direct interdit !'); 

class VueGenerique{

	protected $contenu, $titre;

	function __construct(){
		$this->contenu = "";
		$this->titre = "";
		ob_start();	
	}


	function vue_erreur(){
		$this->titre="Erreur";
	    $this->contenu= 'Erreur';
	}

	function erreur($numErreur){
		$this->titre="Erreur ".$numErreur;
		$this -> contenu = file_get_contents('images/Page_Erreur/'.$numErreur.'/index.html');
	}
     

	function getTitre(){
		return $this->titre;
	}

	function getContenu(){
		return $this->contenu;
	}


	function tamponVersContenu(){

		$this->contenu.=ob_get_clean();
	}
}

?>
