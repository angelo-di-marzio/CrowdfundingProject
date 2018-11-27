<?php
    require_once("controller/project.php");
    require_once("controller/category.php");

    function startRoutingFunded($routingArray){
        $categories = controllerCategoryAllList();
        $template = "project_list.phtml";
        $title = "CrowdFunding Financés";
        if(!isset($routingArray[1])){
            $projects = controlerProjectFundedList();
        }
        else{
            $projects = controlerProjectFundedCategoryList($routingArray[1]);

            //If category not found.
            if(false){
                $template = "error.phtml";
                $title = "CrowdFunding Error";
            }
        }
        require("views/layout.phtml");
    }

?>
