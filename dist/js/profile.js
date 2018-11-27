$(document).ready(function(){
    $("#buttonEditProfilePassword").click(function(){
        if(validateProfilePassword())
        {
            $.ajax({
                url: "/api/profil-edition-password",
                type: "POST",
                data: $("#formProfileEditPassword").serialize()
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                {
                    /*sca ajouter informations */
                    $("#getMessage").html("Votre mot de passe a bien été modifié.");
                    $("#response-message").modal('show');

                    $('.btn').click(function(){
                         location.reload();
                    })
                }
                else
                {
                    console.log("profile failed: "+data);

                    $("#getMessage").html("Il y a eu une erreur.\n"+data);
                    $("#response-message").modal('show');
                }

            }).fail(function(data){
                console.log(data);
            });
        }
        else
        {
               $("#getMessage").html("Vos mots de passes ne correspondent pas.");
               $("#response-message").modal('show');

        }
    });

   $("#buttonEditProfile").click(function(){
        if(validateProfileFields())
        {
             var form = $('#formProfileEdit')[0];
             var formData = new FormData(form);

            $.ajax({
                url: "/api/profil-edition",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST'
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data == "success")
                {
                    /*sca ajouter informations */
                    $("#getMessage").html("Votre profil a bien été modifié.");
                    $("#response-message").modal('show');

                    $('.btn').click(function(){
                         location.reload();
                    })
                }
                else
                {
                    console.log("profile failed: "+data);

                    $("#getMessage").html("Il y a eu une erreur.\n"+data);
                    $("#response-message").modal('show');
                }

            }).fail(function(data){

                console.log("profile failed: "+data);
                 $("#getMessage").html("Il y a eu une erreur.\n"+data);
                    $("#response-message").modal('show');
            });
        }
        else
        {
               $("#getMessage").html("Erreur de mise à jour de votre profil.");
               $("#response-message").modal('show');

        }
    });

    $('#avatar').click(function(){
    $('#avatar').attr('src', 'http://profile.ak.fbcdn.net/hprofile-ak-ash3/41811_170099283015889_1174445894_q.jpg');
    });

    function validateProfilePassword(){


        var isPasswordFilled = $("#profilePassword").val().length > 0;
        var isConfirmPasswordFilled = $("#profilePasswordConfirm").val().length > 0;
        var isConfirmPasswordMatching = $("#profilePasswordConfirm").val() === $("#profilePassword").val();

        //TODO: Display user friendly error.

        if(isPasswordFilled && isConfirmPasswordMatching)
        {
            var clearPassword = $("#profilePassword").val();
            var encryptedPassword = hex_sha512(clearPassword);
            $("#profileEncodedPassword").val(encryptedPassword);
            $("#profilePassword").val("");
        }

        return isPasswordFilled && isConfirmPasswordMatching;
    }

        function validateProfileFields(){
            var mailRegex = /[a-zA-Z0-9-._]+@[a-zA-Z0-9-_]+.[a-zA-Z-_]+/;
            if(!mailRegex.exec($("#registerEmail").val()))
                return false;

            return true;
    }
})
