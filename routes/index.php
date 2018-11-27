<?php
    require_once("controller/project.php");
    require_once("controller/category.php");

    function startRoutingIndex($routingArray){

        if(isset($_SESSION["user"])
            && !$_SESSION["user"]->getActive())
        {
            $template = "acceuil_user_blocked.phtml";
            $title = "CrowdFunding Accueil - Bloqué";
              require("views/layout.phtml");
        }
        else
        {

            //Display all projects/ideas.
          /*  if(isset($routingArray[1]))
                $projects = controlerProjectAllCategoryList($routingArray[1]);
            else
            {*/
                /*sca : recherche project by keyword*/
            if(isset($_GET["keyword"]))
            {
                $projects = controlerProjectFoundByKeyword($_GET["keyword"]);
            }
            else
            {
                  $projects = controlerProjectTopSixList();
            }
            //}

           // $categories = controllerCategoryAllList();
            $needle="accueil";
            $template = "acceuil_project_list.phtml";
            $title = "CrowdFunding Accueil";
            require("views/layout.phtml");
        }
    }

?>
