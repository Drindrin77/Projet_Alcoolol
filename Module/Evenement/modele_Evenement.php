<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleEvenement extends ModeleGenerique{
   public function __construct () {
   }

   public function accepterEvent($idEvent){
      $selectPreparee = self::$connexion -> prepare("update participantevent set enAttenteEvent=0 where idEvent=? and idParticipant=?");
      $tableauDescription = array($idEvent,$_SESSION["id"]);
      $selectPreparee->execute($tableauDescription);     
   }

   public function refuserEvent($idEvent,$id){
      $selectPreparee = self::$connexion -> prepare("delete from participantevent where idEvent=? and idParticipant=?");
      $tableauDescription = array($idEvent,$id);
      $selectPreparee->execute($tableauDescription);     
   }

   public function supprimerEvent($idEvent){
      $selectPreparee = self::$connexion -> prepare("delete from evenement where idEvent=?");
      $tableauDescription = array($idEvent);
      $selectPreparee->execute($tableauDescription);        
   }

   public function supprimerParticipants($idEvent){
      $selectPreparee = self::$connexion -> prepare("delete from participantevent where idEvent=?");
      $tableauDescription = array($idEvent);
      $selectPreparee->execute($tableauDescription);       
   }

   public function ajouterParticipant($idEvent,$idUser){
      $selectPreparee = self::$connexion -> prepare("insert into participantevent values (?,?,1)");
      $tableauDescription = array($idEvent,$idUser);
      $selectPreparee->execute($tableauDescription); 
   }
  
   public function envoieListeEvenementPublic(){
      $selectPreparee = self::$connexion -> prepare("select * from evenement where estPrive=0");
      $tableauDescription = array();
      $selectPreparee->execute($tableauDescription); 
      return $selectPreparee->fetchAll();
   }

   public function envoieDernierID(){
      $selectPreparee = self::$connexion -> prepare("select max(idEvent) from evenement where idCreateur=?");
      $tableauDescription = array($_SESSION["id"]);
      $selectPreparee->execute($tableauDescription); 
      return $selectPreparee->fetch();     
   }

   // Liste des evenements privé, envoyé si la personne y est invite ou est createur
   public function envoieListeEvenementPrive(){
      $selectPreparee = self::$connexion -> prepare("select distinct evenement.idEvent,nomEvent,date,heureDebut,lieu,idCreateur from evenement left join participantevent on evenement.idEvent = participantevent.idEvent where estPrive=1 and (idCreateur=? or idParticipant=?) group by idEvent");
      $tableauDescription = array($_SESSION["id"],$_SESSION["id"]);
      $selectPreparee->execute($tableauDescription);
      return $selectPreparee->fetchAll(); 
   }

   public function insertionEvenement($nom,$lieu,$heure,$date,$prive){
     $selectPreparee = self::$connexion -> prepare("insert into evenement values(default,?,?,?,?,?,?)");
      $tableauDescription = array($nom,$lieu,$heure,$_SESSION["id"],$date,$prive);
      $selectPreparee->execute($tableauDescription); 
   }

   public function envoieListeParticipant($idEvent){
      $selectPreparee = self::$connexion -> prepare("select * from participantevent inner join utilisateur on participantevent.idParticipant = utilisateur.idUser where idEvent = ? and enAttenteEvent=0");
      $tableauDescription = array($idEvent);
      $selectPreparee->execute($tableauDescription);  
      return $selectPreparee->fetchAll();    
   }

   public function envoieInfoEvent($idEvent){
      $selectPreparee = self::$connexion -> prepare("select * from evenement inner join utilisateur on evenement.idCreateur = utilisateur.idUser where idEvent = ?" );
      $tableauDescription = array($idEvent);
      $selectPreparee->execute($tableauDescription);  
      return $selectPreparee->fetch();     
   }

   public function listeAmisduCreateur(){
      $selectPreparee = self::$connexion -> prepare("select idUser_Utilisateur as idUser,avatar,nom,prenom,login from etreamis inner join utilisateur on etreamis.idUser_Utilisateur = utilisateur.idUser where etreamis.idUser = ? and enAttente=0");
      $tableauDescription = array($_SESSION["id"]);
      $selectPreparee->execute($tableauDescription);  
      return $selectPreparee->fetchAll(); 
   }

   public function dejaParticipantOuAttenteEvent($idUser,$idEvent,$valueAttente){
      $selectPreparee = self::$connexion -> prepare("select count(idParticipant) from participantevent 
         where enAttenteEvent=? and idParticipant=? and idEvent=?");
      $tableauDescription = array($valueAttente,$idUser,$idEvent);
      $selectPreparee->execute($tableauDescription);  
      return $selectPreparee->fetch(); 
   }

   public function envoieInfoParticipant($idUser){
       $selectPreparee = self::$connexion -> prepare("select nom,prenom,avatar,login from utilisateur where idUser=?");
      $tableauDescription = array($idUser);
      $selectPreparee->execute($tableauDescription);  
      return $selectPreparee->fetch();       
   }
   
}

?>