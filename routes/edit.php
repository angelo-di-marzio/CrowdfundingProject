<?php

    function startRoutingEdit($routingArray){
        if(!isset($routingArray[1])){
            $template = "error.phtml";
            $title = "CrowdFunding Error";
        }
        else{
            //Get project by id in $routingArray[1]
            $projectId = $routingArray[1];
            $project = $GLOBALS["projectDAO"]->find($projectId);

            $categories = $GLOBALS["categoryDAO"]->findAll();
            $template = "project_edit.phtml";
            $title = "CrowdFunding Edition";
            //If project is not found.
            if(!$project || $project->getUser()->getId() != $_SESSION["user"]->getId()){
                $template = "error.phtml";
                $title = "CrowdFunding Error";
            }
        }
        require("views/layout.phtml");
    }

?>
