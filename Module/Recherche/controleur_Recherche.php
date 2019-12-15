<?php
if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("vue_Recherche.php");
include_once ("modele_Recherche.php");

class ControleurRecherche extends ControleurGenerique{
	
	public function __construct() {
		$this->modele = new ModeleRecherche();
		$this->vue = new VueRecherche();
    }

     public function rechercheAvance(){

        $recherche = htmlspecialchars($_POST["recherche"]);
        $ingredientsCoche = array();

        if(!empty($_POST["ingredient"])){
            foreach($_POST["ingredient"] as $value){
                array_push($ingredientsCoche,$value);           
            }  
            $boisson = $this -> modele -> resultatRechercheParIngredientBoisson($ingredientsCoche,$recherche);
        }
        else
            $boisson = $this -> modele -> envoieListeBoissonSansIngredient($recherche);

        if(sizeof($boisson)==0)
            $this -> vue -> rechercheVide();
        else{
            if(isset($_SESSION["id"])){
                $favoris = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
                $this -> vue -> afficherListeConnecte($boisson,$favoris);   
            }
            else
                $this -> vue -> afficherListe($boisson);
        }
    }


    public function sesCreationsBoissons(){
    	$id = htmlspecialchars($_POST["idUser"]);
    	$tab = $this -> modele -> listeCreation($id);
   		$favorisPerso = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
    	$this -> vue -> afficherListeConnecte($tab,$favorisPerso);
    }

    public function mesCreationsBoissons(){
    	$tab = $this -> modele -> listeCreation($_SESSION["id"]);
    	$favorisPerso = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
    	$this -> vue -> afficherListeConnecte($tab,$favorisPerso);
    }

    public function afficherSAListeBoissonFavoris(){
		$id = htmlspecialchars($_POST["idUser"]);
		$favorisAmis =  $this -> modele -> envoieListeBoissonFavoris($id);
		$favorisPerso = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
		$this -> vue -> afficherListeConnecte($favorisAmis,$favorisPerso);
	}

    public function afficherMAListeBoissonFavoris(){
    	$this -> vue -> afficherListe($this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]));
    }

    public function listeBoisson(){

		$tab = $this -> modele -> envoieListeBoisson();

		$fruits = $this -> modele -> envoieListeIngredientCategorie("Fruit");
		$alcools = $this -> modele -> envoieListeIngredientCategorie("Alcool");
		$autres = $this -> modele -> envoieListeIngredientCategorie("Autre");

		$this -> vue -> rechercheAvance($fruits,$alcools,$autres);

		if(isset($_SESSION["id"])){
			$favoris = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
			$this -> vue -> afficherListeConnecte($tab,$favoris);	
		}
		else
			$this -> vue -> afficherListe($tab);
    }

    public function afficheErreur($numErreur){
    	$this -> vue -> erreur($numErreur);
    }

/*	public function rechercheAlcool(){
		$nomBoisson = htmlspecialchars($_POST["recherche"]);
		$boisson= $this -> modele -> envoyerListeBoissonRechercheNomBoisson($nomBoisson);

		if(sizeof($boisson)==0)
			$this -> vue -> rechercheVide();
		
		else{
			if(isset($_SESSION["id"])){
				$favoris = $this -> modele -> envoieListeBoissonFavoris($_SESSION["id"]);
				$this -> vue -> afficherListeConnecte($boisson,$favoris);	
			}
			else
    			$this -> vue -> afficherListe($boisson);
		}	
	}*/

	public function rechercheUser(){
        if(isset($_POST["recherche"]))
		  $login = htmlspecialchars($_POST["recherche"]);
        else
            $login = "";
		$tab = $this -> modele -> envoieListeUser($login);
		$amis = $this -> modele -> envoyerListeAmi($_SESSION["id"]);

		if(empty($tab))
			$this -> vue -> afficheRechercheVideUser($login);
		else
			$this -> vue -> afficheListeUser($tab,$amis);
	}
}

?>