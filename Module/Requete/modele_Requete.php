<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleRequete extends ModeleGenerique{
   public function __construct () {
   }

   public function nbBoissonNonModo(){
      $req=self::$connexion->prepare("SELECT count(idBoisson) FROM accepterboisson where idCreateur=?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();     
   }

   public function nbBoissonModo(){
      $req=self::$connexion->prepare("SELECT count(idBoisson) FROM boisson where avisModerateur=0");
      $req->execute(array());
      return $req->fetch();     
   }

   public function estModo(){
      $req=self::$connexion->prepare("SELECT moderateur FROM utilisateur where idUser=?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();      
   }

   public function nbAmis(){
      $req=self::$connexion->prepare("SELECT count(*) FROM etreamis where idUser_Utilisateur=? and enAttente=1");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();     
   }

   public function nbEvent(){
      $req=self::$connexion->prepare("SELECT count(idEvent) FROM participantevent where idParticipant=?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();     
   }

   public function envoyerListeCreationBoisson(){
      $req=self::$connexion->prepare("SELECT * FROM boisson natural join accepterboisson where idCreateur=?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetchAll();
   }
   public function supprimerBoisson($idBoisson){
      $req=self::$connexion->prepare("DELETE FROM boisson WHERE idBoisson=? and avisModerateur=-1");
      $req->execute(array($idBoisson));      
   }

   public function envoyerListeBoissonModerateur(){
      $req=self::$connexion->prepare("SELECT * FROM boisson WHERE avisModerateur=0");
      $req->execute(array());
      return $req->fetchAll();    
   }

   public function supprimerAnnonce($idBoisson){
      $req=self::$connexion->prepare("DELETE FROM accepterboisson WHERE idBoisson=?");
      $req->execute(array($idBoisson));
   }

   public function envoieInfoModerateur(){
      $req=self::$connexion->prepare("SELECT moderateur FROM utilisateur where idUser=?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();
   }
  
   public function updateAccepterBoisson($idBoisson,$message){
      $req=self::$connexion->prepare("UPDATE accepterboisson SET message=? where idBoisson=?");
      $req->execute(array($message,$idBoisson));
   }

   public function refusBoisson($idBoisson){
      $req=self::$connexion->prepare("UPDATE boisson SET avisModerateur=-1 where idBoisson=?");
      $req->execute(array($idBoisson));  
   }

   public function updateEnAttenteModerateur($idBoisson){
      $req=self::$connexion->prepare("UPDATE boisson SET avisModerateur=1 where idBoisson=?");
      $req->execute(array($idBoisson));

   }
   public function suppressionIngredients($idBoisson){
      $req=self::$connexion->prepare("DELETE FROM composerde where idBoisson=?");
      $req->execute(array($idBoisson));
   }
   
   public function envoyerListeDemandeAmi(){
      $req=self::$connexion->prepare("SELECT * FROM etreamis INNER JOIN utilisateur ON etreamis.idUser = utilisateur.idUser where etreamis.idUser_Utilisateur=? and enAttente=1");
      $req->execute(array($_SESSION["id"]));
      return $req->fetchAll();
   }

   public function envoyerListeInvitationEvenement(){
       $req=self::$connexion->prepare("SELECT * FROM evenement INNER JOIN participantevent on evenement.idEvent=participantevent.idEvent INNER JOIN utilisateur ON evenement.idCreateur = utilisateur.idUser where participantevent.idParticipant = ? and enAttenteEvent=1");
      $req->execute(array($_SESSION["id"]));
      return $req->fetchAll();     
   }
}

?>