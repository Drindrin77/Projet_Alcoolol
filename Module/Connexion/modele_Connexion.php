<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleConnexion extends ModeleGenerique{
   public function __construct () {
   }
  
   public function inscrire($nom,$prenom,$email,$login, $mdp){
      $req = self::$connexion -> prepare("insert into utilisateur values(default,?,?,null,?,false,?,?,default,null,null,null)");
      $req->execute(array($nom,$prenom,$email,$login,$mdp)); 
   }

   public function verifLoginMailExistantInscription($login,$mail){
         $req=self::$connexion->prepare("SELECT count(login) FROM utilisateur where login=? or email=? ");
         $req->execute(array($login,$mail));
         return $req->fetch();
   }

   public function verifCompteExistantConnexion($login,$mdp){
         $req=self::$connexion->prepare("SELECT * FROM utilisateur where login=? and mdp=?");
         $req->execute(array($login,$mdp));
         return $req->fetch();
   }
   public function verifLoginExistantInscription($login){
         $req=self::$connexion->prepare("SELECT count(login) FROM utilisateur where login=?");
         $req->execute(array($login));
         return $req->fetch();
   }
   
}

?>