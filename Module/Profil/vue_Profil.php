<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class VueProfil extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }

   public function modifierProfilPerso($value){

   		$this -> titre = "Modifier profil";
   		$this -> contenu .='<div class="ui stackable grid">
			<div class="four column centered row">
				<!--premiere colonne-->
			    <div class="column">
			    	<div class="ui special cards">
				    	<div class="card">
					    	<div class="blurring dimmable image imgProfil">
			         			<div class="ui dimmer">
							        <div class="content">
								        <div class="center">

											<form enctype="multipart/form-data" method="post" name="fileinfo">
									      		<label for="photo" class="ui orange basic button">
												    <i class="file image outline icon"></i>
												    Changer l\'image...
											    </label>
												<input type="file" id="photo" name="file" class="invisible">	
											</form>

								        </div>
							        </div>
							    </div>
							    	<img id="avatarProfil">
			         		</div>
			         	</div>
			        </div>
			        <br>
			        <span id="erreurImg"></span>
			        <div id="loader" class="ui loader"></div>

			    </div>
			    <!--deuxieme colonne-->
			    <div class="six wide column">
			    	<div class="ui segment">
						<h2 class="ui left floated header">'.$value["login"].'</h2>
						<div class="meta">
							<span class="category">'.$value["nom"].' '.$value["prenom"].'</span>
						</div>
						
						<div class="ui clearing divider"></div>
			        	
						<div class="description">
							<div class="ui list">
								<div class="item">
							 		<i class="birthday cake icon"></i>
									<div class="ui form">
							    		<input type="date" id="dateNaissance" value='.$value["dateNaissance"].'>
							   		</div>
								</div>
								
								<div class="item">
									<i class="marker icon"></i>
									<div class="ui form">
										<input type="text" id="adresse" placeholder="New York, NY" value="'.$value["adresse"].'">
									</div>
								</div>
								<div class="item">
									<i class="mail icon"></i>
									<div class="ui form">
										<input type="email" id="email" placeholder="example@domain.com" value='.$value["email"].'>
									</div>
								</div>
								<div class="item">
									<i class="phone square icon"></i>
									<div class="ui form">
										<input type="tel" id="numTel" pattern="[0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}" placeholder="xx xx xx xx xx" value="'.$value["numTel"].'">
									</div>
								</div>
								<div class="ui divider"></div>
								<h3 class="ui left floated header">Description</h3>
								<br><br>
								<div class="item">
									<div class="ui form">
 									    <div class="field">
										    <textarea rows="2" id="description">'.$value["description"].'</textarea>
									    </div>
									</div>
								</div>

								<button id="enregistrer" class="ui teal button">
							      <i class="settings icon"></i>
							      	Enregistrer les modifications
							    </button>

							    <span class="invisible" id="errorMail"></span>

							</div>
						</div>
					</div>  
			    </div>
			</div>

		</div>

		<script>				
				$(window).on("load", function(){
					$("#avatarProfil").attr("src","'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t=" + new Date().getTime());
				});

		</script>
	    
   		<script src="Module/Profil/scriptProfil.js?t='.filemtime("Module/Profil/scriptProfil.js").'"></script>
   		<link rel="stylesheet" type="text/css" href="Module/Profil/styleProfil.css?t='.time().'">'; 
   }

   public function afficherProfilPerso($value){

	   		$this->titre="Profil";
   			$this->contenu.='

							<div class="ui stackable grid">
								<div class="five column centered row">
									<!--premiere colonne-->
								    <div class="four wide column">
								    	<div class="ui special cards">
									    	<div class="card">
												<div class="image imgProfil">
												    <img id="profilUser">
								         		</div>
								         	</div>
								        </div>
								    </div>
								    <!--deuxieme colonne-->
								    <div class="six wide column">
								    	<div class="ui segment">
											<h2 class="ui left floated header">'.$value["login"].'</h2>
											<div class="meta">
												<span class="category">'.$value["nom"].' '.$value["prenom"].'</span>
											</div>
											<div class="ui right floated header">
												<button class="ui mini circular button" onclick=location.href="index.php?module=Profil&action=modifierProfilPerso">
												  <i class="settings icon"></i>
												  Modifier
												</button>
											</div>
											<div class="ui clearing divider"></div>
											<div class="description">
												<div class="ui list">
													<div class="item">
														<div class="ui form">
															<i class="birthday cake icon"></i>
													    	'.$value["dateNaissance"].'
													   	</div>
													</div>
													<div class="item">
														<div class="ui form">
															<i class="marker icon"></i>
															'.$value["adresse"].'
														</div>
													</div>
													<div class="item">
														<div class="ui form">
															<i class="mail icon"></i>
															<a href="mailto:'.$value["email"].'">'.$value["email"].'</a>
														</div>
													</div>
													<div class="item">
														<div class="ui form">
															<i class="phone square icon"></i>
															'.$value["numTel"].'
														</div>
													</div>
													<div class="ui divider"></div>
													<h3 class="ui left floated header">WHO I AM ?</h3>
													<br><br>
													<div class="item">
														<div class="ui content">
															'.$value["description"].'
														</div>
													</div>
												</div>
											</div>
										</div>  
								    </div>
								</div>
					  			<!--Deuxieme ligne-->
					  			<div class="column centered row" >

									<label onclick=location.href="index.php?module=Amis&action=voirMaListeAmi" class="ui teal button">
									    <i class="users icon"></i>
									    Liste d\'amis
									</label>
									<label onclick=location.href="index.php?module=Recherche&action=MAlisteBoissonsFavoris" class="ui blue button">
									    <i class="heart icon"></i>
									    Boissons Favorites
									</label>
									<label onclick=location.href="index.php?module=Recherche&action=mesCreationsBoissons" class="ui violet button">
									    <i class="untappd icon"></i>
									    Création de boissons
									</label>


					  			</div> 
							</div>

		<script>
				$(window).on("load", function(){
					$("#profilUser").attr("src","'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t=" + new Date().getTime());
				});
		</script>
		<link rel="stylesheet" type="text/css" href="Module/Profil/styleProfil.css?t='.time().'">'; 
	}

	public function afficherProfilAutre($value,$amisPerso){

		$this->titre="Profil";
   			
				$pasEnAmi = true;
				$enDemande = false;

				foreach($amisPerso as $ami){

					if($value["idUser"] == $ami["idUser"]){
						if($ami["enAttente"]==='1')
							$enDemande = true;
						
						$pasEnAmi = false;						
					}	
				}			


		$this -> contenu.='
		<div class="ui stackable grid">
			<div class="five column centered row">
				<!--premiere colonne-->
			    <div class="four wide column">
			    	<div class="ui special cards">
				    	<div class="card">
					    	<div class="image imgProfil">
							   <img src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t='.time().'">
			         		</div>';

			         if($pasEnAmi==true){

						$this -> contenu.='
						 <button  idUsr="'.$value["idUser"].'" class="ui green button ajoutAmis"><i class="user plus icon"></i>Ajouter en ami</button>
                           
						';
					}
					else if($enDemande==true){
						$this -> contenu.='

							<button class="ui disabled button attenteAmis" idUsr="'.$value["idUser"].'">
							<i class="history icon"></i>
							  En attente
							</button>
						';

					}

					else{
						$this -> contenu.='
						<button idUsr="'.$value["idUser"].'" class="ui red button retirerAmis"><i class="user plus icon"></i>Retirer des amis</button>
                                
						';
					}

			    $this -> contenu.='</div>
			        </div>
			    </div>
			    <!--deuxieme colonne-->
			    <div class="six wide column">
			    	<div class="ui segment">
						<h2 class="ui left floated header">'.$value["login"].'</h2>
						<div class="meta">
							<span class="category">'.$value["nom"].' '.$value["prenom"].'</span>
						</div>
						<div class="ui clearing divider"></div>
						<div class="description">
							<div class="ui list">
								<div class="item">
									<div class="ui form">
										<i class="birthday cake icon"></i>
								    	'.$value["dateNaissance"].'
								   	</div>
								</div>
								<div class="item">
									<div class="ui form">
										<i class="users icon"></i>
										Guilde
									</div>
								</div>
								<div class="item">
									<div class="ui form">
										<i class="marker icon"></i>
										'.$value["adresse"].'
									</div>
								</div>
								<div class="item">
									<div class="ui form">
										<i class="mail icon"></i>
										<a href="mailto:'.$value["email"].'">'.$value["email"].'</a>
									</div>
								</div>
								<div class="item">
									<div class="ui form">
										<i class="phone square icon"></i>
										'.$value["numTel"].'
									</div>
								</div>
								<div class="ui divider"></div>
								<h3 class="ui left floated header">Description</h3>
								<br><br>
								<div class="item">
									<div class="ui content">
										'.$value["description"].'
									</div>
								</div>
							</div>
						</div>
					</div>  
			    </div>
			</div>
  			<!--Deuxieme ligne-->
  			<div class="column centered row" >
  				<div class="ui buttons">';

						$this -> contenu.='
						<form method="POST" action="index.php?module=Amis&action=voirSaListeAmi">
							<input type="hidden" name="idUser" value='.$value["idUser"].'>

							<button type="submit" class="ui teal button marginRight5">
							    <i class="users icon"></i>
							    Liste d\'amis
							</button>
						</form>


					<form method="POST" action="index.php?module=Recherche&action=SAlisteBoissonsFavoris">
						<input type="hidden" name="idUser" value='.$value["idUser"].'>

						<button type="submit" class="ui blue button marginRight5">
						    <i class="heart icon"></i>
						    Boissons Favorites
						</button>
					</form>

					<form method="POST" action="index.php?module=Recherche&action=sesCreationsBoissons">
						<input type="hidden" name="idUser" value='.$value["idUser"].'>
						<button type="submit" class="ui violet button">
						    <i class="untappd icon"></i>
						   	Création de boissons
						</button>
					</form>
				</div>	
  			</div> 
		</div>
   		<link rel="stylesheet" type="text/css" href="Module/Profil/styleProfil.css?t='.time().'">
   		<script src="Module/Profil/scriptProfil.js"></script>
   		'; 
	}

}
			
?>

