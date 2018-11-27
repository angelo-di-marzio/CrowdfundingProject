<?php
    require_once("controller/project.php");
    require_once("controller/category.php");

    function startRoutingIdea($routingArray){
        $categories = controllerCategoryAllList();
        $template = "project_list.phtml";
        $title = "CrowdFunding Idées";
        if(!isset($routingArray[1])){
            $projects = controlerProjectIdeaList();
        }
        else{
            $projects = controlerProjectIdeaCategoryList($routingArray[1]);

            //If category not found.
            if(false){
                $template = "error.phtml";
                $title = "CrowdFunding Error";
            }
        }
        require("views/layout.phtml");
    }

?>
