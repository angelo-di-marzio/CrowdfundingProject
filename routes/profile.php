<?php

    function startRoutingProfile($routingArray){
        //Display profile edition page.

    
        if($routingArray[0] == "profil")
        {
        	$template = "user_edit.phtml";
        	$title = "CrowdFunding Profil";

        }
        else
        {
        	$template = "user_edit_password.phtml";
        	$title = "CrowdFunding Mot de passe";
        }
       
        require("views/layout.phtml");
        exit;
    }

?>
