<?php
if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');
	
include_once ("vue_Amis.php");
include_once ("modele_Amis.php");

class ControleurAmis extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleAmis();
		$this->vue = new VueAmis();
    }

    public function afficheErreur($numErreur){
        $this -> vue -> erreur($numErreur);
    }

    public function voirMaListeAmi(){
    	$tab = $this -> modele -> envoyerMAListeAmi();
    	$this -> vue -> afficherMaListeAmi($tab);
    }
    public function voirSaListeAmi(){

	    $id= htmlspecialchars($_POST["idUser"]);
		$amis = $this -> modele -> envoyerListeAmiEtAttente($id); 
		$amisPerso = $this -> modele -> envoyerListeAmiEtAttente($_SESSION["id"]);
	
		$this -> vue -> afficherSaListeAmi($amis,$amisPerso);

    }   
}

?>