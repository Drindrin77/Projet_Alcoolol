<div class="barre_navigation">
   <div class="barre_navigation-header">
      <a class=" barre_navigation-title" href="index.php?module=Accueil&action=accueil">Alcoolol</a>
   </div>
   <div class="barre_navigation-btn">
      <label for="barre_navigation-check">
      <span></span>
      <span></span>
      <span></span>
      </label>
   </div>
   <input type="checkbox" id="barre_navigation-check">
   <div class="barre_navigation-links">
      <div class="ui simple dropdown wa">
         <div class="text"><a href="index.php?module=Recherche&action=listeBoisson">Boisson</a></div>
         <div class="menu">
            <?php if(isset($_SESSION["login"]))
               {echo '<div class="item"><a href="index.php?module=Boisson&action=creerBoisson">Creation de boisson</a></div>';}
               ?>
         </div>
      </div>
 
      <?php 
         if(isset($_SESSION["login"])){
             echo'

     <div class="ui simple dropdown wa tel">
         <div class="text"><a href="index.php?module=Boisson&action=creerBoisson"><i class="angle right icon"></i>Creation de boisson</a></div>
      </div>
            <div class="ui simple dropdown wa">
             <div class="text"><a href="index.php?module=Evenement&action=AfficherListeEvenement">Événement</a></div>
            </div>';
          }
         ?>
      <div class="ui simple dropdown wa">
         <div class="text"><a href="index.php?module=Boisson&action=testAlcoolemie">Test d'alcoolémie</a></div>
      </div>
      <div class="ui simple dropdown wa">
         <div class="text"><a href="index.php?module=Accueil&action=propos">A propos</a></div>
      </div>
      <?php if(isset($_SESSION["login"]))
         {echo'		
          <div class="ui simple dropdown wa">
              <div class="ui form">
                  <div class="ui center aligned grid" style="width: 300px">
                      <div class="column">

                        <form method="POST" action="index.php?module=Recherche&action=RechercherUser">

                          <div class="ui search">
                              <div class="ui fluid icon input">
                                <input class="userSearchBar" name="recherche" type="text" list="userList" placeholder="Recherche un utilisateur">
                                <i class="search icon"></i>
                                <datalist id="userList"></datalist> 
                              </div>
                          </div>

                        </form>

                      </div>
                  </div>
              </div>
            </div>
					
         <div id="profile" class="tiny ui compact menu">
        	<a class="item" href="index.php?module=Message&action=menu"><i class="icon mail"></i>
              Messages
          		<div id="badgeNbMessage" class="mini floating ui red label">0</div>
         	</a>
         
    		 	<a class="item" href="index.php?module=Requete&action=menu">
              <i class="icon users"></i>
              Requêtes
          		<div id="badgeNbRequete" class="mini floating ui teal label">0</div>
         	</a>
        
         
		 	    <div class="ui simple dropdown item">'.$_SESSION["login"].'
          		<i class="dropdown icon"></i>
          			<div class="left menu">
            			<div class="item" onclick=location.href="index.php?module=Profil&action=profilPerso">Mon compte</div>
            			<div class="item" onclick=location.href="index.php?module=Connexion&action=deconnexion">Se déconnecter</div>
          			</div>
         	</div>'
		;}
         else{
          echo'<button onclick=location.href="index.php?module=Connexion" type="button" id ="profile" class="ui yellow button">Connexion</button>';
         }?>
   </div>
</div>
</div>
<?php
   echo '<script src="components/scriptHeader.js?t='.filemtime('components/scriptHeader.js').'"></script>';
   ?>