<?php

if(!defined('CONST_INCLUDE'))
   die('Acces direct interdit !');

class ModeleAmis extends ModeleGenerique{
   public function __construct () {
   }
  
   public function envoieListeUser($login){
      $req=self::$connexion->prepare("SELECT * FROM utilisateur where login like ?");
      $req->execute(array("%$login%"));
      return $req->fetchAll();
   }

   public function modifierAttente($id){
      $req=self::$connexion->prepare("UPDATE etreamis set enAttente=0 where idUser_Utilisateur=? and idUser=?");
      $req->execute(array($_SESSION["id"],$id));      
   }

   public function demandeAmi($id){
      $req=self::$connexion->prepare("INSERT INTO etreamis values(?,?,1)");
      $req->execute(array($_SESSION["id"],$id));
   }

   public function ajouterEnAmiRetour($id){
      $req=self::$connexion->prepare("INSERT INTO etreamis values(?,?,0)");
      $req->execute(array($_SESSION["id"],$id));    
   }

   public function envoyerListeAmiEtAttente($id){
      $req=self::$connexion->prepare("SELECT * FROM etreamis INNER JOIN utilisateur ON etreamis.idUser_Utilisateur = utilisateur.idUser where etreamis.idUser=?");
      $req->execute(array($id));
      return $req->fetchAll();       
   }

   public function envoyerMAListeAmi(){
      $req=self::$connexion->prepare("SELECT * FROM etreamis INNER JOIN utilisateur ON etreamis.idUser_Utilisateur = utilisateur.idUser where etreamis.idUser=? and enAttente=0");
      $req->execute(array($_SESSION["id"]));
      return $req->fetchAll();       
   }

   public function supprimerAmi($id){
      $req=self::$connexion->prepare("DELETE FROM etreamis where idUser=? and idUser_Utilisateur=?");
      $req->execute(array($id,$_SESSION["id"]));     
   }
   public function supprimerAmiRetour($id){
      $req=self::$connexion->prepare("DELETE FROM etreamis where idUser=? and idUser_Utilisateur=?");
      $req->execute(array($_SESSION["id"],$id));     
   }
   public function verifSiDejaDemande($id){
      $req=self::$connexion->prepare("SELECT count(*) FROM etreamis where etreamis.idUser=? and 
         etreamis.idUser_Utilisateur=? and enAttente=1");
      $req->execute(array($id,$_SESSION["id"]));
      return $req->fetch();

   }
   
}

?>
