<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Requete.php");

class AjaxRequete{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleRequete();

		$action = htmlspecialchars($_GET["action"]);

		switch($action){

            case "accepterBoisson":
                $this -> accepterBoisson();
            break;

            case "refuserBoisson":
                $this -> refuserBoisson();
            break;

            case "supprimerAnnonce":
                $this -> supprimerAnnonce();
            break;

            case "getNbRequete":
                $this -> getNbRequete();
            break;

		}		
    }

    public function getNbRequete(){
        $nbEvent = $this -> modele -> nbEvent();
        $nbAmis = $this -> modele -> nbAmis();
        $estModo = $this -> modele -> estModo();

        if($estModo["moderateur"]==="1")
            $nbBoisson = $this -> modele -> nbBoissonModo();
        else
            $nbBoisson = $this -> modele -> nbBoissonNonModo();

        $nb = intval($nbEvent[0])+intval($nbAmis[0])+intval($nbBoisson[0]);
        echo json_encode(array("nb" => $nb));
    }

    public function supprimerAnnonce(){
        
            $idBoisson = htmlspecialchars($_POST["idBoisson"]);
            $this -> modele -> supprimerAnnonce($idBoisson);
            $this -> modele -> supprimerBoisson($idBoisson);
        
    }

    public function accepterBoisson(){
        if ($this -> modele ->verifToken(htmlspecialchars($_POST["token"]))){
            $idBoisson = htmlspecialchars($_POST["idBoisson"]);
            $message = htmlspecialchars($_POST["message"]);

            $this -> modele -> updateEnAttenteModerateur($idBoisson);
            $this -> modele -> updateAccepterBoisson($idBoisson, $message);
        }
        echo json_encode(array('token' =>  $this -> modele -> insertToken()) );
    }

    public function refuserBoisson(){
        if ($this -> modele ->verifToken(htmlspecialchars($_POST["token"]))){
        $idBoisson = htmlspecialchars($_POST["idBoisson"]);
        $message = htmlspecialchars($_POST["message"]);

        $this -> modele -> suppressionIngredients($idBoisson);
        $this -> modele -> refusBoisson($idBoisson);
        $this -> modele -> updateAccepterBoisson($idBoisson, $message);
        }
        echo json_encode(array('token' =>  $this -> modele -> insertToken()) );
    }

}

?>