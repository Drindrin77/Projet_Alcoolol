<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleProfil extends ModeleGenerique{
   public function __construct () {
   }

   public function updateAvatar($image){
      $req=self::$connexion->prepare("UPDATE utilisateur set avatar=? where idUser=?");
      $req->execute(array($image,$_SESSION["id"]));     
   }
  
   public function envoieInfoUser($id){
         $req=self::$connexion->prepare("SELECT * FROM utilisateur where idUser=?");
         $req->execute(array($id));
         return $req->fetch();
   }

   public function envoyerListeAmi($id){
      $req=self::$connexion->prepare("SELECT * FROM etreamis INNER JOIN utilisateur ON etreamis.idUser_Utilisateur = utilisateur.idUser where etreamis.idUser=?");
      $req->execute(array($id));
      return $req->fetchAll();       
   }

   public function modifierProfilPerso($dateNaissance,$adresse,$email,$numTel,$description){
      $req=self::$connexion->prepare(" UPDATE utilisateur set dateNaissance=?, adresse=?, email=?,numTel=?,description=? where idUser=?");
      $req->execute(array($dateNaissance,$adresse,$email,$numTel,$description,$_SESSION["id"]));    
   }

   

}

?>