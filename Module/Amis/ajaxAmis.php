<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Amis.php");

class AjaxAmis{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleAmis();

		$action = htmlspecialchars($_GET["action"]);	

		switch($action){

			case "supprimerAmi":
				$this -> supprimerAmi();
			break;

			case "accepterEnAmi":
				$this -> accepterAmi();
			break;

			case "refuserAmi":
				$this -> refuserAmi();
			break;

			case "demanderEnAmi":
				$this -> demandeAmi();
			break;
		
			case "getNbDemandesAmis" : 
				$this -> getNbDemandesAmis();
			break;

		}
		
	}


	public function getNbDemandesAmis(){
		$tab = $this -> modele -> envoyerListeDemandeAmi();		
		$post_data = json_encode(array('nombreDemandesAmis' => sizeof($tab)));
		echo $post_data;	
	}

	public function accepterAmi(){

		$id = htmlspecialchars($_POST["idUser"]);
		$this -> modele -> modifierAttente($id);
		$this -> modele -> ajouterEnAmiRetour($id);
    }

    public function refuserAmi(){
		$id = htmlspecialchars($_POST["idUser"]);
		$this -> modele -> supprimerAmi($id);
    }

    public function demandeAmi(){
    	$id = htmlspecialchars($_POST["idUser"]);
    	$tab = $this -> modele -> verifSiDejaDemande($id);

    	if($tab[0]=="0")
    		$this -> modele -> demandeAmi($id);
    	else
	   	$this -> accepterAmi();
    }

	public function supprimerAmi(){
		$id = htmlspecialchars($_POST["idUser"]);
		$this -> modele -> supprimerAmi($id);
		$this -> modele -> supprimerAmiRetour($id);
	}
}

?>
