<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Message.php");

class AjaxMessage{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleMessage();

		$action = htmlspecialchars($_GET["action"]);	

		switch($action){

			case "EnvoyerMessage":
				$this -> envoyerMessage();
			break;

			case "EnvoyerInfoMsg":
				$this -> EnvoyerInfoMsg();
			break;

			case "repondreMessage":
				$this -> repondreMessage();
			break;

            case "corbeilleMsg":
                $this -> corbeilleMsg();
            break;

            case "supprimerDefinitifMsg":
                $this -> supprimerDefinitifMsg();
            break;

            case "viderCorbeille":
                $this -> viderCorbeille();
            break;

            case "getNbMsgNonLu":
                $this -> getNbMsgNonLu();
            break;

		}
		
	}


    public function getNbMsgNonLu(){
        $nb = $this -> modele -> getNbMsgNonLu();
        echo json_encode($nb);
    }

    public function viderCorbeille(){
        
        if(!empty($_POST["idMessagePere"])){
            foreach($_POST["idMessagePere"] as $value){
                $this -> modele -> supprimerDefinitifMsg($value);
            }  
        }

    }

    public function supprimerDefinitifMsg(){
        $idMsg_pere = htmlspecialchars($_POST["idMsgPere"]);
        $this -> modele -> supprimerDefinitifMsg($idMsg_pere);
    }

    public function corbeilleMsg(){
        $idMsg = htmlspecialchars($_POST["idMsg"]);
        $idMsg_pere = htmlspecialchars($_POST["idMsgPere"]);
        $this -> modele -> mettreCorbeille($idMsg_pere);
        $infoUser = $this -> modele -> envoieInfoUser($_SESSION["id"]);

        $arr = array("login" => $_SESSION["login"],"avatar" => "images/avatar/user/".$infoUser["avatar"]);

        echo json_encode($arr);
    }

    public function EnvoyerInfoMsg(){
        $idMsgPere = htmlspecialchars($_POST["idMsgPere"]);
        $idMsg = htmlspecialchars($_POST["idMsg"]);
        $infoExpediteur = $this -> modele -> infoExpediteur($idMsgPere);
        $infoMsg = $this -> modele -> infoMessage($idMsgPere);

        $infoDestinataire = $this -> modele -> infoDestinataire($idMsgPere);
        $listeReponse = $this -> modele -> envoieListeReponse($idMsgPere);

        $this -> modele -> mettreAJourLuMsg($idMsg);

        $arr = array("objet" => $infoExpediteur["objet"],"dateMsg" => $infoMsg["dateMsg"], "nomExpediteur" => $infoExpediteur["nom"],"prenomExpediteur" => $infoExpediteur["prenom"], "loginExpediteur" => $infoExpediteur["login"],"loginDestinataire"=>$infoDestinataire["login"],"reponses" => $listeReponse);

        echo json_encode($arr);
    }

    public function repondreMessage(){
        $reponse = htmlspecialchars($_POST["reponse"]);
        $idPere = htmlspecialchars($_POST["idPere"]);
        $idMsg = $this -> modele -> getMaxIdMsg();
        $idDestinataire = htmlspecialchars($_POST["idDestinataire"]);
        $objet = htmlspecialchars($_POST["objet"]);
        $this -> modele -> repondreMessage($idMsg["idMessage"],$idPere,$idDestinataire,$reponse, $objet);

        $infoDestinataire = $this -> modele -> envoieInfoUser($idDestinataire);
        $infoExpediteur = $this -> modele -> envoieInfoUser($_SESSION["id"]);
        $dateMsg = date("Y-m-d H:i:s");

        $arr = array("newIdMsg" => $idMsg["idMessage"], "avatarDest" => $infoDestinataire["avatar"],"loginDestinataire" => $infoDestinataire["login"], "avatarExp" => $infoExpediteur["avatar"], "loginExp" => $infoExpediteur["login"], "dateMsg" => $dateMsg);

        echo json_encode($arr);
    }

    public function envoyerMessage(){

        if(isset($_POST["login"])){
            $login = htmlspecialchars($_POST["login"]);
            $tab = $this -> modele -> recupererId($login);

            if(empty($tab)){
                $arr = array("erreur" => true);
                echo json_encode($arr);
                return;
            }
            else
                $idUser = $tab["idUser"];                     
        }
        else
            $idUser = htmlspecialchars($_POST["idUser"]);

        $message = htmlspecialchars($_POST["message"]);
        $objet = htmlspecialchars($_POST["objet"]);

        if(empty($objet))
            $objet = "(aucun objet)";

        $idMsg = $this -> modele -> getMaxIdMsg();

        if($idMsg["idMessage"]==null)
           $idMsg = "1";
        else
           $idMsg = $idMsg["idMessage"];

        $this -> modele -> insertionMessage($idMsg, $objet, $message,$idUser);

        $arr = array("erreur" => false,"idMsg" => $idMsg,"idDest" => $idUser);
        echo json_encode($arr);

    }
}

?>