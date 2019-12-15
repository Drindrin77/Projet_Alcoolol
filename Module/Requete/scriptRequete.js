$(".ami").click(function(){
	var obj= $(this);
	let idUser= $(obj).attr("id_ami");
retirerBadgeRequete();
retirerBadgeAmis();
		$.post("ajax.php?module=Amis&action="+$(obj).attr("id_action")
			,{idUser : idUser}
			,function(data){
				$("#cardAmi_"+idUser).remove();
			}
	)					
});

$(".event").click(function(){
	var obj= $(this);
	let idEvent= $(obj).attr("id_event");
retirerBadgeRequete();
retirerBadgeEvent();
	$.post("ajax.php?module=Evenement&action="+$(obj).attr("id_action")
		,{idEvent : idEvent, token : $("#tokenAdmi").val()}
		,function(data){
			$("#cardEvent_"+idEvent).remove();
		}
	)					
});

$(".boissons").click(function(evt){

	evt.stopImmediatePropagation();

	let action=$(this).attr("id_action");
	let idBoisson = $(this).attr("id_boisson");
	let message = $("#message").val();
	retirerBadgeRequete();
	retirerBadgeBoisson();
	$.post("ajax.php?module=Requete&action="+action
		,{idBoisson:idBoisson, message: message, token : $("#tokenAdmi").html()}
		,function(data){
			$("#cardBoisson_"+idBoisson).remove();
            $("#tokenAdmi").html(jQuery.parseJSON(data).token);
		}
               
	)	
});

function retirerBadgeRequete(){
	let nbr = parseInt($("#badgeNbRequete").html())-1;
	$("#badgeNbRequete").html(nbr);
}

function retirerBadgeAmis(){
	let nbr = parseInt($("#nbrAmi").html())-1;
	$("#nbrAmi").html(nbr);
}

function retirerBadgeEvent(){
	let nbr = parseInt($("#nbrEvent").html())-1;
	$("#nbrEvent").html(nbr);
}

function retirerBadgeBoisson(){
	let nbr = parseInt($("#nbrBoisson").html())-1;
	$("#nbrBoisson").html(nbr);
}


$(".supprimerAnnonce").click(function(){

	let idBoisson = $(this).attr("id_boisson");
	retirerBadgeRequete();
	retirerBadgeBoisson();

	$.post("ajax.php?module=Requete&action=supprimerAnnonce"
		,{idBoisson:idBoisson}
		,function(data){
			$("#cardBoissonCreateur_"+idBoisson).remove();
		}

	)

});

$('.menu .item').tab();