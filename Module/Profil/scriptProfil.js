$(".image").dimmer({
	on: "hover"
});
$(document).ready(function () {
	$("body").on("click", ".ajoutAmis", ajoutAmis);

	$("body").on("click", ".retirerAmis", retirerAmis);
});
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

$("#enregistrer").click(function(e){
	let dateNaissance = $("#dateNaissance").val();
	let adresse = $("#adresse").val();
	let email = $("#email").val();
	let numTel = $("#numTel").val();
	let description = $("#description").val();

	console.log(dateNaissance);

	$.post("ajax.php?module=Profil&action=validerModification"
		,{dateNaissance : dateNaissance, adresse: adresse, email: email, numTel : numTel , description: description}
        ,function(data){

        	if(data["erreur"]){
        		$("#errorMail").removeClass("invisible");
        		$("#errorMail").html(data["message"]);
        	}
        	
        	else
				document.location.href="index.php?module=Profil&action=profilPerso";
		}
		,'json'
	).fail(function(e) {
		console.log(e.responseText);
        alert( "Posting failed." );
    })
    
 	
		
});


var responseChangeImage;
var form = document.forms.namedItem("fileinfo");
$("#photo").change(function(e) {

	if(!(e.originalEvent.target.value==="")){

		let request = obj => {return new Promise((resolve, reject) => {
			var oOutput = document.querySelector("div"),
			oData = new FormData(form);
			oData.append("CustomField", "Données supplémentaires");
			var oReq = new XMLHttpRequest();
			oReq.open("POST", "ajax.php?module=Profil&action=uploadAvatar", true);
			oReq.onload = function(oEvent) {

				if (oReq.status == 200) {
					var returnedV = oEvent.currentTarget.responseText;
					responseChangeImage= JSON.parse(returnedV);

					if(responseChangeImage["erreur"]){
						$("#erreurImg").css("color","red");
						$("#erreurImg").html(responseChangeImage["message"]);
					}
					else{
						$("#loader").addClass("active");
						setTimeout(replaceImage,2000);

					}

				}
				else {
				    oOutput.innerHTML = "Erreur " + oReq.status + " lors de la tentative d’envoi du fichier.<br/>";
				}
			};

			oReq.send(oData);
			
		  });
		};
		request().then();
	}
})

const replaceImage = () =>{
	let imgSrc ="images/avatar/user/" + responseChangeImage.nomFichier +"?t=" + new Date().getTime();
	$("#loader").removeClass("active");
	$("#avatarProfil").attr("src",imgSrc);
	$("#erreurImg").html(responseChangeImage["message"]);
	$("#erreurImg").css("color","green");
}
