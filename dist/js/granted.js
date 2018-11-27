$(document).ready(function(){
    $(".list-group").on("click", ".list-button-show", function(event){
        $("#grantedUsername").html($(this).attr("data-username"));
        $("#grantedUsernameForm").val($(this).attr("data-username"));
        $("#roleEdit").val($(this).attr("data-role"));
        $("#grantedId").val($(this).attr("data-id"));
        $("#modalEditGranted").modal("show");
    });

    $("#buttonGrantedDelete").click(function(){
        $.ajax({
            url: "/admin/roles-suppression",
            type: "POST",
            data: $("#formEditGranted").serialize()
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

    $("#buttonGrantedSave").click(function(){
        $.ajax({
            url: "/admin/roles-edition",
            type: "POST",
            data: $("#formEditGranted").serialize()
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Save failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    });

    $("#buttonCreateGranted").click(function(){
        $.ajax({
            url: "/admin/roles-ajout",
            type: "POST",
            data: $("#formCreateGranted").serialize()
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                location.reload();
            else
                console.log("Save failed: "+data);
        }).fail(function(data){
            console.log(data);
        });
    });

});
