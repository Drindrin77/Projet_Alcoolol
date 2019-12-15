<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Profil.php");

class AjaxProfil{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleProfil();

		$action = htmlspecialchars($_GET["action"]);

		switch($action){

            case "validerModification":
                $this -> validerModification();
            break;

            case "uploadAvatar":
                $this -> uploadAvatar();
            break;
 
		}
		
    }

    public function validerModification(){
        $dateNaissance = htmlspecialchars($_POST["dateNaissance"]);
        $adresse = htmlspecialchars($_POST["adresse"]);
        $email = htmlspecialchars($_POST["email"]);
        $numTel = htmlspecialchars($_POST["numTel"]);
        $description = htmlspecialchars($_POST["description"]);

        if ($email!="" && !filter_var($email, FILTER_VALIDATE_EMAIL)){
            echo json_encode(array("erreur" => true , "message" => "Votre email n'est pas valide"));
            exit(1);
        }

        else{
            if($dateNaissance=="")
                $dateNaissance=NULL;          

            $this -> modele -> modifierProfilPerso($dateNaissance,$adresse,$email,$numTel,$description);
            echo json_encode(array("erreur" => false));
            exit(0);
        }

        
    }

    public function uploadAvatar(){
        // Vérifier si le formulaire a été soumis
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Vérifie si le fichier a été uploadé sans erreur.

            if(isset($_FILES["file"])){
                $allowed = array("png" => "image/png", "jpg" => "image/jpg", "jpeg" => "image/jpeg");
                $filename = $_FILES["file"]["name"];
                $filetype = $_FILES["file"]["type"];
                $filesize = $_FILES["file"]["size"];

                // Vérifie l'extension du fichier
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
    

                if(!array_key_exists($ext, $allowed)){
                    $arr = array('erreur' => true,'message'=>"Veuillez sélectionner un format de fichier valide (.jpg, .jpeg ou .png");
                    echo json_encode($arr);
                    exit(1);
                }


                // Vérifie la taille du fichier - 5Mo maximum
                $maxsize = 5 * 1024 * 1024;
                if($filesize > $maxsize){
                    $arr = array('erreur' => true,'message'=>"La taille du fichier est supérieure à la limite autorisée.");
                    echo json_encode($arr);
                    exit(1);
                }

                // Vérifie le type MIME du fichier
                if(in_array($filetype, $allowed)){
                    
                    // Vérifie si le fichier existe avant de le télécharger.
                    foreach(array_keys($allowed) as $key){
                        if(file_exists( CONST_FILE_PATH_USER . $_SESSION["id"].".".$key))
                          unlink(CONST_FILE_PATH_USER . $_SESSION["id"].".".$key);
                            
                    }
                     
                    move_uploaded_file($_FILES["file"]["tmp_name"], CONST_FILE_PATH_USER .$_SESSION["id"].".".$ext);


                        if($ext=="png"){
                            $filePath = CONST_FILE_PATH_USER .$_SESSION["id"].".".$ext;
                            $image = imagecreatefrompng($filePath);
                            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                            imagealphablending($bg, TRUE);
                            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                            imagedestroy($image);
                            $quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
                            imagejpeg($bg, CONST_FILE_PATH_USER . $_SESSION["id"] . ".jpg", $quality);
                            imagedestroy($bg);
                            $ext="jpg";
                            unlink(CONST_FILE_PATH_USER . $_SESSION["id"].".png");

                        }

                    $this -> modele -> updateAvatar($_SESSION["id"]);
                    $arr = array('erreur' => false,'nomFichier'=>$_SESSION["id"],"message" => "Téléchargement reussi !");
                    echo json_encode($arr);
                    exit(0);
                } 
                else{
                    $arr = array('erreur' => true,'message'=>"Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.");
                    echo json_encode($arr);
                    exit(1);
                }
                
            } 

            else{
                $arr = array('erreur' => true,'message'=>"Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.");
                echo json_encode($arr);
                exit(1);
            }
        }
    }

}

?>