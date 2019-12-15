<?php

if(!defined('CONST_INCLUDE'))
  die('Acces direct interdit !');

class ModeleBoisson extends ModeleGenerique{
   public function __construct () {
   } 

   public function insertionIngredients($idIngredient, $idBoisson){
      $req=self::$connexion->prepare("INSERT into composerde values (?,?)");
      $req->execute(array($idIngredient, $idBoisson));   
   }

   public function insertionAttenteBoisson($idBoisson){
      $req=self::$connexion->prepare("INSERT into accepterboisson (idBoisson,idCreateur) values (?,?)");
      $req->execute(array($idBoisson,$_SESSION["id"]));     
   }

   public function insertionNouveauBoisson($recette, $nomBoisson, $note, $difficulte, $alcool, $idBoisson, $img, $moderateur){
      $req=self::$connexion->prepare("INSERT into boisson values (?,?,?,?,?,?,?,0,?,?)");
      $req->execute(array($idBoisson,$note,$nomBoisson,$difficulte,$recette,$alcool,$img,$_SESSION["id"],$moderateur));      

   }
   public function getMaxIdBoisson(){
        $req=self::$connexion->prepare("SELECT max(idBoisson)+1 as idBoisson from boisson");
        $req->execute();
        return $req->fetch();
   }

   public function envoieListeBoissonFavoris($id){
        $req=self::$connexion->prepare("SELECT * FROM listefavoris natural join boisson where idUser=?");
        $req->execute(array($id));
        return $req->fetchAll();
   }
   public function envoieListeIngredient(){
         $req=self::$connexion->prepare("SELECT * FROM ingredient");
         $req->execute();
         return $req->fetchAll();  
   }

   public function envoieListeIngredientBoisson($id){
      $req=self::$connexion->prepare("SELECT * FROM ingredient inner join composerde on ingredient.idIngredient = composerde.idIngredient where idBoisson = ?");
      $req->execute(array($id));
      return $req->fetchAll();    
   }

   public function envoieListeIngredientCategorie($nom){
      $req=self::$connexion->prepare("SELECT * FROM ingredient where categorieIngredient=?");
      $req->execute(array($nom));
      return $req->fetchAll();  
   }

   public function envoieBoissonParID($id){
         $req=self::$connexion->prepare("SELECT * FROM boisson inner join utilisateur on boisson.idCreateur = utilisateur.idUser where idBoisson=?");
         $req->execute(array($id));
         return $req->fetch();
   }

   public function augmenterNbrFav($idBoisson){
      $req=self::$connexion->prepare("UPDATE boisson set nombreFavoris = nombreFavoris+1 where idBoisson=?");
      $req->execute(array($idBoisson));
   }

  public function diminuerNbrFav($idBoisson){
      $req=self::$connexion->prepare("UPDATE boisson set nombreFavoris = nombreFavoris-1 where idBoisson=?");
      $req->execute(array($idBoisson));
   }

   public function envoieListeCommentaireBoisson($idBoisson){

     $req=self::$connexion->prepare("SELECT * FROM commentaire inner join utilisateur on commentaire.idUser = utilisateur.idUser where commentaire.idBoisson=? and commentaire.estFils = 0");
     $req->execute(array($idBoisson));
     return $req->fetchAll();

   }

   public function envoieListeCommentaireCommentaire($idBoisson){
     $req=self::$connexion->prepare("SELECT * FROM commentaire inner join utilisateur on commentaire.idUser = utilisateur.idUser where commentaire.idBoisson=? and commentaire.estFils = 1");
     $req->execute(array($idBoisson));
     return $req->fetchAll();
   }

   public function enleverBoissonFavoris($idBoisson){
      $req=self::$connexion->prepare("DELETE FROM listefavoris where idBoisson=?");
      $req->execute(array($idBoisson));
      return $req->fetchAll();      
    }

  public function ajouterBoissonFavoris($idBoisson){
      $req=self::$connexion->prepare("INSERT INTO listefavoris values(?,?)");
      $req->execute(array($_SESSION["id"],$idBoisson));
      return $req->fetchAll();     
  }
  
   public function envoieInfoUser(){
      $req=self::$connexion->prepare("SELECT * FROM utilisateur where idUser = ?");
      $req->execute(array($_SESSION["id"]));
      return $req->fetch();          
   }


}

?>