$(document).ready(function(){
	$(".ui.accordion").accordion();

	$(".uneboisson").rating();
	$("#nomBoissonCreation").change(function(e){
		$("#nomBoissonFinal").html(e.target.value);
	});

	$("#recetteCreation").change(function(e){
		$("#recetteFinal").html(e.target.value);
	});

	$('#difficulteCreation').rating('setting', 'onRate', function(value) {

		$("#difficulteFinal").rating({
	    	initialRating: value,
	    	interactive : false
	  	})  
	});

  $('#noteCreation').rating('setting', 'onRate', function(value) {
     	$("#noteFinal").rating({
	    	initialRating: value,
	    	interactive : false
	  	})  
  });

  $("#commenterPere").click(function(e){

	e.stopImmediatePropagation();

  	let commentaire = $("#commentairePere").val();
  	let idBoisson = $("#idBoisson").val();

  	if(commentaire==''){
  		$("#commentairePereErreur").html("Votre commentaire ne doit pas etre vide");
  		$("#commentairePereErreur").removeClass("invisible");
  	}
  	else{
	  	$.post("ajax.php?module=Commentaire&action=envoyerCommentaire"
	  		,{commentaire : commentaire, idBoisson : idBoisson}
	  		,function(data){
	  			$("#commentairePere").val("");	  			
	  			ajouterCommentairePere(data["idCommentaire"],commentaire, "images/avatar/user/"+data["avatar"], data["login"]);
	  		}
			,'json'
	  	)
  	}
  });

  $(document).on("click", ".commenterFils", function (evt) {
	evt.stopImmediatePropagation();

  	let idCommentaire = $(this).attr("id_comment");
  	let idBoisson = $("#idBoisson").val();
  	let commentaire = $("#commentaireFils_"+idCommentaire).val();

  	if(commentaire==""){
  		alert("Le commentaire ne doit pas etre vide");
  	}
  	else{
  		$.post("ajax.php?module=Commentaire&action=commenterCommentaire"
	  		,{commentaire : commentaire, idBoisson : idBoisson, idCommentaire : idCommentaire}
	  		,function(data){
	  			$("#commentaireFils_"+idCommentaire).val("");
				$("#commentaireDiv_"+idCommentaire).addClass("invisible");
	  			ajouterCommentaireFils(idCommentaire,commentaire,"images/avatar/user/"+data["avatar"],data["login"]);
	  		}
			,'json'
		);
  	}

	

  });


  $(".afficherTextArea").click(function(e){

  	let idCommentaire = $(this).attr("id_comment"); 
  	$("#commentaireDiv_"+idCommentaire).removeClass("invisible");

  });

	$('#checkboxAlcoolise').change(function() {

		if ($('#checkboxAlcoolise').is(':checked'))
			$("#checkboxFinal").prop('checked', true);
		else
			$("#checkboxFinal").prop('checked', false);

	});

	$(".ui.checkbox").checkbox();

// IMAGE BOISSON


	var responseChangeImage;
	var form = document.forms.namedItem("fileinfo");
	$("#photoBoisson").change(function(e) {

		if(!(e.originalEvent.target.value==="")){

			let request = obj => {
				  return new Promise((resolve, reject) => {
				var oOutput = document.querySelector("div"),
				oData = new FormData(form);
				oData.append("CustomField", "Données supplémentaires");
				var oReq = new XMLHttpRequest();
				oReq.open("POST", "ajax.php?module=Boisson&action=creationImgTemporaire", true);
				oReq.onload = function(oEvent) {

					if (oReq.status == 200) {
						var returnedV = oEvent.currentTarget.responseText;
						responseChangeImage= JSON.parse(returnedV);

						if(responseChangeImage["erreur"]){
							$("#resultatUploadBoisson").css("color","red");
							$("#resultatUploadBoisson").html(responseChangeImage["message"]);
							$('#avatarBoisson').attr("src",null);
						}
						else{
							$("#loader").addClass("active");
							setTimeout(replaceImage,2000);
						}

					}
				};

				oReq.send(oData);
				
			  });
			};
			request().then();
		}
	})
	const replaceImage = () =>{
		let imgSrc ="images/Boisson/CreationBoisson/" + responseChangeImage.nomFichier +"?t=" + new Date().getTime();
		$("#loader").removeClass("active");
		$("#avatarBoisson").attr("src",imgSrc);

		$("#resultatUploadBoisson").html(responseChangeImage["message"]);
		$("#resultatUploadBoisson").css("color","green");

	}


// ETAPES
	$(".suivant").click(function(e){

		let page = e.target.id.substr(8);
		let pageSuivante = parseInt(page) + 1;
		let nomBoisson = $("#nomBoissonCreation").val();
		let recette = $("#recetteCreation").val();
		let note = $('#noteCreation .active').length;
		let difficulte = $("#difficulteCreation .active").length;
        let alcool = $("#checkboxAlcoolise").is(":checked");
        let image = $('#avatarBoisson').attr('src');
		var ext = "";

		if(!(typeof $('#avatarBoisson').attr('src') === "undefined"))
	        ext =image.substr((image.lastIndexOf('.') + 1),3);
    	

		if(page=="3"){
			$("#etape3").removeClass("active").addClass("completed");
			$("#titre").html("<i class=\'circular flask icon\'></i>Création terminé");
			$("#contenu3").addClass("invisible");
			$("#final").removeClass("invisible");
			$("#precedent_3").addClass("invisible");
			$("#suivant_3").css("display","none");

			var ingredients = [];
			$("input:checkbox[name=ingredient]:checked").each(function(){
				ingredients.push($(this).val());
			});

			//ingredients : ingredients, 
			 $.post("ajax.php?module=Boisson&action=creationFiniBoisson"
			 	,{nomBoisson : nomBoisson, recette : recette, note : note, difficulte : difficulte, alcool : alcool, ext: ext, ingredient : ingredients }
			 	,function(){

			 	}
			)

		}
		else{

			if(page=="1" && nomBoisson !=="" && recette !==""){
				$("#contenu1" ).css("display", "none");
				$("#titre").html("<i class=\'circular flask icon\'></i>Création de boisson 2/3");
				$("#contenu2").removeClass("invisible");
				$("#suivant_1").attr("id", "suivant_2");
				$("#precedent_2").removeClass("invisible");
				$("#etape1").removeClass("active").addClass("completed");
				$("#erreur").addClass("invisible");
			}

			else if(page=="2" && !(typeof $('#avatarBoisson').attr('src') === "undefined")){

				$("#contenu2" ).addClass("invisible");
				$("#contenu3").removeClass("invisible");
				$("#titre").html("<i class=\'circular flask icon\'></i>Création de boisson 3/3");
				$("#suivant_" + page).attr("id", "suivant_" + pageSuivante);
				$("#precedent_"+page).attr("id", "precedent_"+pageSuivante);	
				$("#etape2").removeClass("active").addClass("completed");
				$("#erreur").addClass("invisible");
				$("#avatarBoissonFinal").attr("src",$("#avatarBoisson").attr("src"));


				$("input:checkbox[name=ingredient]:checked").each(function(){
					$("#listIngredient").append("<li value=\'-\'>"+($(this).attr("nomIngr"))+"</li>");
				});
						
			}

			else{
				$("#erreur").removeClass("invisible");
			}
		}
	});

	$(".precedent").click(function(e){

		let page = e.target.id.substr(10);
		let pagePrecedente = parseInt(page) - 1;

		$("#titre").html("<i class=\'circular flask icon\'></i>Création de boisson " + pagePrecedente + "/3");
		$("#suivant_" + page).attr("id", "suivant_" + pagePrecedente);			
		$("#erreur").addClass("invisible");
		

		if(page=="2"){	
			$("#contenu1").css("display","");
			$("#contenu2").addClass("invisible");
			$("#precedent_2").addClass("invisible");
			$("#listIngredient").empty();
		}
		else if(page=="3"){
			$("#contenu3").addClass("invisible");
			$("#contenu2").removeClass("invisible");
			$("#precedent_3").attr("id","precedent_" + pagePrecedente);
		}
		
	});

		$(document).on("click", ".afficherTextArea", function (evt) {
			evt.stopImmediatePropagation();
			let idComment = $(this).attr("id_comment");
			$("#commentaireDiv_" + idComment).removeClass("invisible");
			$("#button_"+idComment).css("display","none");							
		});


	  $("#boutonCalculer").click(function(){
		    let sexe = $("#idSexe").val();
		    let volume = $("#idVolume").val();
		    let poid = $("#idPoid").val() ;
		    let degre  = $("#idDegre").val();
		    let coeffDiffusion;
		    let resultat;

			if (sexe=="0") {
				coeffDiffusion = 0.7;
			} else {
				coeffDiffusion = 0.6;
			}
			if (volume=="" || poid=="" || degre=="") {
				$('#champErreur').removeClass("invisible");
				$('#resultat').css('display', 'none');
				$('#pasConduire').addClass("invisible");
			}
			else {
				$('#champErreur').addClass("invisible");
				$('#resultat').css('display', '');
				let dividande =parseInt(volume)/100 * parseInt(degre) * 0.8;
				resultat = dividande / parseInt(coeffDiffusion * parseInt(poid)); 
				$( "#resultat" ).text( "Votre taux d'alcool dans le sang est de : " + (Math.round(resultat*100)/100) +" g/L" );
				$('#pasConduire').removeClass("invisible");
				

				if ($('input[name=appr]').is(':checked') && (resultat >0.2) ) {
					$("#pasConduire").removeClass("positive").addClass("error");
					$( "#headerConduire" ).text( "Attention !" );
					$( "#textPasConduire" ).text( "Votre taux d'alcool dans le sang a dépassé les 0,2g/L, vous n'êtes pas en état de conduire !" );
				} else if (resultat >0.5) {
					$("#pasConduire").removeClass("positive").addClass("error");
					$( "#headerConduire" ).text( "Attention !" );
					$( "#textPasConduire" ).text( "Votre taux d'alcool dans le sang a dépassé les 0,5g/L, vous n'êtes pas en état de conduire !" );
				} 
				else {
					$("#pasConduire").removeClass("error").addClass("positive");
					$( "#headerConduire" ).text( "C'est bon !" );
					$( "#textPasConduire" ).text( "Vous pouvez conduire !" );
				}
			}
		});

	  $(".butFavBoisson").click(function(evt){

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

				},  "html"        
				).fail(function() {

				    alert( "Posting failed." );
				});
			});
			
});

	function ajouterCommentairePere(idCommentaire, commentaire, avatar, login){
		$("#commentaireList").append("<div class='comment'><a class='avatar avatarCommentaire'><img src="+avatar+"></a><div class='content'><a class='author'>"+login+"</a><div class='metadata'><span class='date'>A l'instant</span></div><div class='text'>"+commentaire+"</div><div id_comment="+idCommentaire+" class='actions afficherTextArea'><p class='reply'>Répondre</p><div id='commentFils_"+idCommentaire+"' class='ui comments'></div></div><div class='ui reply form invisible' id='commentaireDiv_"+idCommentaire+"'><div class='field'><textarea id='commentaireFils_"+idCommentaire+"' placeholder='Commentez ici'></textarea></div><div id_comment="+idCommentaire+" class='ui blue labeled submit icon button commenterFils'><i class='icon edit'></i> Commenter</div></div></div></div>");
	}

	function ajouterCommentaireFils(idCommentPere, commentaire, avatar, login){
		console.log(idCommentPere,commentaire,avatar,login);
		$("#commentFils_"+idCommentPere).append("<div class='comment'><a class='avatar avatarCommentaire'><img src="+avatar+"></a><div class='content'><a class='author'>"+login+"</a><div class='metadata'><span class='date'>A l'instant</span></div><div class='text'>"+commentaire+"</div></div></div>");		
	}
