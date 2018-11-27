$(document).ready(function(){
    $(".list-button-show").click(function(){
        var newTab = window.open('/vue/'+$(this).attr("data-project-id"), '_blank');
        if (newTab)
            newTab.focus();
    });
});
