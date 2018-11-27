<?php
    require_once("controller/history.php");

    function startRoutingHistory($routingArray){
        switch($routingArray[1])
        {
            case "etoiles":
                $stars = controllerHistoryStars();
                $template = "history-stars.phtml";
                $title = "CrowdFunding Historique";
                require("views/layout.phtml");
                break;
            default:
                http_response_code(404);
                $template = "404.phtml";
                require("views/layout.phtml");
                break;
        }
    }

?>
