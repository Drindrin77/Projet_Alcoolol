<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Commentaire.php");
include_once ("modele_Commentaire.php");

class ControleurCommentaire extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleCommentaire();
		$this->vue = new VueCommentaire();
    }
    
    public function afficheErreur($numErreur){
        $this -> vue -> erreur($numErreur);
    }
        
    
  
}

?>