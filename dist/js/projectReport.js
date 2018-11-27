$(document).ready(function(){

    $("tbody").on("click", "tr", function(event){
        $("#modalModerateProject").attr("data-id", $(this).attr("data-id"));
        $("#modalModerateProject").attr("data-project-id", $(this).attr("data-project-id"));
        $("#modalUsername").html($(this).attr("data-username"));
        $("#modalProject").html($(this).attr("data-title"));
        $("#modalModerateProject").modal("show");
    })

    $("#buttonView").click(function(){
        var newTab = window.open('/vue/'+$("#modalModerateProject").attr("data-project-id"), '_blank');
        if (newTab)
            newTab.focus();
    });

    $("#buttonDelete").click(function(){
            $.ajax({
                url: "/moderation/projet-accepter",
                type: "POST",
                data: {"report_id": $("#modalModerateProject").attr("data-id")}
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
                data: {"report_id": $("#modalModerateProject").attr("data-id")}
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
                url: "/moderation/projet-refuser",
                type: "POST",
                data: {"report_id": $("#modalModerateProject").attr("data-id")}
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
