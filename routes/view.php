<?php

    function startRoutingView($routingArray){
        if(!isset($routingArray[1])){
            $template = "error.phtml";
            $title = "CrowdFunding Error";
        }
        else{
            //Get project by id in $routingArray[1]
            $projectId = $routingArray[1];
            $project = $GLOBALS["projectDAO"]->find($projectId);

            $project->setView($project->getView()+1);
            $GLOBALS["projectDAO"]->save($project);

            $template = "project_view.phtml";
            $title = "CrowdFunding vue";
            //If project is not found.
            if(!$project){
                $template = "error.phtml";
                $title = "CrowdFunding Error";
            }


        }
        require("views/layout.phtml");

    }

?>
