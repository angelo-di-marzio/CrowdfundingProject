<?php

    function startRoutingCreate($routingArray){
        $categories = $GLOBALS["categoryDAO"]->findAll();
        $template = "project_create.phtml";
        $title = "CrowdFunding Création";
        require("views/layout.phtml");
    }

?>
