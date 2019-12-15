<?php

if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');

class VueAmis extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }

   public function afficherMaListeAmi($tab){

	   		$this->titre="Liste ami";
   			$this -> contenu .=
   			'
   			<h1 class="ui center aligned icon header">
				<i class="circular users icon"></i>
					Votre liste d\'ami
			</h1>

   			<div class="ui link cards">';

			foreach($tab as $value){

   			$this-> contenu.='

  				<div class="card" id="cardAmi_'.$value["idUser"].'">
    				<div class="image imgAmi" onclick=location.href="index.php?module=Profil&action=profilAutre&idUser='.$value["idUser"].'">
				    	<img src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t='.time().'">
					</div>

	 				<div class="content">
	     				<div class="header">'.$value["login"].'</div>

						<div class="meta">
						        <a>'.$value["nom"].' '.$value["prenom"].'</a>
						</div>

						<div class="description">
	       					Description: '.$value["description"].'
	      				</div>

	 				</div>	

 					<div class="extra content">
					
						<button id="ami_'.$value["idUser"].'" class="ui red fluid button ami"><i class="user times icon"></i>Retirer des amis</button>
					
					</div>
				</div>';
				
					
			}	 

   		$this -> contenu.='</div>

   		<script src="Module/Amis/scriptAmis.js?t='.filemtime("Module/Amis/scriptAmis.js").'"></script>
   		<link rel="stylesheet" type="text/css" href="Module/Amis/styleAmis.css?t='.time().'">';  
 	
   }

   public function afficherSaListeAmi($tab,$amis){

	   		$this->titre="Recherche";
   			$this -> contenu .=
   			'
   			<h1 class="ui center aligned icon header">
				<i class="circular users icon"></i>
					Liste d\'ami 
			</h1>

   			<div class="ui link cards">';

			foreach($tab as $value){

   			$this->contenu.='

  				<div class="card" onclick=location.href="index.php?module=Profil&action=profilAutre&idUser='.$value["idUser"].'">
    				<div class="image imgAmi">
						<img src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t='.time().'">
					</div>

	 				<div class="content">
	     				<div class="header">'.$value["login"].'</div>

						<div class="meta">
						        <a>'.$value["nom"].' '.$value["prenom"].'</a>
						</div>

						<div class="description">
	       					Description: '.$value["description"].'
	      				</div>

	 				</div>	

 					<div class="extra content">';
					

				$pasEnAmi = true;
				$enDemande = false;

				foreach($amis as $ami){

					if($value["idUser"] == $ami["idUser"]){
						if($ami["enAttente"]==='1')
							$enDemande = true;
						
						$pasEnAmi = false;						
					}	
				}

				if(strtolower($_SESSION["login"])==strtolower($value["login"])){
					$this -> contenu.=
						'C\'est vous !
						<form method="POST" action =" index.php?module=Profil&action=profilPerso">
						<button class="ui teal button"><i class="eye icon"></i>Voir votre profil</button>
						</form>';
				}

				else{

					$this -> contenu .='<div class="ui two buttons">';

					if($pasEnAmi==true){

						$this -> contenu.='
						<form method="POST" action="index.php?module=Amis&action=demanderEnAmi">
							<input type="hidden" id="idUser" name="idUser" value='.$value["idUser"].'>
							<button id="ajout" class="ui green button"><i class="user plus icon"></i>Ajouter en ami</button>
						</form>
						';
					}
					else if($enDemande==true){
						$this -> contenu.='
							<button id="attente" class="ui disabled button">
							<i class="history icon"></i>
							  En attente
							</button>
						';

					}

					else{
						$this -> contenu.=
						'<form method="POST" action="index.php?module=Amis&action=supprimerAmi">

							<input type="hidden"  id="idUser" name="idUser" value='.$value["idUser"].'>
							<button id="retirer"class="ui red button"><i class="user times icon"></i>Retirer des amis</button>
						</form>
						';
					}

					$this -> contenu.='
						
					</div>
					';
				}
					
				$this -> contenu .='
						
					</div>
				</div>';

			}	 

   		$this -> contenu.='</div>

   		   		<script src="Module/Ami/scriptAmi.js"></script>
   		  		<link rel="stylesheet" type="text/css" href="Module/Ami/styleAmi.css?t='.time().'">';    
 	
   }

  

}
			
?>

