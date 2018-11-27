$(document).ready(function(){
    $("#buttonCreateSwitch").click(function(){
        $('#loginModal').on('hidden.bs.modal', function () {
            $('#loginModal').off();
            $('#registerModal').modal('show');
        });
      $('#loginModal').modal('hide');
  });

    $("#buttonConnect").click(function(){
        if(validateLoginFields())
            $.ajax({
                url: "/authentification/connexion",
                type: "POST",
                data: $("#formLogin").serialize()
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success"){
                      $("#generalBadMessage").hide();
                    if(typeof waiting_like != 'undefined' && waiting_like)
                            sendLike();
                    else if(window.location.href.indexOf("erreur") > -1)
                        document.location.href = "/accueil";
                    else
                        location.reload();
                }
                else
                {
                    $("#generalBadMessage").html("Le nom d'utilisateur et le mot de passe que vous avez entrés ne correspondent pas. Veuillez vérifier et réessayer.");
                    $("#generalBadMessage").show();
                    console.log("login failed");
                }
            }).fail(function(data){
                console.log(data);
            });
    });

    function validateLoginFields(){
        var isUsernameFilled = $("#loginUsername").val().length > 0;
        var isPasswordFilled = $("#loginPassword").val().length > 0;

        //TODO: Display user friendly error.

        if(isUsernameFilled && isPasswordFilled)
        {
            var clearPassword = $("#loginPassword").val();
            var encryptedPassword = hex_sha512(clearPassword);
            $("#loginEncodedPassword").val(encryptedPassword);
            $("#loginPassword").val("");
        }

        return isUsernameFilled && isPasswordFilled;
    }
});
