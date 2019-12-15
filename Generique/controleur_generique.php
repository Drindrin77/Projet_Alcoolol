<?php
if(!defined('CONST_INCLUDE'))
	die('Acces   direct interdit !'); 

class ControleurGenerique {

	protected $modele;
	protected $vue;

	function getModele(){
		return $this->modele;
	}

	function getVue(){
		return $this->vue;
	}

}
?>
