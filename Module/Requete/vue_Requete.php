<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class VueRequete extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }

   public function afficherListeDemande($amis,$events,$boissons,$moderateur,$token){

   	$this -> titre ="Requete";
   	$this -> contenu .='
                <a id="tokenAdmi" style="display:none">'.$token.'</a>
   		<div class="ui top attached tabular menu">
		  <a class="item active" data-tab="first">
		  	Amis
		  	<div id="nbrAmi" class="mini floating ui red label">'.sizeof($amis).'</div>
		  </a>

		  <a class="item" data-tab="second">
		  Evénements
		  <div id="nbrEvent" class="mini floating ui teal label">'.sizeof($events).'</div>
		  </a>

		  <a class="item" data-tab="third">
		  Boissons
		  <div id="nbrBoisson" class="mini floating ui blue label">'.sizeof($boissons).'</div>
		  </a>
		</div>';

		// REQUETE AMIS

		$this -> contenu .='

		<div class="ui bottom attached tab segment active" data-tab="first">
		    <h2 class="ui center aligned icon header">
			 	<i class="circular users icon"></i>
			  	Requêtes d\'amis
			</h2>
			<div class="ui three stackable cards">';

			foreach($amis as $value){
		 
					$this -> contenu.='
					<div class="card" id="cardAmi_'.$value["idUser"].'">
						    <div class="image imgEvent" onclick=location.href="index.php?module=Profil&action=profilAutre&idUser='.$value["idUser"].'">
						      	<img src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t='.time().'">
						    </div>

						    <div class="content">
								<a class="header">'.$value["login"].'</a>

							      <div class="description">
							        '.$value["login"].' souhaite vous ajouter dans sa liste d\'amis
							      </div>

						    </div>

						    <div class="extra content">

							    <div class="ui two buttons">

									<button id_ami="'.$value["idUser"].'" id_action="refuserAmi" class="ui basic red ami button">Refuser</button>

									<button id_ami="'.$value["idUser"].'" id_action="accepterEnAmi" class="ui basic green ami button">Accepter</button>
										
							    </div>

						    </div>
					</div>';
		}

		$this -> contenu .='</div></div>';

		// EVENEMENT

		$this -> contenu .='
		<div class="ui bottom attached tab segment" data-tab="second">
		  	<h2 class="ui center aligned icon header">
				<i class="circular heart icon"></i>
				Invitation aux événements
			<h2>
			<div class="ui three stackable cards">';

			// INVITATION EVENEMENT
			foreach($events as $value){
					 
					$this -> contenu.='
					<div class="card" id="cardEvent_'.$value["idEvent"].'">
						    <div class="image imgEvent">
						      <img src="images/avatar/soiree.jpg">
						    </div>

							<div class="content">
							      <div class="header">'.$value["nomEvent"].'</div>

							      <div class="meta">
							        <a>Evenement prive</a>
							      </div>

							      <div class="description">
							      	Date: '.$value["date"].'
							      	<br/>Heure: '.$value["heureDebut"].'
							      	<br/>Lieu: '.$value["lieu"].'
							      </div>

							</div>

							<div class="extra content">
								<div class="ui two buttons">

									<button id_action="refuserEvent" id_event="'.$value["idEvent"].'" class="ui basic red button event">Refuser</button>

									<button id_action="accepterEvent" id_event="'.$value["idEvent"].'" class="ui basic green button event">Accepter</button>

								</div>	

								<form method="POST" action="index.php?module=Evenement&action=detailEvenementPrive">
							      		 <input type="hidden" name="idEvent" value='.$value["idEvent"].'>
											 <button class="ui fluid teal button"><i class="eye icon"></i>Voir l\'évenement</button>
							    </form>

							</div>
					</div>';
			}

	$this -> contenu .='
			</div>
		</div>
		
		
		<div class="ui bottom attached tab segment" data-tab="third">
			<h2 class="ui center aligned icon header">
				<i class="circular heart icon"></i>
				Créations de boissons
			<h2>
			<div class="ui three stackable cards">';
			
			// VOIR MES CREATIONS
			if($moderateur == "0"){

				foreach($boissons as $value){
					 
					$this -> contenu.='
					<div class="card" id="cardBoissonCreateur_'.$value["idBoisson"].'">
					    <div class="image imgEvent">
					      <img src="'.CONST_FILE_PATH_BOISSON.''.$value["img"].'">
					    </div>

						<div class="content">';
						if($value["avisModerateur"]!=0){
							$this -> contenu .='<button id_boisson='.$value["idBoisson"].' class="ui tiny negative basic button supprimerAnnonce">
							  <i class="close icon"></i>
							  Supprimer
							</button>';
						}
							
						   $this -> contenu .='<div class="header">'.$value["nomBoisson"].'</div><br>';

						// BOISSON ACCEPTER = 1 OU REFUSER = -1 EN ATTENTE = 0

						if($value["avisModerateur"]!=0){

							//BOISSON ACCEPTER
							if($value["avisModerateur"]==1){
								$this -> contenu .=' 
								<div class="description">

							      	<p class="accept">Votre boisson a été accepté par un modérateur!</p>

									<div class="extra content">							
										<form method="POST" action="index.php?module=Boisson&action=afficheBoisson">
							      			<input type="hidden" name="id" value='.$value["idBoisson"].'>
											 <button class="ui fluid blue button"><i class="eye icon"></i>Voir votre boisson</button>
							    		</form>		

									</div>

							    </div>';
						   	}

						   	//BOISSON REFUSE
						   	else{
								$this -> contenu .=' 
								<div class="description">

							      	<p class="refus">Votre boisson a été refusé par un modérateur.<p><br>
							      	Message du modérateur:
							      	'.$value["message"].'									

							    </div>';

						   	}
						}

						// TOUJOURS EN ATTENTE
						else{
							$this -> contenu .=' 
							<div class="description">
						      	Votre boisson est toujours en attente de validation d\'un modérateur.
						    </div>';
						}


				$this -> contenu .='
						</div>
					</div>';
				}

			}

			// MODERATEUR ON = ACCEPTER OU REFUS
			else{
				foreach($boissons as $value){
				 
					$this -> contenu.='
					<div class="card" id="cardBoisson_'.$value["idBoisson"].'">

						    <div class="image imgEvent">
						      <img src="'.CONST_FILE_PATH_BOISSON.''.$value["img"].'">
						    </div>

							<div class="content">
							    <div class="header">'.$value["nomBoisson"].'</div>							

								<div class="description">

									<form method="POST" action="index.php?module=Boisson&action=afficheBoisson">
						   				<input type="hidden" name="id" value='.$value["idBoisson"].'>
						   				<button class="ui teal fluid button"> <i class="eye icon"></i>Voir la boisson</button>
						   			</form>
						 
						 			Message:<br>
						   			<textarea id="message"></textarea>

						   			<br>
									<div class="ui two buttons">
										<button id_action="refuserBoisson" id_boisson="'.$value["idBoisson"].'" class="ui basic red button boissons">Refuser</button>

										<button id_action="accepterBoisson" id_boisson="'.$value["idBoisson"].'" class="ui basic green button boissons">Accepter</button>
									</div>
							    </div>

							</div>

						  
					</div>';
				}
			}

			$this -> contenu .='
			</div>	
		</div>
	</div>

	<script src="Module/Requete/scriptRequete.js?t='.filemtime("Module/Requete/scriptRequete.js").'"></script>
   	<link rel="stylesheet" type="text/css" href="Module/Requete/styleRequete.css?t='.time().'">';


   }

}
			
?>

