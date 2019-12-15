$(document).ready(function(){

  $("#boiteReception").click(function(){
      $("#listeMessageEnvoye").addClass("invisible");
      $("#listeMessageRecu").removeClass("invisible");
      $("#listeCorbeille").addClass("invisible");
      $("#boiteReception").css("color","green");
      $("#msgEnvoye").css("color","black");
      $("#corbeille").css("color","black");
      $("#titreListe").html("Ma boîte de réception");
      $("#ouvrirPopUpFlush").addClass("invisible");

  });

  $("#msgEnvoye").click(function(){
      $("#listeMessageEnvoye").removeClass("invisible");
      $("#listeMessageRecu").addClass("invisible");
      $("#listeCorbeille").addClass("invisible");
      $("#msgEnvoye").css("color","green");
      $("#boiteReception").css("color","black");
      $("#corbeille").css("color","black");
      $("#titreListe").html("Mes messages envoyés");
      $("#ouvrirPopUpFlush").addClass("invisible");

  });

  $("#corbeille").click(function(){
      $("#listeMessageEnvoye").addClass("invisible");
      $("#listeMessageRecu").addClass("invisible");
      $("#listeCorbeille").removeClass("invisible");
      $("#corbeille").css("color","green");
      $("#msgEnvoye").css("color","black");
      $("#boiteReception").css("color","black");
      $("#titreListe").html("Ma corbeille");

      $("#ouvrirPopUpFlush").removeClass("invisible");

  });  

    $("#supprimerMsg").popup({
      popup : $("popupCorbeille"),
      on    : "hover"
    });

    $("#longmodalNew").click(function(){
          $('.long.modal').modal('show');
      });

    $("#ouvrirPopUpFlush").popup({
        popup : $("#popupFlush"),
        on    : "click"
    });

    $("#supprDefinitf").popup({
      popup : $("#popupSupprimer"),
      on    : "hover"
    });

    $("#tinymodal").popup({
      popup : $("#popupRepondre"),
      on    : "hover"
    });

    $("#supprDefinitf").click(function(){

      let idMsgPere = $(this).attr("id_msgPere");
      let idMsg = $(this).attr("id_msg");
      $("#msg_"+idMsg).remove();
      $("#segmentDroiteMessage").addClass("invisible");
      $("#segmentDroiteAucun").removeClass("invisible");

      $.post("ajax.php?module=Message&action=supprimerDefinitifMsg"
        ,{idMsg : idMsg, idMsgPere : idMsgPere}
        ,'json'
        )
      });

    $("#flush").click(function(){

      let idMessagePere = [];

      $("#listeCorbeille").children().each(function(){
        let idPere = $(this).attr("id_msgPere");
        idMessagePere.push(idPere);
        $(".corbeille"+idPere).remove();
      });

      $.post("ajax.php?module=Message&action=viderCorbeille"
        ,{idMessagePere : idMessagePere}
        ,'json'       
      )     
    });


   $("#supprimerMsg").click(function(){
    let idMsgPere = $(this).attr("id_msgPere");
    let idMsg = $(this).attr("id_msg");
    $(".pere"+idMsgPere).remove();
    let objet = $("#messageDestinataireObjet").html();

    $("#segmentDroiteMessage").addClass("invisible");
    $("#segmentDroiteAucun").removeClass("invisible");

    $.post("ajax.php?module=Message&action=corbeilleMsg"
      ,{idMsg : idMsg, idMsgPere : idMsgPere}
      ,function(data){
        ajouterMsgListeCorbeille(idMsg, idMsgPere, data["avatar"], data["login"],objet);
      }
      ,'json'

      )

   }); 

  $(document).on("click", ".msgListe", function () {

      $("#segmentDroiteMessage").removeClass("invisible");
      $("#segmentDroiteAucun").addClass("invisible");

      let idMsgPere = $(this).attr("id_msgPere");
      let idMsg = $(this).attr("id_msg");
      let idSession = $("#sessionId").val();

      $(".clickedMess").removeClass('clickedMess');
      $(this).addClass('clickedMess');
      $(this).removeClass('pasLu');

      $(this).find("i").addClass("open");
      $("#listReponse").empty();

      let idFuturDestinataire = $(this).attr("idFuturDestinataire");

       if($(this).attr("id_type")!=='corbeille'){

          $("#supprDefinitf").addClass("invisible");
          $("#supprimerMsg").removeClass("invisible");

          $("#tinymodal").attr("id_pere",idMsgPere);
          $("#tinymodal").attr("idFuturDestinataire",idFuturDestinataire);
          $("#tinymodal").attr("idMsg",idMsg);

          $("#supprimerMsg").attr("id_msg",idMsg);
          $("#supprimerMsg").attr("id_msgPere",idMsgPere);

      }

      else{
        $("#tinymodal").addClass("invisible");
        $("#supprimerMsg").addClass("invisible");
        $("#supprDefinitf").removeClass("invisible");

        $("#supprDefinitf").attr("id_msg",idMsg);
        $("#supprDefinitf").attr("id_msgPere",idMsgPere);
      }            

      $.post("ajax.php?module=Message&action=EnvoyerInfoMsg"
            ,{idMsgPere : idMsgPere, idMsg : idMsg}
            ,function(data){

              $("#loginDroite").html(data["loginExpediteur"]);
              $("#nomPrenomDroite").html(data["nomExpediteur"]+" "+data["prenomExpediteur"]);
              $("#messageDestinataireObjet").html(data["objet"]);           

              $("#messageDestinataireLogin").html(data["loginDestinataire"]);
              $("#dateMsgDroite").html(data["dateMsg"]);

              for (var i = data["reponses"].length - 1; i >= 0; i--) {
                if(data["reponses"][i]["idExpediteur"]==idSession)
                  afficherReponseDroite("images/avatar/user/"+data["reponses"][i][1],data["reponses"][i][2],data["reponses"][i][0],data["reponses"][i][3]);
                
                else
                  afficherReponseGauche("images/avatar/user/"+data["reponses"][i][1],data["reponses"][i][2],data["reponses"][i][0],data["reponses"][i][3]);

              }
            }
             ,'json'
            ).fail(function(e) {
            console.log(e.responseText);
            alert( "Posting failed." );
        })

    });

   $(".userSearchBar").keyup(function(){
            $.post("ajax.php?module=Recherche&action=BarreRechercherUser"
            ,{ recherche: $(".userSearchBar").val()  }
            ,function(data){
                $("#userList").empty();
                for (var i = data.length - 1; i >= 0; i--) {
                    $("#userList").append("<option>"+data[i]["login"]+"</option>");
                }
            }, "json"
            ).fail(function() {
                alert( "Posting failed." );
            });
    });

    window.onload = function(){
      var dAujourdhui = new Date();
      var options = { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' };
      var nowDate = dAujourdhui.toLocaleDateString('fr-FR', options) ;
      document.getElementById('dateNow').innerHTML = nowDate;
      };
      $(function(){
          $("#tinymodal").click(function(){
              $('.tiny.modal').modal('show');
          });
      }); 
      
});

  function afficherReponseDroite(avatar,login,message,date){
    $("#listReponse").append("<div class='item'><div class='image avatarReponse floatRight'><img src="+avatar+"></div><div class='content'><a class='header'>"+login+" <div class='dateReponse'>("+date+")</div></a><div class='description'>"+message+"</div></div></div>")
  }

  function afficherReponseGauche(avatar,login,message,date){
    $("#listReponse").append("<div class='item'><div class='image avatarReponse'><img src="+avatar+"></div><div class='content'><a class='header'>"+login+" <div class='dateReponse'>("+date+")</div></a><div class='description'>"+message+"</div></div></div>")
  }

  $("#boutonRepondre").click(function(){
    let reponse = $("#reponse").val();
    let idPere = $("#tinymodal").attr("id_pere");
    let idDestinataire = $("#tinymodal").attr("idFuturDestinataire");
    let objet = $("#messageDestinataireObjet").html();
    let idSession = $("#sessionId").val();
    let idMsg = $("#tinymodal").attr("idMsg");

    if(reponse==''){
      $("#errorReponse").removeClass("invisible");
      $("#errorReponse").html("Votre message ne doit pas être vide");
    }
    else{

      $.post("ajax.php?module=Message&action=repondreMessage"
        ,{reponse : reponse, idPere : idPere, idDestinataire : idDestinataire, objet : objet}
        ,function(data){

          $("#reponse").val('');
          afficherReponseDroite("images/avatar/user/"+data["avatarExp"],data["loginExp"],reponse,data["dateMsg"]);

           $('#reponseModal').modal('hide');
        }
        ,'json'
      )
    }
  });

  $("#boutonEnvoye").click(function(evt){
  evt.stopImmediatePropagation();

    let message = $("#message").val();
    let objet = $("#objet").val();
    let login = $("#login").val();
    let loginActuel = $(this).attr("login");

    if(login =="" || message =="")
        $("#spanErreur").html("<i class='exclamation triangle icon'></i>Veuillez entrer un destinataire et un message non vide<i class='exclamation triangle icon'></i>");

    else{
      $.post("ajax.php?module=Message&action=EnvoyerMessage"
        ,{message : message, objet : objet, login : login}
        ,function(data){
          if(data["erreur"])
            $("#spanErreur").html("<i class='exclamation triangle icon'></i> Cet utilisateur n'existe pas <i class='exclamation triangle icon'></i>");
          
          else {

            let avatar = $("#imgProfil").attr("src");
            ajouterMsgListeEnvoye(data["idMsg"],data["idDest"],data["idMsg"],avatar,login,objet);
            $("#envoyerModal").modal("hide");

            $("#message").val('');
            $("#login").val('');
            $("#objet").val('');

            if(login==loginActuel)
              ajouterMsgListeRecu(data["idMsg"],data["idMsg"],avatar,loginActuel,objet);
          }

        }
        ,'json'
      )
    }
});

function ajouterMsgListeEnvoye(idMsg, idDest, idMsgPere, avatar, login, objet){
  $("#listeMessageEnvoye").prepend("<div id_type='envoyer' id='msg_"+idMsg+"' idFuturDestinataire='"+idDest+"' id_msg="+idMsg+" id_msgPere="+idMsgPere+" class='item msgListe pere"+idMsgPere+"'><div class='right floated content'>A l'instant<i class='envelope outline icon'></i></div><img class='ui tiny image floatLeft imgListe' src="+avatar+"><div class='content'><div class='enGras'>A : "+login+"</div><br><div>Objet: "+objet+"</div></div></div>");
}

function ajouterMsgListeRecu(idMsg, idMsgPere, avatar, login, objet){
  $("#listeMessageRecu").prepend("<div id_type='recu' id='msg_"+idMsg+"' id_msg="+idMsg+" id_msgPere="+idMsgPere+" class='item msgListe pasLu pere"+idMsgPere+"'><div class='right floated content'>A l'instant<i class='envelope outline icon'></i></div><img class='ui tiny image floatLeft imgListe' src="+avatar+"><div class='content'><div class='enGras'>De : "+login+"</div><br><div class='enGras'>Objet: "+objet+"</div></div></div>");          
}

function ajouterMsgListeCorbeille(idMsg, idMsgPere, avatar, login, objet){
  $("#listeCorbeille").prepend("<div id='msg_"+idMsg+"' id_msg="+idMsg+" id_type='corbeille' id_msgPere="+idMsgPere+" class='item msgListe corbeille"+idMsgPere+"'><div class='right floated content'><i class='envelope open outline icon'></i></div><img class='ui tiny image floatLeft imgListe' src="+avatar+"><div class='content'><div>"+login+"</div><br><div>"+objet+"</div></div></div>");          
}

function retirerBadgeMessage(){
  let nbr = parseInt($("#badgeNbMessage").html())-1;
  $("#badgeNbMessage").html(nbr); 
}