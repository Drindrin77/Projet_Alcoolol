<?php
if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Requete.php");
include_once ("modele_Requete.php");

class ControleurRequete extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleRequete();
		$this->vue = new VueRequete();
    }

    public function menu(){

    	$events = $this -> modele -> envoyerListeInvitationEvenement();
    	$amis = $this -> modele -> envoyerListeDemandeAmi();
        $moderateur = $this -> modele -> envoieInfoModerateur();

        if($moderateur[0]=="0")
            $boissons = $this -> modele -> envoyerListeCreationBoisson();
        else
            $boissons = $this -> modele -> envoyerListeBoissonModerateur();

        $token = $this -> modele -> insertToken();
    	$this -> vue -> afficherListeDemande($amis,$events,$boissons,$moderateur[0],$token);
    }
    
}

?>