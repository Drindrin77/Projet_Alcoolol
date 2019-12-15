<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class ModeleMessage extends ModeleGenerique{
   public function __construct () {
   }

   public function getNbMsgNonLu(){
      $req=self::$connexion->prepare("SELECT count(*) as nb from message where idDestinataire = ? and idMessage IN (SELECT MAX(idMessage) FROM message where message.idDestinataire=? group by idMessage_pere) and lu=0");
      $req->execute(array($_SESSION["id"],$_SESSION["id"]));
      return $req->fetch();
   }

   public function repondreMessage($idMsg,$idPere,$idDestinataire,$reponse, $objet){
      $req=self::$connexion->prepare("INSERT INTO message values (?,?,?,?,?,?,0,now(),0,0)");
      $req->execute(array($idMsg, $idPere, 'Re:'.$objet, $reponse, $_SESSION["id"],$idDestinataire));
   }

   public function mettreAJourLuMsg($idMsg){
      $req=self::$connexion->prepare("UPDATE message set lu=1 where idMessage = ?");
      $req->execute(array($idMsg));     
   }

   public function infoDestinataire($idMsg){
      $req=self::$connexion->prepare("SELECT login FROM message inner join utilisateur on message.idDestinataire = utilisateur.idUser where idMessage = ?");
      $req->execute(array($idMsg));
      return $req->fetch();           
   }

   public function infoExpediteur($idMsg){
      $req=self::$connexion->prepare("SELECT login,nom,prenom,objet FROM message inner join utilisateur on message.idExpediteur = utilisateur.idUser where idMessage = ?");
      $req->execute(array($idMsg));
      return $req->fetch();      
   }

   public function infoMessage($idMsg){
      $req=self::$connexion->prepare("SELECT dateMsg FROM message where idMessage = ?");
      $req->execute(array($idMsg));
      return $req->fetch();      
   }

   public function envoieListeReponse($idMsg){
      $req=self::$connexion->prepare("SELECT message,avatar,login,dateMsg,idExpediteur from message inner join utilisateur on message.idExpediteur=utilisateur.idUser where idMessage_pere=? order by dateMsg DESC");
      $req->execute(array($idMsg));
      return $req->fetchAll(); 
   }

   public function getMaxIdMsg(){
      $req=self::$connexion->prepare("SELECT max(idMessage)+1 as idMessage from message");
      $req->execute(array());
      return $req->fetch();         
   }

   public function insertionMessage($idMsg, $objet, $message,$idUser){
      
      $req = self::$connexion -> prepare("insert into message values(?,?,?,?,?,?,0,now(),0,0)");
      $req->execute(array($idMsg, $idMsg, $objet, $message, $_SESSION["id"],$idUser)); 
   }

   public function envoyerListeAmi($login){
      $req=self::$connexion->prepare("SELECT * FROM etreamis INNER JOIN utilisateur ON etreamis.idUser_Utilisateur = utilisateur.idUser where UPPER(utilisateur.login) like ? and enAttente=0 limit 10");
     $b=strtoupper($login);
      $req->execute(array("%$b%"));
      return $req->fetchAll();        
   }

   public function envoyerListeMessageRecu(){

      $req=self::$connexion->prepare("SELECT idMessage_pere, objet, avatar,login,lu,idMessage,idExpediteur FROM message inner join utilisateur on message.idExpediteur=utilisateur.idUser WHERE corbeille NOT LIKE ? AND idMessage IN (SELECT MAX(idMessage) FROM message where message.idDestinataire=? group by idMessage_pere) order by dateMsg DESC");
       $test = "%".$_SESSION["id"]."%";
      $req->execute(array($test,$_SESSION["id"]));
      return $req->fetchAll();   
   }

   public function supprimerDefinitifMsg($idMsg_pere){
      $req=self::$connexion->prepare("SELECT supprimer from message where idMessage_pere=?");
      $req->execute(array($idMsg_pere));     
      $tab = $req -> fetch();

      if($tab["supprimer"]=="0"){
         $req=self::$connexion->prepare("UPDATE message set supprimer=? where idMessage_pere=?");
         $req->execute(array($_SESSION["id"], $idMsg_pere));
      }
      else{
         $req=self::$connexion->prepare("DELETE FROM message where idMessage_pere=?");
         $req->execute(array($idMsg_pere));
      }
      
   
   }

   public function mettreCorbeille($idMsg_pere){

      $req=self::$connexion->prepare("SELECT corbeille from message where idMessage_pere=?");
      $req->execute(array($idMsg_pere));     
      $tab = $req -> fetch();

      if($tab["corbeille"]==="0")
         $idUser = $_SESSION["id"];
      
      else
         $idUser = $tab["corbeille"]." ".$_SESSION["id"];
      

      $req=self::$connexion->prepare("UPDATE message set corbeille=? where idMessage_pere=?");
      $req->execute(array($idUser, $idMsg_pere));

   }

   public function envoyerListeCorbeille(){
      $req=self::$connexion->prepare("SELECT * FROM message inner join utilisateur on message.idExpediteur=utilisateur.idUser where idMessage IN (SELECT MAX(idMessage) FROM message WHERE corbeille like ? and supprimer not like ? group by idMessage_pere) order by dateMsg DESC");
      $test = "%".$_SESSION["id"]."%";
      $req->execute(array($test,$test));
      return $req->fetchAll(); 
   }

   public function envoyerListeMessageEnvoyer(){
      $req=self::$connexion->prepare("SELECT idMessage_pere,idMessage,login,idDestinataire,objet FROM message inner join utilisateur on message.idDestinataire=utilisateur.idUser WHERE corbeille NOT LIKE ? AND idMessage IN (SELECT MAX(idMessage) FROM message where message.idExpediteur=? group by idMessage_pere) order by dateMsg DESC");
       $test = "%".$_SESSION["id"]."%";
      $req->execute(array($test,$_SESSION["id"]));
      return $req->fetchAll();   
   }

   public function envoieInfoUser($idUser){
      $req=self::$connexion->prepare("SELECT avatar,login,nom,prenom FROM utilisateur WHERE idUser=?");
      $req->execute(array($idUser));
      return $req->fetch();            
   }
   
   public function recupererId($login){
      $req=self::$connexion->prepare("SELECT idUser from utilisateur where login like ?");
      $req->execute(array($login));
      return $req->fetch();  
   }
}

?>