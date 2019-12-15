<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class VueRecherche extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }


   public function afficheRechercheVideUser($login){

   		$this -> titre .='Pas de resultat';

   		$this -> contenu .='
   		<div class="ui placeholder segment">
		    <div class="ui icon header">
    			<i class="search icon"></i>
		    	Aucun alcoolo répond du nom de '.$login.'
		    </div>

		    <form method="POST" action="index.php?module=Recherche&action=RechercherUser">
		        <div class="field">
		          <div class="ui search">
		            <div class="ui icon input">
		              <input class="prompt userSearchBar" name="recherche" type="text" list="userList" placeholder="Continuer à rechercher...">
		              <i class="search icon"></i>
		              <datalist id="userList"></datalist> 
		            </div>
		          </div>
		        </div>
 			</form>
		</div>

   		<script src="Module/Recherche/scriptRecherche.js?t='.filemtime("Module/Recherche/scriptRecherche.js").'"></script>
   		<link rel="stylesheet" type="text/css" href="Module/Recherche/styleRecherche.css?t='.time().'">';  

   }

      public function rechercheAvance($fruits,$alcools,$autres){
   		$this -> titre .='Boissons';

   		$this -> contenu .='

		<form method="POST" action="index.php?module=Recherche&action=RechercheAvance">

	   		<div class="ui centered grid" id="gridRechercheAvance">
	   			<h2 class="ui center aligned icon header"><i class="circular flask icon"></i>Recherche de boisson</h2>


	   			<div class="row">
	   				<div class="eight wide column">

					  	<div class="ui inverted fluid left icon input">
					    	<input class="alcoolSearchBar" type="text" name="recherche" list="alcoolList" placeholder="A consulter avec modération...">
					    	<i class="search icon"></i>
					    	<datalist id="alcoolList"></datalist> 

					  	</div>
				  	</div>
			  	</div>	 
			 
			  	<div class="row">


			  	   	<div class="fourteen wide column">
						<div class="ui accordion field">
					      	<div class="title" id="titleAjoutIngr">
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
												        <input name="ingredient[]" value="'.$value["idIngredient"].'" type="checkbox">	    
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
												        <input name="ingredient[]" value="'.$value["idIngredient"].'" type="checkbox">				    
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
												        <input name="ingredient[]" value="'.$value["idIngredient"].'"type="checkbox">				    
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

			  	<div class="row">
			  		<button class="ui blue button">Valider</button>
			  	</div>

			</div>

		</form>	

		<script src="Module/Recherche/scriptRecherche.js?t='.filemtime("Module/Recherche/scriptRecherche.js").'"></script>
		<link rel="stylesheet" type="text/css" href="Module/Recherche/styleRecherche.css?t='.time().'">';  

   }

   public function afficherListe($tab){
	   	$this-> titre="Boisson";
   		$this -> contenu .='

   		<h1 class="ui center aligned icon header nbResultat">
			'.sizeof($tab).' résultat(s)
		</h1>

   		<div class="ui link cards">';

   		foreach($tab as $value){
   			$this->contenu .='
   			  <div class="card">
   			  	<div class="image imgBoisson">
	   			  		<img src='.CONST_FILE_PATH_BOISSON.''.$value["img"].'>
	   			</div>
   			  	<div class="content">
   			  		<div class="header">'.utf8_encode($value["nomBoisson"]).'</div>

   			  		<div class="description">
						Difficulte: <div class="ui star rating" data-rating="'.$value["difficulte"].'" data-max-rating="5"></div><br>
						Note: <div class="ui heart rating" data-rating="'.$value["note"].'" data-max-rating="5"></div><br>

						<div class="ui read-only checkbox checkAlcool">
						   <label>Avec alcool</label>
					       <input type="checkbox" class="checkboxListeBoisson"';
					       if($value["nomCategorie"]==="cocktail avec alcool")
					       		$this -> contenu .='checked="checked"';      
					      $this -> contenu .='>				    
				   	   </div>

   			  		</div>

   			  	</div>
   			  	<div class="extra content">
   			  		<form method="POST" action="index.php?module=Boisson&action=afficheBoisson">
 						<input type="hidden" name="id" value='.$value["idBoisson"].'>
						<button class ="ui fluid teal button" ><i class="eye icon"></i>
					     		 Voir la boisson
   			  			</button>
		   			</form>
		   		</div>

   			</div>

   			';
   		}

   		$this -> contenu .='</div>
   		<script src="Module/Recherche/scriptRecherche.js?t='.filemtime("Module/Recherche/scriptRecherche.js").'"></script>
   		<link rel="stylesheet" type="text/css" href="Module/Recherche/styleRecherche.css?t='.time().'">';  
  
   }

	public function afficherListeConnecte($boissons,$favorisPerso){

	   	$this->titre="Boisson";
	   	$this -> contenu .='

   		<h1 class="ui center aligned icon header nbResultat">
			'.sizeof($boissons).' résultat(s)
		</h1>

	   	<div class="ui link cards">';

   		foreach($boissons as $value){

   			$this-> contenu.='


   				<div class="card">
	   			  	<div class="image imgBoisson">
	   			  		<img src='.CONST_FILE_PATH_BOISSON.''.$value["img"].'>
	   			  	</div>

   			  	<div class="content">
   			  		<div class="header">'.utf8_encode($value["nomBoisson"]).'</div>
   			  		<div class="description diffNoteBoisson">
						Difficulte: <div class="ui star rating" data-rating="'.$value["difficulte"].'" data-max-rating="5"></div><br>
						Note: <div class="ui heart rating" data-rating="'.$value["note"].'" data-max-rating="5"></div><br>

						<div class="ui read-only checkbox checkAlcool">
						   <label>Avec alcool</label>
					       <input type="checkbox" class="checkboxListeBoisson"';
					       if($value["nomCategorie"]==="cocktail avec alcool")
					       		$this -> contenu .='checked="checked"';      
					      $this -> contenu .='>				    
				   	   </div>

   			  		</div><br>';

				$pasPareil = true;
				foreach($favorisPerso as $favori){
					if($value["idBoisson"] == $favori["idBoisson"] and $pasPareil==true)
							$pasPareil = false;		
				}
				
				if($pasPareil==true){

                    $this -> contenu.='
		   				<div class="ui labeled button" tabindex="0">
						  <div class="ui red button butFav" id_change="'.$value["idBoisson"].'" id_fav="ajouterFavoris">
						    <i class="heart icon"></i> Ajouter à mes favoris
						  </div>
						  <a id="nbrFav_'.$value["idBoisson"].'" class="ui basic red left pointing label">
						    '.$value["nombreFavoris"].'
						  </a>
						</div>';
				}                    

					else{
                         $this -> contenu.='
						<div class="ui labeled button" tabindex="0">
						  <div class="ui red button butFav" id_change="'.$value["idBoisson"].'" id_fav="enleverFavoris">
						    <i class="heart icon"></i> Retirer de mes favoris
						  </div>
						  <a id="nbrFav_'.$value["idBoisson"].'" class="ui basic red left pointing label">
						    '.$value["nombreFavoris"].'
						  </a>
						</div>';

					}
   			  	
				$this -> contenu .='</div>

				<div class="extra content">';

					$this -> contenu.='
		   			<form method="POST" action="index.php?module=Boisson&action=afficheBoisson">
		   				<input type="hidden" name="id" value='.$value["idBoisson"].'>
		   				<button class="ui teal fluid button"> <i class="eye icon"></i>Voir la boisson</button>
		   			</form>
		   			';
				
			
			
   				$this -> contenu.='</div></div>';  			
   		}
   		$this -> contenu .='<script src="Module/Recherche/scriptRecherche.js?t='.filemtime("Module/Recherche/scriptRecherche.js").'"></script>
   		   	<link rel="stylesheet" type="text/css" href="Module/Recherche/styleRecherche.css?t='.time().'">';  

	}

   public function rechercheVide(){

   	$this -> titre ='Pas de résultat';
   	$this -> contenu.='

	<h2 class="ui center aligned icon header">
		<i class="circular frown outline icon"></i>
		Pas de résultat pour votre recherche
	</h2>

   	<div class="ui placeholder segment">

	  <div class="ui two column stackable center aligned grid">

	    <div class="middle aligned row">
	      <div class="column">
	        <div class="ui icon header">
	          <i class="search icon"></i>
	         	Effectuer une autre recherche
	        </div>
	        <div class="field">

			<form method="POST" action="index.php?module=Recherche&action=RechercheAvance">
	          <div class="ui search">
	            <div class="ui icon input">
	              <input class="prompt alcoolSearchBar" name="recherche" list="alcoolList" type="text" placeholder="Continuer à rechercher...">
	              <i class="search icon"></i>
	              <datalist id="alcoolList"></datalist> 
	            </div>
	          </div>

	         </form>


	        </div>
	      </div>

	      <div class="column">

	        <div class="ui icon header">
	          <i class="flask icon"></i>
	          Créer une boisson
	        </div>';

	        if(isset($_SESSION["id"])){
		        $this -> contenu .='

		        <div class="ui primary button" onclick=location.href="index.php?module=Boisson&action=creerBoisson">
		          Créer
		        </div>';
	        }
	        else{
	        	$this -> contenu.='

				<div class="ui primary button">
		          Créer
		        </div>

				<div class="ui special popup">
		            <div class="ui form">
		                <div class="ui center aligned grid">
		                    <div class="column">			                    
	                        	<h3>Il faut être connecté pour pouvoir créer une boisson</h3>
	                            <p>Vous pouvez vous connecter en appuyant sur le bouton ci-dessous</p>
	                            <br>

	                       		<div class="ui positive labeled icon button" onclick=location.href="index.php?module=Connexion&action=menu">
			                        Se connecter
			                        <i class="user icon"></i>
			                    </div>

		                    </div>
		                </div>
		            </div>
		        </div>';
	        }
	        						

	      $this -> contenu .='</div>
	    </div>
	  </div>
	</div>

   	<script src="Module/Recherche/scriptRecherche.js?t='.filemtime("Module/Recherche/scriptRecherche.js").'"></script>
    <link rel="stylesheet" type="text/css" href="Module/Recherche/styleRecherche.css?t='.time().'">';  
 
   }

   public function afficheListeUser($tab,$amis){

	   		$this->titre="Recherche";
   			$this -> contenu .=
   			'
   			<h1 class="ui center aligned icon header">
				<i class="circular users icon"></i>
					Resultat de la recherche
			</h1>

   			<div class="ui link cards">';

			foreach($tab as $value){

   			$this->contenu.='

  				<div class="card">
    				<div class="image imgUser" onclick=location.href="index.php?module=Profil&action=profilAutre&idUser='.$value["idUser"].'">
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
					'C\'est vous !';
				
				}

				//on a pas retrouve l'id de la personne dans la liste d'ami de la personne courante
				else{

					$this -> contenu .='<div class="ui two buttons">';

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

					$this -> contenu.='

						<label class="ui teal button">
						    <i class="envelope icon"></i>
						    Envoyer un message
						</label>
						<div class="ui special popup" id="popUpMsg'.$value["idUser"].'">
				            <div class="ui form">
				                <div class="ui center aligned grid">
				                    <div class="column">
				                    	Objet:<input type="text" id="objet_'.$value["idUser"].'" placeholder="Objet">
				                    	<br>
				                        Message:<textarea id="message_'.$value["idUser"].'" placeholder="Mon message..." rows="5" class="msgUser"></textarea>

				                        <div id_change="'.$value["idUser"].'" class="ui positive labeled icon button envoyerMessage">
				                            Envoyer
				                            <i class="checkmark icon"></i>
				                        </div>

				                    </div>
				                </div>
				            </div>
				        </div>						
					</div>
					';
				}
					
				$this -> contenu .='
						
					</div>
				</div>';

			}	 

   		$this -> contenu.='</div>

   		<script src="Module/Recherche/scriptRecherche.js?t='.filemtime("Module/Recherche/scriptRecherche.js").'"></script>
   		<link rel="stylesheet" type="text/css" href="Module/Recherche/styleRecherche.css?t='.time().'">';  

   
   }



}


						
?>

