<?php
if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Message.php");
include_once ("modele_Message.php");

class ControleurMessage extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleMessage();
		$this->vue = new VueMessage();
    }

    public function afficheErreur($numErreur){
        $this -> vue -> erreur($numErreur);
    }

    public function menu(){
        $msgRecu = $this -> modele -> envoyerListeMessageRecu();
        $msgEnvoye = $this -> modele -> envoyerListeMessageEnvoyer();
        $infoUser = $this -> modele -> envoieInfoUser($_SESSION["id"]);
        $corbeille = $this -> modele -> envoyerListeCorbeille();

        $this -> vue -> menu($msgEnvoye,$msgRecu,$corbeille,$infoUser);

    }
}

?>