<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

include_once ("modele_Boisson.php");

class AjaxBoisson{

	protected $modele;

	public function __construct(){

		$this->modele = new ModeleBoisson();

		$action = htmlspecialchars($_GET["action"]);	

		switch($action){

			case "creationImgTemporaire":
				$this -> creationImgTemporaire();
			break;

			case "creationFiniBoisson":
				$this -> creationFiniBoisson();
			break;

            case "testPseudo":
                $this -> testPseudo();
            break;

            case "ajouterFavoris":
				$this -> ajouterBoissonFavoris();
			break;

			case "enleverFavoris":
				$this -> enleverBoissonFavoris();
			break;
		}
		
	}

	public function ajouterBoissonFavoris(){
		if(isset($_POST["idBoisson"])){
			$idBoisson=htmlspecialchars($_POST["idBoisson"]);
			$this -> modele -> ajouterBoissonFavoris($idBoisson);
			$this -> modele -> augmenterNbrFav($idBoisson);
		}
	}

	public function enleverBoissonFavoris(){
		if(isset($_POST["idBoisson"])){
			$idBoisson=htmlspecialchars($_POST["idBoisson"]);
			$this -> modele -> enleverBoissonFavoris($idBoisson);
			$this -> modele -> diminuerNbrFav($idBoisson);
		}
	}


 	public function creationFiniBoisson(){

  		$idBoisson = $this -> modele -> getMaxIdBoisson();
    	$idBoisson = $idBoisson["idBoisson"];
    	$ext = htmlspecialchars($_POST["ext"]);
    	$img = $idBoisson . "." . $ext;


    	rename("images/Boisson/CreationBoisson/".$_SESSION["id"].".".$ext,"images/Boisson/".$img);

    	$recette = htmlspecialchars($_POST["recette"]);
    	$nomBoisson = htmlspecialchars($_POST["nomBoisson"]);
    	$note = htmlspecialchars($_POST["note"]);
    	$difficulte = htmlspecialchars($_POST["difficulte"]);

    	$moderateur = $this -> modele -> envoieInfoUser();

    	if($moderateur["moderateur"]=="1")
    		$moderateur=1;
    	else
    		$moderateur=0;

		if ($_POST['alcool']==="true") 
           $alcool="cocktail avec alcool";   
        else
           $alcool="cocktail sans alcool";

    	$this -> modele -> insertionNouveauBoisson($recette, $nomBoisson, $note, $difficulte, $alcool, $idBoisson, $img, $moderateur);

    	// LES BOISSONS QUE LES MODERATEURS CREE SONT DIRECTEMENT ACCEPTER
    	if($moderateur==0)
    		$this -> modele -> insertionAttenteBoisson($idBoisson);

       	if(!empty($_POST["ingredient"])){
			foreach($_POST["ingredient"] as $value){
				$this -> modele -> insertionIngredients(intval($value), $idBoisson);
			}  
		}
    }


    public function creationImgTemporaire(){

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
                    	$arr = array('erreur' => true,'message'=>"Veuillez sélectionner un format de fichier valide (.jpg, .jpeg ou .png)");
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
		        		if(file_exists( CONST_FILE_PATH_BOISSON . "CreationBoisson/" . $_SESSION["id"].".".$key))
		              	  unlink(CONST_FILE_PATH_BOISSON . "CreationBoisson/" . $_SESSION["id"].".".$key);
		          			
		        	}
		             
	                move_uploaded_file($_FILES["file"]["tmp_name"], CONST_FILE_PATH_BOISSON . "CreationBoisson/" .$_SESSION["id"].".".$ext);


	        		if($ext=="png"){
	        			$filePath = CONST_FILE_PATH_BOISSON . "CreationBoisson/" .$_SESSION["id"].".".$ext;
	        			$image = imagecreatefrompng($filePath);
						$bg = imagecreatetruecolor(imagesx($image), imagesy($image));
						imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
						imagealphablending($bg, TRUE);
						imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
						imagedestroy($image);
						$quality = 50; // 0 = worst / smaller file, 100 = better / bigger file 
						imagejpeg($bg, CONST_FILE_PATH_BOISSON . "CreationBoisson/" . $_SESSION["id"] . ".jpg", $quality);
						imagedestroy($bg);
						$ext="jpg";
						unlink(CONST_FILE_PATH_BOISSON . "CreationBoisson/" . $_SESSION["id"].".png");

	        		}



                    $arr = array('erreur' => false,'nomFichier'=>$_SESSION["id"].".".$ext,"message" => "Téléchargement reussi !");
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