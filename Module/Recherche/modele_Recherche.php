<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleRecherche extends ModeleGenerique{
   public function __construct () {
   }

   public function listeCreation($idUser){
      $req=self::$connexion->prepare("SELECT * FROM boisson where idCreateur=? and avisModerateur=1");
      $req->execute(array($idUser));
      return $req->fetchAll();    
   }

   public function envoieListeIngredientCategorie($nom){
      $req=self::$connexion->prepare("SELECT * FROM ingredient where categorieIngredient=? order by nomIngredient");
      $req->execute(array($nom));
      return $req->fetchAll();  
   }

   public function envoieListeBoissonSansIngredient($recherche){
      $req=self::$connexion->prepare("SELECT * from boisson where nomBoisson like ? and avisModerateur=1");
      $req->execute(array("%$recherche%"));
      return $req->fetchAll();     
   }

   public function resultatRechercheParIngredientBoisson($ingredients,$recherche){

      $requeteSQL = 'SELECT idBoisson,nomBoisson,img,note,difficulte,nombreFavoris,nomCategorie FROM boisson natural join composerde natural join ingredient WHERE idIngredient in (' . implode(',', array_map('intval', $ingredients)) . ') and avisModerateur=1 and nomBoisson like ?';

      $req=self::$connexion->prepare($requeteSQL);
      $req->execute(array("%$recherche%"));
      return $req->fetchAll();    

   }

   public function envoieListeBoissonFavoris($id){
      $req=self::$connexion->prepare("SELECT * FROM listefavoris natural join boisson where idUser=?");
        $req->execute(array($id));
        return $req->fetchAll();
   }

   public function envoieListeBoisson(){
         $req=self::$connexion->prepare("SELECT * FROM boisson where avisModerateur=1");
         $req->execute();
         return $req->fetchAll();
   }

   public function envoieInfoUser($id){
         $req=self::$connexion->prepare("SELECT * FROM utilisateur where idUser=?");
         $req->execute(array($id));
         return $req->fetchAll();
   }

   public function envoieListeUser($login){
      $req=self::$connexion->prepare("SELECT * FROM utilisateur where login like ? LIMIT 10");
      $req->execute(array("%$login%"));
      return $req->fetchAll();
   }

   public function envoyerListeAmi($id){
      $req=self::$connexion->prepare("SELECT * FROM etreamis INNER JOIN utilisateur ON etreamis.idUser_Utilisateur = utilisateur.idUser where etreamis.idUser=?");
      $req->execute(array($id));
      return $req->fetchAll();       
   }

   public function envoyerListeBoissonRechercheNomBoisson($nomBoisson){
      $req=self::$connexion->prepare("SELECT * FROM boisson where nomBoisson like ? and avisModerateur = 1 LIMIT 10");
      $req->execute(array("%$nomBoisson%"));
      return $req->fetchAll();      
   }

   public function barreRechercheAlcool($nom){
      $req=self::$connexion->prepare("SELECT nomBoisson FROM boisson where nomBoisson like ? and avisModerateur = 1 LIMIT 10");
      $req->execute(array("%$nom%"));
      return $req->fetchAll();   
   }

   
}

?>