$(document).ready(function(){
    $("#buttonLoginSwitch").click(function(){
        $('#registerModal').on('hidden.bs.modal', function () {
            $('#registerModal').off();
            $('#loginModal').modal('show');
        });
        $('#registerModal').modal('hide');
    });

    $("#buttonRegister").click(function(){
        if(validateRegisterFields())
        {
            var form = $('#formRegister')[0];
            var formData = new FormData(form);
            $.ajax({
                url: "/authentification/enregistrement",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST'
            }).done(function(data){
                //TODO: Display user friendly error.
                //console.log(data);
                if(data === "success")
                {
                    /*sca : ajouter des messages d'avertissement*/
                    $("#errorMessage").hide();
                    $("#generalMessage").html("Bienvenue, vous êtes maintenant inscrit.");
                    $("#generalMessage").show();

                    if(typeof waiting_like != 'undefined' && waiting_like)
                        sendLike();
                    else
                        location.reload();
                }
                else
                {
                    $("#errorMessage").html(""+data);
                    $("#errorMessage").show();
                    console.log(data+ ' register failed');
                }
            }).fail(function(data){
               
                 $("#errorMessage").html(data);
                 $("#errorMessage").show();            
                console.log(data+' failed');
            });
        }

    });

    function validateRegisterFields(){

        var isUsernameFilled = $("#registerUsername").val().length > 0;
        var isPasswordFilled = $("#registerPassword").val().length > 0;
        var isLastnameFilled = $("#registerLastname").val().length > 0;
        var isFirstnameFilled = $("#registerFirstname").val().length > 0;
        var isEmailFilled = $("#registerEmail").val().length > 0;
        var isConfirmPasswordMatching = $("#registerPasswordConfirm").val() === $("#registerPassword").val();


        if(!isLastnameFilled)
        {
            $("#nameMessage").html("Le nom doit être rempli");
            $("#nameMessage").show();
        }
        else
        {
            $("#nameMessage").hide();
        }

        if(!isFirstnameFilled)
        {
            $("#firstnameMessage").html("Le prénom doit être rempli");
            $("#firstnameMessage").show();
        }
        else
        {
            $("#firstnameMessage").hide();
        }

        if(!isUsernameFilled)
        {
            $("#usernameMessage").html("Le nom d'utilisateur doit être rempli");
            $("#usernameMessage").show();
        }
        else
        {
            $("#usernameMessage").hide();
        }

        var mailRegex = /[a-zA-Z0-9-._]+@[a-zA-Z0-9-_]+.[a-zA-Z-_]+/;
        if(!isEmailFilled || !mailRegex.exec($("#registerEmail").val()))
        {
            $("#mailMessage").html("Le mail doit être rempli ou ne correspond pas à une adresse email.");
            $("#mailMessage").show();
        }
        else
        {
            $("#mailMessage").hide();
        }

        if(!isPasswordFilled)
        {
            $("#pwdMessage").html("Le mot de passe doit être rempli");
            $("#pwdMessage").show();
        }
        else
        {
            $("#pwdMessage").hide();
        }

        if(!isConfirmPasswordMatching)
        {
            $("#cpwdMessage").html("Les mots de passe ne correspondent pas");
            $("#cpwdMessage").show();
        }
        else
        {
            $("#cpwdMessage").hide();
        }


        if(isUsernameFilled
        && isPasswordFilled
        && isLastnameFilled
        && isFirstnameFilled
        && isEmailFilled
        && isConfirmPasswordMatching
        )
        {
            var clearPassword = $("#registerPassword").val();
            var encryptedPassword = hex_sha512(clearPassword);
            $("#registerEncodedPassword").val(encryptedPassword);
            $("#registerPassword").val("");
            $("#registerPasswordConfirm").val("");
            
        }

        return isUsernameFilled && isPasswordFilled && isLastnameFilled && isFirstnameFilled && isEmailFilled && isConfirmPasswordMatching;
    }
})
