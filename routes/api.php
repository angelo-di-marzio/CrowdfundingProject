<?php
    require_once("controller/profile.php");
    require_once("controller/report.php");
    require_once("controller/comment.php");
    require_once("controller/star.php");
    require_once("controller/like.php");

    function startRoutingApi($routingArray)
    {
        switch($routingArray[1])
        {
            case "projet-creation":
                $id = controllerProjectCreate($_POST, $_FILES);
                if($id >= 0){
                    header('Content-Type: application/json');
                    echo json_encode($id);
                    exit;
                }
                else{
                    header('Content-Type: application/json');
                    echo json_encode("failure");
                    exit;
                }
                break;
            case "projet-edition":
                if(controllerProjectEdit($_POST, $_FILES)){
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
            case "profil-edition":
                //var_dump($_POST);
                if(controllerProfileEdit($_POST, $_FILES)){
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

            case "profil-edition-password":
                if(controllerProfileEditPassword($_POST, $_FILES)){
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
            case "projet-suppression":

                break;
            case "projet-like":
               
                if(controllerLikeAdd($_POST)){

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
            case "projet-etoile":
                if(controllerSendStar($_POST)){
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
            case "projet-commenter":
                if(controllerCommentAdd($_POST)){
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
            case "commentaire-editer":
                if(controllerCommentEdit($_POST)){
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
            case "commentaire-delete":
                if(isset($routingArray[2]) && controllerCommentRemove($routingArray[2])){
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
            case "projet-report":
                if(isset($routingArray[2]) && controllerReportProject($routingArray[2])){
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
            case "commentaire-report":
                if(isset($routingArray[2]) && controllerReportComment($routingArray[2])){
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
