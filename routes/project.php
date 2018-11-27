<?php
    require_once("controller/project.php");
    require_once("controller/category.php");

    function startRoutingProject($routingArray){
        $categories = controllerCategoryAllList();
        $template = "project_list.phtml";
        $title = "CrowdFunding list";
        if(!isset($routingArray[1])){
            if (isset($_SESSION["user"])
            && strpos($_SERVER['REQUEST_URI'], $_SESSION["user"]->getId()) == true)
            {
                $projects = controlerProjectFoundByUser($_SESSION["user"]->getId());
            }
            else
            {
                 $projects = controlerProjectProjectList();
            }

        }
        else{
            $projects = controlerProjectProjectCategoryList($routingArray[1]);

            //If category not found.
            if(false){
                $template = "error.phtml";
                $title = "CrowdFunding Error";
            }
        }
        require("views/layout.phtml");
    }

    function startRoutingMyProject($routingArray){
        $categories = controllerCategoryAllList();
        $template = "project_list.phtml";
        if(!isset($routingArray[1]))
        {
            if (isset($_SESSION["user"]))
            {
                $projects = controlerProjectFoundByUser($_SESSION["user"]->getId());
            }
            else
            {
                 $projects = controlerProjectProjectList();

            }
        }
        else
        {   
            $projects = controlerProjectOwnProjectCategoryList($routingArray[1],$_SESSION["user"]->getId());

            if(false)
                $template = "error.phtml";
        }

        require("views/layout.phtml");
    }

?>
