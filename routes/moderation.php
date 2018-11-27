<?php
    require_once("controller/moderation.php");

    function startRoutingModeration($routingArray){
        switch($routingArray[1])
        {
            case "projets":
                $reports = controllerModerationProject();
                $template = "admin_project.phtml";
                $title = "CrowdFunding Modération Projets";
                require("views/layout.phtml");
                break;
            case "utilisateur-bloquer":
                if(controllerModerationUtilisateurBlocage($_POST)){
                    header('Content-Type: application/json');
                    echo json_encode("success");
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            case "projet-accepter":
                if(controllerModerationProjectApprove($_POST)){
                    header('Content-Type: application/json');
                    echo json_encode("success");
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            case "projet-refuser":
                if(controllerModerationProjectDisapprove($_POST)){
                    header('Content-Type: application/json');
                    echo json_encode("success");
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            case "commentaires":
                $reports = controllerModerationComment();
                $template = "admin_comment.phtml";
                $title = "CrowdFunding Modération Commentaires";
                require("views/layout.phtml");
                break;
            case "commentaire-accepter":
                if(controllerModerationCommentApprove($_POST)){
                    header('Content-Type: application/json');
                    echo json_encode("success");
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            case "commentaire-refuser":
                if(controllerModerationCommentDisapprove($_POST)){
                    header('Content-Type: application/json');
                    echo json_encode("success");
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            default:
                http_response_code(404);
                $template = "404.phtml";
                require("views/layout.phtml");
                break;
        }
    }

?>
