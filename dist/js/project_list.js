function selectOnChange(elem){
    if(window.location.href.indexOf("/idee") > -1)
        location = "/idee/"+(elem.options[elem.selectedIndex].value);
    else if(window.location.href.indexOf("/projet") > -1)
        location = "/projet/"+(elem.options[elem.selectedIndex].value);
    else if(window.location.href.indexOf("/finance") > -1)
        location = "/finance/"+(elem.options[elem.selectedIndex].value);
    else if(window.location.href.indexOf("/mes_projet") > -1)
        location = "/mes_projet/"+(elem.options[elem.selectedIndex].value);
    else
        location = "/accueil/"+(elem.options[elem.selectedIndex].value);
}
