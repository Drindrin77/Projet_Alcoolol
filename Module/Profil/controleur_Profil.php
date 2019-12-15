<?php
if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Profil.php");
include_once ("modele_Profil.php");

class ControleurProfil extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleProfil();
		$this->vue = new VueProfil();
    }

    public function afficheErreur($numErreur){
    	$this -> vue -> erreur($numErreur);
    }

	public function voirProfilPerso(){
		$this -> vue -> afficherProfilPerso($this -> modele -> envoieInfoUser($_SESSION["id"]));
	}

	public function voirProfilAutre(){
        $idUser = htmlspecialchars($_GET["idUser"]);
		$amisPerso = $this -> modele -> envoyerListeAmi($_SESSION["id"]);
		$this -> vue -> afficherProfilAutre($this -> modele -> envoieInfoUser($idUser),$amisPerso);		
	}

	public function modifierProfilPerso(){
		$tab = $this -> modele -> envoieInfoUser($_SESSION["id"]);
		$this -> vue -> modifierProfilPerso($tab);

	}	
}

?>