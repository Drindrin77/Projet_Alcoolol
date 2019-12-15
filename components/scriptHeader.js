$(document).ready(function(){

    $(".rechercheAlcoolo").popup({
        popup : $(".popup"),
        on    : "click"
    });

   if (typeof(Worker) !== "undefined") {
        if (typeof(w) === "undefined") {
            w = new Worker("/script/actu5Sec.js");
            
        }
        w.onmessage = function(event) {
            nbMessageNonLu();
            nbRequete();
        };
    }     
  

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

   function nbMessageNonLu(){
      $.post('ajax.php?module=Message&action=getNbMsgNonLu'
        ,function(data){
              let nb = data['nb'];
              $('#badgeNbMessage').html(nb);
        }
        ,'json'
      )
   }

   function nbRequete(){
      $.post('ajax.php?module=Requete&action=getNbRequete'
        ,function(data){
              let nb = data['nb'];
              $('#badgeNbRequete').html(nb);
        }
        ,'json'
        ).fail(function(e) {
          console.log(e.responseText);
        });
      
   }

});

