<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class VueConnexion extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }

   public function affiche_menu($token){
   	$this -> titre = "Connexion";
   	$this -> contenu = '

		<div class="ui middle aligned center aligned grid stackable">
		    <div class="column">

			    <h2 class="ui image header">
			    	Connexion
			    </h2>

		        <div class="ui secondary segment">
			        <div class="ui attached message invisible" id="erreurConnexion">
					  	<p>Votre login ou mot de passe est incorect</p>
					</div>

					<label class="floatLeft">Login:</label><br>
			        <div class="ui fluid left icon input marginBottom20">
			        	<i class="user icon"></i>
			            <input type="text" id="username" placeholder="login">
			        </div>

					<label class="floatLeft">Mot de passe:</label><br>
		        	<div class="ui fluid left icon input marginBottom20">
			            <i class="lock icon"></i>
			            <input type="password" id="password" placeholder="mot de passe">
		        	</div>
				        
				    <div id="submit" class="ui fluid large orange submit button">Se connecter</div>

		        </div>

			    <div class="ui message" id="inscriBlock">
			    	Pas encore un Alcoolo ? <button class="ui button yellow create_btn" type="button" id="tinymodal">Creer un compte</button>
			    	<div class="ui tiny modal" id ="modalInscri">
						<i id="croix" class="close icon"></i>
					    <div class="header">
					    	Creer un compte
					  	</div>
				  		<div class="ui form">
							<div class="ui segment">
								<div class="two fields">
								    <div class="field">
								      	<label>Nom</label>
								     	<input id="incriNom" placeholder="nom" type="text">
								    </div>
								    <div class="field">
								      	<label>Email</label>
								     	<input id="incriEmail" type="email" name="emailCreate" placeholder="example@domain.com">
								    </div>
						      	</div>
						      	<div class="two fields">
								    <div class="field">
								      	<label>Prenom</label>
								     	<input id="incriPrenom" type="text" name="prenom" placeholder="prenom">
								    </div>
								    <div class="field">
								      <label>Mot de passe</label>
								      <input id="incriPsw" type="password" name="mdpCreate" placeholder="mot de passe">
								    </div>
						      	</div>
						      	<div class="two fields">
								    <div class="field">
								     	<label>Login</label>
								        <input id="pseudo" placeholder="login" type="text">

									    <div class="ui pointing red basic label invisible" id="cont">
									    </div>
									    
								    </div>
								    <div class="field">
								      <label>Confirmation du mot de passe</label>
								      <input id="incriPswConf" type="password" name="mdpConfirmCreate" placeholder="confirmation du mot de passe">
                                           <a class="invisible" id="inscriToken">'.$token.'</a>
								    </div>
						      	</div>
					    	</div>
					    </div>
                           <span class="ui red basic label invisible" id="inscriAlert"></span>
				   			<div id="buttonInsc" class=" ui positive right labeled icon button">
						    	Creer son compte
						    	<i   class=" checkmark icon"></i>
				    		</div>
					</div>
			    </div>
		    </div>
		</div>



   	';

   	$this->contenu.='
		<script src="Module/Connexion/scriptConnexion.js"></script>
		<link rel="stylesheet" type="text/css" href="Module/Connexion/styleConnexion.css?t='.time().'">';
       }

}			
?>

