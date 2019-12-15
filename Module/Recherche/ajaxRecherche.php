<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Recherche.php");

class AjaxRecherche{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleRecherche();

		$action = htmlspecialchars($_GET["action"]);

		switch($action){

            case "BarreRechercherUser":
                $this -> barreRechercheUser();
            break;

            case "BarreRechercherAlcool":
                $this -> barreRechercheAlcool();
            break;
		}		
    }

    public function barreRechercheAlcool(){
        $recherche = htmlspecialchars($_POST["recherche"]);
        $tab = $this -> modele -> barreRechercheAlcool($recherche);
        echo json_encode($tab);
    }

    public function barreRechercheUser(){
        $recherche = htmlspecialchars($_POST["recherche"]);
        $tab = $this -> modele -> envoieListeUser($recherche);
        echo json_encode($tab);
    }


}

?>