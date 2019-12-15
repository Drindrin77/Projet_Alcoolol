<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Commentaire.php");

class AjaxCommentaire{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleCommentaire();

		$action = htmlspecialchars($_GET["action"]);	

		switch($action){

			case "envoyerCommentaire":
				$this  -> envoyerCommentaire();	
			break;

			case "commenterCommentaire":
				$this -> commenterCommentaire();
			break;	

		}
		
	}

	public function envoyerCommentaire(){
        $commentaire = htmlspecialchars($_POST["commentaire"]);
        $idBoisson = htmlspecialchars($_POST["idBoisson"]);
        $idCommentaire = $this -> modele -> getMaxIdCommentaire();
        $infoUser = $this -> modele -> infoUser();

        if($idCommentaire["idCommentaire"] == null)
            $idCommentaire = 1;
        else
            $idCommentaire = $idCommentaire["idCommentaire"];

        $this -> modele -> insertionCommentaireBoisson($idCommentaire,$commentaire,$idBoisson);

    	$arr = array("avatar" => $infoUser["avatar"], "login" => $infoUser["login"],"idCommentaire" => $idCommentaire);
    	echo json_encode($arr);
    }

    public function commenterCommentaire(){
        $idBoisson = htmlspecialchars($_POST["idBoisson"]);
        $idCommentaire = htmlspecialchars($_POST["idCommentaire"]);
        $commentaire = htmlspecialchars($_POST["commentaire"]);
        $infoUser = $this -> modele -> infoUser();
        $this -> modele -> insertionCommentairedeCommentaire($commentaire,$idBoisson,$idCommentaire);

    	$arr = array("avatar" => $infoUser["avatar"], "login" => $infoUser["login"]);
    	echo json_encode($arr);
    	
    }

}

?>