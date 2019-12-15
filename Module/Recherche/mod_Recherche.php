<?php 

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

require_once("controleur_Recherche.php");

class ModRecherche extends ModuleGenerique{

	function __construct(){
		$this-> controleur = new ControleurRecherche();
		
		//SI PAS DE CONNEXION	
		if(isset($_GET["action"]))
			$action = htmlspecialchars($_GET["action"]);	
		else
			$this -> controleur -> afficheErreur(404);

	
		switch($action){

			case "listeBoisson":
				$this -> controleur -> listeBoisson();
			break;

			case "sesCreationsBoissons":
				$this -> controleur -> sesCreationsBoissons();
			break;

			case "mesCreationsBoissons":
				$this -> controleur -> mesCreationsBoissons();
			break;			

			case "MAlisteBoissonsFavoris":
				if(isset($_SESSION["id"]))
					$this -> controleur -> afficherMAListeBoissonFavoris();		
				else
					$this -> controleur -> afficheErreur(401);					
			break;

			case "SAlisteBoissonsFavoris":
				if(isset($_SESSION["id"])){
					if(isset($_POST["idUser"]))
						$this -> controleur -> afficherSAListeBoissonFavoris();
					else
						$this -> controleur -> afficheErreur(403);						
				}
				else
					$this -> controleur -> afficheErreur(401);					
			break;


			case "RechercherUser":
				if(isset($_SESSION["id"]))
					$this -> controleur -> rechercheUser();		
				
				else
					$this -> controleur -> afficheErreur(401);
			break;
                        
            
			case "RechercherAlcool":
				if(isset($_POST["recherche"]))
					$this -> controleur -> rechercheAlcool();
				else
					$this -> controleur -> afficheErreur(403);
			break;

	        case "RechercheAvance":
                $this -> controleur -> RechercheAvance();
            break;
                       
			default:
				$this -> controleur -> afficheErreur(404);
			break;
		
		}			
		
		
			
	}

}
		
?>