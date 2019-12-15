$(".ami").click(function(e){
	let idUser= e.target.id.substring(4);
		$.post("ajax.php?module=Amis&action=supprimerAmi"
			,{idUser : idUser}
			,function(data){
				$("#cardAmi_"+idUser).remove();
			}
	)					
});
