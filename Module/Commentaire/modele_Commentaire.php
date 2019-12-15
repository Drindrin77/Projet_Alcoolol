<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleCommentaire extends ModeleGenerique{
   public function __construct () {
   }

   public function getMaxIdCommentaire(){
      $req = self::$connexion -> prepare("SELECT max(idCommentaire)+1 as idCommentaire from commentaire");
      $req->execute(array());
      return $req->fetch();      
   }

   public function insertionCommentaireBoisson($idCommentaire,$commentaire,$idBoisson){
 	   $req = self::$connexion -> prepare("insert into commentaire values(?,?,?,?,null,now(),0)");
      $req->execute(array($idCommentaire, $commentaire,$_SESSION["id"],$idBoisson)); 
   }

   public function insertionCommentairedeCommentaire($commentaire,$idBoisson,$idCommentaire){
 	   $req = self::$connexion -> prepare("insert into commentaire values(default,?,?,?,?,now(),1)");
      $req->execute(array($commentaire,$_SESSION["id"],$idBoisson,$idCommentaire)); 
   }

   public function infoUser(){
      $req = self::$connexion -> prepare("SELECT login,avatar from utilisateur where idUser=?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();
   }

   

}

?>