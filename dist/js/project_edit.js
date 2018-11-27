$(document).ready(function(){
    $("#formProjectEdit").submit(function(){
        if(!isValid())
            return false;

        var formData = new FormData(this);

        $.ajax({
            url: "/api/projet-edition",
            type: 'POST',
            data: formData,
            success: function (data) {
                if(data == "success")
                    location.reload();
                else
                    console.log("Update failed: "+data);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return false;
    });

    var i=1;
    $('#addimg').click(function(){

        $('#appendjq').append('<div class="form-group"> <label for="exampleInputFile">Image :</label> <input type="file" name="image'+i+'" id="image'+i+'"> </div>');
        i++;
    })
    
    function isValid(){
        if($("#stars_total").val().length == 0 || ($("#stars_total").val()*1) < 10)
            return false;
        else if($("#title").val().length < 2 || $("#description").val().length < 10)
            return false;
        else
            return true;
    }

    $("#buttonDeleteProject").click(function(){
        $.ajax({
            url: "/project/delete",
            type: "POST",
            data: {"report_id": $("#id").val()}
        }).done(function(data){
            //TODO: Display user friendly error.
            if(data === "success")
                window.location.href = '/index';
            else
                console.log("Delete failed");
        }).fail(function(data){
            console.log(data);
        });
    });
});
