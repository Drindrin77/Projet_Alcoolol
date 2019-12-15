<?php

if(!defined('CONST_INCLUDE'))
	die('Acces direct interdit !');

class VueBoisson extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();

   }

   public function debutCreation($infoUser,$fruits,$alcools,$autres){

   		$this -> titre = "Creation de boisson";
   		$this -> contenu .='		
   			<h2 id="titre" class="ui center aligned icon header">
				<i class="circular flask icon"></i>
				Création de boisson 1/3
			</h2>

			<div id="contenu1" class="ui form">

			    <div class="field">
			    	<label>Nom de la boisson</label>
			    	<input type="text" id="nomBoissonCreation" placeholder="Ex: Jeager Bomb">
			    </div>

				<div class="field">
				    <label>Recette</label>
				    <textarea id="recetteCreation" placeholder="Ex: De l\'eau et on mélange"></textarea>
				</div>

				<div class="inline field">

					<div class="ui checkbox" id="checkboxCreation">
					   <label>Avec alcool</label>
				       <input id="checkboxAlcoolise" name="checkboxAlcool" type="checkbox" tabindex="0" class="hidden">				    
				    </div>

				    Difficulte : <div id="difficulteCreation" class="ui star rating" data-max-rating="5"></div>				    
					Note : <div id="noteCreation" class="ui heart rating" data-max-rating="5"></div>
					

				</div>

				<div class="row">
			  	   	<div class="fourteen wide column">
						<div class="ui accordion field">
					      	<div class="title" id="titleIngr">
						        <i class="icon dropdown"></i>
						        Ajouter des ingrédients
					    	</div>
					    	<div class="content field">

						    	<div class="ui stackable three column grid">
									
									<div class="six wide column">
										<h4>Fruit</h4>						
									 	<div class="ui middle aligned selection list">
									 	';
							    					
							    		foreach($fruits as $value){				        

								        	$this -> contenu .= 
								        	'
												<div class="item">
												    <div class="ui checkbox">
												        <label>'.utf8_encode($value["nomIngredient"]).'</label>
												        <input name="ingredient" nomIngr ="'.utf8_encode($value["nomIngredient"]).'" value="'.utf8_encode($value["idIngredient"]).'" type="checkbox">	    
												    </div>
												</div>			    	   	   

									    	';
									    }

							    	$this -> contenu .='
							    				
							    			</div>
						    		</div>

									<div class="five wide column">

										<h4>Alcool</h4>						
									 	<div class="ui middle aligned selection list">';
							    				    	
							    		foreach($alcools as $value){				        	
							        						        	

								        	$this -> contenu .= 
								        	'
								        	   <div class="item">
												    <div class="ui checkbox">
												        <label>'.utf8_encode($value["nomIngredient"]).'</label>
												        <input name="ingredient" nomIngr ="'.utf8_encode($value["nomIngredient"]).'" value="'.utf8_encode($value["idIngredient"]).'" type="checkbox">				    
												    </div>
												</div>
									    	';
									    }

							    	$this -> contenu .=' 
							    			
							    		</div>
							    	</div>

									<div class="five wide column">

										<h4>Autre</h4>						
									 	<div class="ui middle aligned selection list">';
							    				    	
							    		foreach($autres as $value){				        	
							        						        	

								        	$this -> contenu .= 
								        	'
								        	   <div class="item">
												    <div class="ui checkbox">
												        <label>'.utf8_encode($value["nomIngredient"]).'</label>
												        <input name="ingredient" nomIngr ="'.utf8_encode($value["nomIngredient"]).'" value="'.utf8_encode($value["idIngredient"]).'" type="checkbox">				    
												    </div>
												</div>
									    	';
									    }

							    	$this -> contenu .=' 
							    			
							    		
							    		</div>
							    	</div>

							    </div>
					    	</div>
					    </div>
				    </div>

				</div>

			</div>


			<div id="contenu2" class="invisible">
				<div class="ui placeholder segment">
				    
				    <h2 class="ui center aligned header">Choisissez une image</h2>				 	

					<div class="center" id="divAvatarBoisson">
						<div class="image imgDiv">
							<img id="avatarBoisson">
						</div><br>

						<div id="loader" class="ui loader"></div>
						
					  	<form enctype="multipart/form-data" method="post" name="fileinfo">
							<input type="file" id="photoBoisson" name="file"><br>						
						</form>
						
						<span id="resultatUploadBoisson"></span>

					</div>


				</div>

			</div>


			<div id="contenu3" class="invisible">

				<div class="ui grid" id="recapGrid">
				  	<h2 class="ui center aligned header" id="recapTitre">
						Récapitulatif des informations
					</h2>

					<div class="two column centered row">
						<div class="fourteen wide column">
							<div class="ui items">
								<div class="item">
									<div class="image imgDiv">
							     		<img id="avatarBoissonFinal" class="ui medium image" src="'.CONST_FILE_PATH_BOISSON.'?t='.time().'">
							     	</div>
								    <div class="content">
								    	<h1 id="nomBoissonFinal"></h1>
							        	<div class="meta">
							       			Difficulte : <div id="difficulteFinal" class="ui star rating" data-max-rating="5"></div><br><br>
							       			Note : <div id="noteFinal" class="ui heart rating" data-max-rating="5"></div><br><br>

											<div class="ui read-only checkbox" id="checkBoxFinal">
											   <label>Avec alcool</label>
										       <input type="checkbox" id="checkboxFinal">				       			    
									   	    </div>

							     		</div><br>
							     		<div class="ingredients">
							      			<h2>Ingredients</h2>
							        		<ol id="listIngredient" class="ui list">';											      
											    
						$this->contenu.=   '</ol>
							      		</div><br>
							      		<div class="recette">
							      			<h2>Recette</h2>
							        		<p id="recetteFinal"></p>
							      		</div>
								    </div>
								</div>
							</div>
							<div class="ui bottom attached header" id="titreRecapAuteur">
								<div class="ui stackable grid">
		  							<div class="row">
									    <div class="three wide column">
									    	<div class="image">
											    <img class="ui bottom aligned small image" src="'.CONST_FILE_PATH_USER.''.$infoUser["avatar"].'?t='.time().'">
							         		</div>
									    </div>
									    <div class="ten wide column">
									    	<h2>Auteur : '.$infoUser["login"].'</h2>
									    	<div class="ui message">
												<p>'.$infoUser["description"].'</p>
											</div>
									    </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>



			<div id="final" class="invisible">
				<div class="ui success message">
				    <div class="header">Félicitation vous avez fini de créer votre boisson !</div>
				    <p> Veuillez maintenant patienter la validation d\'un modérateur pour que votre boisson soit visible de tous ! 
				    	<br>Vous serez notifier dans l\'onglet requêtes en haut à gauche si votre boisson est validé </p> 				
				</div>

				<h3 class="ui center aligned icon header">
					Voulez vous créer une autre boisson ?<br>
					
					<button id="creerBouton" class="ui blue button" onclick=location.href="index.php?module=Boisson&action=creerBoisson"> Créer une autre boisson </button>
				</h3>
				
			</div>

			<div id="etapes" class="ui fluid ordered steps">
			  <div id="etape1" class="active step">
			    <div class="content">
			      <div class="title">Renseignement</div>
			      <div class="description">Quelques renseignements pour commencer</div>
			    </div>
			  </div>
			  <div id="etape2"class="active step">
			    <div class="content">
			      <div class="title">Image</div>
			      <div class="description">Une belle photo pour la nouvelle</div>
			    </div>
			  </div>
			  <div id="etape3" class="active step">
			    <div class="content">
			      <div class="title">Confirmation</div>
			      <div class="description">Confirmer votre création</div>
			    </div>
			  </div>

			</div>

			<br>
			<div id="erreur" class="ui error message invisible">
				<div class="header">Erreur !</div>
				<p> Veuillez remplir tous les champs </p> 				
			</div>
			<br>

			<button id="precedent_2" class="ui button invisible precedent">Précédent</button>
			<button id="suivant_1" class="ui blue button suivant">Suivant</button>';   		

   		$this -> contenu .='
   		  		<script src="Module/Boisson/scriptBoisson.js?t='.filemtime("Module/Boisson/scriptBoisson.js").'"></script>
   		  		<link rel="stylesheet" type="text/css" href="Module/Boisson/styleBoisson.css?t='.time().'">';
   }
	
	public function afficherBoisson($tab,$ingredients){
	
	   	$this->titre="Boisson";
   		$this->contenu.=
   		'<div class="ui grid">
			<div class="two column centered row">
				<div class="fourteen wide column">
					<div class="ui items">
						<div class="item">
							<div class="image imgDiv">
					     		<img class="ui medium image" src="'.CONST_FILE_PATH_BOISSON.''.$tab["img"].'">
					     	</div>
						    <div class="content">
						    	<h1>'.utf8_encode($tab["nomBoisson"]).'</h1>
					        	<div class="meta">
					       			Difficulte : <div class="ui star rating uneboisson" data-rating="'.$tab["difficulte"].'" data-max-rating="5"></div><br><br>
					       			Note : <div class="ui heart rating uneboisson" data-rating="'.$tab["note"].'" data-max-rating="5"></div><br><br>

									<div class="ui read-only checkbox" id="afficherBoissonCheck">
									   <label>Avec alcool</label>
								       <input type="checkbox"';
								       if($tab["nomCategorie"]==="cocktail avec alcool")
								       		$this -> contenu .='checked="checked"';      
								      $this -> contenu .='>				    
							   	   </div>

					     		</div><br>
					     		<div class="ingredients">
					      			<h2>Ingredients</h2>
					        		<ol class="ui list">';

					        			foreach($ingredients as $value){
					        				$this->contenu.= '<li value="-">'.utf8_encode($value["nomIngredient"]).'</li>';

					        			}
									      
									    
				$this->contenu.=   '</ol>
					      		</div><br>
					      		<div class="recette">
					      			<h2>Recette</h2>
					        		<p>'.utf8_encode($tab["recette"]).'</p>
					      		</div>
						    </div>
						</div>
					</div>
					<div class="ui bottom attached header" id="afficherBoissonHeader">
						<div class="ui stackable grid">
  							<div class="row">
							    <div class="three wide column">

							    	<div id="avatarAuteur" class="image"';

							    	if(isset($_SESSION["id"])){
							    		$this -> contenu .='
							    			onclick=location.href="index.php?module=Profil&action=profilAutre&idUser='.$tab["idCreateur"].'"';
							    	}

							    	$this -> contenu .='
							    	
							    	>					      
									    <img class="ui bottom aligned small image" src="'.CONST_FILE_PATH_USER.''.$tab["avatar"].'?t='.time().'">
					         		</div>
							    </div>
							    <div class="ten wide column">
							    	<h2>Auteur : '.$tab["login"].'</h2>
							    	<div class="ui message">
										<p>'.$tab["description"].'</p>
									</div>
							    </div>
							 </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="Module/Boisson/scriptBoisson.js?t='.filemtime("Module/Boisson/scriptBoisson.js").'"></script>
		<link rel="stylesheet" type="text/css" href="Module/Boisson/styleBoisson.css">';
	}
	public function afficheBouton($value,$favoris){
   			
		$pasPareil = true;
		foreach($favoris as $favori){
				if($value["idBoisson"] == $favori["idBoisson"] and $pasPareil==true)
					$pasPareil = false;		
		}						
		if($pasPareil==true){

			$this -> contenu.='
			  	<div class="ui labeled button" tabindex="0">
					<div class="ui red button butFavBoisson" id_change="'.$value["idBoisson"].'" id_fav="ajouterFavoris">
						<i class="heart icon"></i> Ajouter à mes favoris
					</div>
					<a id="nbrFav_'.$value["idBoisson"].'" class="ui basic red left pointing label">'.$value["nombreFavoris"].'
					</a>
				</div>
			';
		}

		else{
			$this -> contenu.=
				'<div class="ui labeled button" tabindex="0">
				  <div class="ui red fluid button butFavBoisson" id_change="'.$value["idBoisson"].'" id_fav="enleverFavoris">
				    <i class="heart icon"></i> Retirer de mes favoris
				  </div>
				  <a id="nbrFav_'.$value["idBoisson"].'" class="ui basic red left pointing label">
				    '.$value["nombreFavoris"].'
				  </a>
				</div>';
		}

	}

	public function afficherCommentaire($tab,$id,$fils){
		$compteur = 1;
		$this -> contenu .= '

		<input type="hidden" id="idBoisson" value="'.$id.'">

		<div class="ui comments" id="commentaireList">
  			<h3 class="ui dividing header">Commentaires</h3>
			'.sizeof($tab).' commentaire(s)';


			foreach($tab as $value){

				$dateString = date("Y-m-d H:i:s");
				$date = new DateTime($dateString);
				$date2 = new DateTime($value["date"]);
				$interval = date_diff($date, $date2);

				$this -> contenu .='

					<div class="comment">
					    <a class="avatar avatarCommentaire">
							<img src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'?t='.time().'">
					    </a>
					    <div class="content">
					      	<a class="author">'.$value["login"].'</a>
					      	<div class="metadata">
					        	<span class="date"> Envoyé il y a '.$interval->format('%d jours, %h heure et %i').' mins</span>
					      	</div>
					      	<div class="text">'.$value["commentaire"].'</div>

					      	<div id_comment="'.$value["idCommentaire"].'" class="actions afficherTextArea">
					      		<p class="reply">Répondre</p>
					      	</div>

					      	<div id="commentFils_'.$value["idCommentaire"].'" class="ui comments">';


							    foreach($fils as $fil){
							    	if($fil["idCommentaire_pere"]==$value["idCommentaire"]){

							    		$this -> contenu .='
								      		<div class="comment">
								       			<a class="avatar avatarCommentaire">
								       				<img src="'.CONST_FILE_PATH_USER.''.$fil["avatar"].'?t='.time().'">
								       			</a>
								        		<div class="content">
							    				    <a class="author">'.$fil["login"].'</a>
								         			<div class="metadata">
								            			<span class="date">A l\'instant</span>
								          			</div>
								          			<div class="text">
							       						'.$fil["commentaire"].'
								          			</div>
								          		</div>
								          	</div>';
							    	}
							    }
						$this -> contenu .='

						   </div>
						   		<div class="ui reply form invisible" id="commentaireDiv_'.$value["idCommentaire"].'">
	    							<div class="field">								
				  					  	<textarea id="commentaireFils_'.$value["idCommentaire"].'" placeholder="Commentez ici"></textarea>
				  					</div>

				   					<div id_comment="'.$value["idCommentaire"].'" class="ui blue labeled submit icon button commenterFils">
								      <i class="icon edit"></i> Commenter
								    </div>									
								</div>
						</div>					
					    
					</div>';

				$compteur++;

			}
			$this -> contenu .='
		</div>

		<div class="ui reply form">
		    <div class="field">
			    <textarea id="commentairePere" placeholder="Commentez ici"></textarea>
		    </div>
		    <div id="commenterPere" class="ui blue labeled submit icon button">
		      <i class="icon edit"></i> Commenter
		    </div>

		    <span class="invisible" id="commentairePereErreur"></span>
		</div>

		<script src="Module/Boisson/scriptBoisson.js"></script>
		<link rel="stylesheet" type="text/css" href="Module/Boisson/styleBoisson.css">';
	}

	public function testAlcoolemie(){
		$this -> titre .='Test d\'alcoolémie';
		$this -> contenu .='<div class="ui stackable grid">
			<div class="row">
				<div class="two wide column"></div>
				<div class="seven wide column">
					<div id="champErreur" class="ui error message invisible">
		                <div class="header">Erreur !</div>
		                <p> Veuillez remplir tous les champs </p>                 
					</div>
					​<table>
					  <tr id="tr">
					    <th>ALCOOLÉMIE DANS LE SANG</th>
					    <th></th>
					  </tr>
					  <tr>
					    <td>Sexe</td>
					    <td>
					    	<select id="idSexe" class="ui fluid search dropdown">
					            <option value="0">Homme</option>
					            <option value="1">Femme</option>
					        </select>
					    </td>
					  </tr>
					  <tr>
					    <td>Poids corporel (kg)</td>
					    <td>
					    	<div class="ui mini icon input">
							    <input type="text" id="idPoid">
							</div>
					    </td>
					  </tr>
					  <tr>
					    <td>Volume d\'alcool (mL)</td>
					    <td>
					    	<div class="ui mini icon input">
							    <input type="text" id="idVolume">
							</div>
						</td>
					  </tr>
					  <tr>
					    <td>Degré d’alcool (%)</td>
					    <td>
					    	<div class="ui mini icon input">
							    <input type="text" id="idDegre">
							</div>
					    </td>
					  </tr>
					  <tr>
					    <td>Apprenti</td>
					    <td>
					    	<input type="checkbox" id="apprenti" name="appr">
					    </td>
					  </tr>
					</table><br>

					<button id="boutonCalculer" class="ui primary button">Calculer <i class="chevron right icon"></i></button>
					
					<!--POUR METTRE LE RESULTAT-->
					<p id="resultat"></p>
					<div id="pasConduire" class="ui error message invisible">
		                <div id="headerConduire" class="header"></div>
		                <p id="textPasConduire"></p>                 
					</div>

				</div>



				<div class="five wide column">
					<div class="ui card" id="cardAlcoolemie">
					  <div class="content">
					    <div class="ui blue header"><h3>Alcool au volant : <br> sanctions, amende et retrait de points</h3></div>
					  </div>


					  <div class="content">
				          " La limite autorisée du taux d\'alcool dans le sang par la loi en 2019 est de <b>0,5 g/L</b>soit en équivalent <b>0,25 mg</b> par litre d\'air expiré. Depuis le 1er juillet 2015, le taux d\'alcoolémie légal est de <b>0,2 g/L</b> pour les jeunes conducteurs.
						Les sanctions prévues par le Code de la route pour une alcoolémie positive contraventionnelle (taux inférieur à 0,8 g/L de sang) sont <b>une amende de 135€</b> et un retrait de 6 points ainsi que potentiellement un retrait de permis. La mesure de l\'alcool consommé s\'effectue avec un éthylomètre homologué ou avec une analyse de sang. "
					  </div>
					  <div class="extra content">
					   <a id="legipermis" href="https://www.legipermis.com/infractions/alcool-permis-conduire.html">LegiPermis.com</a>
					  </div>
					</div>

				</div>
			</div>
		</div>

   		<script src="Module/Boisson/scriptBoisson.js?t='.filemtime("Module/Boisson/scriptBoisson.js").'"></script>
   		<link rel="stylesheet" type="text/css" href="Module/Boisson/styleBoisson.css?t='.time().'">';
	}


}

			
?>

