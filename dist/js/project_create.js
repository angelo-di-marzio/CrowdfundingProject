$(document).ready(function(){
    $("#formProjectCreate").submit(function(){
        if(!isValid())
            return false;

        var formData = new FormData(this);

        $.ajax({
            url: "/api/projet-creation",
            type: 'POST',
            data: formData,
            success: function (data) {
                if(data.indexOf("failure") == -1)
                    window.location.href = '/vue/'+data;
                else
                    console.log("Creation failed: "+data);
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
});
