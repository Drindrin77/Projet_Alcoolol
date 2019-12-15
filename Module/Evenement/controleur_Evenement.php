<?php
if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Evenement.php");
include_once ("modele_Evenement.php");


class ControleurEvenement extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleEvenement();
		$this->vue = new VueEvenement();

    }

    public function afficheErreur($numErreur){
        $this -> vue -> erreur($numErreur);
    }


    public function detailEvenementPublic(){
        $idEvent = htmlspecialchars($_POST["idEvent"]);
        
        $infoEvent = $this -> modele -> envoieInfoEvent($idEvent);
        $this -> vue -> detailEvenementPublic($infoEvent);

    }

    public function detailEvenementPrive(){
        $idEvent = htmlspecialchars($_POST["idEvent"]);

        $infoEvent = $this -> modele -> envoieInfoEvent($idEvent);
        $participants = $this -> modele -> envoieListeParticipant($idEvent);
        $amis = $this -> modele -> listeAmisduCreateur();
        $array = array();

        foreach($amis as $ami){

            $dejaParticipant = $this -> modele -> dejaParticipantOuAttenteEvent($ami["idUser"],$idEvent,0);
            $dejaEnAttente = $this -> modele -> dejaParticipantOuAttenteEvent($ami["idUser"],$idEvent,1);  

            $value ="1";

            if($dejaEnAttente[0]==='0')
                $value= "0";
 
            if($dejaParticipant[0]==='0'){
                $ami["enAttente"]=$value;
                array_push($array,$ami);
            }
               
        }

        $this -> vue -> detailEvenementPrive($infoEvent,$participants,$array);       
    }

    public function AfficherListeEvenement(){

    	$public = $this -> modele -> envoieListeEvenementPublic();
    	$prive = $this -> modele -> envoieListeEvenementPrive();

    	$this -> vue -> afficherMenu($public,$prive, $this -> modele -> insertToken());
    }	
}

?>