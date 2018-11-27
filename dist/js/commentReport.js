$(document).ready(function(){

    $("tbody").on("click", "tr", function(event){
        $("#modalModerateComment").attr("data-id", $(this).attr("data-id"));
        $("#modalUsername").html($(this).attr("data-username"));
        $("#modalComment").html($(this).attr("data-comment"));
        $("#modalModerateComment").modal("show");
    })

    $("#buttonDelete").click(function(){
            $.ajax({
                url: "/moderation/commentaire-accepter",
                type: "POST",
                data: {"report_id": $("#modalModerateComment").attr("data-id")}
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                    location.reload();
                else
                    console.log("Delete failed: "+data);
            }).fail(function(data){
                console.log(data);
            });
    });

    $("#buttonBlock").click(function(){
            $.ajax({
                url: "/moderation/utilisateur-bloquer",
                type: "POST",
                data: {"report_id": $("#modalModerateComment").attr("data-id")}
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                    location.reload();
                else
                    console.log("Block failed: "+data);
            }).fail(function(data){
                console.log(data);
            });
    });

    $("#buttonDismiss").click(function(){
            $.ajax({
                url: "/moderation/commentaire-refuser",
                type: "POST",
                data: {"report_id": $("#modalModerateComment").attr("data-id")}
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                    location.reload();
                else
                    console.log("Dismiss failed: "+data);
            }).fail(function(data){
                console.log(data);
            });
    });
});
