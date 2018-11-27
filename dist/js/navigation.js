$(document).ready(function(){
  if(urlContains("/accueil") || window.location.pathname == "/")
    $("#tab_home").addClass("active");
  else if(urlContains("/creer"))
    $("#tab_create").addClass("active");
  else if(urlContains("/idee"))
    $("#tab_idea").addClass("active");
  else if(urlContains("/projet"))
    $("#tab_project").addClass("active");
  else if(urlContains("/finance"))
    $("#tab_funded").addClass("active");
  else if(urlContains("/profil"))
    $("#tab_profile").addClass("active");
  else if(urlContains("/historique"))
    $("#tab_profile").addClass("active");
  else if(urlContains("/mes_projet"))
    $("#tab_profile").addClass("active");
  else if(urlContains("/admin"))
    $("#tab_administration").addClass("active");
  else if(urlContains("/moderation"))
    $("#tab_administration").addClass("active");
  else if(urlContains("/charte"))
    $("#tab_rules").addClass("active");
});

function urlContains(compare){
  return window.location.pathname.indexOf(compare) > -1;
}
