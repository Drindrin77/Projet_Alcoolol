$(function(){
    $('#tinymodal').click(function(){
            $('.tiny.modal').modal('show');
    });
    $('.tiny.modal').modal({
            closable: true
            
    });
    
});
$(document).ready(function () {
    $('#pseudo').keyup(function () {
        $('#cont').removeClass("invisible");
        if ($('#pseudo').val().length > 3) {
            $.post('ajax.php?module=Connexion&action=testPseudo'
            ,{loginInscription: $('#pseudo').val()}
            ,function (data) {

                if (!data["erreur"]){
                    $('#cont').text(data["message"]);
                    $('#cont').removeClass("red");
                    $('#cont').addClass("green");              
                }

                else{                   
                    $('#cont').text(data["message"]);
                    $('#cont').removeClass("green");
                    $('#cont').addClass("red");
                }
            }, 'json'

            ).fail(function () {

                alert('Posting failed.');
            });
        } 
        else{
            $('#cont').removeClass("green");
            $('#cont').addClass("red");
            $('#cont').text('pseudo trop court');
        }
    });

    $('#submit').click(function(e){
        e.preventDefault();
        let login = $('#username').val();
        let password = $('#password').val();

        $.post('ajax.php?module=Connexion&action=connexion',
            {login : login, pass :password },
            function(data){
                if(data['erreur'])
                    $('#erreurConnexion').removeClass("invisible");                   
            
                else
                    document.location.href='index.php?module=Accueil';	
            }
            ,'json'		
        );

    });

    $('#buttonInsc').click(function () {
        $.post("ajax.php?module=Connexion&action=inscription"
        , {nom : $('#incriNom').val()
            ,prenom:$('#incriPrenom').val()
            ,email:$('#incriEmail').val()
            ,loginInscription:$('#pseudo').val()
            ,mdpInscription:$('#incriPsw').val()
            ,mdpInscriptionConfirmation:$('#incriPswConf').val()
            ,token:$('#inscriToken').html()
        }
        ,function (data) {
            console.log(data);

            if (!data["erreur"]){
                $('#modalInscri').removeClass("transition","visible","active");
                $('#modalInscri').css('display', 'none');
                $('body').removeClass("dimmed");
                $('div.ui.dimmer.modals.page.transition.visible.active').remove();
                $('#inscriBlock').html("inscription reussie");
                       
            }
            else{
                $('#inscriAlert').removeClass("invisible");
                $('#inscriAlert').html(data["message"]);
            }

        }, 'json'
        ).fail(function (e) {  
            console.log(e.responseText);               
            alert('Posting failed.');
        });
    });
});
