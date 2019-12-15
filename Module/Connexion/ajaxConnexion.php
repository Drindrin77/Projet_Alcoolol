<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Connexion.php");

class AjaxConnexion{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleConnexion();

		$action = htmlspecialchars($_GET["action"]);			
		if(!isset($_SESSION["id"])){
			switch($action){

				case "connexion":
					$this -> connexion();
				break;

				case "inscription":
					$this-> inscription();
				break;

                case "testPseudo":
                    $this -> testPseudo();
                break;
			}
		}
	}

	public function testPseudo(){

        $login = htmlspecialchars($_POST["loginInscription"]);
        $tab = $this->modele->verifLoginExistantInscription($login);

		if($tab[0]==='0'){
			$arr = array("message" => "login libre","erreur" => false);
            echo json_encode($arr);
            exit(0);
		}
        
        else 
            $arr = array("message" => "login déjà pris", "erreur" => true);
            echo json_encode($arr);
            exit(0);
    }


	public function inscription(){
		$nom = htmlspecialchars($_POST["nom"]);
		$prenom = htmlspecialchars($_POST["prenom"]);
		$email = htmlspecialchars($_POST["email"]);
		$login = htmlspecialchars($_POST["loginInscription"]);
		$mdp = htmlspecialchars($_POST["mdpInscription"]);
		$mdpConfirm = htmlspecialchars($_POST["mdpInscriptionConfirmation"]);
        $token = htmlspecialchars($_POST["token"]);

		if(!empty($nom) && !empty($prenom) && !empty($email) && !empty($login) && !empty($mdp)){
            if(strlen($login)<4){
            	$arr = array("message" => "pseudo trop court","erreur" => true);
	            echo json_encode($arr);
	            exit(1);
            }

			else if($mdpConfirm != $mdp){
				$arr = array("message" => "Les 2 mots de passes ne sont pas identiques","erreur" => true);
	            echo json_encode($arr);
	            exit(1);
			}
			
			else if(strlen($mdp)<4) {
				$arr = array("message" => "Mot de passe trop court","erreur" => true);
	            echo json_encode($arr);
	            exit(1);
			}

            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            	$arr = array("message" => "Email invalide","erreur" => true);
	            echo json_encode($arr);
	            exit(1);
            }
            
            else{
				$hash = hash("sha256",$mdp,false);
				$tab = $this->modele->verifLoginMailExistantInscription($login,$email);

				//Inscription reussi 
				if($tab[0]==='0'){
                    if($this->modele->verifToken($token)){
						$this -> modele -> inscrire($nom,$prenom,$email,$login,$hash);

						$arr = array("message" => "inscription reussi","erreur" => false);
			            echo json_encode($arr);
			            exit(0);
                    }

                    else{
                    	$arr = array("message" => "Veuillez recharger la page","erreur" => true);
			            echo json_encode($arr);
			            exit(1);
                    }
				}

				//inscription echoue : login ou email deja existant

				else{
                    $tab = $this->modele->verifLoginExistantInscription($login);
					if ($tab[0]==='0'){
						$arr = array("message" => "Email déjà utilisé","erreur" => true);
			            echo json_encode($arr);
			            exit(0);
					}
                    else{
                    	$arr = array("message" => "Login deja pris","erreur" => true);
			            echo json_encode($arr);
			            exit(0);
                    }
				}
			}
			

		}
		else{

			$arr = array("message" => "Veuillez remplir tous les paramètres","erreur" => true);
		    echo json_encode($arr);
		    exit(1);
		}
	}


	public function connexion(){

		$login = htmlspecialchars($_POST["login"]);
		$mdp = htmlspecialchars($_POST["pass"]);

		if(!empty($login) && !empty($mdp)){
			$hash = hash("sha256",$mdp,false);
			$tab = $this-> modele ->verifCompteExistantConnexion($login,$hash);

			//Erreur : compte inexistant ou erreur de login / mdp
			if(empty($tab)){
				$arr = array('erreur' => true);
				echo json_encode($arr);
				exit(0);
			}
			//Connexion reussi
			else{
				$_SESSION["login"]=$login;
				$_SESSION["id"]=$tab["idUser"];
				$arr = array('erreur' => false);
				echo json_encode($arr);
				exit(0);
			}
		}

		else{
			$arr = array('erreur' => true);
			echo json_encode($arr);
			exit(1);
		}
	}
}

?>