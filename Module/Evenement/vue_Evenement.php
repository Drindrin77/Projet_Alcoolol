<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class VueEvenement extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }

   public function detailEvenementPublic($infoEvent){
   	$this -> titre = "Detail evenement public";
	$this ->  contenu .='
		<div class="ui stackable four column grid">

			<div class="four wide column"></div>

			<div class="four wide column">

				<h1 class="marginBottom50">Information sur l\'evenement</h1> 
				<div class="ui card">
					<div class="image imgEvent">
						<img src="images/avatar/soiree.jpg">
					</div>

					<div class="content">
					      <div class="header">'.$infoEvent["nomEvent"].'</div>

					      <div class="meta">
					        <a>Evenement prive</a>
					      </div>

					      <div class="description">
					      	Date: '.$infoEvent["date"].'
					      	<br/>Heure: '.$infoEvent["heureDebut"].'
					      	<br/>Lieu: '.$infoEvent["lieu"].'
					      </div>

					</div>

			  	</div>

			</div>



			<div class="four wide column">
						<h1 class="marginBottom50" >Information sur le createur</h1> 

						<div class="ui card">
							  <div class="image imgEvent">
					    		<img src="'.CONST_FILE_PATH_USER.''.$infoEvent["avatar"].'?t='.time().'">
							  </div>
							  <div class="content">
								    <a class="header">'.$infoEvent["login"].'</a>
								    <div class="meta">
								      <span class="date">Joined in 2013</span>
								    </div>
								    <div class="description">
								      	Nom: '.$infoEvent["nom"].'
								      	<br/>Prenom: '.$infoEvent["prenom"].'
								      	<br/>Description: '.$infoEvent["description"].'							    
								  	</div>
								</div>									    
								
				   		 </div>
			</div>
		</div>

		<script src="Module/Evenement/scriptEvenement.js"></script>
		<link rel="stylesheet" type="text/css" href="Module/Evenement/styleEvenement.css?t='.time().'">';
   }

   public function detailEvenementPrive($infoEvent,$participants,$amis){

   	$this -> titre = "Detail evenement prive";
   	$this ->  contenu .='
     		<input type="hidden" id="idEvent" value='.$infoEvent["idEvent"].'>

			<div class="ui stackable grid">

				<div class="three wide column">
					<h1 class="titreDetail">Information sur l\'évenement</h1> 
				  	<div class="ui card">
						<div class="image imgEvent">
						    <img src="images/avatar/soiree.jpg">
						</div>

						<div class="content">
						      <a class="header">'.$infoEvent["nomEvent"].'</a>

						      <div class="meta">
						        <a>Evenement prive</a>
						      </div>

						      <div class="description">
						      	Date: '.$infoEvent["date"].'
						      	<br/>Heure: '.$infoEvent["heureDebut"].'
						      	<br/>Lieu: '.$infoEvent["lieu"].'
						      </div>

						</div>
					</div>				  	
				</div>


				<div class="one wide column"></div>
				<div class="three wide column">
					<h1 class="titreDetail">Information sur le créateur</h1> 

						<div class="ui card">
							<div class="image imgEvent">
					    		<img src="'.CONST_FILE_PATH_USER.''.$infoEvent["avatar"].'?t='.time().'">
							</div>
							<div class="content">
							    <a class="header">'.$infoEvent["login"].'</a>

							    <div class="meta">
							    	<a>Le créateur de l\'évenement</a>
							    </div>

							    <div class="description">
							      	Nom: '.$infoEvent["nom"].'
							      	<br/>Prenom: '.$infoEvent["prenom"].'
							      	<br/>Description: '.$infoEvent["description"].'							    
							  	</div>
							</div>			    
								
				   		</div>
				</div>
	
			  
				<div class="one wide column"></div>

				<div class="eight wide column">
					<h1 class="titreDetail">Liste des participants</h1> 

						<div class="ui three stackable cards">';

	

					// DEMANDE DAMIS
					foreach($participants as $value){
				 
							$this -> contenu.='
								<div id="divParticipant_'.$value["idUser"].'"class="card">
									   <div class="image imgEvent">
											<img src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t='.time().'">
									     </div>

									    <div class="content">
			    							<a class="header">'.$value["login"].'</a>
											<div class="meta">
											    <span class="date">'.$value["nom"].' '.$value["prenom"].'</span>
											</div>
										      <div class="description">
										        '.$value["description"].'
										      </div>

									    </div>';

									    if($_SESSION["id"]==$infoEvent["idCreateur"]){

									    $this -> contenu .='
									    <div class="extra content">										    
											<button id="divRetirer_'.$value["idUser"].'" class="ui fluid red button retirerParticipant">Retirer</button>	
									    </div>';
										}
								$this -> contenu .='</div>';
				}
						$this -> contenu .='

							</div> 
						<br/>';
				

        if($_SESSION["id"]==$infoEvent["idCreateur"]){

			$this-> contenu.='

				<button id="button" onclick="ajouter()" class="ui basic button">
					<i class="icon plus user"></i>
					 	Ajouter des participants
				</button>
				

				<div id="liste" class="ui three stackable cards invisible">';

					foreach($amis as $ami){

					$this -> contenu .='

							<div class="card">
							  	<div class="image imgEvent">
							    	<img src="'.CONST_FILE_PATH_USER.''.$ami["avatar"].'?t='.time().'">
							   	</div>

							    <div class="content">

							      <div class="header">'.$ami["login"].'</div>
							     '.$ami["nom"].$ami["prenom"].'

							    </div>

							    <div class="extra content">';


								    if($ami["enAttente"]==="1"){

								    	$this -> contenu .='<button class="ui fluid disabled button">
											  <i class="user icon"></i>
											  En attente
											</button>
								    	';

								    }
								    else{
								    	$this -> contenu .='
								    	
								  			<button id="divAjouter_'.$ami["idUser"].'" type="submit" class="ui fluid teal button ajouterParticipant"><i class="user plus icon"></i>Ajouter</button>
								  
								  		';
								    }


							  	$this -> contenu .='</div>
						    </div>';
					}

				$this -> contenu.=
					'</div><button id="boutonAnnulerListe" onclick="annuler()" class="ui black button invisible">Annuler</button>
				</div>';			
		}

		$this -> contenu .='
		<script src="Module/Evenement/scriptEvenement.js"></script>
		<link rel="stylesheet" type="text/css" href="Module/Evenement/styleEvenement.css?t='.time().'">';

   }

   	public function afficherMenu($public, $prive,$token){
   		$this -> contenu .='
                                <a id="TokenEv" style="display:none">'.$token.'</a>
   				<div class="ui placeholder segment">
				  <div class="ui two column very relaxed stackable grid">
					    <div class="ten wide column">
							<div class="ui top attached tabular menu">
								  <a id="tab1" onclick="prive()" class="item active" data-tab="first">Evenement prive</a>
								  <a id="tab2" onclick="public()" class="item " data-tab="second">Evenement public</a>
							</div>

							<div id="contenu1" class="ui bottom attached tab segment active" data-tab="first">
							 	<h1 class="titreDetail">Liste de vos évenements privés</h1>
							 	<div id="divPrivate" class="ui two stackable cards">';

								foreach($prive as $private){
									$this -> contenu .='
									<div id="divCard'.$private["idEvent"].'" class="card">

										    <div class="image imgEvent">
										      <img src="images/avatar/soiree.jpg">
										    </div>

											<div class="content">
											      <div class="header">'.$private["nomEvent"].'';

											      if($_SESSION["id"]==$private["idCreateur"]){

											     	$this -> contenu .='
 													
														 <button id="deleteEvent_'.$private["idEvent"].'" class="floatRight ui button fluid red deleteEvent">
															 Supprimer
														 </button>';
											  	  }
											  	  else{
											  	  	$this -> contenu .='
											  	  	 <button id="rageQuit_'.$private["idEvent"].'" class="floatRight ui button fluid red quitterEvent">
															 Quitter
														 </button>';
											  	  }

											      $this -> contenu .='</div>



											      <div class="meta">
											        <a>Evenement prive</a>
											      </div>

											      <div class="description">
											      	Date: '.$private["date"].'
											      	<br/>Heure: '.$private["heureDebut"].'
											      	<br/>Lieu: '.$private["lieu"].'
											      </div>

											</div>

										    <div class="extra content">';
										        	
										        if($_SESSION["id"]==$private["idCreateur"]){
													$this -> contenu.='


												      <span>
										        		<i class="user icon"></i>
															Vous etes le createur
													  </span>

  												      <form method="POST" action="index.php?module=Evenement&action=detailEvenementPrive">
												      		 <input type="hidden" name="idEvent" value='.$private["idEvent"].'>
 															 <button type="submit" class="ui button floatRight"><i class="cogs icon"></i></button>
												      </form>';

										        }
										        else
										        {
										         $this -> contenu.='
										         	 

												      <span>
										        		<i class="user icon"></i>
															Vous etes invite
													  </span>

													   <form method="POST" action="index.php?module=Evenement&action=detailEvenementPrive">
												      		 <input type="hidden" name="idEvent" value="'.$private["idEvent"].'">
 															 <button type="submit" class="ui button floatRight"><i class="eye icon"></i></button>
												      </form>';
											    }



										     

										    $this -> contenu .='</div>
										  

									</div>
									';							
								}




							$this -> contenu .='
								</div>
							</div>


							<div id="contenu2" class="ui bottom attached tab segment" data-tab="second">
							 	<h1 class="titreDetail">Liste de vos évenements publics</h1>
								<div id="divPublic" class="ui two stackable cards">';
							
									foreach($public as $pub){
										$this -> contenu .='
										  <div id="divCard'.$pub["idEvent"].'" class="card">

										    <div class="image imgEvent">
										      <img src="images/avatar/soiree.jpg">
										    </div>

											<div class="content">
											      <div class="header">'.$pub["nomEvent"];
 													if($_SESSION["id"]==$pub["idCreateur"]){

												     	$this -> contenu .='
	 													
														<button id="deleteEvent_'.$pub["idEvent"].'" class="floatRight ui button fluid red deleteEvent">
															Supprimer
														 </button>';
												      	
											  	  }
											  	   else{
											  	  	$this -> contenu .='
											  	  	 <button id="rageQuit_'.$pub["idEvent"].'" class="floatRight ui button fluid red quitterEvent">
															 Quitter
														 </button>';
											  	  }
											  	  $this -> contenu .='
											  	  </div>
											      <div class="meta">
											        <a>Evenement public</a>
											      </div>

											      <div class="description">
													Date: '.$pub["date"].'
											      	<br/>Heure: '.$pub["heureDebut"].'
											      	<br/>Lieu: '.$pub["lieu"].'
											      </div>

											</div>

											<div class="extra content">';
										        	
										        if($_SESSION["id"]==$pub["idCreateur"]){
													$this -> contenu.='


												      <span>
										        		<i class="user icon"></i>
															Vous etes le createur
													  </span>

  												      <form method="POST" action="index.php?module=Evenement&action=detailEvenementPublic">
												      		 <input type="hidden" name="idEvent" value='.$pub["idEvent"].'>
 															 <button type="submit" class="ui button floatRight"><i class="cogs icon"></i></button>
												      </form>';

										        }
										        else
										        {
										         $this -> contenu.='
										         	 

												      <span>
										        		<i class="user icon"></i>
															Vous etes invite
													  </span>

													   <form method="POST" action="index.php?module=Evenement&action=detailEvenementPublic">
												      		 <input type="hidden" name="idEvent" value="'.$pub["idEvent"].'">
 															 <button type="submit" class="ui button floatRight"><i class="eye icon"></i></button>
												      </form>';
											    }


										  $this -> contenu .='</div>
									</div>';
																	
							}

					$this -> contenu .='
								</div>
							</div>
						</div>	
				 
	    				<div class="middle aligned five wide column">
	    						<h1 class="titreDetail"> Pas d\'evenement qui vous interesse ? </h1>
										<button id="buttonCreer" class="ui big blue button">Creer un evenement</button>
										<div id="formulaire" class="invisible">

											<h3 class="titreDetail">Creer un evenement</h3>

											<form class="ui form">

													  <div class="field">
													    <label>Nom de l\'evenement</label>
													    <input required type="text" id="nom" placeholder="ex : Soiree apero chez Dorian">
													  </div>
													  <div class="field">
													    <label>Lieu</label>
													    <input required type="text" id="lieu" placeholder="ex: Paris">
													  </div>

													  <div class="field">
													    <label>Heure</label>
													    <input required  type="time" id="heure" placeholder="Heure">
													  </div>

													  <div class="field">
													    <label>Date</label>
													    <input required type="date" id="date" placeholder="Date">
													  </div>

													  <div class="field">
														<div class="ui checkbox">
														  <input type="checkbox" id="prive">
														  <label>Prive</label>
														</div>
													  </div>

														<div id ="divErreur" class="invisible titreDetail ui negative message">
														  <div class="header">
														    Erreur de création d\'évenement
														  </div>
														  <p id="messageErreur"> </p>
														</div>
													 
														
												 		<button id="submit" class="ui blue button">Creer</button>
												  	
											</form>

											<button id="annule" onclick="annule()" class="ui black button">Annuler</button>

						</div>

						

				  	</div>			 
				</div>

		<script src="Module/Evenement/scriptEvenement.js"?t='.filemtime("Module/Evenement/scriptEvenement.js").'"></script>
		<link rel="stylesheet" type="text/css" href="Module/Evenement/styleEvenement.css?t='.time().'">';
   	}
       
}			
?>

