<?php
if(!defined('CONST_INCLUDE'))
	die('Acces   direct interdit !'); 

class ModeleGenerique{

	static protected $connexion;
	private static $dns = "mysql:host=localhost;dbname=alcoolol";
    private static $user="alcoolol"; 
    private static $password="cestdeleau";
	
	  public function __construct() {}	

  	public static function initConnexionBD(){

  		try{
  			self::$connexion= new PDO(self::$dns,self::$user,self::$password);
  			
  		}catch(exeption $e){
  			echo "Erreur de connexion à la BD : ".$e;
  		}	
  	}

    public function netoyeToken(){
        $req=self::$connexion->prepare("delete from tokenInscription where dateCreation < (now() - interval 30 minute)");
        $req->execute();
    }
    public function verifToken($token){

        $this->netoyeToken();
        $req=self::$connexion->prepare("select * from tokenInscription where token = ?");
        $req->execute(array($token));
           
        if (0<$req->rowCount()){
          $this->deleteToken($token);
          return true;
        }
        else{
          return false;
        }

    }

    public function deleteToken($token){
        $req=self::$connexion->prepare("delete from tokenInscription where token = ?");
        $req->execute(array($token));
    }
    public function insertToken(){
       
      $req=self::$connexion->prepare("INSERT into tokenInscription values(?, default) ");

      do {
        
        $this->netoyeToken();
        $idToken = mt_rand(0,99999999 );
      } while (!$req->execute(array($idToken)));

      return $idToken;
   }
	
}

?>

	

