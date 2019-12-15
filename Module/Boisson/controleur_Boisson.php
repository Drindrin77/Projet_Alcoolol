<?php

if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');
	
include_once ("vue_Boisson.php");
include_once ("modele_Boisson.php");

class ControleurBoisson extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleBoisson();
		$this->vue = new VueBoisson();
    }

    public function afficheErreur($numErreur){
        $this -> vue -> erreur($numErreur);
    }

    public function creerBoisson(){
    	$infoUser = $this -> modele -> envoieInfoUser();
		$fruits = $this -> modele -> envoieListeIngredientCategorie("Fruit");
		$alcools = $this -> modele -> envoieListeIngredientCategorie("Alcool");
		$autres = $this -> modele -> envoieListeIngredientCategorie("Autre");
    	$this -> vue -> debutCreation($infoUser,$fruits,$alcools,$autres);
    }

	public function boissonParID(){

		if(isset($_POST["id"])){



			$id=htmlspecialchars($_POST["id"]);
			$tab = $this -> modele -> envoieBoissonParID($id);
			$ingredients = $this -> modele -> envoieListeIngredientBoisson($id);	
			$this -> vue -> afficherBoisson($tab,$ingredients);

			if(isset($_SESSION["id"])  && $tab["avisModerateur"]==1 ){
				$favoris = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
			    $this -> vue -> afficheBouton($tab,$favoris);
			    $filsCommentaire = $this -> modele -> envoieListeCommentaireCommentaire($id);
				$tabComment = $this -> modele -> envoieListeCommentaireBoisson($id);
				$this -> vue -> afficherCommentaire($tabComment,$id,$filsCommentaire);
			}
		}				
	}

	public function testAlcoolemie(){
		$this -> vue -> testAlcoolemie();
	}



}

?>