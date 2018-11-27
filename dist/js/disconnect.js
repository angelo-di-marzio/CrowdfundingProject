$(document).ready(function(){
    $("#buttonDisconnect").click(function(){
            $.ajax({
                url: "/authentification/deconnexion",
                type: "get"
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                    location.reload();
                else
                    console.log("Disconnect failed");
            }).fail(function(data){
                console.log(data);
            });
    });
})
