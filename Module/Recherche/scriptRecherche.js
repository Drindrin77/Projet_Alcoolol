$(document).ready(function () {

    $('.ui.checkbox').checkbox();
   	$(".rating").rating("disable");

    $(".alcoolSearchBar").keyup(function(evt){

			evt.stopImmediatePropagation();

            $.post("ajax.php?module=Recherche&action=BarreRechercherAlcool"
            ,{ recherche: $(".alcoolSearchBar").val()  }
            ,function(data){
                $("#alcoolList").empty();
                for (var i = data.length - 1; i >= 0; i--) {
                    $("#alcoolList").append("<option>"+data[i]["nomBoisson"]+"</option>");
                }
            },'json'
            )
    });
        

	$(".ui.accordion").accordion();

	$(".butFav").click(function(evt){
		
		evt.stopImmediatePropagation();

		var obj = $(this);
		let idBoisson = $(obj).attr("id_change");
		$.post("ajax.php?module=Boisson&action=" + $(obj).attr("id_fav")
		,{ idBoisson: idBoisson }
		,function(){                          

		    if ($(obj).attr("id_fav")==="enleverFavoris"){
		        $(obj).html("<i class=\'heart icon\'></i> Ajouter à mes favoris");
		        $(obj).attr("id_fav","ajouterFavoris");
				let nbr = parseInt($("#nbrFav_"+idBoisson).html())-1;
		       	$("#nbrFav_"+idBoisson).html(nbr);  
		    }
		    else{
		        $(obj).html("<i class=\'heart icon\'></i> Retirer de mes favoris");
		        $(obj).attr("id_fav","enleverFavoris");
		        let nbr = parseInt($("#nbrFav_"+idBoisson).html())+1;
		       	$("#nbrFav_"+idBoisson).html(nbr);
		    }

		}        
		).fail(function() {

		    alert( "Posting failed." );
		});
	});
    
	$(".button").popup({
	    popup : $(".custom.popup"),
	    on    : "click"
	  })
	;

	$("body").on("click", ".ajoutAmis", ajoutAmis);

	$("body").on("click", ".retirerAmis", retirerAmis);

    function ajoutAmis() {
        			
        $(this).html('<i class="history icon"></i>Enattente').removeClass("ajoutAmis").removeClass("green").addClass("attenteAmis").addClass("disabled");
	let idUser = $(this).attr("idUsr");

	//console.log(idUser);
        $.post("ajax.php?module=Amis&action=demanderEnAmi"
		,{idUser : idUser}
		
        );
    }

    function retirerAmis(){
        $(this).removeClass("retirerAmis").removeClass("red").addClass("ajoutAmis").addClass("green").html('<i class="user plus icon"></i>Ajouter en ami');
	let idUser = $(this).attr("idUsr");

        $.post("ajax.php?module=Amis&action=supprimerAmi"
		,{idUser : idUser}
		
        );
        
    }


	$(document).on("click", ".envoyerMessage", function(e){
		var obj = $(this);
		let idUser= $(obj).attr("id_change");
		let message = $("#message_"+idUser).val();
		let objet = $("#objet_"+idUser).val();

		if(message!==""){
				$.post("ajax.php?module=Message&action=EnvoyerMessage"
				,{idUser : idUser , message : message, objet : objet}
				,function(){
					$("#message_"+idUser).val("");
					$("#objet_"+idUser).val("");
                    $("#popUpMsg"+idUser).removeClass("visible").addClass("hidden")                      
                    afficheMessageReussi("Message envoyé!","Votre ami recevra votre message bientot");
				}
			);
		}
	});	

	function afficheMessageReussi(msgHeader, msg){
		let messageOk = $('<div style="position:fixed;top:50px;margin-left:40%;z-index:5000" class="ui positive message"></div>');
		messageOk.append('<i id="closebutton" class="close icon"></i><div class="header">'+msgHeader+'</div><p>'+msg+'</p>');
		$("body").append(messageOk);
	}
	                      
	$(document).on ("click", "#closebutton", function () {
		$(this).closest('.message').transition('fade');
	});
});
