<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Evenement.php");

class AjaxEvenement{

    protected $modele;

    public function __construct(){

        $this->modele = new ModeleEvenement();

        $action = htmlspecialchars($_GET["action"]);

        switch($action){

            case "ajouterParticipant":
                $this -> ajouterParticipant();  
            break;

            case "retirerParticipant":              
                $this -> retirerParticipant();          
            break;

            case "accepterEvent":
                $this -> accepterEvent();
            break;

            case "refuserEvent":
                $this -> refuserEvent();
            break;

            case "quitterEvent":
                $this -> quitterEvent();
            break;

            case "supprimerEvent":
                $this -> supprimerEvent();
            break;

            case "creerEvenement":
                $this -> creerEvenement();
            break;
        }
        
    }

    public function retirerParticipant(){
        $idUser = htmlspecialchars($_POST["idUser"]);
        $idEvent = htmlspecialchars($_POST["idEvent"]); 
        $this -> modele -> refuserEvent($idEvent,$idUser);  
        $tab = $this -> modele -> envoieInfoParticipant($idUser);
        $arr = array('nom' => $tab["nom"],'prenom'=> $tab["prenom"],'avatar' => $tab["avatar"], 'login' => $tab["login"]);

        echo json_encode($arr);
            
    }

    public function quitterEvent(){
       $idEvent = htmlspecialchars($_POST["idEvent"]); 
       $this -> modele -> refuserEvent($idEvent,$_SESSION["id"]);       
    }

    public function refuserEvent(){
        $idEvent = htmlspecialchars($_POST["idEvent"]);
        $this -> modele -> refuserEvent($idEvent,$_SESSION["id"]);       
    }

    public function accepterEvent(){

        $idEvent = htmlspecialchars($_POST["idEvent"]);
        $this -> modele -> accepterEvent($idEvent);
    }

    public function supprimerEvent(){

        $idEvent = htmlspecialchars($_POST["idEvent"]);
        $this -> modele -> supprimerParticipants($idEvent);
        $this -> modele -> supprimerEvent($idEvent);
    }


    public function ajouterParticipant(){

        $idUser = htmlspecialchars($_POST["idUser"]);
        $idEvent = htmlspecialchars($_POST["idEvent"]);
        $this -> modele -> ajouterParticipant($idEvent,$idUser);

    }

        //1001-01-01 9999-12-31
    public function creerEvenement(){

        $nom = htmlspecialchars($_POST["nom"]);
        $lieu = htmlspecialchars($_POST["lieu"]);
        $heure = htmlspecialchars($_POST["heure"]);
        $date = htmlspecialchars($_POST["date"]);
        $tab = explode("-", $date);
        $token = htmlspecialchars($_POST["token"]);
        if(!empty($nom) && !empty($lieu) && !empty($heure) && !empty($date)){
            if(intval($tab[0],10) > 9999 || intval($tab[0],10) < 1001){
                $arr = array('erreur' => true,'message'=>'Veuillez mettre une date valide');
                echo json_encode($arr);
            }
            else{
                if ($this-> modele -> verifToken($token)){
                    if ($_POST['prive']==="true") 
                        $prive=1;   
                    else
                       $prive=0;

                    $this -> modele -> insertionEvenement($nom,$lieu,$heure,$date,$prive);
                    $idNew = $this->modele -> envoieDernierID();
                    $arr = array('erreur' => false, 'message'=>'Création reussie', 'idNew' => $idNew[0], 'token'=> $this -> modele->insertToken() );
                    echo json_encode($arr);
                    }
                    else{
                        $arr = array('erreur' => true,'message'=>'Veuillez recharger la page');
                        echo json_encode($arr);
                    }
                }
            }          
           
        
        else{
            $arr = array('erreur' => true,'message'=>'Veuillez remplir tous les champs' );
            echo json_encode($arr);
            
        }
        
    }

}

?>