var waiting_like = false;
function sendLike(){
    $.ajax({
        url: "/api/projet-like",
        type: "POST",
        data: {"project_id": $("#button-like").attr("data-id")}
    }).done(function(data){
        //TODO: Display user friendly error.
        if(data === "success")
            location.reload();
        else
            console.log("Upvote failed: "+data);
    }).fail(function(data){
        console.log(data);
    });
}

$(document).ready(function(){
    $('blockquote:odd').addClass('blockquote-reverse')
    $(".sendStar").click(function(){
        $.ajax({
            url: "/api/projet-etoile",
            type: "POST",
            data: {"project_id": $("#button-like").attr("data-id"), "amount": $("#starsSend").val()}
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Star failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    })

    $(".upvote").click(function(){
        var connected = $("#button-like").attr("data-connected");
        if(connected){
            $.ajax({
                url: "/api/projet-like",
                type: "POST",
                data: {"project_id": $("#button-like").attr("data-id")}
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                    location.reload();
                else
                    console.log("Upvote failed: "+data);
            }).fail(function(data){
                console.log(data);
            });
        }
        else{
            waiting_like = true;
            $("#loginModal").modal("show");
        }

    })

    $(".downvote").click(function(){
        $.ajax({
            url: "/project/downvote",
            type: "POST",
            data: {"project_id": $(this).attr("data-id")}
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Upvote failed");
        }).fail(function(data){
            console.log(data);
        });
    })

    $(".report-project").click(function(){
        $.ajax({
            url: "/api/projet-report/"+$(this).attr("data-id"),
            type: "GET"
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Report failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    })

    $(".report-comment").click(function(){
        $.ajax({
            url: "/api/commentaire-report/"+$(this).attr("data-id"),
            type: "GET"
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Report failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    });

    $("#editComment").click(function(){
        $.ajax({
            url: "/api/commentaire-edit/"+$(this).attr("data-id"),
            type: "GET"
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Edit failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    });

    $("#deleteComment").click(function(){

        var result = confirm("Etes-vous sûr de vouloir supprimer le commentaire ?");
        if (result) {

                $.ajax({
                    url: "/api/commentaire-delete/"+$(this).attr("data-id"),
                    type: "GET"
                }).done(function(data){
                    //TODO: Display user friendly error.
                    if(data === "success")
                        location.reload();
                    else
                        console.log("Delete failed: "+data);
                }).fail(function(data){
                    console.log(data);
                });
            }
        }
    );

   /* sca edit
   $("#edit").click(function(){
    $.ajax({
        url: "/api/commentaire-edit",
        type: "POST",
        data: {"project_id": $("#addComment").attr("data-id"), "comment": $("#addComment").val()}
    }).done(function(data){
        //TODO: Display user friendly error.
        if(data === "success")
            location.reload();
        else
            console.log("Sending failed: "+data);
    }).fail(function(data){
        console.log(data);
    });*/

    $("#submitComment").click(function(){
        $.ajax({
            url: "/api/projet-commenter",
            type: "POST",
            data: {"project_id": $("#addComment").attr("data-id"), "comment": $("#addComment").val()}
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Sending failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    })
})
