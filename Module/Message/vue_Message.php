<?php

if(!defined('CONST_INCLUDE'))
    die('Acces direct interdit !');

class VueMessage extends VueGenerique{
   public function __construct () {	 
	 parent::__construct();
   }


   public function menu($msgEnvoye,$msgRecu,$corbeille,$infoUser){

     $this -> contenu .='<div class="ui stackable grid" id="gridPageMessage">
      <input type="hidden" id="sessionId" value="'.$_SESSION["id"].'">

      <div class="four wide column">
        <div id="colonneGauche">
          <div id="headerColonneGauche">
              <img class="ui centered small image" id="imgProfil" src="'.CONST_FILE_PATH_USER.''.$infoUser["avatar"].'">
              <div class="ui center aligned header" id="titreGauche">
                <h2>Mes messages</h2>
                <p id="dateNow"></p><br>
            </div>
          </div>
          <div class="ui items" id="itemsGauche"">
            <div class="item">
              <div class="middle aligned content" id="boiteReception">
                  <i class="envelope icon"></i>
                    <a class="header">Ma boite de réception</a>
                </div>
            </div>
            <div class="item">
                <div class="middle aligned content" id="msgEnvoye">
                  <i class="paper plane icon"></i>
                  <a class="header">Les messages envoyés</a>
                </div>
            </div>
              <div class="item">
                <div class="middle aligned content" id="corbeille">
                    <i class="trash icon"></i>
                    <a class="header">Corbeille</a>
                </div>
              </div>
          </div>
        </div>
      </div>



      <div class="five wide column">
      
          <button class="large ui basic button" id="longmodalNew">
            <i class="pencil alternate icon"></i>
              Envoyer un nouveau message
          </button>


           <div id="envoyerModal" class="ui long modal paddingBottom">
              <h3 class="ui grey inverted top attached header">
                <i class="edit icon marginBottom20"></i>
                  Nouveau Message
              </h3>
              
              <h3 class="marginBottom20 marginLeft10">Destinataire:</h3>

              <div class="ui fluid icon input marginBottom20">
                <input class="userSearchBar" id="login" type="text" list="userList" placeholder="Recherche un utilisateur">
                <i class="search icon"></i>
                <datalist id="userList"></datalist> 
              </div>

              <h3 class="marginBottom20 marginLeft10">Objet:</h3>
              <div class="ui fluid icon input marginBottom20">                
                <input type="text" placeholder="Objet" id="objet">
              </div>

              <h3 class="marginBottom20 marginLeft10">Message:</h3>
              <div class="ui form marginBottom20">
                <div class="field">
                    <textarea rows="7" name="champDescrib" id="message" placeholder="Entrez votre message ici ...."></textarea>
                </div>
              </div>

              <span class="marginLeft10" id="spanErreur"></span>

              <button class="ui primary button floatRight" login="'.$_SESSION["login"].'" id="boutonEnvoye">
                <i class="check icon"></i>
                  Envoyer
              </button>

          </div>


          <h2 id="titreListe">Liste des messages</h2>

          <button id="ouvrirPopUpFlush" class="ui inverted red button invisible">
            <i class="trash icon"></i>
            Vider la corbeille
          </button>

          <div id="popupFlush" class="ui special popup">
                <div class="ui form">
                    <div class="ui center aligned grid">
                        <div class="column">                          
                            <h3>Etes-vous sûr de vider la corbeille?</h3>
                              <p>Cette action est irréversible</p>
                              <br>

                            <div id="flush" class="ui positive labeled icon button">
                              Vider la corbeille
                              <i class="check icon"></i>
                          </div>

                        </div>
                    </div>
                </div>
          </div>


          <div class="ui middle aligned divided listMsg list" id="listeMessageRecu">';

              foreach($msgRecu as $value){
                  $this -> contenu .=' 
                <div id_type="recu" id="msg_'.$value["idMessage"].'" idFuturDestinataire="'.$value["idExpediteur"].'" id_msg="'.$value["idMessage"].'" id_msgPere="'.$value["idMessage_pere"].'" class="item msgListe pere'.$value["idMessage_pere"].'';

                    if($value["lu"]==0)
                      $this -> contenu .=' pasLu';
                    
                $this -> contenu .='">
                  <div class="right floated content">';

                    if($value["lu"]==1)
                      $this -> contenu .='<i class="envelope open outline icon"></i>';
                    else
                      $this -> contenu.='<i class="envelope outline icon"></i>';

                  $this -> contenu .='</div>
                    <img class="ui tiny image floatLeft imgListe" src="'.CONST_FILE_PATH_USER.''.$value["avatar"].'">

                  <div class="content">
                    <div class="enGras">
                      De: '.$value["login"].'
                    </div><br>
                    <div ';
                    if($value["lu"]==0)
                      $this -> contenu.='class="enGras"';
                    $this -> contenu.='
                    >
                      '.$value["objet"].'
                    </div>
                  </div>
                </div>';
              }

      $this -> contenu .='</div>

      <div class="ui middle aligned divided listMsg list invisible" id="listeMessageEnvoye">';
      

              foreach($msgEnvoye as $value){
                  $this -> contenu .=' 
                <div id_type="envoyer" id="msg_'.$value["idMessage"].'" idFuturDestinataire="'.$value["idDestinataire"].'" id_msg="'.$value["idMessage"].'" id_msgPere="'.$value["idMessage_pere"].'" class="item msgListe pere'.$value["idMessage_pere"].'">
                  <div class="right floated content">
                    <i class="envelope open outline icon"></i>                
                  </div>
                    <img class="ui tiny image floatLeft imgListe" src="'.CONST_FILE_PATH_USER.''.$infoUser["avatar"].'">

                  <div class="content">

                    <div class="enGras">A: '.$value["login"].'</div><br>
                    <div>Objet: '.$value["objet"].'</div>
                  </div>
                </div>';
              }

      $this -> contenu .='</div>

      <div class="ui middle aligned divided listMsg list invisible" id="listeCorbeille">';

               foreach($corbeille as $value){
                  $this -> contenu .=' 
                <div id="msg_'.$value["idMessage"].'" id_msg="'.$value["idMessage"].'" id_type="corbeille" id_msgPere="'.$value["idMessage_pere"].'" class="item msgListe corbeille'.$value["idMessage_pere"].'">
                  <div class="right floated content">
                    <i class="envelope open outline icon"></i>                
                  </div>
                    <img class="ui tiny image floatLeft imgListe" src="'.CONST_FILE_PATH_USER.''.$infoUser["avatar"].'">

                  <div class="content">

                    <div>'.$value["login"].'</div><br>
                    <div>'.$value["objet"].'</div>
                  </div>
                </div>';
              }

          $this -> contenu .='</div>
      </div>

        <div class="seven wide column">         

        <div class="ui segment" id="segmentDroiteAucun">
          <h3 id="aucunMessage">Aucun message sélectionné</h3>
        </div>

        <div class="ui segment invisible" id="segmentDroiteMessage">    
 
          <div class="ui grid" id="headerMsgRecu">
            <div class="eight wide column">

              <h2 class="ui left floated header" id="loginDroite"></h2>
              <span class="category" id="nomPrenomDroite"></span>
              <br>
              <h3 id="objetTitre">Objet:</h3> <span id="messageDestinataireObjet"></span>
            </div>
              <div class="eight wide column">
                <i class="reply icon actionMessage" id="tinymodal" id_pere="" idFuturDestinataire="" idMsg=""></i>

                <div id="reponseModal" class="ui tiny modal">

                    <h3 class="ui grey inverted top attached header">
                      <i class="edit icon"></i>
                        Répondre un message
                    </h3>

                    <div class="ui form">
                      <div class="field">
                        <textarea rows="5" id="reponse" placeholder="Entrez votre message ici ...."></textarea>
                      </div>
                    </div>

                    <span class="invisible" id="errorReponse"></span>

                    <button class="ui primary button floatRight" id="boutonRepondre">
                      <i class="check icon"></i>
                        Envoyer
                    </button>                

                </div>

                <i class="close icon actionMessage" id="supprDefinitf" id_msg="" id_msgPere=""></i>
                <i class="trash icon actionMessage" id="supprimerMsg" id_msg=""></i>

                <div id="popupCorbeille" class="ui special popup">
                  <p>Mettre à la corbeille</p>
                </div>

                <div id="popupRepondre" class="ui special popup">
                  <p>Répondre</p>
                </div>  

                <div id="popupSupprimer" class="ui special popup">
                  <p>Supprimer définitivement</p>
                </div>                
 

                <span id="dateMsgDroite"></span>
                <h4 id="destinataireTitre">Destinataire: </h4><span id="messageDestinataireLogin"></span>
              </div>
          </div>
          <div class="ui grid">
            <div class="sixteen wide column" id="descriptionDuMsg">
                <div class="ui relaxed divided list" id="listReponse">
                  

                </div>

            </div>
          </div>
        </div>
      </div>    
    </div>

    <script src="Module/Message/scriptMessage.js"></script>
    <link rel="stylesheet" type="text/css" href="Module/Message/styleMessage.css?t='.time().'">'; 

   }
}
			
?>

