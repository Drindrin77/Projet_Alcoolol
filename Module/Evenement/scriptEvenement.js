	$("#buttonCreer").click(function(e){
		$("#formulaire").removeClass("invisible");
		$("#buttonCreer").css("display","none");														
	});

	$('.retirerParticipant').click(function(e){
		e.preventDefault();
		let idEvent = $('#idEvent').val();
		let idUser = e.target.id.substring(11);	

			 $.post("ajax.php?module=Evenement&action=retirerParticipant"
			 ,{idEvent : idEvent, idUser : idUser}
			 ,function(data){
			 	$('#divParticipant_'+idUser).remove();
			 	addParticipant(data["nom"],data["prenom"],data["avatar"],data["login"],idUser,idEvent);
			 }
			 ,'json'
		)					
	});

	$(".ajouterParticipant").click(function(e){
			e.preventDefault();
			 let idEvent = $("#idEvent").val();
			 let idUser = e.target.id.substring(11);							  				 

			 $.post("ajax.php?module=Evenement&action=ajouterParticipant"
			 ,{idEvent : idEvent, idUser : idUser}
			 ,function(){
				$("#divAjouter_"+idUser).attr("class","ui fluid disabled button");
				$("#divAjouter_"+idUser).html('<i class="user icon"></i>En attente');

			 })

		});

	function ajouterParticipantNew(idUser,idEvent){
		$.post("ajax.php?module=Evenement&action=ajouterParticipant"
			 ,{idEvent : idEvent, idUser : idUser}
			 ,function(){
			 	$("#fct"+idUser).attr("class","ui fluid disabled button");
			 	$("#fct"+idUser).html('<i class="user icon"></i>En attente');
			 })
	}


	function addParticipant(nom, prenom, avatar, login, idUser, idEvent){
		$("#liste").append('<div class="card"><div style="height:200px" class="image"><img style="height:100%" src="images/avatar/user/'+avatar+'"></div><div class="content"><div class="header">'+login+'</div>'+nom+' '+prenom+'</div><div class="extra content"><button id="fct'+idUser+'" onclick="ajouterParticipantNew('+idUser+','+idEvent+')" type="submit" class="ui fluid teal button"><i class="user plus icon"></i>Ajouter</button></div></div>');								
	}
			 
	
	function ajouter(){
		$("#liste").removeClass("invisible");
		$("#boutonAnnulerListe").removeClass("invisible");
		$("#button").css("display","none");											
	}

	function annuler(){
		$("#button").css("display","");
		$("#liste").addClass("invisible");
		$("#boutonAnnulerListe").addClass("invisible");
	}


	$(document).on("click", ".deleteEvent", function () {
	     let idEvent = $(this)[0].id.substring(12);

		$.post("ajax.php?module=Evenement&action=supprimerEvent"
            ,{idEvent : idEvent}
            ,function(){
				$("#divCard"+idEvent).remove();
				afficheMessageReussi("Suppression réussi !", "Vous avez supprimé un événement");
			}
		);
	});				

	$(document).on("click", ".quitterEvent", function () {
			let idEvent = $(this)[0].id.substring(9);

			$.post("ajax.php?module=Evenement&action=quitterEvent"
            ,{idEvent : idEvent}
            ,function(data){
            	$("#divCard"+idEvent).remove();
            	afficheMessageReussi("Exil réussi !", "Vous vous êtes enfui de l'évenement de votre ami, bouuh!");
			}
		);
	 
	});

	$("#submit").click(function(e){
        e.preventDefault();
        let nom = $("#nom").val();
        let lieu = $("#lieu").val();
        let heure = $("#heure").val();
        let date = $("#date").val();
        let prive = $("#prive").is(":checked");

        $.post("ajax.php?module=Evenement&action=creerEvenement"
        ,{nom : nom, lieu : lieu, heure : heure, date : date, prive : prive, token: $("#TokenEv").html()}
        ,function(data){
			if(data["erreur"]){
				$("#divErreur").removeClass("invisible");
				$("#messageErreur").html(data["message"]);
			}
			else{
				$("#divErreur").css("display", "none");
				$("#nom").val("");
      			$("#lieu").val("");
        		$("#heure").val("");
       			$("#date").val("");
       			$("#prive").removeProp("checked");
                        $("#TokenEv").html(data["token"])
       			annule();

       			afficheMessageReussi("Création réussi !", "Vous pouvez à présent inviter vos amis à vos évenements ;) ");

				if(prive)
					addEvent(nom,lieu, heure, date, data.idNew,"divPrivate", "privé");
				else
					addEvent(nom,lieu, heure, date, data.idNew,"divPublic", "public");
			}
		}
        ,'json'
		).fail(function(e) {
			console.log(e.responseText);
            alert( "Posting failed." );
        })
    
 	});

	$(document).on ("click", "#closebutton", function () {
		$(this).closest('.message').transition('fade');
	});

	function afficheMessageReussi(msgHeader, msg){
		let messageOk = $('<div style="position:fixed;top:50px;margin-left:40%;z-index:5000" class="ui positive message"></div>');
		messageOk.append('<i id="closebutton" class="close icon"></i><div class="header">'+msgHeader+'</div><p>'+msg+'</p>');
			$("body").append(messageOk);
	}
		
function annule(){
	$("#formulaire").addClass("invisible");
	$("#buttonCreer").css("display","");	
}

function prive(){
	$("#tab1").addClass("active");
	$("#tab2").removeClass("active");
	$("#contenu1").addClass("active");
	$("#contenu2").removeClass("active");
}

function public(){
	$("#tab2").addClass("active");
	$("#tab1").removeClass("active");
	$("#contenu2").addClass("active");
	$("#contenu1").removeClass("active");
}

function addEvent(nom, lieu, heure, date, idNew, idBox, message){

		$("#"+idBox+"").append('<div id="divCard'+idNew+'" class="card"><div style="height:200px" class="image"><img style="height:100%" src="images/avatar/soiree.jpg"></div><div class="content"><div class="header">'+nom+'<button style="float:right" class="ui button fluid red deleteEvent" id="deleteEvent_'+idNew+'">Supprimer</button></div><div class="meta"><a>Evenement '+message+'</a></div><div class="description">Date:'+date+'<br/>Heure:'+heure+'<br/>Lieu: '+lieu+'</div></div><div class="extra content"><span><i class="user icon"></i>Vous etes le createur</span><form style="float:right" method="POST" action="index.php?module=Evenement&action=detailEvenementPrive"><input type="hidden" name="idEvent" value='+idNew+'><button type="submit" class="ui button"><i class="cogs icon"></i></button></form></div></div>');
}