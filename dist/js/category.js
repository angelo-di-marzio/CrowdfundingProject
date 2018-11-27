$(document).ready(function(){

    $(".list-group").on("click", ".list-button-show", function(event){
        $("#categoryEditName").val($(this).attr("data-name"));
        $("#categoryEditId").val($(this).attr("data-id"));
        $("#modalEditCategory").modal("show");
    });

    $("#buttonEditDelete").click(function(){
            $.ajax({
                url: "/admin/categorie-suppression",
                type: "POST",
                data: $("#formEditCategory").serialize()
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

    $("#buttonEditSave").click(function(){
        if(validateCategoryEditFields())
            $.ajax({
                url: "/admin/categorie-modification",
                type: "POST",
                data: $("#formEditCategory").serialize()
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

    $("#buttonCreateCreate").click(function(){
        if(validateCategoryCreateFields())
            $.ajax({
                url: "/admin/categorie-ajout",
                type: "POST",
                data: $("#formCreateCategory").serialize()
            }).done(function(data){
                //TODO: Display user friendly error.
                if(data === "success")
                    location.reload();
                else
                    console.log("Creation failed: "+data);
            }).fail(function(data){
                console.log(data);
            });
    });

    function validateCategoryCreateFields(){
        var isNameFilled = $("#categoryCreateName").val().length > 1;

        //TODO: Display user friendly error message.
        return isNameFilled;
    }

    function validateCategoryEditFields(){
        var isNameFilled = $("#categoryEditName").val().length > 1;

        //TODO: Display user friendly error message.
        return isNameFilled;
    }
});
